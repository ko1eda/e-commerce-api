<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ProductVariation;

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
}
