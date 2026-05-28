<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        Review::create([
            'user_id' => 2,
            'cat_id'  => 4, // Dumbo (hoặc Leo, nhưng trong dump cat_id=4 được review)
            'rating'  => 5,
            'comment' => 'Leo siêu đẹp và khỏe mạnh, shop giao hàng rất kỹ.',
        ]);

        Review::create([
            'user_id' => 3,
            'cat_id'  => 7, // Nala
            'rating'  => 4,
            'comment' => 'Mèo ngoan nhưng hay bị dị ứng da chút xíu, shop tư vấn tốt.',
        ]);
    }
}
