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
     * Then store this in the product_variation_user join table for the given user
     *
     * @param Collection $variatins
     * @return void
     */
    public function add(Collection $variations) : void
    {
        $this->user->cart()->syncWithoutDetaching(
            $this->reformatForSync($variations)
        );
    }


    /**
     * Reformat the a collection of product variations
     * passed to match the formatting of
     * the sync method [id1 => ['quantity' => 1], id2 => ['quantity' => 2], ...]
     *
     * @param Collection $variations
     * @return Collection
     */
    protected function reformatForSync(Collection $variations) : Collection
    {
        return $variations
            ->keyBy('id')
            ->map(function ($variation) {
                return ['quantity' => $variation['quantity'] + $this->getCurrentQuantity($variation['id'])];
            });
    }


    /**
     * If the variation already exists in this users cart
     * Then return the quantity, otherwise return 0.
     *
     * @param int $id
     * @return int
     */
    protected function getCurrentQuantity(int $id) : int
    {
        if ($variation = $this->user->cart->where('id', $id)->first()) {
            return $variation->pivot->quantity;
        }

        return 0;
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
