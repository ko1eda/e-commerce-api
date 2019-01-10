<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use Illuminate\Support\Collection;
use App\Cart\Cart;

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
    public function index()
    {
        //
    }

    /**
     * Destructure the products from the validated request
     * and convert it to a collection.
     * Then store it in the users cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cart $cart)
    {
        $variations = Collect($request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products_variations,id',
            'products.*.quantity' => 'required|gte:1'
        ])['products']);

        $cart->add($variations);
    }


    /**
     * Update the specified item in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove all items from the cart.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
