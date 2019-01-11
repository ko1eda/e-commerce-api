<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ProductVariation;

class CartUpdateTest extends TestCase
{
    public function test_it_does_not_allow_unauthenticated_users_to_udpate_items()
    {
        // 401 unauthorized
        $this->withExceptionHandling()
            ->json('PATCH', route('cart.update', ['id' => 1]))
            ->assertStatus(401);
    }

    public function test_it_returns_404_if_the_variation_is_not_found()
    {
        $this->be($user = factory(User::class)->create());

        $this->withExceptionHandling()
            ->json('PATCH', route('cart.update', ['id' => 1]))
            ->assertStatus(404);
    }

    public function test_it_updates_the_quantity_of_a_variation_already_in_the_cart()
    {
        $this->be($user = factory(User::class)->create());

        $vid = factory(ProductVariation::class)->create()->id;

        $this->json('POST', route('cart.store'), [
            'products' => [
                ['id' => $vid, 'quantity' => 10],
            ]
        ]);

        $this->assertEquals(10, $user->refresh()->cart->first()->pivot->quantity);

        // However if we add 10 more of the same product
        $this->json('PATCH', route('cart.update', $vid), ['id' => $vid, 'quantity' => 4]);

        // now the quantity should be 4
        $this->assertEquals(4, $user->refresh()->cart->first()->pivot->quantity);
    }


    /**
     * -------------------------
     * Validation tests
     * -------------------------
    */
    public function test_it_requires_a_variation_to_have_a_quantity_greater_than_zero()
    {
        $this->be($user = factory(User::class)->create());

        $vid = factory(ProductVariation::class)->create()->id;

        $user->cart()->sync([$vid => ['quantity' => 10]]);

        $this->withExceptionHandling()
            ->json('PATCH', route('cart.update', $vid), ['id' => $vid, 'quantity' => 0])
            ->assertJsonValidationErrors(['quantity']);
    }

    public function test_it_requires_a_variation_to_have_a_quantity()
    {
        $this->be($user = factory(User::class)->create());

        $vid = factory(ProductVariation::class)->create()->id;

        $user->cart()->sync([$vid => ['quantity' => 10]]);

        $this->withExceptionHandling()
            ->json('PATCH', route('cart.update', $vid), ['id' => $vid])
            ->assertJsonValidationErrors(['quantity']);
    }
}
