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
}
