<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;

class ProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_many_categories()
    {
        // given we have a category
        $product = factory(Product::class)->create();

        $product->categories()->save(factory(Category::class)->create());
         
        // and we call products
        // then it should return a type App\Modles\Product
        $this->assertInstanceOf(Category::class, $product->categories->first());
    }

    public function test_it_has_many_variations()
    {
        // given we have a product
        $product = factory(Product::class)->create();

        $var = new ProductVariation;
        $var->name = $product->name;
        $var->price = $product->price;

        // and that product has a variation
        $product->variations()->save($var);
         
        // if we list that products variations, then it should be
        // then it should be a productvariation
        $this->assertInstanceOf(ProductVariation::class, $product->variations->first());
    }
}
