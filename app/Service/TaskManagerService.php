<?php

namespace App\Service;

use App\Repository\TaskManagerRepository;

class TaskManagerService
{
    protected $taskRepository;

    public function __construct(TaskManagerRepository $taskRepository = null)
    {
        $this->taskRepository = $taskRepository ?? new TaskManagerRepository();
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


    public function getTasksList(array $filters, mixed $page, mixed $perPage)
    {

        return $this->taskRepository->getTasksList($filters, $page, $perPage);
    }
}
