<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_view_another_users_order(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();

        $order = Order::create([
            'user_id' => $owner->user_id,
            'total_amount' => 100000,
            'shipping_fee' => 50000,
            'final_amount' => 150000,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'shipping_address' => '321 Private Street',
        ]);

        $this->actingAs($intruder)
            ->withHeaders(['Accept' => 'application/json'])
            ->get(route('orders.show', $order))
            ->assertForbidden();
    }
}
