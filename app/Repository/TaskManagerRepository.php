<?php

namespace App\Repository;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Support\Collection;

class TaskManagerRepository
{
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

        if ($task)
        {
            $task->status_id = $statusId;

            return $task->save();
        }

        return false;
    }

    public function getTasksList(array $filters, $page, $perPage)
    {
        $builder = Task::query();

        if($filters['sprint_id'])
        {
            $builder->where('sprint_id', $filters['sprint_id']);
        }

        if ($filters['user_id'])
        {
            $builder->where('user_id', $filters['user_id']);
        }

        return $builder->latest()->paginate($perPage, page: $page);
    }

    public function validateTaskStatus(int $statusId)
    {
        return TaskStatus::find($statusId);
    }
}
