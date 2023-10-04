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
}
