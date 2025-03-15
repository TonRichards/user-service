<?php

namespace App\Actions;

use App\Models\User;
use App\Data\UserData;

class UpdateUserAction
{
    public static function execute(User $user, array $data): User
    {
        $userData = UserData::fromArray($data);

        if (is_null($userData['password'])) {
            unset($userData['password']);
        }

        $user->update($userData);

        return $user;
    }
}