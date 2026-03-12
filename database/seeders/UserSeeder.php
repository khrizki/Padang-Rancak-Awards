<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Padang Rancak',
                'email' => 'admin@padangrancak.id',
                'password' => 'password',
                'phone' => '081234567890',
                'role' => 'Admin',
            ],
            [
                'name' => 'Panitia Lomba',
                'email' => 'panitia@padangrancak.id',
                'password' => 'password',
                'phone' => '081234567891',
                'role' => 'Panitia',
            ],
            [
                'name' => 'Juri 1',
                'email' => 'juri1@padangrancak.id',
                'password' => 'password',
                'phone' => '081234567892',
                'role' => 'Juri',
            ],
            [
                'name' => 'Juri 2',
                'email' => 'juri2@padangrancak.id',
                'password' => 'password',
                'phone' => '081234567893',
                'role' => 'Juri',
            ],
            [
                'name' => 'Ketua RT 01',
                'email' => 'rt01@padangrancak.id',
                'password' => 'password',
                'phone' => '081234567894',
                'address' => 'RT 01 RW 01 Kelurahan Andalas',
                'role' => 'RT',
            ],
            [
                'name' => 'Ketua RW 01',
                'email' => 'rw01@padangrancak.id',
                'password' => 'password',
                'phone' => '081234567896',
                'address' => 'RW 01 Kelurahan Andalas',
                'role' => 'RW',
            ],
            [
                'name' => 'Lurah Andalas',
                'email' => 'lurah.andalas@padangrancak.id',
                'password' => 'password',
                'phone' => '081234567897',
                'address' => 'Kelurahan Andalas',
                'role' => 'Lurah',
            ],
            [
                'name' => 'Camat Koto Tangah',
                'email' => 'camat.kototangah@padangrancak.id',
                'password' => 'password',
                'phone' => '081234567898',
                'address' => 'Kecamatan Koto Tangah',
                'role' => 'Camat',
            ],
            [
                'name' => 'Mahasiswa Surveyor 1',
                'email' => 'mahasiswa1@padangrancak.id',
                'password' => 'password',
                'phone' => '081234567899',
                'role' => 'Mahasiswa',
            ],
            [
                'name' => 'Warga Kota Padang',
                'email' => 'warga@gmail.com',
                'password' => 'password',
                'phone' => '081234567800',
                'role' => 'Warga',
            ],
        ];

        foreach ($users as $userData) {

            $role = $userData['role'];
            unset($userData['role']);

            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'phone' => $userData['phone'] ?? null,
                    'address' => $userData['address'] ?? null,
                    'password' => Hash::make($userData['password']),
                ]
            );

            // assign role hanya jika belum ada
            if (!$user->hasRole($role)) {
                $user->assignRole($role);
            }
        }

        $this->command->info('Users seeded successfully!');
    }
}