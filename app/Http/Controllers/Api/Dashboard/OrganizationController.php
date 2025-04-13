<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\OrganizationService;
// use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
// use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
// use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationCollection;
use App\Http\Requests\OrganizationStoreRequest;

class OrganizationController extends Controller
{
    public function __construct(
        protected OrganizationService $organizationService
    ) {}

    public function store(OrganizationStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $organization = $this->organizationService->upsert($data);

        $user = Auth::guard('api')->user();

        $adminRoleId = Role::where('name', 'admin')->value('id');

        $user->organizations()->attach($organization->id, [
            'role_id' => $adminRoleId,
        ]);

        return response()->created([
            'organization' => new OrganizationResource($organization),
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $user = Auth::guard('api')->user();

        $organizations = $user->organizations()->get();

        return response()->success(new OrganizationCollection($organizations));
    }
}
