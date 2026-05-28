<?php

namespace Tests\Feature;

use App\Models\Cat;
use App\Models\CatBreed;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartMergeTest extends TestCase
{
    use RefreshDatabase;

    public function test_session_cart_is_merged_into_database_on_login(): void
    {
        $user = User::factory()->create([
            'email' => 'merge@example.com',
            'password' => 'password',
        ]);

        $cat = $this->createCat();

        $this->withSession([
            'cart' => [$cat->cat_id => 2],
        ])->post('/login', [
            'email' => 'merge@example.com',
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->user_id,
            'cat_id' => $cat->cat_id,
            'quantity' => 2,
        ]);
    }

    private function createCat(): Cat
    {
        $breed = CatBreed::create([
            'breed_name' => 'Scottish Fold '.uniqid(),
            'origin' => 'Scotland',
        ]);

        return Cat::create([
            'breed_id' => $breed->breed_id,
            'name' => 'Foldy',
            'price' => 1700000,
            'age_in_months' => 5,
            'gender' => 'female',
            'stock_status' => 'available',
        ]);
    }
}
