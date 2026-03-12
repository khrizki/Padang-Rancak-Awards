<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // reset cache permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            'Admin',
            'Panitia',
            'Juri',
            'RT',
            'RW',
            'Lurah',
            'Camat',
            'Mahasiswa',
            'Warga',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        // ambil role admin
        $adminRole = Role::where('name', 'Admin')->first();

        if ($adminRole) {

            $permissions = [
                'view users',
                'create users',
                'edit users',
                'delete users',
            ];

            // pastikan permission ada
            foreach ($permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission,
                    'guard_name' => 'web',
                ]);
            }

            // assign permission
            $adminRole->syncPermissions($permissions);
        }

        $this->command->info('Roles created successfully!');
        $this->command->info('Permissions assigned to Admin role successfully!');
    }
}