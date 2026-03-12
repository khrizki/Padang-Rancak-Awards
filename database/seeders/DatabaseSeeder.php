<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            WilayahSeeder::class,
        ]);
    }
}