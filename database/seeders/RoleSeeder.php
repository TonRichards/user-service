<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Application;
use App\Models\Organization;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::updateOrCreate([
            'name' => 'superadmin',
            'application_id' => Application::first()->id,
            'organization_id' => Organization::first()->id,
        ]);

        $role->permissions()->sync(Permission::all()->pluck('id'));
    }
}
