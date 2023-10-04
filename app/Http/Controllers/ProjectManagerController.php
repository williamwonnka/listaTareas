<?php

namespace App\Http\Controllers;

use App\Service\ProjectManagerService;
use App\Service\TaskManagerService;
use Illuminate\Http\Request;

class ProjectManagerController extends Controller
{
    protected ProjectManagerService $projectManagerService;

    public function __construct(ProjectManagerService $projectManagerService)
    {
        $this->projectManagerService = $projectManagerService;
    }

    public function getProjectList(Request $request)
    {
        $allParameterInApi = [
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
        $tasks = $this->projectManagerService->getProjectList($apiDataReceived['page'], $apiDataReceived['per_page']);

        return response()->json($tasks);
    }

    public function createProject(Request $request)
    {
        $allParameterInApi = [
            'name' => 'required|string',
            'description' => 'string'
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

        if (!isset($apiDataReceived['description']))
            $apiDataReceived['description'] = '';

        // start endpoint logic

        $response = $this->projectManagerService->createProject($apiDataReceived['name'], $apiDataReceived['description']);

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

    public function updateProject(Request $request)
    {
        $allParameterInApi = [
            'project_id' => 'required|integer',
            'name' => 'string',
            'description' => 'string'
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

        if (!isset($apiDataReceived['description']))
            $apiDataReceived['description'] = '';

        if (!isset($apiDataReceived['name']))
            $apiDataReceived['name'] = '';

        // start endpoint logic

        $response = $this->projectManagerService->updateProject(
            $apiDataReceived['project_id'],
            $apiDataReceived['name'],
            $apiDataReceived['description']
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

    public function deleteProject(Request $request)
    {
        $allParameterInApi = [
            'project_id' => 'required|integer'
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

        $result = $this->projectManagerService->deleteProject($apiDataReceived['project_id']);

        if ($result->status)
        {
            return response()->json($result);
        }
        else
        {
            return $this->error(
                [
                    'errorType' => $result->errorType,
                    'detail' => $result->errorMessage
                ],
                $this->errorBadRequest
            );
        }
    }
}
