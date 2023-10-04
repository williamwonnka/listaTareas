<?php

namespace App\Repository;

use App\Models\User;

class AdministratorManagementRepository
{
    public function getAllUsers(mixed $page, mixed $perPage)
    {
        $users = User::latest()->paginate($perPage, page: $page);

        return $users;
    }

    public function getUserById(mixed $userId)
    {
        $user = User::find($userId);

        return $user;
    }

    public function getUserByUsername(mixed $username)
    {
        $user = User::where('username', $username)->first();

        return $user;
    }

    public function updateUser(mixed $userId, mixed $username, mixed $password, mixed $name, mixed $lastname)
    {
        $builder = User::where('id', $userId);

        $updateData = [];

        if ($username != null && $username != '')
        {
            $updateData['username'] = $username;
        }

        if ($password != null && $password != '')
        {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($name != null && $name != '')
        {
            $updateData['name'] = $name;
        }

        if ($lastname != null && $lastname != '')
        {
            $updateData['lastname'] = $lastname;
        }

        return$builder->update($updateData);
    }

    public function deleteUser(mixed $userId)
    {
        $builder = User::where('id', $userId);

        return $builder->delete();
    }
}
