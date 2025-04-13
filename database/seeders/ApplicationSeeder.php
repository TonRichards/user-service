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
                'name' => 'project-management-service',
                'display_name' => 'Project Management Service',
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
