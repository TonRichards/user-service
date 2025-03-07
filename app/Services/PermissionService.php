<?php

namespace App\Services;

use App\Models\Permission;
use App\Data\PermissionData;

class PermissionService
{
    public function model(): Permission
    {
        return new Permission();
    }

    public function store(array $data = []): Permission
    {
        $permission = $this->model()->create(PermissionData::fromArray($data));

        if (isset($data['role_id'])) {
            $permission->roles()->sync($data['role_id']);
        }

        return $permission;
    }
}