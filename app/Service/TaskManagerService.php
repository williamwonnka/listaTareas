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
        $response = new TaskManagerServiceResponse();

        if($this->taskRepository->getTaskById($taskId) == null)
        {
            $response->status = false;
            $response->errorType = 'not_found';
            $response->errorMessage = 'Task not found';

            return $response;
        }

        if(!$this->taskRepository->validateTaskStatus($statusId))
        {
            $response->status = false;
            $response->errorType = 'not_found';
            $response->errorMessage = 'Status not found';

            return $response;
        }

        if($this->taskRepository->updateTaskStatus($taskId, $statusId))
        {
            $response->status = true;
            $response->message = 'Task status updated';

            return $response;
        }
        else
        {
            $response->status = false;
            $response->errorType = 'internal_error';
            $response->errorMessage = 'Task status not updated';

            return $response;
        }
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

    public function createTask(string $title, string $details, int|null $userId, int|null $sprintId)
    {
        $response = new TaskManagerServiceResponse();

        $result = $this->taskRepository->createTask($title, $details, $userId, $sprintId);

        if ($result)
        {
            $response->status = true;
            $response->message = 'Task created';
            $response->data = $result->toArray();

            return $response;
        }
        else
        {
            $response->status = false;
            $response->errorType = 'internal_error';
            $response->errorMessage = 'Task not created';

            return $response;
        }
    }

    public function updateTask(int $taskId, string|null $title, string|null $details, int|null $userId, int|null $statusId, int|null $sprintId)
    {
        $response = new TaskManagerServiceResponse();

        $result = $this->taskRepository->updateTask($taskId, $title, $details, $userId, $statusId, $sprintId);

        $taskUpdated = $this->taskRepository->getTaskById($taskId);

        if ($result > 0)
        {
            $response->status = true;
            $response->message = 'Task updated';
            $response->data = $taskUpdated->toArray();

            return $response;
        }
        else
        {
            $response->status = false;
            $response->errorType = 'internal_error';
            $response->errorMessage = 'Task not updated';

            return $response;
        }
    }

    public function deleteTask(int $taskId)
    {
        $response = new TaskManagerServiceResponse();

        $result = $this->taskRepository->deleteTask($taskId);

        if ($result)
        {
            $response->status = true;
            $response->message = 'Task deleted';

            return $response;
        }
        else
        {
            $response->status = false;
            $response->errorType = 'internal_error';
            $response->errorMessage = 'Task not deleted';

            return $response;
        }
    }
}
