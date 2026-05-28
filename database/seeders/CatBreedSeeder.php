<?php

namespace Database\Seeders;

use App\Models\CatBreed;
use Illuminate\Database\Seeder;

class CatBreedSeeder extends Seeder
{
    public function run(): void
    {
        $breeds = [
            ['breed_name' => 'British Shorthair', 'origin' => 'United Kingdom', 'description' => 'Gấu mèo dễ thương, bộ lông dày mượt.'],
            ['breed_name' => 'Scottish Fold', 'origin' => 'Scotland', 'description' => 'Đôi tai cụp đặc trưng, tính tình hiền lành.'],
            ['breed_name' => 'Persian', 'origin' => 'Iran', 'description' => 'Bộ lông dài sang trọng, mặt bẹt, thảnh thơi.'],
            ['breed_name' => 'Maine Coon', 'origin' => 'United States', 'description' => 'Hổ rù khổng lồ, thân thiện và thân dài.'],
            ['breed_name' => 'Ragdoll', 'origin' => 'United States', 'description' => 'Xả rồ khi bế lên, mắt xanh biếc, lông nhung.'],
            ['breed_name' => 'Bengal', 'origin' => 'United States', 'description' => 'Vằn đốm như báo săn, năng động, thông minh.'],
            ['breed_name' => 'Sphynx', 'origin' => 'Canada', 'description' => 'Mèo không lông, da nhăn, thân thiện và ấm áp.'],
            ['breed_name' => 'Russian Blue', 'origin' => 'Russia', 'description' => 'Bộ lông màu xám xanh, đôi mắt xanh lá cây.'],
            ['breed_name' => 'American Shorthair', 'origin' => 'United States', 'description' => 'Mèo nhà mũm mĩm, sức khỏe tốt.'],
            ['breed_name' => 'Siamese', 'origin' => 'Thailand', 'description' => 'Mèo Thái, mắt xanh, thân hình thanh mảnh, thích kêu.'],
        ];

        foreach ($breeds as $breed) {
            CatBreed::create($breed);
        }
    }
}
