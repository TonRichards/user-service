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
                'name' => 'user.view_list',
                'label_en' => 'View User List',
                'label_th' => 'ดูรายการผู้ใช้',
                'description_en' => 'Allow viewing the user list',
                'description_th' => 'อนุญาตให้ดูรายชื่อผู้ใช้ทั้งหมด',
            ],
            [
                'name' => 'user.view_detail',
                'label_en' => 'View User Detail',
                'label_th' => 'ดูรายละเอียดผู้ใช้',
                'description_en' => 'Allow viewing user details',
                'description_th' => 'อนุญาตให้ดูข้อมูลของผู้ใช้แต่ละคน',
            ],
            [
                'name' => 'user.create',
                'label_en' => 'Create User',
                'label_th' => 'สร้างผู้ใช้',
                'description_en' => 'Allow creating new user accounts',
                'description_th' => 'อนุญาตให้เพิ่มผู้ใช้ใหม่เข้าสู่ระบบ',
            ],
            [
                'name' => 'user.edit',
                'label_en' => 'Edit User',
                'label_th' => 'แก้ไขผู้ใช้',
                'description_en' => 'Allow editing existing user accounts',
                'description_th' => 'อนุญาตให้แก้ไขข้อมูลผู้ใช้',
            ],
            [
                'name' => 'user.delete',
                'label_en' => 'Delete User',
                'label_th' => 'ลบผู้ใช้',
                'description_en' => 'Allow deleting user accounts',
                'description_th' => 'อนุญาตให้ลบผู้ใช้ออกจากระบบ',
            ],

            // CRM
            [
                'name' => 'crm.view_list',
                'label_en' => 'View Customer List',
                'label_th' => 'ดูรายการลูกค้า',
                'description_en' => 'Allow viewing the customer list',
                'description_th' => 'อนุญาตให้ดูรายชื่อลูกค้าทั้งหมด',
            ],
            [
                'name' => 'crm.view_detail',
                'label_en' => 'View Customer Detail',
                'label_th' => 'ดูรายละเอียดลูกค้า',
                'description_en' => 'Allow viewing customer details',
                'description_th' => 'อนุญาตให้ดูข้อมูลของลูกค้าแต่ละคน',
            ],
            [
                'name' => 'crm.create',
                'label_en' => 'Create Customer',
                'label_th' => 'สร้างลูกค้า',
                'description_en' => 'Allow creating new customer accounts',
                'description_th' => 'อนุญาตให้เพิ่มลูกค้าใหม่เข้าสู่ระบบ',
            ],
            [
                'name' => 'crm.edit',
                'label_en' => 'Edit Customer',
                'label_th' => 'แก้ไขลูกค้า',
                'description_en' => 'Allow editing existing customer accounts',
                'description_th' => 'อนุญาตให้แก้ไขข้อมูลลูกค้า',
            ],
            [
                'name' => 'crm.delete',
                'label_en' => 'Delete Customer',
                'label_th' => 'ลบลูกค้า',
                'description_en' => 'Allow deleting customer accounts',
                'description_th' => 'อนุญาตให้ลบลูกค้าออกจากระบบ',
            ],

            // Inventory
            [
                'name' => 'inventory.view_list',
                'label_en' => 'View Inventory List',
                'label_th' => 'ดูรายการสต็อคสินค้า',
                'description_en' => 'Allow viewing the inventory list',
                'description_th' => 'อนุญาตให้ดูรายชื่อสต็อคสินค้าทั้งหมด',
            ],
            [
                'name' => 'inventory.view_detail',
                'label_en' => 'View Inventory Detail',
                'label_th' => 'ดูรายละเอียดสต็อคสินค้า',
                'description_en' => 'Allow viewing inventory details',
                'description_th' => 'อนุญาตให้ดูข้อมูลของสต็อคสินค้าแต่ละคน',
            ],
            [
                'name' => 'inventory.create',
                'label_en' => 'Create Inventory',
                'label_th' => 'สร้างสต็อคสินค้า',
                'description_en' => 'Allow creating new inventory accounts',
                'description_th' => 'อนุญาตให้เพิ่มสต็อคสินค้าใหม่เข้าสู่ระบบ',
            ],
            [
                'name' => 'inventory.edit',
                'label_en' => 'Edit Inventory',
                'label_th' => 'แก้ไขสต็อคสินค้า',
                'description_en' => 'Allow editing existing inventory accounts',
                'description_th' => 'อนุญาตให้แก้ไขข้อมูลสต็อคสินค้า',
            ],
            [
                'name' => 'inventory.delete',
                'label_en' => 'Delete Inventory',
                'label_th' => 'ลบลูกค้า',
                'description_en' => 'Allow deleting inventory accounts',
                'description_th' => 'อนุญาตให้ลบลูกค้าออกจากระบบ',
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
