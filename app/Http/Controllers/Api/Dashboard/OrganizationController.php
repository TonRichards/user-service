<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\OrganizationService;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationCollection;
use App\Http\Requests\OrganizationStoreRequest;
use App\Http\Requests\OrganizationUpdateRequest;

class OrganizationController extends Controller
{
    public function __construct(protected OrganizationService $organizationService) {}

    public function store(OrganizationStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $organization = $this->organizationService->upsert($data);

        $user = Auth::guard('api')->user();

        $adminRoleId = Role::where('name', 'admin')->value('id');

        $user->organizations()->attach($organization->id, [
            'role_id' => $adminRoleId,
        ]);

        return response()->created(new OrganizationResource($organization));
    }

    public function index(Request $request): JsonResponse
    {
        $user = Auth::guard('api')->user();

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
