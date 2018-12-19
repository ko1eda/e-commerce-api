<?php

use Faker\Generator as Faker;
use App\Models\Product;
use App\Models\Category;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->name(),
        'slug'=> str_slug($name),
        'price' => $faker->numberBetween(1, 100000),
        'description' => str_limit($faker->sentence($nbWords = 2), 40)
    ];
});
