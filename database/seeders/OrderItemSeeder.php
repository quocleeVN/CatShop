<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        OrderItem::create([
            'order_id'         => 1,
            'cat_id'           => 4,  // Leo (Maine Coon) - nhưng kiểm tra lại: dump có cat_id=4,5 với giá 12tr và 11.5tr
            'price_at_purchase' => 12000000.00,
            'quantity'         => 1,
        ]);

        OrderItem::create([
            'order_id'         => 1,
            'cat_id'           => 5,  // Luna (Scottish Fold) giá 6.800.000 theo seeder cats ở trên, nhưng dump order_items lại có giá 11.500.000 cho cat_id=5. Để khớp dump, ta giữ giá đó.
            'price_at_purchase' => 11500000.00,
            'quantity'         => 1,
        ]);
    }
}
