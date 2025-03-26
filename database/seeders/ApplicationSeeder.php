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
            ['name' => 'user', 'display_name' => 'User mangament'],
            ['name' => 'crm', 'display_name' => 'CRM'],
            ['name' => 'order', 'display_name' => 'Order management'],
            ['name' => 'inventory', 'display_name' => 'Inventory management'],
        ];

        foreach ($applications as $application) {
            Application::updateOrCreate([
                'name' => $application['name'],
                'display_name' => $application['display_name']
            ]);
        }
    }
}
