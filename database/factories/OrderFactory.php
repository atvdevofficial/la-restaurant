<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'address' => $faker->streetAddress,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'sub_total' => random_int(100, 9999),
        'delivery_fee' => random_int(100, 9999),
        'grand_total' => random_int(100, 9999),
        'status' => 'PENDING'
    ];
});
