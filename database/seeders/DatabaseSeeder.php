<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Pak Bos Admin',
            'email' => 'admin@cybertask.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun Karyawan (Staff)
        User::create([
            'name' => 'Andi Staff',
            'email' => 'andi@cybertask.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',

            
        ]);
        
        User::create([
        'name' => 'yanto',
            'email' => 'yanto@cybertask.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);
        // 3. Buat Project Contoh (Biar gak kosong)
        \App\Models\Project::create([
            'name' => 'Website Company Profile',
            'description' => 'Project pembuatan web untuk klien korporat.',
            'start_date' => '2025-01-01',
            'end_date' => '2025-02-01',
        ]);
    }
}