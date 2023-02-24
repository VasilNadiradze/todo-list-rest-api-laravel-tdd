<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TodoList;

class TaskController extends Controller
{
    public function index(TodoList $todo_list)
    {
        return response($todo_list->tasks);
    }

    public function store(Request $request, TodoList $todo_list)
    {
        return $todo_list->tasks()->create($request->all());
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response('', 204);
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return $task;
    }
}

