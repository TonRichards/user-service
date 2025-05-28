<?php

namespace App\Services;

use App\Models\Role;
use App\Data\RoleData;
use Illuminate\Http\Request;
use Meilisearch\Endpoints\Indexes;
use App\Actions\SyncRolePermissionAction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RoleService
{
    public function model(): Role
    {
        return new Role();
    }

    public function getById(string $id): Role
    {
        return $this->model()->findOrFail($id);
    }

    public function store(array $data = []): Role
    {
        $role = $this->model()->create(RoleData::fromArray($data));

        SyncRolePermissionAction::execute($role, $data);

        return $role;
    }

    public function getRoles(Request $request): LengthAwarePaginator
    {
        $user = $request->user();

        $search = $request->get('q', '*');
        $orderBy = $request->get('order', 'asc');
        $perPage = $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);
        $sortBy = $request->get('sort', 'created_at');
        $applicationId = $request->get('application_id', 1);
        $organizationId = $user->current_organization_id;

        return $this->model()::search($search, function (Indexes $meilisearch, $query, $options) use ($organizationId, $applicationId, $sortBy, $orderBy) {
            $options['filter'] = 'application_id = ' . $applicationId . ' AND organization_id = ' . $organizationId;
            $options['sort'] = [$sortBy . ':' . $orderBy];
            return $meilisearch->search($query, $options);
        })->paginate($perPage, 'page', $page);
    }

    public function update(string $id, array $data = []): Role
    {
        $role = $this->getById($id);

        $role->update(RoleData::fromArray($data));

        SyncRolePermissionAction::execute($role, $data);

        $role->fresh();

        return $role;
    }

    public function upsert(array $data = []): Role
    {
        $role = $this->model()->updateOrCreate(
            [
                'name' => $data['name'],
                'application_id' => $data['application_id'],
                'organization_id' => $data['organization_id'],
            ], RoleData::fromArray($data)
        );

        SyncRolePermissionAction::execute($role, $data);

        $role->fresh();

        return $role;
    }

    public function delete(string $id): void
    {
        $role = $this->getById($id);

        $role->delete();
    }
}