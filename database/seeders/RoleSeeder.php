<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Models\Application;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::updateOrCreate([
            'name' => 'superadmin',
        ], [
            'name' => 'superadmin',
            'display_name' => 'Superadmin',
            'application_id' => Application::where('name', 'user-management')->first()->id,
            'organization_id' => Organization::where('name', 'Eraton')->first()->id,
        ]);

        $role->permissions()->sync(Permission::all()->pluck('id'));
    }
}
