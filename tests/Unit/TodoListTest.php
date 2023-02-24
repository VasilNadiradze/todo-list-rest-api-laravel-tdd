<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    public function test_todo_list_has_many_tasks()
    {
        $list = TodoList::factory()->create(['name' => 'my list']);
        $task = Task::factory()->create(['todo_list_id' => $list->id]);

        $this->assertInstanceOf(Task::class, $list->tasks->first());
    }

    public function test_if_todo_list_is_deleted_its_tasks_will_be_deleted_()
    {
        $list = TodoList::factory()->create(['name' => 'my list']);
        $task = Task::factory()->create(['todo_list_id' => $list->id]);

        $list->delete();

        $this->assertDatabaseMissing('todo_lists', ['id' => $list->id]);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}

