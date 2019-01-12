<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;
use App\Cart\Money;

class CartProductVariationResource extends ProductVariationResource
{
    /**
     * Add aditional information to the ProductVariation Resource
     * that pretains specifically to our cart, such as total or parent product
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // the total for each variation in the cart
        $total = new Money($this->price->amount() * $this->pivot->quantity);
        
        return array_merge(parent::toArray($request), [
            'product' => new ProductIndexResource($this->product),
            'quantity' => $this->pivot->quantity,
            'total' => $total->formatted()
        ]);
    }
}
