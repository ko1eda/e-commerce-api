<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ProductVariation;
use App\Cart\Money;

class CartIndexTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        // sign in user
        $this->be($this->user = factory(User::class)->create());

        // create 2 variations
        $this->v1 = factory(ProductVariation::class)->create();
        $this->v2 = factory(ProductVariation::class)->create();

        // sync them to the users cart
        $this->user->cart()->sync(
            [$this->v1->id => ['quantity' => 1], $this->v2->id => ['quantity' => 10]]
        );
    }

    public function test_it_does_not_allow_unauthenticated_users_to_remove_all_variations()
    {
        // log the user out
        $this->json('POST', route('logout'), [''], [
            'Authorization' => 'Bearer ' . \JWTAuth::fromUser($this->user)
        ]);

        // 401 unauthorized
        $this->withExceptionHandling()
            ->json('GET', route('cart.index'))
            ->assertStatus(401);
    }

    public function test_it_displays_all_variations_in_the_cart()
    {
        $this->json('get', route('cart.index'))->assertJsonStructure([
            'data' => [
                'products' => []
            ]
        ]);

        $this->json('GET', route('cart.index'))->assertJsonFragment([
            'name' => $this->v1->name,
            'name' => $this->v2->name
        ]);
    }

    public function test_it_displays_each_variations_parent_product()
    {
        // each json object inside products array should have a parent product
        $this->json('get', route('cart.index'))->assertJsonStructure([
            'data' => [
                'products' => [
                    [
                        'product' => []
                    ]
                ]
            ]
        ]);

        $this->json('GET', route('cart.index'))->assertJsonFragment([
            'slug' => $this->v1->product->slug,
        ]);
    }

    public function test_it_displays_each_variations_total_price()
    {
        $this->json('GET', route('cart.index'))->assertJsonFragment([
            'total' => (new Money($this->v2->price->amount() * $this->user->cart->last()->pivot->quantity))->formatted()
        ]);
    }
}
