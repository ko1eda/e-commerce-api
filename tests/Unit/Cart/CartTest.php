<?php

namespace Tests\Unit\Cart;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Cart\Cart;
use App\Models\ProductVariation;
use App\Models\User;

class CartTest extends TestCase
{

    public function test_it_can_add_variations()
    {
        $this->be($user = factory(User::class)->create());

        $cart = new Cart($user);

        // cart should have an initial cont of 0
        $this->assertEquals(0, $user->cart()->count());

        $vId = factory(ProductVariation::class)->create()->id;

        $cart->add(Collect([
            ['id' => $vId, 'quantity' => 1 ]
        ]));

        // then the cart should reflect this
        $this->assertEquals(1, $user->fresh()->cart()->count());
    }

    public function test_it_can_add_to_the_quantity_of_an_existing_variation()
    {
        $this->be($user = factory(User::class)->create());

        $cart = new Cart($user);

        $vId = factory(ProductVariation::class)->create()->id;

        $cart->add(Collect([
            ['id' => $vId, 'quantity' => 1 ]
        ]));

        $this->assertEquals(1, $user->refresh()->cart->first()->pivot->quantity);

        $cart->add(Collect([
            ['id' => $vId, 'quantity' => 10 ]
        ]));

        // now the quantity should be 11
        $this->assertEquals(11, $user->refresh()->cart->first()->pivot->quantity);
    }
}
