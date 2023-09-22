<?php

namespace App\Service;

use App\Models\Entity\Response\AuthenticationServiceResponse;
use App\Repository\AuthenticationRepository;

class AuthenticationService
{
    private AuthenticationRepository $authenticationRepository;

    public function __construct(AuthenticationRepository $authenticationRepository)
    {
        $this->authenticationRepository = $authenticationRepository;
    }

    public function authenticate(string $username, string $password): AuthenticationServiceResponse
    {
        $response = new AuthenticationServiceResponse();

        $credentials = $this->authenticationRepository->getCredentials($username);

        if ($credentials && password_verify($password, $credentials->password))
        {
            $response->status = true;
            $response->userId = $credentials->id;
        }
        else
        {
            $response->status = false;
            $response->errorMessage = 'Invalid credentials';
            $response->errorType = 'unauthorized';
        }

        return $response;
    }
}
