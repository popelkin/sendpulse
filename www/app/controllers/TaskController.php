<?php

namespace App\Controllers;

use App\Factory;
use App\Models\Task;

class TaskController extends MainController
{

    /**
     *
     */
    public function tasksPage()
    {
        $sort = 'DESC';
        if ($_GET['s'] == 'a') {
            $sort = 'ASC';
        }
        $this->display('tasks', [
            'email' => Factory::AuthVendor()->getEmail(),
            'tasks' => Task::orderBy('date', $sort)->get(),
            'sort' => $sort
        ]);
    }

    /**
     * @param $id
     */
    public function deleteTaskByID($id)
    {
        try {
            Factory::TaskService()->deleteTaskByID($id);
            $this->redirect('/tasks/');
        } catch (\Exception $e) {
            $this->redirect('/404/');
        }
    }

    /**
     *
     */
    public function createTaskPage()
    {
        $this->display('create', [
            'email' => Factory::AuthVendor()->getEmail(),
            'tasks' => Task::with('children')->where('parent_id', 0)->get(),
            'delimiter' => '',
        ]);
    }

    /**
     * @param $data
     */
    public function addTask($data)
    {
        $result = Factory::TaskService()->addTask($data);

        if (is_array($result)) {
            // fields validation error 
            $this->display('create', [
                'email' => Factory::AuthVendor()->getEmail(),
                'errors' => $result,
                'tasks' => Task::with('children')->where('parent_id', 0)->get(),
                'delimiter' => '',
            ]);
        } else {
            // ok
            $this->redirect('/tasks/');
        }
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function editTaskPage($id)
    {
        try {
            $this->display('edit', [
                'task' => Factory::TaskService()->getTaskByID($id),
                'email' => Factory::AuthVendor()->getEmail(),
                'tasks' => Task::with('children')->where('parent_id', 0)->get(),
                'delimiter' => '',
            ]);
        } catch (\Exception $e) {
            $this->redirect('/404/');
        }
    }

    /**
     * @param $id
     * @param $data
     */
    public function updateTask($id, $data)
    {
        try {
            $result = Factory::TaskService()->updateTask($id, $data);

            if (is_array($result)) {
                // fields validation error 
                $this->display('edit', [
                    'email' => Factory::AuthVendor()->getEmail(),
                    'errors' => $result,
                    'tasks' => Task::where('parent_id', 0)->get(),
                    'delimiter' => '',
                ]);
            } else {
                // ok
                $this->redirect('/tasks/');
            }
        } catch (\Exception $e) {
            // wrong task ID
            $this->redirect('/404/');
        }
    }

}