<?php

namespace App\Service;

use App\Models\Entity\Response\AuthenticationServiceResponse;
use App\Repository\AuthenticationRepository;
use function PHPUnit\Framework\isNull;

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

    public function register(mixed $username, mixed $password, mixed $name, mixed $lastname): AuthenticationServiceResponse
    {
        $response = new AuthenticationServiceResponse();

        $userValidation = $this->authenticationRepository->checkForRegisteredUser($username);

        if ($userValidation)
        {
            $response->status = false;
            $response->errorMessage = 'User already registered';
            $response->errorType = 'bad_request';

            return $response;
        }

        $user = $this->authenticationRepository->register($username, $password, $name, $lastname);

        if($user)
        {
            $response->status = true;
            $response->userId = $user->id;
        }
        else
        {
            $response->status = false;
            $response->errorMessage = 'Error while registering user';
            $response->errorType = 'internal_server_error';
        }

        return $response;
    }
}
