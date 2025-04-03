<?php

namespace App\Actions;

use App\Models\Role;
use App\Models\Permission;

class SyncRolePermissionAction
{
    public static function execute(Role $role, array $data): void
    {
        $permissionNames = $data['permission_names'] ?? [];

        $permissionIds = Permission::whereIn('name', $permissionNames)->pluck('id');

        $role->permissions()->sync($permissionIds);
    }
}