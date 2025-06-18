<?php

namespace App\Data;

use App\Models\User;

class JwtData
{
    public function prepare(User $user): array
    {
        return [
            'sub' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'current_organization_id' => $user->current_organization_id,
            'current_organization_name' => $user->currentOrganization?->name,
            'organizations'  => $this->organizations($user->organizations), // @phpstan-ignore-line
            'exp' => time() + env('JWT_EXP', 3600),
            'iss' => 'user-service',
        ];
    }

    private function organizations($organizations): array
    {
        return $organizations->map(function ($organization) {
            return [
                'organization_id' => $organization->id,
                'name' => $organization->name,
                'role' => $organization->pivot->role_id,
            ];
        })->toArray();
    }
}