<?php

require_once __DIR__ . '/../../init-tests.php';

use PHPUnit\Framework\TestCase;
use App\Factory;
use App\Models\Task;

class TaskServiceTest extends TestCase
{

    const ONE_DAY_SECONDS = 24 * 60 * 60;

    public function setUp()
    {
        Task::truncate();
    }

    public function testTaskExists()
    {
        $data = [
            'title' => 'Test title',
            'body' => 'Test body',
            'date' => date('Y-m-d H:i:s'),
            'user_id' => 1,
        ];
        $taskNew = Factory::TaskService()->addTask($data);

        $task = Factory::TaskService()->getTaskByID($taskNew->id);
        $this->assertIsObject($task);
        $this->assertEquals($taskNew->id, $task->id);
    }

    public function testTaskNotExists()
    {
        $this->expectException(Exception::class);
        Factory::TaskService()->getTaskByID(0);
    }

    public function testTaskIsUpdatedCorrectly()
    {
        $data = [
            'title' => "Title task",
            'body' => "Body task",
            'date' => date("Y-m-d"),
            'user_id' => 1,
        ];
        $task = Factory::TaskService()->addTask($data);

        $newTitle = 'New title';

        Factory::TaskService()->updateTask($task->id, ['title' => $newTitle]);

        $task = Factory::TaskService()->getTaskByID($task->id);

        $this->assertEquals($task->title, $newTitle);
    }

    public function testTaskParentDoneByChildren()
    {
        $parentData = [
            'title' => "Title task",
            'body' => "Body task",
            'date' => date("Y-m-d"),
            'user_id' => 1,
        ];
        $parentTask = Factory::TaskService()->addTask($parentData);

        $childTaskData = [
            'title' => "Title child task",
            'body' => "Body child task",
            'date' => date("Y-m-d", time() + 7 * self::ONE_DAY_SECONDS),
            'parent_id' => $parentTask->id,
            'user_id' => 1,
        ];

        $childTask = Factory::TaskService()->addTask($childTaskData);

        Factory::TaskService()->updateTask($childTask->id, ['done' => 1]);

        $parentTaskCurrentStateData = Factory::TaskService()->getTaskByID($parentTask->id);
        $this->assertNotEmpty($parentTaskCurrentStateData['done']);
    }

    public function testTaskIsDeleted()
    {
        $data = [
            'title' => "Title task",
            'body' => "Body task",
            'date' => date("Y-m-d"),
        ];
        $task = Factory::TaskService()->addTask($data);

        $insertedID = $task->id;

        $task->delete();

        $this->expectException(Exception::class);
        Factory::TaskService()->getTaskByID($insertedID);
    }

    public function testTaskIsDeletedWithChilds()
    {
        $parentData = [
            'title' => "Title task",
            'body' => "Body task",
            'date' => date("Y-m-d"),
        ];
        $parentTask = Factory::TaskService()->addTask($parentData);
        $parentID = $parentTask->id;

        $childTaskData = [
            'title' => "Title child task",
            'body' => "Body child task",
            'date' => date("Y-m-d", time() + 7 * self::ONE_DAY_SECONDS),
            'parent_id' => $parentTask->id,
        ];

        $childTask = Factory::TaskService()->addTask($childTaskData);
        $childID = $childTask->id;

        $parentTask->delete();
        
        $this->expectException(Exception::class);
        Factory::TaskService()->getTaskByID($parentID);
        
        $this->expectException(Exception::class);
        Factory::TaskService()->getTaskByID($childID);
    }

    public function testTaskAddWrongLevelError()
    {
        $parentData = [
            'title' => "Title task",
            'body' => "Body task",
            'date' => date("Y-m-d"),
            'user_id' => 1,
        ];
        $parentTask = Factory::TaskService()->addTask($parentData);

        $childTaskData = [
            'title' => "Title child task",
            'body' => "Body child task",
            'date' => date("Y-m-d", time() + 7 * self::ONE_DAY_SECONDS),
            'parent_id' => $parentTask->id,
            'user_id' => 1,
        ];

        $childTask = Factory::TaskService()->addTask($childTaskData);
        $childID = $childTask->id;
        
        $childTaskData2 = [
            'title' => "Title child task 2",
            'body' => "Body child task 2",
            'date' => date("Y-m-d", time() + 7 * self::ONE_DAY_SECONDS),
            'parent_id' => $childID,
            'user_id' => 1,
        ];
        
        $result = Factory::TaskService()->addTask($childTaskData2);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('wrong_level', $result);
    }
    
    public function testTaskAddFailButIncorrectData()
    {
        $data = [
            'title' => "Title task",
            'body' => "Body task",
            'date' => date("Y-m-d", time() - self::ONE_DAY_SECONDS),
        ];
        $result = Factory::TaskService()->addTask($data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('incorrect_data_past', $result);
    }
    
}