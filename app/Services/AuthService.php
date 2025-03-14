<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function model(): User
    {
        return new User();
    }

    public function login($data): ?User
    {
        if (!Auth::attempt($data)) {
            return null;
        }

        return Auth::user();
    }
}