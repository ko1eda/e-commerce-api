<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Display all the variations in the passed in users cart.
     * Load the variations parent products and stock as well to avoid n+1.
     *
     * Note: CartProductVariationResource is a child of the regular ProductVariationResource
     *  with specific information relating to the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'products' => CartProductVariationResource::collection(
                $this->cart()->with(['product', 'product.variations.stock', 'stock'])->get()
            )
        ];
    }
}
