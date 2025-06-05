<?php

namespace App\Services;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Config;

class JwtService
{
    public function generate(array $payload): string
    {
        $now = Carbon::now()->timestamp;
        $exp = $now + config('jwt.ttl', 3600);

        $data = array_merge([
            'iss' => config('jwt.issuer', 'user_service'),
            'iat' => $now,
            'exp' => $exp,
        ], $payload);

        return JWT::encode($data, config('jwt.secret'), 'HS256');
    }

    public function decode(string $token): object
    {
        return JWT::decode($token, new Key(config('jwt.secret'), 'HS256'));
    }
}
