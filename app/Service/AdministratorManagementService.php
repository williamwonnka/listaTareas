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

    public function updateUser(mixed $userId, mixed $username, mixed $password, mixed $name, mixed $lastname)
    {
        $response = new AdministratorManagementServiceResponse();

        $user = $this->administratorManagementRepository->getUserById($userId);

        if ($user)
        {
            if($username != null && $username != '')
            {
                $userValidation = $this->administratorManagementRepository->getUserByUsername($username);

                if ($userValidation)
                {
                    $response->status = false;
                    $response->errorMessage = 'Username already exists';
                    $response->errorType = 'already_exists';

                    return $response;
                }
            }

            $result = $this->administratorManagementRepository->updateUser($userId, $username, $password, $name, $lastname);

            if ($result)
            {
                $updatedUser = $this->administratorManagementRepository->getUserById($userId);

                $response->status = true;
                $response->data = $updatedUser->toArray();
            }
            else
            {
                $response->status = false;
                $response->errorMessage = 'User not updated';
                $response->errorType = 'not_updated';
            }
        }
        else
        {
            $response->status = false;
            $response->errorMessage = 'User not found';
            $response->errorType = 'not_found';
        }

        return $response;
    }

    public function deleteUser(mixed $userId)
    {
        $response = new AdministratorManagementServiceResponse();

        $user = $this->administratorManagementRepository->getUserById($userId);

        if ($user)
        {
            $result = $this->administratorManagementRepository->deleteUser($userId);

            if ($result)
            {
                $response->status = true;
                $response->message = 'User deleted';
            }
            else
            {
                $response->status = false;
                $response->errorMessage = 'User not deleted';
                $response->errorType = 'not_deleted';
            }
        }
        else
        {
            $response->status = false;
            $response->errorMessage = 'User not found';
            $response->errorType = 'not_found';
        }

        return $response;
    }
}
