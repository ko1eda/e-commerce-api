<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class ProductsIndexTest extends TestCase
{
    public function test_all_products_are_displayed()
    {
        // Given we have 2 products
        factory(Product::class, 2)->create();

        // And we hit our products endpoint
        // Then We should see all our products
        $this->json('GET', route('products.index'))->assertJsonCount(2, 'data');
    }

    public function test_pagination_data_is_displayed()
    {
        // Our products index should output json in this structure
        $this->json('GET', route('products.index'))->assertJsonStructure([
            'data',
            'links',
            'meta'
        ]);
    }
}
