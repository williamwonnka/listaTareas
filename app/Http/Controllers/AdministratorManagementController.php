<?php

namespace App\Http\Controllers;

use App\Service\AdministratorManagementService;
use Illuminate\Http\Request;

class AdministratorManagementController extends Controller
{
    public AdministratorManagementService $administratorManagementService;

    public function __construct(AdministratorManagementService $administratorManagementService)
    {
        $this->administratorManagementService = $administratorManagementService;
    }

    public function createUser(Request $request)
    {
        $allParameterInApi = [
            'username' => 'required|string',
            'password' => 'required|string',
            'name' => 'string',
            'lastname' => 'string'
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

        if (!isset($apiDataReceived['lastname']))
        {
            $apiDataReceived['lastname'] = '';
        }

        // start endpoint logic

        $response = $this->administratorManagementService->createUser($apiDataReceived['username'], $apiDataReceived['password'], $apiDataReceived['name'], $apiDataReceived['lastname']);

        if ($response->status)
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

    public function getAllUsers(Request $request)
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
        {
            $apiDataReceived['page'] = 1;
        }

        if (!isset($apiDataReceived['per_page']))
        {
            $apiDataReceived['per_page'] = 5;
        }

        // start endpoint logic

        $response = $this->administratorManagementService->getAllUsers($apiDataReceived['page'], $apiDataReceived['per_page']);

        if ($response->status)
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

    public function updateUser(Request $request)
    {
        $allParameterInApi = [
            'userId' => 'required|integer',
            'username' => 'string',
            'password' => 'string',
            'name' => 'string',
            'lastname' => 'string'
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

        $response = $this->administratorManagementService->updateUser($apiDataReceived['userId'], $apiDataReceived['username'] ?? null, $apiDataReceived['password'] ?? null, $apiDataReceived['name'] ?? null, $apiDataReceived['lastname'] ?? null);

        if ($response->status)
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
