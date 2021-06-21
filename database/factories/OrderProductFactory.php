<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OrderProduct;
use Faker\Generator as Faker;

$factory->define(OrderProduct::class, function (Faker $faker) {
    return [
        'price' => random_int(100, 999),
        'quantity' => random_int(100, 999),
        'total' => random_int(100, 999),
    ];
});
