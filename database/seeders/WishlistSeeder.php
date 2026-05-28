<?php

namespace Database\Seeders;

use App\Models\Wishlist;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    public function run(): void
    {
        Wishlist::create([
            'user_id' => 2,
            'cat_id'  => 5, // Luna (Scottish Fold)
        ]);

        Wishlist::create([
            'user_id' => 3,
            'cat_id'  => 1, // Biscuit
        ]);
    }
}
