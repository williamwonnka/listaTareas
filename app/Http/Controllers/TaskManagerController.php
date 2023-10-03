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
            'page' => 'integer',
            'per_page' => 'integer'
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

    public function updateTaskStatus(Request $request)
    {
        $allParameterInApi = [
            'status_id' => 'required|integer',
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

        $response = $this->taskService->updateTaskStatus($apiDataReceived['task_id'], $apiDataReceived['status_id']);

        if($response->status)
        {
            return response()->json($response);
        }
        else
        {
            return $this->error(
                [
                    'errorType' => $response->errorType,
                    'detail' => $response->errorMessage
                ],
                $this->errorBadRequest
            );
        }
    }

    public function createTask(Request $request)
    {
        $allParameterInApi = [
            'title' => 'required|string',
            'details' => 'string',
            'user_id' => 'integer',
            'sprint_id' => 'integer'
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

        $response = $this->taskService->createTask($apiDataReceived['title'], $apiDataReceived['details'] ?? '', $apiDataReceived['user_id'] ?? null, $apiDataReceived['sprint_id'] ?? null);

        if($response->status)
        {
            return response()->json($response);
        }
        else
        {
            return $this->error(
                [
                    'errorType' => $response->errorType,
                    'detail' => $response->errorMessage
                ],
                $this->errorBadRequest
            );
        }
    }

    public function updateTask(Request $request)
    {
        $allParameterInApi = [
            'task_id' => 'required|integer',
            'title' => 'string',
            'details' => 'string',
            'user_id' => 'integer',
            'status_id' => 'integer',
            'sprint_id' => 'integer'
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

        $response = $this->taskService->updateTask(
            $apiDataReceived['task_id'],
            $apiDataReceived['title'] ?? null,
            $apiDataReceived['details'] ?? null,
            $apiDataReceived['user_id'] ?? null,
            $apiDataReceived['status_id'] ?? null,
            $apiDataReceived['sprint_id'] ?? null
        );

        if($response->status)
        {
            return response()->json($response);
        }
        else
        {
            return $this->error(
                [
                    'errorType' => $response->errorType,
                    'detail' => $response->errorMessage
                ],
                $this->errorBadRequest
            );
        }
    }
}
