<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;
use App\Models\TodoList;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private $list;

    public function setUp():void
    {
        parent::setUp();
        $this->authUser();
        $this->list = TodoList::factory()->create(['name' => 'my list']);
    }

    public function test_fetch_tasks_for_todo_list()
    {
        $task = Task::factory()->create(['todo_list_id' => $this->list->id]);

        $response = $this->getJson(route('todo-list.task.index',$this->list->id))->assertOk()->json();

        $this->assertEquals(1, count($response));
        $this->assertEquals($task->title, $response[0]['title']);
    }

    public function test_store_task_for_todo_list()
    {
        $task = Task::factory()->make();

        $response = $this->postJson(route('todo-list.task.store', $this->list->id),['title' => $task->title])
                ->assertcreated();

        $this->assertDatabaseHas('tasks', [
            'title' => $task->title,
            'todo_list_id' => $this->list->id
        ]);
    }

    public function test_delete_task()
    {
        $task = Task::factory()->create();

        $this->deleteJson(route('task.destroy', $task->id))
                ->assertNoContent();

        $this->assertDatabaseMissing('tasks', ['title' => $task->title]);
    }

    public function test_update_task()
    {
        $task = Task::factory()->create();

        $response = $this->putJson(route('task.update',$task->id),['title' => 'new title'])
                ->assertOk();

        $this->assertDatabaseHas('tasks', ['title' => 'new title']);
    }
}


