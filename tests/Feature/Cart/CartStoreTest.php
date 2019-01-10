<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ProductVariation;

class CartStoreTest extends TestCase
{
    public function test_it_does_not_allow_unauthenticated_users_to_store_items()
    {
        // 401 unauthorized
        $this->json('POST', route('cart.store'))
            ->assertStatus(401);
    }

    public function test_it_stores_a_number_of_product_variations()
    {
        // Given we have an auth user
        $this->be($user = factory(User::class)->create());

        $this->assertEquals(0, $user->cart()->count());

        // and that user adds two variations to their cart
        $v1 = factory(ProductVariation::class)->create()->id;
        $v2 = factory(ProductVariation::class)->create()->id;

        $this->json('POST', route('cart.store'), [
            'products' => [
                ['id' => $v1, 'quantity' => 1],
                ['id' => $v2, 'quantity' => 1],
            ]
        ]);

        // then the cart should reflect this
        $this->assertEquals(2, $user->fresh()->cart()->count());
    }


    /**
     * -------------------------
     * Validation tests
     * -------------------------
     */

    public function test_it_requires_an_array_of_products()
    {
        // endpoint must have an array of products
        $this->be($user = factory(User::class)->create());

        $this->json('POST', route('cart.store'), [])
            ->assertJsonValidationErrors(['products']);
    }

    public function test_it_requires_each_item_to_have_a_valid_product_variation_id()
    {
        $this->be($user = factory(User::class)->create());

        $variationId = factory(ProductVariation::class)->create()->id;

        // note that if the first id was invalid the error would be products.0.id
        $this->json('POST', route('cart.store'), [
            'products' => [
                ['id' => $variationId, 'quantity' => 1],
                ['id' => 1111111194444444499, 'quantity' => 1],
            ]
        ])->assertJsonValidationErrors(['products.1.id']);
    }

    public function test_it_requires_each_item_to_have_a_quantity_greater_than_zero()
    {
        $this->be($user = factory(User::class)->create());

        $variationId = factory(ProductVariation::class)->create()->id;

        $this->json('POST', route('cart.store'), [
            'products' => [
                ['id' => $variationId, 'quantity' => 0],
            ]
        ])->assertJsonValidationErrors(['products.0.quantity']);
    }
}
