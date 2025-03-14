<?php

namespace App\Services;

use App\Models\User;
use App\Data\UserData;

class UserService
{
    public function model(): User
    {
        return new User();
    }

    public function store(array $data = []): User
    {
        return $this->model()->create(UserData::fromArray($data));
    }
}