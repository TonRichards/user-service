<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function store(UserStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->userService->store($data);

        $this->userService->syncOrganization($user, $data);

        return response()->created(new UserResource($user));
    }

    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->getUsersWithCurrentRoles($request);

        return response()->withPaginated($users, new UserCollection($users));
    }

    public function show(Request $request, $id): JsonResponse
    {
        $user = $this->userService->getById($id);

        return response()->success(new UserResource($user));
    }

    public function update(UserUpdateRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $user = $this->userService->update($id, $data);

        $this->userService->syncOrganization($user, $data);

        return response()->success(new UserResource($user->fresh()));
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        $this->userService->destroy($id);

        return response()->success();
    }
}
