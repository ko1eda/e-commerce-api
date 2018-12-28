<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image_path' => $this->image_path,
            'price' => $this->formattedPrice,
            'hasParentPrice' => $this->hasParentPrice,
            'current_stock' => $this->currentStock,
            'in_stock' => $this->inStock
        ];
    }
}
