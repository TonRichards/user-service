<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Application;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // User
            [
                'name' => 'user.view',
                'label_en' => 'view User',
                'label_th' => 'ดูข้อมูลผู้ใช้',
                'description_en' => 'Allow viewing the user detail',
                'description_th' => 'อนุญาตให้ดูรายชื่อผู้ใช้',
            ],
            [
                'name' => 'user.edit',
                'label_en' => 'Edit User',
                'label_th' => 'แก้ไขผู้ใช้',
                'description_en' => 'Allow editing user accounts',
                'description_th' => 'อนุญาตให้แก้ไขข้อมูลผู้ใช้',
            ],

            // CRM
            [
                'name' => 'crm.view',
                'label_en' => 'View Customer',
                'label_th' => 'ดูข้อมูลลูกค้า',
                'description_en' => 'Allow viewing the customer',
                'description_th' => 'อนุญาตให้ดูรายชื่อลูกค้า',
            ],
            [
                'name' => 'crm.edit',
                'label_en' => 'Edit Customer',
                'label_th' => 'แก้ไขลูกค้า',
                'description_en' => 'Allow editing customer accounts',
                'description_th' => 'อนุญาตให้แก้ไขข้อมูลลูกค้า',
            ],

            // Inventory
            [
                'name' => 'inventory.view',
                'label_en' => 'View Inventory',
                'label_th' => 'ดูข้อมูลสต็อคสินค้า',
                'description_en' => 'Allow viewing the inventory',
                'description_th' => 'อนุญาตให้ดูรายชื่อสต็อคสินค้า',
            ],
            [
                'name' => 'inventory.edit',
                'label_en' => 'Edit Inventory',
                'label_th' => 'แก้ไขสต็อคสินค้า',
                'description_en' => 'Allow editing inventory accounts',
                'description_th' => 'อนุญาตให้แก้ไขข้อมูลสต็อคสินค้า',
            ],
        ];

        $applicationId = Application::where('name', 'user-management')->first()->id;

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm['name']],
                [
                    'label_en' => $perm['label_en'],
                    'label_th' => $perm['label_th'],
                    'description_en' => $perm['description_en'],
                    'description_th' => $perm['description_th'],
                    'application_id' => $applicationId,
                ]
            );
        }
    }
}
