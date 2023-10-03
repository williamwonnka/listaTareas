<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AuthenticationRepository
{
    public function getCredentials(string $username)
    {
        return User::where('username', $username)->first();
    }

    public function register(mixed $username, mixed $password, mixed $name, mixed $lastname): User|bool
    {
        $user = new User();

        $user->username = $username;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->name = $name;
        $user->lastname = $lastname;

        if($user->save())
        {
            return $user;
        }
        else
        {
            return false;
        }
    }

    public function checkForRegisteredUser(mixed $username): ?User
    {
        return User::where('username', $username)->first();
    }
}
