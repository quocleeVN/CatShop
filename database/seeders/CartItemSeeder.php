<?php

namespace Database\Seeders;

use App\Models\CartItem;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    public function run(): void
    {
        CartItem::create([
            'user_id' => 2,
            'cat_id'  => 1, // Biscuit
            'quantity' => 1,
        ]);

        CartItem::create([
            'user_id' => 2,
            'cat_id'  => 4, // Dumbo
            'quantity' => 1,
        ]);
    }
}
