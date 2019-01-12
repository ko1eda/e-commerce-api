<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ProductVariation;

class CartDestroyTest extends TestCase
{
    public function test_it_does_not_allow_unauthenticated_users_to_delete_items()
    {
        // 401 unauthorized
        $this->withExceptionHandling()
            ->json('DELETE', route('cart.destroy', ['id' => 1]))
            ->assertStatus(401);
    }

    public function test_it_returns_404_if_the_variation_is_not_found()
    {
        $this->be($user = factory(User::class)->create());

        $this->withExceptionHandling()
            ->json('DELETE', route('cart.destroy', ['id' => 1]))
            ->assertStatus(404);
    }

    public function test_it_removes_a_single_variation()
    {
        $this->be($user = factory(User::class)->create());

        $vid = factory(ProductVariation::class)->create()->id;

        $this->json('POST', route('cart.store'), [
            'products' => [
                ['id' => $vid, 'quantity' => 1],
            ]
        ]);

        $this->assertEquals(1, $user->refresh()->cart->count());

        $this->json('DELETE', route('cart.update', $vid));

        $this->assertEquals(0, $user->refresh()->cart->count());
        
        $this->assertDatabaseMissing('product_variation_user', ['product_variation_id' => $vid]);
    }
}
