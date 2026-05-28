<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Cat;
use App\Models\CatBreed;
use App\Models\Coupon;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CheckoutFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_can_be_placed_with_saved_address_and_coupon(): void
    {
        $user = User::factory()->create();
        $cat = $this->createCat();

        $address = UserAddress::create([
            'user_id' => $user->user_id,
            'recipient_name' => 'Buyer',
            'phone_number' => '0123456789',
            'specific_address' => '99 Saved Street',
            'ward' => 'Ward 5',
            'district' => 'District 3',
            'city' => 'HCMC',
            'is_default' => true,
        ]);

        $coupon = Coupon::create([
            'code' => 'SAVE10',
            'discount_percent' => 10,
            'max_discount' => 100000,
            'min_order_value' => 100000,
            'expiry_date' => now()->addDay(),
            'is_active' => true,
        ]);

        CartItem::create([
            'user_id' => $user->user_id,
            'cat_id' => $cat->cat_id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($user)
            ->withSession([
                'coupon_code' => $coupon->code,
                'coupon_discount' => 400000,
            ])
            ->post(route('checkout.placeOrder'), [
                'payment_method' => 'cod',
                'use_existing_address' => $address->address_id,
                'order_notes' => 'Call before delivery',
            ]);

        $response->assertRedirectContains('/orders/');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->user_id,
            'coupon_id' => $coupon->coupon_id,
            'payment_method' => 'cod',
            'shipping_address' => '99 Saved Street, Ward 5, District 3, HCMC',
            'order_notes' => 'Call before delivery',
            'order_status' => 'pending',
        ]);

        $this->assertDatabaseHas('order_items', [
            'cat_id' => $cat->cat_id,
            'quantity' => 2,
        ]);

        $this->assertDatabaseHas('cats', [
            'cat_id' => $cat->cat_id,
            'stock_status' => 'reserved',
        ]);

        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $user->user_id,
            'cat_id' => $cat->cat_id,
        ]);
    }

    public function test_user_cannot_place_order_with_another_users_saved_address(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $cat = $this->createCat();

        $address = UserAddress::create([
            'user_id' => $other->user_id,
            'recipient_name' => 'Other User',
            'phone_number' => '0111111111',
            'specific_address' => '1 Foreign Street',
            'city' => 'Hanoi',
            'is_default' => false,
        ]);

        CartItem::create([
            'user_id' => $user->user_id,
            'cat_id' => $cat->cat_id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($user)->from('/checkout')->post(route('checkout.placeOrder'), [
            'payment_method' => 'cod',
            'use_existing_address' => $address->address_id,
        ]);

        $response->assertSessionHasErrors('use_existing_address');
        $this->assertDatabaseCount('orders', 0);
    }

    private function createCat(): Cat
    {
        $breed = CatBreed::create([
            'breed_name' => 'Persian',
            'origin' => 'Iran',
        ]);

        return Cat::create([
            'breed_id' => $breed->breed_id,
            'name' => 'Simba',
            'price' => 2000000,
            'age_in_months' => 9,
            'gender' => 'male',
            'stock_status' => 'available',
        ]);
    }
}
