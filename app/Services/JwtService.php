<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Data\JwtData;
use Illuminate\Support\Str;
use App\Models\RefreshToken;
use Illuminate\Support\Facades\Config;

class JwtService
{
    public function __construct(protected JwtData $jwtData) {}

    public function generate(User $user)
    {
        $payload = $this->jwtData->prepare($user);

        return $this->encode($payload);
    }

    public function refresh(User $user)
    {
        $refreshToken = Str::random(64);

        RefreshToken::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $refreshToken),
            'expires_at' => now()->addDays(7),
        ]);

        return $refreshToken;
    }

    public function validate(string $plainToken): ?User
    {
        $hashedToken = hash('sha256', $plainToken);

        $refreshToken = RefreshToken::where('token', $hashedToken)
            ->where('expires_at', '>', now())
            ->first();

        $user = User::find($refreshToken->user_id) ?? null;

        return $user;
    }

    public function encode(array $payload): string
    {
        return JWT::encode($payload, config('jwt.private_key'), config('jwt.algorithm'));
    }

    public function decode($token)
    {
        return JWT::decode($token, new Key(config('jwt.public_key'), config('jwt.algorithm')));
    }

    public function revoke(string $plainToken): void
    {
        RefreshToken::where('token', hash('sha256', $plainToken))->delete();
    }

    public function revokeAll(User $user): void
    {
        RefreshToken::where('user_id', $user->id)->delete();
    }
}
