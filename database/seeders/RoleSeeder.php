<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Organization;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::updateOrCreate([
            'name' => 'superadmin',
        ], [
            'name' => 'superadmin',
            'display_name' => 'Superadmin',
        ]);

        $role->permissions()->sync(Permission::all()->pluck('id'));
    }
}
