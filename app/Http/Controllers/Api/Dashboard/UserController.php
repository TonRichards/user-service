<?php

namespace App\Http\Controllers\Api\Dashboard;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UserStoreRequest;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function store(UserStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->userService->store($data);

        $user->applications()->attach($data['application_id']);

        return response()->created(new UserResource($user));
    }

    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->getUsers($request);

        return response()->paginated(new UserCollection($users), $users);
    }
}
