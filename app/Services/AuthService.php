<?php

namespace App\Services;

use App\Models\User;
use App\Data\UserData;

class AuthService
{
    public function model(): User
    {
        return new User();
    }

    public function register($data = []): User
    {
        return $this->model()->create(UserData::fromArray($data));
    }
}