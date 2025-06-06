<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\PermissionService;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\PermissionCollection;
use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;

class PermissionController extends Controller
{
    public function __construct(protected PermissionService $permissionService) {}

    public function store(PermissionStoreRequest $request): JsonResponse
    {
        $permission = $this->permissionService->store($request->validated());

        return response()->success(new PermissionResource($permission));
    }

    public function index(Request $request): JsonResponse
    {
        $permissions = $this->permissionService->getPermissions($request);

        return response()->withPaginated($permissions, new PermissionCollection($permissions));
    }

    public function show($id): JsonResponse
    {
        $permission = $this->permissionService->getById($id);

        return response()->success(new PermissionResource($permission));
    }

    public function update(PermissionUpdateRequest $request, string $id): JsonResponse
    {
        $permission = $this->permissionService->update($id, $request->validated());

        return response()->success(new PermissionResource($permission));
    }

    public function destroy($id): JsonResponse
    {
        $this->permissionService->delete($id);

        return response()->success();
    }
}
