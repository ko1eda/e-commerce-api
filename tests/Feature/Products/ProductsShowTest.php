<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\ProductVariation;

class ProductsShowTest extends TestCase
{
    public function test_it_returns_404_response_if_product_not_found()
    {
        $this->json('get', route('products.show', ['slug' => 'kjdlkdlskdlskd']))
            ->assertStatus(404);
    }

    public function test_it_shows_a_product()
    {
        // Given we have a product
        $product = factory(Product::class)->create();

        // When we hit our endpoint it displays the correct product
        $this->json('get', route('products.show', $product))->assertJsonFragment([
            'id' => $product->id
        ]);
    }

    public function test_it_shows_a_products_variations_grouped_by_type()
    {
        // Given we have a product
        $product = factory(Product::class)->create();

        // And that product has two different variations, each variation with its own unique type
        $vars = factory(ProductVariation::class, 2)->create(['product_id' => $product->id]);
        
        // When we hit our endpoint
        // then it should display a structure containing the product data
        // as well as its variations
        // and each variation should be grouped by its product_variation_type name
        $this->json('get', route('products.show', $product))->assertJsonStructure([
            'data' => [
                'variations' => [
                    $vars->first()->type->name => [],
                    $vars->last()->type->name => []
                ]
            ]
        ]);
    }
}
