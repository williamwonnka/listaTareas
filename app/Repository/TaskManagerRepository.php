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

    public function createTask(string $title, string $details, ?int $userId, ?int $sprintId): Task
    {
        $task = new Task();

        $task->title = $title;
        $task->details = $details;
        $task->user_id = $userId;
        $task->sprint_id = $sprintId;

        $task->save();

        return $task->refresh();
    }

    public function updateTask($taskId, ?string $title, ?string $details, ?int $userId, ?int $statusId, ?int $sprintId): int
    {
        $builder = Task::where('id', $taskId);

        $updatesArray = [];

        if ($title)
        {
            $updatesArray['title'] = $title;
        }

        if ($details)
        {
            $updatesArray['details'] = $details;
        }

        if ($userId)
        {
            $updatesArray['user_id'] = $userId;
        }

        if ($statusId)
        {
            $updatesArray['status_id'] = $statusId;
        }

        if ($sprintId)
        {
            $updatesArray['sprint_id'] = $sprintId;
        }

        return $builder->update($updatesArray);
    }
}
