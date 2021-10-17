<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testRegistration()
    {
        $customerData = [
            'email' => $this->faker->email,
            'password' => 'dummy1234',
            'password_confirmation' => 'dummy1234',

            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'contact_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];

        $this->postJson(route('registration', $customerData))
        ->dump()
            ->assertStatus(201)
            ->assertJsonStructure([
                'id', 'first_name', 'last_name', 'contact_number',
                'address', 'latitude', 'longitude', 'user' => ['id', 'email']
            ]);
    }
}
