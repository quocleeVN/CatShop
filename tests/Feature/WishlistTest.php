<?php

namespace Tests\Feature;

use App\Models\Cat;
use App\Models\CatBreed;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_toggle_adds_and_removes_wishlist_item(): void
    {
        $user = User::factory()->create();
        $cat = $this->createCat();

        $this->actingAs($user)->post(route('wishlist.toggle', $cat));
        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->user_id,
            'cat_id' => $cat->cat_id,
        ]);

        $this->actingAs($user)->post(route('wishlist.toggle', $cat));
        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $user->user_id,
            'cat_id' => $cat->cat_id,
        ]);
    }

    private function createCat(): Cat
    {
        $breed = CatBreed::create([
            'breed_name' => 'British Shorthair',
            'origin' => 'UK',
        ]);

        return Cat::create([
            'breed_id' => $breed->breed_id,
            'name' => 'Milo',
            'price' => 1500000,
            'age_in_months' => 8,
            'gender' => 'male',
            'stock_status' => 'available',
        ]);
    }
}
