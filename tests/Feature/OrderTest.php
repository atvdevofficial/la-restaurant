<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Administrator tests
     */
    public function testAdministratorOrderIndex() {
        $customerUser = factory(\App\User::class)->create(['role' => 'CUSTOMER']);
        $customer = factory(\App\Customer::class)->create(['user_id' => $customerUser->id]);

        factory(\App\Order::class, 5)->create(['customer_id' => $customer->id]);

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->getJson(route('orders.index'))
        ->assertStatus(200)
        ->assertJsonStructure([[
            'id', 'address', 'latitude', 'longitude',
            'sub_total', 'delivery_fee', 'grand_total',
            'status', 'customer'
        ]]);
    }

    public function testAdministratorOrderShow() {
        $customerUser = factory(\App\User::class)->create(['role' => 'CUSTOMER']);
        $customer = factory(\App\Customer::class)->create(['user_id' => $customerUser->id]);

        $order = factory(\App\Order::class)->create(['customer_id' => $customer->id]);

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->getJson(route('orders.show', ['order' => $order->id]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'address', 'latitude', 'longitude',
            'sub_total', 'delivery_fee', 'grand_total',
            'status', 'customer'
        ]);
    }

    public function testAdministratorOrderUpdate() {
        $customerUser = factory(\App\User::class)->create(['role' => 'CUSTOMER']);
        $customer = factory(\App\Customer::class)->create(['user_id' => $customerUser->id]);

        $order = factory(\App\Order::class)->create(['customer_id' => $customer->id]);

        $orderData = [
            'order' => $order->id,
            'status' => 'PROCESSING'
        ];

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->putJson(route('orders.update', $orderData))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'address', 'latitude', 'longitude',
            'sub_total', 'delivery_fee', 'grand_total',
            'status',
        ]);
    }

    /**
     * Customer tests
     */
    public function testCustomerOrderIndex() {
        $customerUser = factory(\App\User::class)->create(['role' => 'CUSTOMER']);
        $customer = factory(\App\Customer::class)->create(['user_id' => $customerUser->id]);

        factory(\App\Order::class, 5)->create(['customer_id' => $customer->id]);

        $this->actingAs($customerUser, 'api')
        ->getJson(route('orders.index'))
        ->assertStatus(200)
        ->assertJsonStructure([[
            'id', 'address', 'latitude', 'longitude',
            'sub_total', 'delivery_fee', 'grand_total',
            'status',
        ]]);
    }

    public function testCustomerOrderStore() {
        $product = factory(\App\Product::class)->create();

        $customerUser = factory(\App\User::class)->create(['role' => 'CUSTOMER']);
        factory(\App\Customer::class)->create(['user_id' => $customerUser->id]);

        $orderData = [
            'address' => $this->faker->streetAddress,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'distance' => random_int(100, 999),

            'products' => [
                ['id' => $product->id, 'quantity' => 1]
            ]
        ];

        $this->actingAs($customerUser, 'api')
        ->postJson(route('orders.store', $orderData))
        ->assertStatus(201)
        ->assertJsonStructure([
            'id', 'address', 'latitude', 'longitude',
            'sub_total', 'delivery_fee', 'grand_total',
            'status',
        ]);
    }

    public function testCustomerOrderShow() {
        $customerUser = factory(\App\User::class)->create(['role' => 'CUSTOMER']);
        $customer = factory(\App\Customer::class)->create(['user_id' => $customerUser->id]);

        $order = factory(\App\Order::class)->create(['customer_id' => $customer->id]);

        $this->actingAs($customerUser, 'api')
        ->getJson(route('orders.show', ['order' => $order->id]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'address', 'latitude', 'longitude',
            'sub_total', 'delivery_fee', 'grand_total',
            'status',
        ]);
    }

    public function testCustomerOrderUpdate() {
        $customerUser = factory(\App\User::class)->create(['role' => 'CUSTOMER']);
        $customer = factory(\App\Customer::class)->create(['user_id' => $customerUser->id]);

        $order = factory(\App\Order::class)->create(['customer_id' => $customer->id]);

        $orderData = [
            'order' => $order->id,
            'status' => 'DELIVERED'
        ];

        $this->actingAs($customerUser, 'api')
        ->putJson(route('orders.update', $orderData))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'address', 'latitude', 'longitude',
            'sub_total', 'delivery_fee', 'grand_total',
            'status',
        ]);
    }
}
