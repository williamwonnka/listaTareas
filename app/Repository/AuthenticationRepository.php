<?php

namespace App\Repository;

use App\Models\User;

class AuthenticationRepository
{
    public function getCredentials(string $username)
    {
        return User::where('username', $username)->first();
    }
}
