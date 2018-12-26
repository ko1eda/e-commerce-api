<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Stock::class, function (Faker $faker) {
    return [
        'quantity' => $faker->numberBetween(0, 1000000),
       
    ];
});

$factory->state(App\Models\Stock::class, 'withVariation', function (Faker $faker) {
    return [
        'product_variation_id' => function () {
            return factory(\App\Models\ProductVariation::class)->create()->id;
        }
    ];
});
