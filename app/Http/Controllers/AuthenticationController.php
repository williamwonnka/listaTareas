<?php

namespace App\Http\Controllers;

use App\Service\AuthenticationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    private AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @throws Exception
     */
    public function login(Request $request)
    {
        $allParameterInApi = [
            'username' => 'required|string',
            'password' => 'required|string'
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

        $authenticationResponse = $this->authenticationService->authenticate(
            $apiDataReceived['username'],
            $apiDataReceived['password']
        );

        if ($authenticationResponse->status)
        {
            return $this->success(
                ['user_id' => $authenticationResponse->userId],
                'User authenticated successfully'
            );
        }
        else
        {
            return $this->error(
                [
                    'errorType' => $authenticationResponse->errorType,
                    'detail' => $authenticationResponse->errorMessage
                ],
                $this->errorUnauthorized
            );
        }
    }

    public function register(Request $request)
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

        //validating non required parameters
        if (!isset($apiDataReceived['name']))
            $apiDataReceived['name'] = '';

        if (!isset($apiDataReceived['lastname']))
            $apiDataReceived['lastname'] = '';

        //start script

        $authenticationResponse = $this->authenticationService->register(
            $apiDataReceived['username'],
            $apiDataReceived['password'],
            $apiDataReceived['name'],
            $apiDataReceived['lastname']
        );

        if ($authenticationResponse->status)
        {
            return $this->success(
                ['user_id' => $authenticationResponse->userId],
                'User registered successfully'
            );
        }
        else
        {
            return $this->error(
                [
                    'errorType' => $authenticationResponse->errorType,
                    'detail' => $authenticationResponse->errorMessage
                ],
                $this->errorBadRequest
            );
        }
    }
}
