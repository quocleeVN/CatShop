<?php

namespace Tests\Feature;

use App\Models\Cat;
use App\Models\CatBreed;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_adding_same_cat_twice_increments_quantity(): void
    {
        $user = User::factory()->create();
        $cat = $this->createCat();

        $this->actingAs($user)->post(route('cart.add'), [
            'cat_id' => $cat->cat_id,
            'quantity' => 1,
        ])->assertRedirect();

        $this->actingAs($user)->post(route('cart.add'), [
            'cat_id' => $cat->cat_id,
            'quantity' => 2,
        ])->assertRedirect();

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->user_id,
            'cat_id' => $cat->cat_id,
            'quantity' => 3,
        ]);
    }

    public function test_remove_deletes_item_from_cart(): void
    {
        $user = User::factory()->create();
        $cat = $this->createCat();

        $this->actingAs($user)->post(route('cart.add'), [
            'cat_id' => $cat->cat_id,
            'quantity' => 1,
        ]);

        $this->actingAs($user)->delete(route('cart.remove', $cat->cat_id))
            ->assertRedirect();

        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $user->user_id,
            'cat_id' => $cat->cat_id,
        ]);
    }

    private function createCat(): Cat
    {
        $breed = CatBreed::create([
            'breed_name' => 'Maine Coon',
            'origin' => 'US',
        ]);

        return Cat::create([
            'breed_id' => $breed->breed_id,
            'name' => 'Luna',
            'price' => 2000000,
            'age_in_months' => 10,
            'gender' => 'female',
            'stock_status' => 'available',
        ]);
    }
}
