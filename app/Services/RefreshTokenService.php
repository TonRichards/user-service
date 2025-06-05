<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\RefreshToken;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class RefreshTokenService
{
    public function create(User $user): string
    {
        $plainToken = Str::random(64);

        RefreshToken::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $plainToken),
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        return $plainToken;
    }

    public function validate(string $plainToken): ?User
    {
        $hashedToken = hash('sha256', $plainToken);
        $refreshToken = RefreshToken::where('token', $hashedToken)
            ->where('expires_at', '>', now())
            ->first();

        $user = User::find($refreshToken->user_id);

        return $user;
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
