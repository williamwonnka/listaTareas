<?php

namespace App\Http\Controllers;

use App\Service\TaskManagerService;
use Illuminate\Http\Request;

class TaskManagerController extends Controller
{
    protected TaskManagerService $taskService;

    public function __construct(TaskManagerService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function getTasksList(Request $request)
    {
        $allParameterInApi = [
            'sprint_id' => 'integer',
            'user_id' => 'integer',
            'page' => 'integer|default:1',
            'per_page' => 'integer|default:5'
        ];

        $response = $this->validateParameters($allParameterInApi, $request->all());

        if (!$response->status)
        {
            return $this->error(
                $response->data,
                $this->errorBadRequest
            );
        }

        $apiDataReceived = $response->data;

        if (!isset($apiDataReceived['page']))
            $apiDataReceived['page'] = 1;

        if (!isset($apiDataReceived['per_page']))
            $apiDataReceived['per_page'] = 5;

        // start endpoint logic

        $filters = [
            'sprint_id' => $apiDataReceived['sprint_id'] ?? null,
            'user_id' => $apiDataReceived['user_id'] ?? null
        ];

        $tasks = $this->taskService->getTasksList($filters, $apiDataReceived['page'], $apiDataReceived['per_page']);

        return response()->json($tasks);
    }

    public function getTasksDetails(Request $request)
    {
        $allParameterInApi = [
            'task_id' => 'required|integer'
        ];

        $response = $this->validateParameters($allParameterInApi, $request->all());

        if (!$response->status)
        {
            return $this->error(
                $response->data,
                $this->errorBadRequest
            );
        }

        $apiDataReceived = $response->data;

        // start endpoint logic

        $tasks = $this->taskService->getTasksDetails($apiDataReceived['task_id']);

        if ($tasks->status)
        {
            return response()->json($tasks->data);
        }
        else
        {
            return $this->error(
                [
                    'errorType' => $tasks->errorType,
                    'detail' => $tasks->errorMessage
                ],
                $this->errorBadRequest
            );
        }
    }




    public function getTaskById(int $taskId)
    {
        $task = $this->taskService->getTaskById($taskId);
        return response()->json($task);
    }

    public function getCommentsByTaskId(int $taskId)
    {
        $comments = $this->taskService->getCommentsByTaskId($taskId);
        return response()->json($comments);
    }

    public function updateTaskStatus(Request $request, int $taskId)
    {
        $statusId = $request->input('status_id');
        $success = $this->taskService->updateTaskStatus($taskId, $statusId);
        return response()->json(['success' => $success]);
    }
}
