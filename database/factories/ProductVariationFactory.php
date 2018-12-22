<?php

use Faker\Generator as Faker;
use App\Models\ProductVariation;

$factory->define(ProductVariation::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            return factory(Product::class)->create()->id;
        },
        'name' => $name = str_limit($faker->unique()->words(3, true), 20),
        'price' => $faker->numberBetween(1, 1000000),
    ];
});
