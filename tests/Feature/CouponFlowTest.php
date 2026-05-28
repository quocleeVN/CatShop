<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Cat;
use App\Models\CatBreed;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CouponFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_coupon_is_applied_when_cart_meets_minimum_order_value(): void
    {
        $user = User::factory()->create();
        $cat = $this->createCat(1500000);
        $coupon = $this->createCoupon(500000);

        CartItem::create([
            'user_id' => $user->user_id,
            'cat_id' => $cat->cat_id,
            'quantity' => 1,
        ]);

        $this->actingAs($user)
            ->from('/checkout')
            ->post(route('checkout.applyCoupon'), ['code' => $coupon->code])
            ->assertRedirect('/checkout');

        $this->assertSame('SAVE10', session('coupon_code'));
        $this->assertEquals(150000.0, session('coupon_discount'));
    }

    public function test_coupon_is_rejected_when_cart_does_not_meet_minimum_order_value(): void
    {
        $user = User::factory()->create();
        $cat = $this->createCat(200000);
        $coupon = $this->createCoupon(500000);

        CartItem::create([
            'user_id' => $user->user_id,
            'cat_id' => $cat->cat_id,
            'quantity' => 1,
        ]);

        $this->actingAs($user)
            ->from('/checkout')
            ->post(route('checkout.applyCoupon'), ['code' => $coupon->code])
            ->assertRedirect('/checkout');

        $this->assertNull(session('coupon_code'));
        $this->assertNull(session('coupon_discount'));
    }

    private function createCat(float $price): Cat
    {
        $breed = CatBreed::create([
            'breed_name' => 'Bengal '.uniqid(),
            'origin' => 'India',
        ]);

        return Cat::create([
            'breed_id' => $breed->breed_id,
            'name' => 'Tiger '.uniqid(),
            'price' => $price,
            'age_in_months' => 6,
            'gender' => 'male',
            'stock_status' => 'available',
        ]);
    }

    private function createCoupon(float $minOrderValue): Coupon
    {
        return Coupon::create([
            'code' => 'SAVE10',
            'discount_percent' => 10,
            'max_discount' => 200000,
            'min_order_value' => $minOrderValue,
            'expiry_date' => now()->addDays(3),
            'is_active' => true,
        ]);
    }
}
