<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::create([
            'code'             => 'WELCOME10',
            'discount_percent' => 10.00,
            'max_discount'     => 200000.00,
            'min_order_value'  => 0.00,
            'expiry_date'      => '2025-12-31 23:59:59',
            'is_active'        => true,
        ]);

        Coupon::create([
            'code'             => 'MEOWLOVE20',
            'discount_percent' => 20.00,
            'max_discount'     => 500000.00,
            'min_order_value'  => 2000000.00,
            'expiry_date'      => '2024-12-31 23:59:59',
            'is_active'        => true,
        ]);

        Coupon::create([
            'code'             => 'VIP50',
            'discount_percent' => 50.00,
            'max_discount'     => 1000000.00,
            'min_order_value'  => 10000000.00,
            'expiry_date'      => '2024-06-30 23:59:59',
            'is_active'        => true,
        ]);
    }
}
