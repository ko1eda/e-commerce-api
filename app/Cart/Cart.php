<?php

namespace App\Cart;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Models\ProductVariation;

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
     * Convert the parameter to a collection if it is not already
     * Then reformat it and sync it to the product_variation_user_table
     *
     * @param Illuminate\Support\Collection | @param array  $variations
     * @return void
     */
    public function add($variations) : void
    {
        if (is_array($variations)) {
            $variations = Collect($variations);
        }

        $this->user->cart()->syncWithoutDetaching(
            $this->reformatForSync($variations)
        );
    }

    /**
     * Update a given variation in the users cart
     *
     * @param int $id
     * @param array $updateable
     * @return void
     */
    public function update(int $id, array $updateable) : void
    {
        $this->user->cart()->updateExistingPivot($id, $updateable);
    }

    /**
     * Remove a variation from the cart
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id) : void
    {
        $this->user->cart()->detach($id);
    }

    /**
     * Remove a variation from the cart
     *
     * @param int $id
     * @return void
     */
    public function empty() : void
    {
        $this->user->cart()->sync([]);
    }


    /**
     * Reformat the a collection of product variations
     * passed to match the formatting of
     * the sync method
     * from [['id' => 1, 'quantity' => 1], ...]
     * to  [1 => ['quantity' => 1], 2 => ['quantity' => 2], ...]
     *
     * @param Illuminate\Support\Collection $variations
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
