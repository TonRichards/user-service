<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Application;
use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate([
            'email' => config('app.default_email'),
        ], [
            'name' => config('app.default_name'),
            'email' => config('app.default_email'),
            'password' => bcrypt(config('app.default_password')),
        ]);

        $applicationId = Application::where('name', 'user-management')->first()->id;
        $roleId = Role::where('name', 'superadmin')->first()->id;

        $syncData = Organization::all()->pluck('id')->mapWithKeys(function ($orgId) use ($applicationId, $roleId) {
            return [
                $orgId => [
                    'application_id' => $applicationId,
                    'role_id' => $roleId,
                ]
            ];
        })->toArray();

        $user->organizations()->sync($syncData);
    }
}
