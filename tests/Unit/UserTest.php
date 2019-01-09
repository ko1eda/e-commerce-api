<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserTest extends TestCase
{
    public function test_it_has_many_product_variations_referred_to_as_its_cart()
    {
        // Given we have a user
        $user = factory(User::class)->create();

        // And that user adds a variation to their cart
        $user->cart()->save(
            factory(\App\Models\ProductVariation::class)->make()
        );

        // then that user should have a product variation relationship
        $this->assertInstanceOf(\App\Models\ProductVariation::class, $user->cart->first());
    }

    public function test_its_variations_have_a_quantity_that_can_be_updated()
    {
        // Given we have a user
        $user = factory(User::class)->create();

        // And that user adds a variation to their cart
        // Note attach method only updates the intermediary table in a relationship
        // https://laravel.com/docs/5.7/eloquent-relationships
        $user->cart()->attach(
            factory(\App\Models\ProductVariation::class)->create(),
            ['quantity' => 5]
        );

        // then that user shoul have a variation with a quantity of 1
        $this->assertEquals(5, $user->cart->first()->pivot->quantity);

        // however if we update the quantity of variation in that users cart
        $user->cart->first()->pivot->quantity = 1;

        // then that should be reflected
        $this->assertEquals(1, $user->cart->first()->pivot->quantity);
    }
}
