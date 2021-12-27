<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'unit-list',
            'unit-create',
            'unit-edit',
            'unit-delete',
            'tahun-list',
            'tahun-create',
            'tahun-edit',
            'tahun-delete',
            'satuan-list',
            'satuan-create',
            'satuan-edit',
            'satuan-delete',
            'kategori-list',
            'kategori-create',
            'kategori-edit',
            'kategori-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }
    }
}
