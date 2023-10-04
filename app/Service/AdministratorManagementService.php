<?php

namespace App\Service;

use App\Models\Entity\Response\AdministratorManagementServiceResponse;
use App\Models\Entity\Response\AuthenticationServiceResponse;
use App\Repository\AdministratorManagementRepository;

class AdministratorManagementService
{
    public AdministratorManagementRepository $administratorManagementRepository;
    public AuthenticationService $authenticationService;

    public function __construct(AdministratorManagementRepository $administratorManagementRepository)
    {
        $this->administratorManagementRepository = $administratorManagementRepository;
    }

    public function createUser(mixed $username, mixed $password, mixed $name, mixed $lastname)
    {
        $response = new AdministratorManagementServiceResponse();

        $this->authenticationService = app()->get(AuthenticationService::class);

        $result = $this->authenticationService->register($username, $password, $name, $lastname);

        if ($result->status)
        {
            $response->status = true;
            $response->userId = $result->userId;
        }
        else
        {
            $response = $result;
        }
        return $response;
    }

    public function getAllUsers(mixed $page, mixed $per_page)
    {
        $response = new AdministratorManagementServiceResponse();

        $users = $this->administratorManagementRepository->getAllUsers($page, $per_page);

        if ($users)
        {
            $response->status = true;
            $response->data = $users->toArray();
        }
        else
        {
            $response->status = false;
            $response->errorMessage = 'No users found';
            $response->errorType = 'not_found';
        }

        return $response;
    }
}
