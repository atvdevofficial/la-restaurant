<?php

namespace Tests\Feature;

use App\DeliveryFee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeliveryFeeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Public Route Tests
     */
    public function testPublicDeliveryFeeIndex() {
        factory(\App\DeliveryFee::class, 5)->create();

        $this->getJson(route('deliveryFees.index'))
        ->assertStatus(200)
        ->assertJsonStructure([[
            'id', 'from', 'to', 'fee'
        ]]);
    }

    public function testPublicDeliveryFeeShow() {
        $deliveryFee = factory(\App\DeliveryFee::class)->create();

        $this->getJson(route('deliveryFees.show', ['deliveryFee' => $deliveryFee->id]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'from', 'to', 'fee'
        ]);
    }

    /**
     * Administrator Tests
     */
    public function testAdministratorDeliveryFeeStore() {
        $deliveryFeeData = [
            'from' => 1,
            'to' => 3,
            'fee' => 50,
        ];

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->postJson(route('deliveryFees.store', $deliveryFeeData))
        ->assertStatus(201)
        ->assertJsonStructure([
            'id', 'from', 'to', 'fee'
        ]);
    }

    public function testAdministratorDeliveryFeeUpdate() {
        $deliveryFee = factory(\App\DeliveryFee::class)->create();

        $deliveryFeeData = [
            'deliveryFee' => $deliveryFee->id,
            'from' => 1,
            'to' => 3,
            'fee' => 50,
        ];

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->putJson(route('deliveryFees.update', $deliveryFeeData))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'from', 'to', 'fee'
        ]);
    }

    public function testAdministratorDeliveryFeeDestroy() {
        $deliveryFee = factory(\App\DeliveryFee::class)->create();

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->deleteJson(route('deliveryFees.destroy', ['deliveryFee' => $deliveryFee->id]))
        ->assertStatus(204);
    }
}
