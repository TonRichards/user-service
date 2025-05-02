<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SelectOptionService
{
    private function buildResponse(string $baseKey, callable $queryFn, ?string $search = null)
    {
        $cacheKey = $search ? "{$baseKey}_search_" . md5($search) : $baseKey;

        return Cache::remember($cacheKey, now()->addHours(6), $queryFn);
    }

    public function getUserOptions(Request $request)
    {
        return $this->buildResponse('users', function () use ($request) {
            return User::select('id', 'email', 'name')
                ->when($request->q, fn($q) => $q->where('email', 'like', '%' . $request->q . '%'))
                ->orderBy('email')
                ->get();
        }, $request->q);
    }

    public function getOrganizationOptions(Request $request)
    {
        $user = $request->user();
        $organizationIds = $user->organizations()->pluck('organizations.id');

        $baseKey = 'organizations_' . $user->name;

        return $this->buildResponse($baseKey, function () use ($request, $organizationIds) {
            return Organization::select('id', 'name')
                ->whereIn('id', $organizationIds)
                ->when($request->q, fn($q) => $q->where('name', 'like', '%' . $request->q . '%'))
                ->orderBy('name')
                ->get();
        });
    }

    public function getRoleOptions(Request $request)
    {
        $user = $request->user();
        $baseKey = 'roles_application_' . $request->application_id . '_organization_' . $user->current_organization_id;

        return $this->buildResponse('roles', function () use ($request, $user) {
            return Role::select('id', 'display_name')
                ->where('application_id', $request->application_id)
                ->where('organization_id', $user->current_organization_id)
                ->when($request->q, fn($q) => $q->where('display_name', 'like', '%' . $request->q . '%'))
                ->orderBy('display_name')
                ->get();
        });
    }
}