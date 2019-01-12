<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use App\Cart\Cart;
use App\Http\Resources\CartResource;

class CartController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display cart contents for the given user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return new CartResource($request->user());
    }

    /**
     * Pull the array of products from the validated request array
     * Then store it in the users cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param App\Cart\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cart $cart)
    {
        $variations = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products_variations,id',
            'products.*.quantity' => 'required|gte:1'
        ])['products'];

        $cart->add($variations);
    }

    /**
     * Update the specified item in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\ProductVariation $variation
     * @param  App\Cart\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductVariation $productVariation, Cart $cart)
    {
        $cart->update($productVariation->id, $request->validate(['quantity' => 'required|gte:1']));
    }

    /**
     * Remove an item from the cart.
     *
     * @param  int  $id
     * @param  App\Cart\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductVariation $productVariation, Cart $cart)
    {
        $cart->delete($productVariation->id);
    }

    /**
     * Remove all the items from the cart.
     *
     * @param  App\Cart\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function empty(Cart $cart)
    {
        $cart->empty();
    }
}
