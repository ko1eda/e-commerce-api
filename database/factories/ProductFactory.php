<?php

use Faker\Generator as Faker;
use App\Models\Product;
use App\Models\Category;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'category_id' => function () {
            return factory(Category::class)->create()->id;
        },
        'name' => $name = $faker->name(),
        'slug'=> str_slug($name),
        'price' => $faker->numberBetween(1, 100000),
        'description' => str_limit($faker->sentences($nb = 3), 68)
    ];
});
