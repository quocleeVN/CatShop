<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::create([
            'user_id'         => 2,
            'total_amount'    => 11500000.00,
            'shipping_fee'    => 50000.00,
            'final_amount'    => 10450000.00,
            'coupon_id'       => 2, // MEOWLOVE20
            'payment_method'  => 'bank_transfer',
            'payment_status'  => 'pending',
            'order_status'    => 'delivered',
            'shipping_address' => '123 Duong ABC, Phuong 1, Quan 1, Ho Chi Minh',
            'order_notes'     => null,
        ]);
    }
}
