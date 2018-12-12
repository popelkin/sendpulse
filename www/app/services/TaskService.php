<?php

namespace App\Services;

use App\Factory;
use App\Models\Task;

class TaskService
{

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getTaskByID($id)
    {
        if (!$task = Task::find($id)) {
            throw new \Exception('Задачи с таким ID не существует');
        }
     
        if ($task->user_id != Factory::AuthVendor()->getUserId()) {
            throw new \Exception('Задача не принадлежит текущему пользователю');
        }
        
        return $task;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function deleteTaskByID($id)
    {
        $task = $this->getTaskByID($id);
        
        if ($children = $task->children()) {
            $children->delete();
        }
        return $task->delete();
    }

    /**
     * @param $data
     * @return array|bool
     */
    public function addTask($data)
    {
        $result = $this->validateTaskData($data);

        if (is_array($result)) {
            // form validation errors
            return $result;
        }

        return Task::create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function updateTask($id, $data)
    {
        $task = $this->getTaskByID($id);

        $result = $this->validateTaskData($data);

        if (is_array($result)) {
            return $result;
        }

        $task->update($data);
        if ($task->done) {
            if ($task->parent_id) {
                // this is child - check all siblings are done too
                if (!$siblings = Task::where("parent_id", $task->parent_id)->where('done', 0)->count()) {
                    $task->parent()->update(['done' => 1]);
                }
            } else {
                // this is parent - mark all children as done
                if ($children = $task->children()) {
                    $children->update(['done' => 1]);
                }
            }
        }

        return $task;
    }

    /**
     * @param $data
     * @return array|bool
     */
    private function validateTaskData($data)
    {
        $errors = [];
        foreach ($data as $k => $v) {
            if (in_array($k, ['title', 'body', 'date', 'parent_id', 'user_id'])) {
                if (!trim(strip_tags($v))) {
                    if ($k == 'title') {
                        $errors['incorrect_title'] = 'Некорректное поле "Заголовок"';
                    } elseif ($k == 'body') {
                        $errors['incorrect_body'] = 'Некорректное поле "Тело"';
                    }
                }
                if ($k == 'date') {
                    try {
                        $date = new \DateTime($v);
                        $now = new \DateTime();
                        if ($date->format('Y-m-d') < $now->format('Y-m-d')) {
                            $errors['incorrect_data_past'] = 'Дата не должна быть меньше текущей';
                        }
                    } catch (\Exception $e) {
                        $errors['incorrect_data'] = 'Некорректное поле "Дата"';
                    }
                }
                if ($k == 'parent_id' && $v) {
                    try {
                        $task = $this->getTaskByID($v);
                        if ($task->parent_id) {
                            // it is child too
                            throw new \Exception();
                        }
                    } catch (\Exception $e) {
                        $errors['wrong_level'] = 'Попытка добавить задачу в подзадачу';
                    }
                }
                if ($k == 'user_id') {
                    try {
                        $userID = Factory::AuthVendor()->getUserId();
                        if ($userID != $v) {
                            // trying to add/edit task of wrong user
                            throw new \Exception();
                        }
                    } catch (\Exception $e) {
                        $errors['wrong_user'] = 'Попытка назначить задаче чужого пользователя';
                    }
                }
            }
        }
        if (count($errors)) {
            return $errors;
        }

        return true;
    }

    /**
     * @param string $sort
     * @param null $userID
     * @return mixed
     * @throws \Exception
     */
    public function getUserTasks($sort = 'DESC', $userID = null)
    {
        if (!$userID) {
            // getting current logined user
            $userID = Factory::AuthVendor()->getUserId();
        }
        
        // checking user really exists
        Factory::UserService()->getUserByID($userID);
        
        return Task::where('user_id', $userID)->orderBy('date', $sort)->get();
    }

    /**
     * @param int $parentID
     * @return mixed
     */
    public function getTasksByParentID($parentID = 0)
    {
        $userID = Factory::AuthVendor()->getUserId();
        return Task::where('parent_id', $parentID)->where('user_id', $userID)->get()->toArray();
    }
    
    /**
     * @param int $parentID
     * @return array
     */
    public function getChildrenTasksByParentID($parentID = 0)
    {
        $userID = Factory::AuthVendor()->getUserId();
        return Task::with('children')->where('parent_id', $parentID)->where('user_id', $userID)->get()->toArray();
    }
    
}