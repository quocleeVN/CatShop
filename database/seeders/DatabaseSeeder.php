<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CatBreedSeeder::class,
            CatSeeder::class,
            CouponSeeder::class,
            UserAddressSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            CartItemSeeder::class,
            ReviewSeeder::class,
            WishlistSeeder::class,
        ]);
    }
}
