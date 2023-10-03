<?php

namespace App\Service;

use App\Models\Entity\Response\TaskManagerServiceResponse;
use App\Repository\TaskManagerRepository;

class TaskManagerService
{
    protected $taskRepository;

    public function __construct(TaskManagerRepository $taskRepository = null)
    {
        $this->taskRepository = $taskRepository ?? new TaskManagerRepository();
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

    public function getTasksDetails(int $taskId)
    {
        $response = new TaskManagerServiceResponse();

        $task = $this->taskRepository->getTaskById($taskId);

        if (!$task)
        {
            $response->status = false;
            $response->errorType = 'not_found';
            $response->errorMessage = 'Task not found';

            return $response;
        }

        $response->status = true;

        $comments = $this->taskRepository->getCommentsByTaskId($taskId);

        $response->data['task'] = $task;

        $response->data['comments'] = $comments->toArray();

        return $response;
    }
}
