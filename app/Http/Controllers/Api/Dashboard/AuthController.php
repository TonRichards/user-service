<?php

namespace App\Http\Controllers\Api\Dashboard;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserRegisterResource;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected UserService $userService,
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

        return response()->success([
            'user' => new UserRegisterResource($user),
            'access_token' => $user->createToken('auth_service_token')->accessToken,
        ]);
    }

    public function getCurrentUser(Request $request): JsonResponse
    {
        $user = Auth::guard('api')->user();

        $this->authService->assignCurrentOrganization($user, $user->current_organization_id);

        return response()->success(new UserResource($user->fresh()));
    }

    public function switchOrganization(Request $request): JsonResponse
    {
        $user = Auth::guard('api')->user();

        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
        ]);

        if (! $user->organizations()->where('organizations.id', $request->organization_id)->exists()) {
            return response()->unauthorized();
        }

        $this->authService->assignCurrentOrganization($user, $request->organization_id);

        return response()->success(new UserResource($user->fresh()));
    }
}
