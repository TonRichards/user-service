<?php

namespace App\Http\Controllers\Api\Dashboard;

use Illuminate\Http\Request;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\RoleResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStoreRequest;

class RoleController extends Controller
{
    public function __construct(protected RoleService $roleService) {}

    public function store(RoleStoreRequest $request): JsonResponse
    {
        $role = $this->roleService->store($request->validated());

        return response()->created(new RoleResource($role));
    }
}
