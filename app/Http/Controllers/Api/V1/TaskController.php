<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return response()->json([
            'tasks' => $tasks,
        ]);
    }

    public function store(Request $request)
    {
        $taskData = $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $taskData['user_id'] = auth()->id();

        $task = Task::create($taskData);

        return response()->json([
            'task' => $task,
        ]);
    }

    public function show(Task $task)
    {
        return response()->json([
            'task' => $task,
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $taskData = $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['nullable', 'string', 'max:255'],
            'is_completed' => ['boolean'],
        ]);

        $task->update($taskData);

        return response()->json([
            'task' => $task,
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted.'
        ]);
    }
}
