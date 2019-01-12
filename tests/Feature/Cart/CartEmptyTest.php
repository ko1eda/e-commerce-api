<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ProductVariation;

class CartEmptyTest extends TestCase
{
    public function test_it_does_not_allow_unauthenticated_users_to_remove_all_variations()
    {
        // 401 unauthorized
        $this->withExceptionHandling()
            ->json('DELETE', route('cart.empty'))
            ->assertStatus(401);
    }

    public function test_it_removes_all_variations()
    {
        $this->be($user = factory(User::class)->create());

        $v1 = factory(ProductVariation::class)->create()->id;
        $v2 = factory(ProductVariation::class)->create()->id;

        $this->json('POST', route('cart.store'), [
            'products' => [
                ['id' => $v1, 'quantity' => 1],
                ['id' => $v2, 'quantity' => 1],
            ]
        ]);

        $this->assertEquals(2, $user->refresh()->cart->count());

        $this->json('DELETE', route('cart.empty'));

        $this->assertEquals(0, $user->refresh()->cart->count());
    }
}
