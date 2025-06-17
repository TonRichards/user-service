<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Config;

class JwtService
{
    public function generate(User $user)
    {
        $privateKey = file_get_contents(base_path(env('JWT_PRIVATE_KEY_PATH')));

        $payload = [
            'sub' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'current_organization_id' => $user->current_organization_id,
            'organizations'  => $this->organizations($user->organizations), // @phpstan-ignore-line
            'exp' => time() + env('JWT_EXP', 3600),
            'iss' => 'user-service',
            'aud' => 'order-service',
        ];

        return JWT::encode($payload, $privateKey, env('JWT_ALGO', 'RS256'));
    }

    public function decode(string $token): object
    {
        return JWT::decode($token, new Key($publicKey, 'RS256'));
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
