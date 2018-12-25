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

        // and that product has a variation
        $product->variations()->save(factory(ProductVariation::class)->create());
         
        // if we list that products variations, then it should be
        // then it should be a productvariation
        $this->assertInstanceOf(ProductVariation::class, $product->variations->first());
    }

    public function test_it_returns_a_money_object_as_its_price()
    {
        // given we have a product
        $product = factory(Product::class)->create();

        // and that product has a price
        // then that price should be of type
        $this->assertInstanceOf(\App\Cart\Money::class, $product->price);
    }

    // public function test_it_returns_a_formatted_money_string_for_current_locale()
    // {
    //     // Note default locale is en_US

    //     // given we have a product
    //     $product = factory(Product::class)->create([
    //         'price' => 5000
    //     ]);

    //     // and that product has a price
    //     // then that price should be of type
    //     $this->assertEquals('$50.00', $product->formattedPrice);

    //     // however if we change the locale
    //     config(['app.locale' => 'en_CA']);
        
    //     $this->assertEquals('US$50.00', $product->formattedPrice);
    // }
}
