<?php

namespace App\Http\Controllers\Api\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\PermissionService;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Requests\PermissionStoreRequest;

class PermissionController extends Controller
{
    public function __construct(protected PermissionService $permissionService) {}

    public function store(PermissionStoreRequest $request): JsonResponse
    {
        $permission = $this->permissionService->store($request->validated());

        return response()->success(new PermissionResource($permission));
    }
}
