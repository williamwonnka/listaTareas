<?php

namespace App\Services;

use App\Repositories\TaskManagerRepository;

class TaskmanagerService
{
    protected $taskRepository;

    public function __construct(TaskManagerRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getTasksByUser(int $userId)
    {
        return $this->taskRepository->getTasksByUser($userId);
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
