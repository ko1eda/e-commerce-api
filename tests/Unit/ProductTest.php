<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Category;

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
}
