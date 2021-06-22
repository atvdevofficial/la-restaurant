<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DeliveryFee;
use Faker\Generator as Faker;

$factory->define(DeliveryFee::class, function (Faker $faker) {
    return [
        'from' => random_int(1, 10),
        'to' => random_int(11, 20),
        'fee' => random_int(50, 100)
    ];
});
