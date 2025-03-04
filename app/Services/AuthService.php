<?php

namespace App\Services;

use App\Models\User;
use App\Data\UserData;

class AuthService
{
    public function register($data = []): User
    {
        return User::create(UserData::fromArray($data));
    }
}