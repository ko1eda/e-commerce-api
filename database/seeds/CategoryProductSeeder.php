<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class CategoryProductSeeder extends Seeder
{
    /**
     * Createds 10 categories,
     * and 10 products,
     * 5 of which will have a category associated
     *
     * @return void
     */
    public function run()
    {
        $categories = factory(Category::class, 10)->create();

        $categories->each(function ($category) {
            $products = factory(Product::class, 2)->create();

            $products->each(function ($product, $index) use ($category) {
                if ($index % 2 !== 0) {
                    $product->categories()->save($category);
                }
            });
        });
    }
}
