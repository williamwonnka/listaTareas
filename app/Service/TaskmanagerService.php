<?php

namespace App\Services;

use App\Repositories\TaskManagerRepository;

class TaskmanagerService
{
    protected $taskRepository;

    public function __construct(TaskManagerRepository $taskRepository = null)
    {
        $this->taskRepository = $taskRepository ?? new TaskManagerRepository();
    }

    public function getTasksByUser(int $userId = null)
    {
        return $this->taskRepository->getTasks($userId);
    }

    public function getTaskById(int $taskId)
    {
        return $this->taskRepository->getTaskById($taskId);
    }

    public function getCommentsByTaskId(int $taskId)
    {
        return $this->taskRepository->getCommentsByTaskId($taskId);
    }

    public function updateTaskStatus(int $taskId, int $statusId)
    {
        return $this->taskRepository->updateTaskStatus($taskId, $statusId);
    }
}
