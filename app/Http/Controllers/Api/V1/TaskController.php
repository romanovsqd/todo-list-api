<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $tasks = Task::query()->paginate(10);

        return response()->json([
            'tasks' => $tasks,
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $taskData = $request->validated();

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

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('edit', $task);

        $taskData = $request->validate();

        $task->update($taskData);

        return response()->json([
            'task' => $task,
        ]);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json([
            'message' => 'Task deleted.'
        ]);
    }
}
