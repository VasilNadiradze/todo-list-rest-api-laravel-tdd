<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;

class TaskCompletedTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_status_can_be_changed()
    {
        $this->authUser();

        $task = Task::factory()->create();

        $this->patchJson(route('task.update', $task->id),['status' => 'started']);

        $this->assertDatabaseHas('tasks', ['status' => 'started']);
    }
}

