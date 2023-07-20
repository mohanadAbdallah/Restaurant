<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class OrderPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parents = [
            'order' => ['view', 'add', 'edit', 'delete'],
        ];

        foreach ($parents as $parent => $types) {
            foreach ($types as $type) {
                Permission::create(['name_key' => $type, 'name' => "$type" . "_" . $parent, 'parent' => $parent]);
            }
        }

    }
}
