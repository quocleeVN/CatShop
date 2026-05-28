<?php

namespace Tests\Feature;

use App\Models\Cat;
use App\Models\CatBreed;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->withHeaders(['Accept' => 'application/json'])
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_admin_can_update_order_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $buyer = User::factory()->create(['role' => 'user']);
        $cat = $this->createCat();

        $order = Order::create([
            'user_id' => $buyer->user_id,
            'total_amount' => $cat->price,
            'shipping_fee' => 50000,
            'final_amount' => $cat->price + 50000,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'shipping_address' => '123 Admin Street',
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.orders.updateStatus', $order), [
                'order_status' => 'processing',
                'payment_status' => 'paid',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'order_id' => $order->order_id,
            'order_status' => 'processing',
            'payment_status' => 'paid',
        ]);
    }

    public function test_admin_user_show_route_is_not_exposed(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin)
            ->get("/admin/users/{$user->user_id}")
            ->assertStatus(405);
    }

    public function test_admin_cannot_delete_another_admin_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $otherAdmin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $otherAdmin))
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'user_id' => $otherAdmin->user_id,
            'role' => 'admin',
        ]);
    }

    public function test_breed_cannot_be_deleted_while_it_has_cats(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $cat = $this->createCat();

        $this->actingAs($admin)
            ->from(route('admin.breeds.index'))
            ->delete(route('admin.breeds.destroy', $cat->breed))
            ->assertRedirect(route('admin.breeds.index'));

        $this->assertDatabaseHas('cat_breeds', [
            'breed_id' => $cat->breed->breed_id,
        ]);
    }

    private function createCat(): Cat
    {
        $breed = CatBreed::create([
            'breed_name' => 'Sphynx',
            'origin' => 'Canada',
        ]);

        return Cat::create([
            'breed_id' => $breed->breed_id,
            'name' => 'Nova',
            'price' => 1800000,
            'age_in_months' => 7,
            'gender' => 'female',
            'stock_status' => 'available',
        ]);
    }
}
