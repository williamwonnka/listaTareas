<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Collection;

class TaskManagerRepository
{
    public function getTasks(int $userId): Collection
    {
        if($userId != null)
            return Task::where('user_id', $userId)->latest()->paginate(5);
        else
            return Task::latest()->paginate(5);
    }

    public function getTaskById(int $taskId): ?Task
    {
        return Task::find($taskId);
    }

    public function getCommentsByTaskId(int $taskId): Collection
    {
        return Task::find($taskId)->comments;
    }

    public function updateTaskStatus(int $taskId, int $statusId): bool
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->task_status_id = $statusId;
            return $task->save();
        }
        return false;
    }
}
