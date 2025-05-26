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
            'email' => env('DEFAULT_EMAIL'),
        ], [
            'name' => env('DEFAULT_NAME'),
            'email' => env('DEFAULT_EMAIL'),
            'password' => bcrypt(env('DEFAULT_PASSWORD')),
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
