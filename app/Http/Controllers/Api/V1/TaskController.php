<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index(IndexTaskRequest $request): JsonResponse
    {
        $tasks = Task::query()
            ->with(['user:id,name,email'])
            ->isCompleted($request->is_completed)
            ->applySort($request->sort_by)
            ->paginate(10);

        return response()->json([
            'tasks' => TaskResource::collection($tasks),
        ]);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $taskData = $request->validated();

        $taskData['user_id'] = auth()->id();

        $task = Task::create($taskData);

        return response()->json([
            'tasks' => TaskResource::make($task),
        ]);
    }

    public function show(Task $task): JsonResponse
    {
        $task->load(['user']);

        return response()->json([
            'task' => TaskResource::make($task),
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $this->authorize('edit', $task);

        $taskData = $request->validate();

        $task->update($taskData);

        return response()->json([
            'tasks' => TaskResource::make($task),
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json([
            'message' => 'Task deleted.'
        ]);
    }
}
