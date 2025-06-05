<?php

namespace App\Http\Controllers\Api;

use Firebase\JWT\JWT;
use App\Services\JwtService;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\RefreshTokenService;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserRegisterResource;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected UserService $userService,
        protected RefreshTokenService $refreshTokenService,
    ) {}

    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->userService->store($data);

        return response()->created([
            'user' => new UserRegisterResource($user->fresh()),
        ]);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->authService->login($data);

        if (!$user) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Incorrect username or password',
            ]);
        }

        $token = app(JwtService::class)->generate([
            'sub' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'current_organization_id' => $user->current_organization_id,
        ]);

        $refreshToken = $this->refreshTokenService->create($user);

        return response()->success([
            'user' => new UserResource($user),
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'Bearer',
            'expires_in' => 15 * 60,
        ]);
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->input('refresh_token');

        if (!$refreshToken) {
            return response()->json(['message' => 'Refresh token required'], 400);
        }

        $user = $this->refreshTokenService->validate($refreshToken);

        if (!$user) {
            return response()->json(['message' => 'Invalid refresh token'], 401);
        }

        $jwt = JWT::encode([
            'sub' => $user->id,
            'email' => $user->email,
            'exp' => now()->addMinutes(15)->timestamp
        ], config('jwt.secret'), 'HS256');

        return response()->json([
            'access_token' => $jwt,
            'token_type' => 'Bearer',
            'expires_in' => 15 * 60,
        ]);
    }

    public function getCurrentUser(Request $request): JsonResponse
    {
        $user = $request->user();

        $this->authService->assignCurrentOrganization($user, $user->current_organization_id);

        return response()->success(new UserResource($user->fresh()));
    }

    public function switchOrganization(Request $request): JsonResponse
    {
        $user = $request->user();

        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
        ]);

        if (! $user->organizations()->where('organizations.id', $request->organization_id)->exists()) {
            return response()->unauthorized();
        }

        $this->authService->assignCurrentOrganization($user, $request->organization_id);

        return response()->success(new UserResource($user->fresh()));
    }

    public function logout(Request $request): JsonResponse
    {
        $refreshToken = $request->input('refresh_token');

        if (!$refreshToken) {
            return response()->json(['message' => 'Missing refresh token'], 400);
        }

        $this->refreshTokenService->revoke($refreshToken);

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }
}
