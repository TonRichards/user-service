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

    public function assignCurrentOrganization(User $user, ?string $organizationId = null): void
    {
        if (!$organizationId) {
            $organizationId = $user->organizations()->first()?->id;
        }

        $user->forceFill([
            'current_organization_id' => $organizationId,
        ])->save();
    }
}