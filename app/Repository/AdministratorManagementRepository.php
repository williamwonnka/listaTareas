<?php

namespace App\Repository;

use App\Models\User;

class AdministratorManagementRepository
{

    public function createUser(mixed $username, mixed $password, mixed $name, mixed $lastname)
    {
        $user = new User();

        $user->username = $username;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->name = $name;
        $user->lastname = $lastname;

        $user->save();

        return $user->refresh();
    }
}
