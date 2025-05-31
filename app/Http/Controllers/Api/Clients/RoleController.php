<?php

namespace App\Http\Controllers\Api\Clients;

use Illuminate\Http\Request;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\RoleResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleCollection;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;

class RoleController extends Controller
{
    public function __construct(protected RoleService $roleService) {}

    public function store(RoleStoreRequest $request): JsonResponse
    {
        $role = $this->roleService->store($request->validated());

        return response()->created(new RoleResource($role));
    }

    public function index(Request $request): JsonResponse
    {
        $request->validate(['application_id' => 'required']);

        $roles = $this->roleService->getRoles($request);

        return response()->withPaginated($roles, new RoleCollection($roles));
    }

    public function show($id): JsonResponse
    {
        $role = $this->roleService->getById($id);

        return response()->success(new RoleResource($role));
    }

    public function update(RoleUpdateRequest $request, $id): JsonResponse
    {
        $role = $this->roleService->update($id, $request->validated());

        return response()->success(new RoleResource($role));
    }

    public function destroy($id): JsonResponse
    {
        $this->roleService->delete($id);

        return response()->success();
    }
}
