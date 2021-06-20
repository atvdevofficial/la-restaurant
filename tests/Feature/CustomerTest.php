<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Administrator Tests
     */
    public function testAdministratorCustomerIndex() {
        factory(\App\User::class, 5)->create(['role' => 'CUSTOMER'])->each(function($user) {
            factory(\App\Customer::class)->create(['user_id' => $user->id]);
        });

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->getJson(route('customers.index'))
        ->assertStatus(200)
        ->assertJsonStructure([[
            'id', 'first_name', 'last_name', 'contact_number',
            'address', 'latitude', 'longitude', 'user' => ['id', 'email']
        ]]);
    }

    public function testAdministratorCustomerStore() {
        $customerData = [
            'email' => $this->faker->email,
            'password' => 'dummy1234',

            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'contact_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->postJson(route('customers.store', $customerData))
        ->assertStatus(201)
        ->assertJsonStructure([
            'id', 'first_name', 'last_name', 'contact_number',
            'address', 'latitude', 'longitude', 'user' => ['id', 'email']
        ]);
    }

    public function testAdministratorCustomerShow() {
        $customerUser = factory(\App\User::class)->create(['role' => 'CUSTOMER']);
        $customer = factory(\App\Customer::class)->create(['user_id' => $customerUser->id]);

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->getJson(route('customers.show', ['customer' => $customer->id]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'first_name', 'last_name', 'contact_number',
            'address', 'latitude', 'longitude', 'user' => ['id', 'email']
        ]);
    }

    public function testAdministratorCustomerUpdate() {
        $customerUser = factory(\App\User::class)->create(['role' => 'CUSTOMER']);
        $customer = factory(\App\Customer::class)->create(['user_id' => $customerUser->id]);

        $customerData = [
            'customer' => $customer->id,
            'email' => $customerUser->email,
            'password' => null,

            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'contact_number' => $customer->contact_number,
            'address' => $customer->address,
            'latitude' => $customer->latitude,
            'longitude' => $customer->longitude,
        ];

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->putJson(route('customers.update', $customerData))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'first_name', 'last_name', 'contact_number',
            'address', 'latitude', 'longitude', 'user' => ['id', 'email']
        ]);
    }

    public function testAdministratorCustomerDestroy() {
        $customerUser = factory(\App\User::class)->create(['role' => 'CUSTOMER']);
        $customer = factory(\App\Customer::class)->create(['user_id' => $customerUser->id]);

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->deleteJson(route('customers.destroy', ['customer' => $customer->id]))
        ->assertStatus(204);
    }

    /**
     * Customer Tests
     */
    public function testCustomerShow() {
        $customerUser = factory(\App\User::class)->create(['role' => 'CUSTOMER']);
        $customer = factory(\App\Customer::class)->create(['user_id' => $customerUser->id]);

        $this->actingAs($customerUser, 'api')
        ->getJson(route('customers.show', ['customer' => $customer->id]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'first_name', 'last_name', 'contact_number',
            'address', 'latitude', 'longitude', 'user' => ['id', 'email']
        ]);
    }

    public function testCustomerUpdate() {
        $customerUser = factory(\App\User::class)->create(['role' => 'CUSTOMER']);
        $customer = factory(\App\Customer::class)->create(['user_id' => $customerUser->id]);

        $customerData = [
            'customer' => $customer->id,
            'email' => $customerUser->email,
            'password' => null,

            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'contact_number' => $customer->contact_number,
            'address' => $customer->address,
            'latitude' => $customer->latitude,
            'longitude' => $customer->longitude,
        ];

        $this->actingAs($customerUser, 'api')
        ->putJson(route('customers.update', $customerData))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'first_name', 'last_name', 'contact_number',
            'address', 'latitude', 'longitude', 'user' => ['id', 'email']
        ]);
    }
}
