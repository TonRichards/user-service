<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateJwt
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        $publicKey = file_get_contents(base_path(env('JWT_PUBLIC_KEY_PATH')));

        $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            $payload = JWT::decode($token, new Key($publicKey, 'RS256'));

            $user = User::find($payload->sub);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $request->setUserResolver(function () use ($user) {
                return $user;
            });

            return $next($request);

        } catch (\Exception $e) {
            \Log::error('JWT decode failed: ' . $e->getMessage());
            return response()->json(['message' => 'Invalid token'], 401);
        }
    }
}
