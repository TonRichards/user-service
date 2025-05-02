<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Application;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applications = [
            [
                'name' => 'user-management',
                'display_name' => 'User Management',
            ],
            [
                'name' => 'ecommerce-erp',
                'display_name' => 'Ecommerce ERP',
            ],
        ];

        foreach ($applications as $item) {
            Application::updateOrCreate(
                ['name' => $item['name']],
                [
                    'name' => $item['name'],
                    'display_name' => $item['display_name'],
                ]
            );
        }
    }
}
