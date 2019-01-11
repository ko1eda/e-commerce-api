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

    public function setUp()
    {
        parent::setUp();

        $this->be($this->user = factory(User::class)->create());

        $this->cart = new Cart($this->user);
    }


    public function test_it_can_add_variations()
    {
        // cart should have an initial cont of 0
        $this->assertEquals(0, $this->user->cart()->count());

        $vid = factory(ProductVariation::class)->create()->id;

        $this->cart->add(Collect([
            ['id' => $vid, 'quantity' => 1 ]
        ]));

        // then the cart should reflect this
        $this->assertEquals(1, $this->user->fresh()->cart()->count());
    }

    public function test_it_can_add_to_the_quantity_of_an_existing_variation()
    {
        $vid = factory(ProductVariation::class)->create()->id;

        $this->cart->add(Collect([
            ['id' => $vid, 'quantity' => 1 ]
        ]));

        $this->assertEquals(1, $this->user->refresh()->cart->first()->pivot->quantity);

        $this->cart->add([
            ['id' => $vid, 'quantity' => 10 ]
        ]);

        // now the quantity should be 11
        $this->assertEquals(11, $this->user->refresh()->cart->first()->pivot->quantity);
    }


    public function test_it_can_update_an_existing_variation()
    {
        $vid = factory(ProductVariation::class)->create()->id;

        $this->cart->add(Collect([
            ['id' => $vid, 'quantity' => 1 ]
        ]));

        $this->assertEquals(1, $this->user->refresh()->cart->first()->pivot->quantity);

        $this->cart->update($vid, ['quantity' => 10]);

        // now the quantity should be 11
        $this->assertEquals(10, $this->user->refresh()->cart->first()->pivot->quantity);
    }
}
