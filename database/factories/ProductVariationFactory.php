<?php

use Faker\Generator as Faker;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\Product;

$factory->define(ProductVariation::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            return factory(Product::class)->create()->id;
        },
        'product_variation_type_id' => function () {
            return factory(ProductVariationType::class)->create()->id;
        },
        'name' => $name = str_limit($faker->unique()->words(3, true), 20),
        'price' => $faker->numberBetween(1, 1000000),
        'order' => $faker->numberBetween(0, 1000000),
        'image_path' => $faker->url,
    ];
});
