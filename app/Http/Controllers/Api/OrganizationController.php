<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\OrganizationService;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationCollection;
use App\Http\Requests\OrganizationStoreRequest;
use App\Http\Requests\OrganizationUpdateRequest;

class OrganizationController extends Controller
{
    public function __construct(
        protected RoleService $roleService,
        protected OrganizationService $organizationService,
    ) {}

    public function store(OrganizationStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $organization = $this->organizationService->upsert($data);

        $user = $request->user();

        $permissionNames = Permission::where('application_id', $data['application_id'])->pluck('name');

        $ownerRole = $this->roleService->upsert([
            'name' => 'owner',
            'display_name' => 'Owner',
            'organization_id' => $organization->id,
            'application_id' => $data['application_id'],
            'permission_names' => $permissionNames,
        ]);

        $user->organizations()->attach($organization->id, [
            'role_id' => $ownerRole->id,
            'application_id' => $data['application_id'],
        ]);

        return response()->created(new OrganizationResource($organization));
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $organizations = $user->organizations()->get();

        return response()->success(new OrganizationCollection($organizations));
    }

    public function update(OrganizationUpdateRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $organization = $this->organizationService->update($id, $data);

        return response()->success(new OrganizationResource($organization));
    }

    public function destroy($id): JsonResponse
    {
        $this->organizationService->destroy($id);

        return response()->success();
    }
}
