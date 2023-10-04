<?php

namespace App\Http\Controllers;

use App\Service\BacklogService;
use Illuminate\Http\Request;

class BacklogController extends Controller
{
    private BacklogService $backlogService;

    public function __construct(BacklogService $backlogService)
    {
        $this->backlogService = $backlogService;
    }

    public function createSprint(Request $request)
    {
        $allParameterInApi = [
            'name' => 'required|string',
            'start_date' => 'date',
            'end_date' => 'date',
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

        $response = $this->backlogService->createSprint($apiDataReceived['name'], $apiDataReceived['start_date'] ?? null, $apiDataReceived['end_date'] ?? null, $apiDataReceived['project_id']);

        if ($response->status)
        {
            return response()->json($response->data);
        }
        else
        {
            return $this->error(
                $response->data,
                $this->errorBadRequest
            );
        }
    }

    public function getSprintListWithTasks(Request $request)
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

        $response = $this->backlogService->getSprintListWithTasks($apiDataReceived['project_id']);

        if ($response->status)
        {
            return response()->json($response->data);
        }
        else
        {
            return $this->error(
                $response->data,
                $this->errorBadRequest
            );
        }
    }

    public function updateSprint(Request $request)
    {
        $allParameterInApi = [
            'name' => 'string',
            'start_date' => 'date',
            'end_date' => 'date',
            'sprint_id' => 'required|integer',
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

        if (!isset($apiDataReceived['name']))
        {
            $apiDataReceived['name'] = '';
        }

        // start endpoint logic

        $response = $this->backlogService->updateSprint($apiDataReceived['sprint_id'], $apiDataReceived['name'], $apiDataReceived['start_date'] ?? null, $apiDataReceived['end_date'] ?? null);

        if ($response->status)
        {
            return response()->json($response->data);
        }
        else
        {
            return $this->error(
                $response->data,
                $this->errorBadRequest
            );
        }
    }

    public function deleteSprint(Request $request)
    {
        $allParameterInApi = [
            'sprint_id' => 'required|integer',
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

        $response = $this->backlogService->deleteSprint($apiDataReceived['sprint_id']);

        if ($response->status)
        {
            return response()->json($response);
        }
        else
        {
            return $this->error(
                $response->data,
                $this->errorBadRequest
            );
        }
    }
}
