<?php

namespace App\Cart;

use App\Models\User;
use Illuminate\Support\Collection;

class Cart
{
    /**
     * $user
     *
     * @var User
     */
    protected $user;


    /**
     * __construct
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Restructure the passed in collection to a format that is
     * compatable with sync method ex: [id1 => ['quantity' => 1], id2 => ['quantity' => 2], ...]
     * Then store this in the product_variation_user join table for the given user
     *
     * @param Collection $variatins
     * @return void
     */
    public function add(Collection $variations)
    {
        $this->user->cart()->syncWithoutDetaching(
            $variations->keyBy('id')->map(function ($variation) {
                return ['quantity' => $variation['quantity']];
            })
        );
    }

    // /**
    //  * total
    //  *
    //  * @param Collection $variatins
    //  * @return void
    //  */
    // public function total()
    // {
    //     // $this->user()->cart->reduce(function ($carry, $variation) {
    //     //     return $carry->add($variation->price->amount()->multiply($variation->pivot->quantity));
    //     // }, Money::{config('app.currency')}(0));
    // }
}
