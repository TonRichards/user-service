<?php

namespace App\Services;

use App\Models\Permission;
use App\Data\PermissionData;
use Illuminate\Database\Eloquent\Collection;

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

    public function getPermissions(): Collection
    {
        return $this->model()->get();
    }
}