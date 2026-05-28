<?php

namespace Tests\Feature;

use App\Models\Cat;
use App\Models\CatBreed;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_review_without_delivered_purchase(): void
    {
        $user = User::factory()->create();
        $cat = $this->createCat();

        $response = $this->actingAs($user)->post(route('reviews.store', $cat), [
            'rating' => 5,
            'comment' => 'Great cat',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_user_can_create_or_update_review_after_delivered_purchase(): void
    {
        $user = User::factory()->create();
        $cat = $this->createCat();
        $this->createDeliveredOrder($user, $cat);

        $this->actingAs($user)->post(route('reviews.store', $cat), [
            'rating' => 4,
            'comment' => 'Very calm',
        ])->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->user_id,
            'cat_id' => $cat->cat_id,
            'rating' => 4,
            'comment' => 'Very calm',
        ]);

        $this->actingAs($user)->post(route('reviews.store', $cat), [
            'rating' => 5,
            'comment' => 'Even better after a week',
        ])->assertRedirect();

        $this->assertDatabaseCount('reviews', 1);
        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->user_id,
            'cat_id' => $cat->cat_id,
            'rating' => 5,
            'comment' => 'Even better after a week',
        ]);
    }

    private function createCat(): Cat
    {
        $breed = CatBreed::create([
            'breed_name' => 'Ragdoll',
            'origin' => 'US',
        ]);

        return Cat::create([
            'breed_id' => $breed->breed_id,
            'name' => 'Mochi',
            'price' => 2500000,
            'age_in_months' => 12,
            'gender' => 'female',
            'stock_status' => 'available',
        ]);
    }

    private function createDeliveredOrder(User $user, Cat $cat): void
    {
        $order = Order::create([
            'user_id' => $user->user_id,
            'total_amount' => $cat->price,
            'shipping_fee' => 50000,
            'final_amount' => $cat->price + 50000,
            'payment_method' => 'cod',
            'payment_status' => 'paid',
            'order_status' => 'delivered',
            'shipping_address' => '123 Test Street',
        ]);

        OrderItem::create([
            'order_id' => $order->order_id,
            'cat_id' => $cat->cat_id,
            'price_at_purchase' => $cat->price,
            'quantity' => 1,
        ]);
    }
}
