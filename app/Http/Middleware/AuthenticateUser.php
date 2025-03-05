<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->bearerToken()) {
            return response()->unauthorized();
        }

        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->unauthorized();
        }

        return $next($request);
    }
}
