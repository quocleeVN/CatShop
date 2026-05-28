<?php

namespace Database\Seeders;

use App\Models\UserAddress;
use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
{
    public function run(): void
    {
        UserAddress::create([
            'user_id'          => 2,
            'recipient_name'   => 'Nguyen Van A',
            'phone_number'     => '0912345678',
            'specific_address' => '123 Duong ABC',
            'ward'             => 'Phuong 1',
            'district'         => 'Quan 1',
            'city'             => 'Ho Chi Minh',
            'is_default'       => true,
        ]);

        UserAddress::create([
            'user_id'          => 2,
            'recipient_name'   => 'Nguyen Van A',
            'phone_number'     => '0912345678',
            'specific_address' => '456 Duong XYZ',
            'ward'             => 'Phuong 2',
            'district'         => 'Quan Go Vap',
            'city'             => 'Ho Chi Minh',
            'is_default'       => false,
        ]);

        UserAddress::create([
            'user_id'          => 3,
            'recipient_name'   => 'Tran Thi B',
            'phone_number'     => '0987654321',
            'specific_address' => '789 Duong DEF',
            'ward'             => 'Phuong 5',
            'district'         => 'Quan Thanh Khe',
            'city'             => 'Da Nang',
            'is_default'       => true,
        ]);
    }
}
