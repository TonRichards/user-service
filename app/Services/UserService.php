<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Data\UserData;
use Illuminate\Http\Request;
use App\Actions\UpdateUserAction;
use App\Actions\UpsertUserAction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function model(): User
    {
        return new User();
    }

    public function getById(string $id): User
    {
        return $this->model()->findOrFail($id);
    }

    public function store(array $data = []): User
    {
        return UpsertUserAction::execute($data);
    }

    public function getUsersWithCurrentRoles(Request $request): LengthAwarePaginator
    {
        $sortBy = $request->get('sort', 'created_at');
        $orderBy = $request->get('order', 'asc');
        $search = $request->get('q', '*');
        $perPage = $request->get('per_page', 10);

        $currentOrgId = $request->user()?->current_organization_id;

        $paginator = User::search($search)
            ->query(function ($query) use ($currentOrgId) {
                $query->whereHas('organizations', function ($q) use ($currentOrgId) {
                    $q->where('organizations.id', $currentOrgId);
                });
            })
            ->orderBy($sortBy, $orderBy)
            ->paginate($perPage);

        $paginator->getCollection()->load([ // @phpstan-ignore-line
            'organizations' => fn ($q) => $q->withPivot('role_id'),
        ]);

        $roleIds = collect($paginator->items())
            ->map(function ($user) use ($currentOrgId) {
                return $user->organizations->firstWhere('id', $currentOrgId)?->pivot?->role_id;
            })
            ->filter()
            ->unique();

        $roles = Role::whereIn('id', $roleIds)->get()->keyBy('id');

        foreach ($paginator->items() as $user) {
            $org = $user->organizations->firstWhere('id', $currentOrgId);
            $roleId = $org?->pivot?->role_id;
            $user->setRelation('current_role', $roles[$roleId] ?? null);
        }

        return $paginator;
    }

    public function update(string $id, array $data = []): User
    {
        $user = $this->getById($id);

        UpdateUserAction::execute($user, $data);

        return $user;
    }

    public function destroy(string $id): void
    {
        $user = $this->getById($id);

        $user->delete();
    }

    public function syncOrganization(User $user, array $data): void
    {
        $applicationId = $data['application_id'];

        if (isset($data['organizations'])) {
            $syncData = collect($data['organizations'])->mapWithKeys(function ($org) use ($applicationId) {
                return [
                    $org['organization_id'] => [
                        'role_id' => $org['role'],
                        'application_id' => $applicationId,
                    ]
                ];
            })->all();

            $user->organizations()->syncWithoutDetaching($syncData);
        }
    }
}