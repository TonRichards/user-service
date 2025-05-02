<?php

namespace App\Services;

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

    public function getUsers(Request $request): LengthAwarePaginator
    {
        $sortBy = $request->get('sort', 'created_at');
        $orderBy = $request->get('order', 'asc');
        $search = $request->get('q', '*');
        $perPage = $request->get('per_page', 10);

        $currentOrgId = $request->user()?->current_organization_id;

        return $this->model()
            ->search($search)
            ->query(function ($query) use ($currentOrgId) {
                $query->whereHas('organizations', function ($q) use ($currentOrgId) {
                    $q->where('organizations.id', $currentOrgId);
                });
            })
            ->orderBy($sortBy, $orderBy)
            ->paginate($perPage);
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
        if (isset($data['organizations'])) {
            $syncData = collect($data['organizations'])->mapWithKeys(function ($org) {
                return [
                    $org['organization_id'] => [
                        'role_id' => $org['role']
                    ]
                ];
            })->all();

            $user->organizations()->syncWithoutDetaching($syncData);
        }
    }
}