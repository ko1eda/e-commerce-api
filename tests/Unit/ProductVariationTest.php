<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ProductVariation;
use App\Models\Stock;

class ProductVariationTest extends TestCase
{
    public function test_it_has_one_product_variation_type()
    {
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasOne::class,
            factory(ProductVariation::class)->create()->type()
        );

        $this->assertInstanceOf(
            \App\Models\ProductVariationType::class,
            factory(ProductVariation::class)->create()->type
        );
    }

    public function test_it_belongs_to_a_product()
    {
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            factory(ProductVariation::class)->create()->product()
        );

        $this->assertInstanceOf(
            \App\Models\Product::class,
            factory(ProductVariation::class)->create()->product
        );
    }

    public function test_it_returns_a_parent_price_object_if_it_has_no_price()
    {
        // given we have a product and a variation, both with different prices
        $variation = factory(ProductVariation::class)->create();

        // then the product and variation should not have the same price
        $this->assertNotEquals($variation->product->price->amount(), $variation->price->amount());

        // however if the variation price is not specified
        unset($variation->price);

        // then the two prices should now be equal
        $this->assertEquals($variation->product->price->amount(), $variation->price->amount());
    }

    public function test_it_returns_a_parent_image_path_if_it_has_no_image()
    {
        // given we have a product and a variation, both with different prices
        $variation = factory(ProductVariation::class)->create();

        // then the product and variation should not have the same price
        $this->assertNotEquals($variation->product->image_path, $variation->image_path);

        // however if the variation price is not specified
        unset($variation->image_path);

        // then the two prices should now be equal
        $this->assertEquals($variation->product->image_path, $variation->image_path);
    }

    public function test_it_knows_if_it_has_its_parents_price()
    {
        // given we have a product and a variation, both with different prices
        $variation = factory(ProductVariation::class)->create();

        $this->assertFalse($variation->hasParentPrice);

        unset($variation->price);

        $this->assertTrue($variation->hasParentPrice);
    }

    public function test_it_has_many_stocks()
    {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(factory(\App\Models\Stock::class)->make());

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $variation->stocks());
        $this->assertInstanceOf(\App\Models\Stock::class, $variation->stocks->first());
    }

    
    public function test_it_has_access_to_its_current_stock()
    {
        // Given we have a product with a variation
        $variation = factory(ProductVariation::class)->create();

        // And that variation has one stock block in our database
        $variation->stocks()->save(factory(Stock::class)->make());

        // then the variations current stock should equal the stock that was just added
        $this->assertEquals(
            $initalStock = Stock::where('product_variation_id', $variation->id)->first()->quantity,
            $variation->current_stock
        );

        // however if we update the stock block by adding a new stock object for the variation
        $variation->stocks()->save(factory(Stock::class)->make());

        // then the returned stock should reflect that
        $this->assertNotEquals(
            $initalStock,
            $variation->refresh()->current_stock
        );
    }

    public function test_it_knows_if_it_is_in_stock()
    {
        // Given we have a product with a variation
        $variation = factory(ProductVariation::class)->create();

        // then in stock should be 0 or false 1 or true
        $this->assertEquals(false, $variation->in_stock);

        // And that variation has one stock block in our database
        $variation->stocks()->save(factory(Stock::class)->make());

        $this->assertEquals(true, $variation->refresh()->in_stock);
    }   
}
