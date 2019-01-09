<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends ProductIndexResource
{
    /**
     * Transform the resource into an array.
     * Group each collection of product variations by its type (ex: color, size, RAM, w/e)
     *
     * https://secure.php.net/manual/en/function.array-merge.php
     * could also use array union operater return arr1 + arr2;
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'total_stock' => $this->totalStock,
            'in_stock' => $this->inStock,
            'variations' => ProductVariationResource::collection(
                $this->variations
            )
            ->groupBy('type.name')
        ]);
    }
}
