<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_storing_a_default_address_clears_previous_default(): void
    {
        $user = User::factory()->create();

        UserAddress::create([
            'user_id' => $user->user_id,
            'recipient_name' => 'Old Default',
            'phone_number' => '0123456789',
            'specific_address' => '1 Old Street',
            'city' => 'Hanoi',
            'is_default' => true,
        ]);

        $response = $this->actingAs($user)->post('/addresses', [
            'recipient_name' => 'New Default',
            'phone_number' => '0987654321',
            'specific_address' => '2 New Street',
            'ward' => 'Ward 1',
            'district' => 'District 1',
            'city' => 'Ho Chi Minh',
            'is_default' => 1,
        ]);

        $response->assertRedirect(route('addresses.index'));

        $this->assertDatabaseCount('user_addresses', 2);
        $this->assertDatabaseHas('user_addresses', [
            'user_id' => $user->user_id,
            'recipient_name' => 'Old Default',
            'is_default' => false,
        ]);
        $this->assertDatabaseHas('user_addresses', [
            'user_id' => $user->user_id,
            'recipient_name' => 'New Default',
            'is_default' => true,
        ]);
    }

    public function test_user_cannot_update_another_users_address(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();

        $address = UserAddress::create([
            'user_id' => $owner->user_id,
            'recipient_name' => 'Owner',
            'phone_number' => '0123456789',
            'specific_address' => '1 Owner Street',
            'city' => 'Danang',
            'is_default' => false,
        ]);

        $response = $this->actingAs($intruder)
            ->withHeaders(['Accept' => 'application/json'])
            ->put(route('addresses.update', $address), [
                'recipient_name' => 'Intruder',
                'phone_number' => '0999999999',
                'specific_address' => '2 Hacked Street',
                'city' => 'Hue',
            ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('user_addresses', [
            'address_id' => $address->address_id,
            'recipient_name' => 'Owner',
        ]);
    }
}
