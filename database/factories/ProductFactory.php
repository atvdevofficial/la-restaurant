<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'price' => random_int(100, 9999),
        'image' => $faker->imageUrl
    ];
});
