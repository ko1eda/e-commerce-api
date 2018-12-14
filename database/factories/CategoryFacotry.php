<?php

use Faker\Generator as Faker;
use App\Models\Category;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->name(),
        'slug' => str_slug($name)
    ];
});


// $factory->state(Category::class, 'withParent', function () {
//     return [
//         'parent_id' => function () {
//             return factory(Category::class)->create()->id;
//         }
//     ];
// });
