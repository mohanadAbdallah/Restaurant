<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parents = [
            'role' => ['view', 'add', 'edit', 'delete'],
            'restaurant' => ['view', 'add', 'edit', 'delete','manage'],
            'category' => ['view', 'add', 'edit', 'delete'],
            'item' => ['view', 'add', 'edit', 'delete'],
            'user' => ['view', 'add', 'edit', 'delete'],
            'statistics' => ['view'],
            'financial' => ['view'],
        ];


        foreach ($parents as $parent => $types) {
            foreach ($types as $type) {
                Permission::create(['name_key' => $type, 'name' => "$type" . "_" . $parent, 'parent' => $parent]);
            }
        }

        $superAdminRole = Role::create(['name'=>'Super Admin']);
        $adminRole = Role::create(['name'=>'Admin']);
        $dataEntryRole = Role::create(['name'=>'Data Entry']);
        $financialRole = Role::create(['name'=>'Financial']);

        $superAdminRole->givePermissionTo([
            'view_role',
            'add_role',
            'edit_role',
            'delete_role',
            'view_restaurant',
            'add_restaurant',
            'edit_restaurant',
            'delete_restaurant',
            'manage_restaurant',
            'view_user',
            'add_user',
            'edit_user',
            'delete_user',
            'view_category',
            'add_category',
            'edit_category',
            'delete_category',
            'view_item',
            'add_item',
            'edit_item',
            'delete_item',
            'view_statistics',
            'view_financial',
        ]);
        $adminRole->givePermissionTo([
            'manage_restaurant',
            'view_category',
            'add_category',
            'edit_category',
            'delete_category',
            'view_item',
            'add_item',
            'edit_item',
            'delete_item',
            'view_statistics',
            'view_financial',
        ]);
        $dataEntryRole->givePermissionTo([
            'view_item',
            'add_item',
            'edit_item',
            'delete_item',
        ]);
        $financialRole->givePermissionTo([
            'view_statistics',
            'view_financial',
        ]);
    }

}
