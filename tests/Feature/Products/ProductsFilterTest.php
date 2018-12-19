<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Category;

class ProductsFilterTest extends TestCase
{
    public function test_products_can_be_filtered_by_category()
    {
        // Given we have two products
        $products = factory(Product::class, 2)->create();
        
        // and the first proudct has a category
        $products->first()->categories()->save($category = factory(Category::class)->create());

        // if we hit our endpoint querying for that category, the product with that category will be returned
        // but the other product will not be present
        $this->json('get', route('products.index', ['category' => $category->slug]))
            ->assertJsonFragment(['slug' => $products->first()->slug])
            ->assertJsonMissing(['name' => $products->last()->name]);
    }
}
