<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserRegisterResource;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->authService->register($data);

        $user->applications()->attach($data['application_id']);

        return response()->created([
            'data' => new UserRegisterResource($user),
            'token' => $user->createToken('auth_service_token')->plainTextToken
        ]);
    }
}
