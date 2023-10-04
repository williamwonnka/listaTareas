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

}
