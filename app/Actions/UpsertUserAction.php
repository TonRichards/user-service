<?php

namespace App\Actions;

use App\Models\User;
use App\Data\UserData;

class UpsertUserAction
{
    public static function execute(array $data = []): User
    {
        $userData = UserData::fromArray($data);

        if (is_null($userData['password'])) {
            unset($userData['password']);
        }

        $user = User::updateOrCreate([
            'email' => $data['email'],
        ], $userData);

        return $user;
    }
}