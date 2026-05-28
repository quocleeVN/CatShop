<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'full_name'    => 'Admin User',
            'email'        => 'admin@catshop.com',
            'password'     => Hash::make('password'),
            'phone_number' => '0901234567',
            'role'         => 'admin',
            'is_active'    => true,
        ]);

        User::create([
            'full_name'    => 'Nguyen Van A',
            'email'        => 'nguyenvanA@gmail.com',
            'password'     => Hash::make('password'),
            'phone_number' => '0912345678',
            'role'         => 'user',
            'is_active'    => true,
        ]);

        User::create([
            'full_name'    => 'Tran Thi B',
            'email'        => 'tranthiB@yahoo.com',
            'password'     => Hash::make('password'),
            'phone_number' => '0987654321',
            'role'         => 'user',
            'is_active'    => true,
        ]);
    }
}
