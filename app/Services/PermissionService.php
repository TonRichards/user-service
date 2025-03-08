<?php

namespace App\Services;

use App\Models\Permission;
use App\Data\PermissionData;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PermissionService
{
    public function model(): Permission
    {
        return new Permission();
    }

    public function getById(string $id): Permission
    {
        return $this->model()->findOrFail($id);
    }

    public function store(array $data = []): Permission
    {
        $permission = $this->model()->create(PermissionData::fromArray($data));

        if (isset($data['role_id'])) {
            $permission->roles()->sync($data['role_id']);
        }

        return $permission;
    }

    public function getPermissions(Request $request): LengthAwarePaginator
    {
        $sortBy = $request->get('sort', 'created_at');
        $orderBy = $request->get('order');
        $search = $request->get('q', '*');
        $perPage = $request->get('per_page', 10);

        return $this->model()
            ->search($search)
            ->orderBy($sortBy, $orderBy)
            ->paginate($perPage);
    }

    public function update(array $data = [], string $id): Permission
    {
        $permission = $this->getById($id);

        $permission->update(PermissionData::fromArray($data));

        $permission->fresh();

        return $permission;
    }

    public function delete(string $id): void
    {
        $permission = $this->getById($id);

        $permission->roles()->detach();

        $permission->delete();
    }
}