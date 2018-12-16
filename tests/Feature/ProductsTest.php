<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class ProductsTest extends TestCase
{
    public function test_all_products_are_displayed_from_index_route()
    {
        // Given we have 2 products
        factory(Product::class, 2)->create();

        // And we hit our products endpoint
        // Then We should see all our products
        $this->json('GET', route('products.index'))->assertJsonCount(2, 'data');
    }

    public function test_index_route_displays_pagination_data()
    {
        // Our products index should output json in this structure
        $this->json('GET', route('products.index'))->assertJsonStructure([
            'data',
            'links',
            'meta'
        ]);
    }
}
