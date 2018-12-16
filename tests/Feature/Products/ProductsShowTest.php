<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

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
}
