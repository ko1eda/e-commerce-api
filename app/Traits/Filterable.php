<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\Filterer;

trait Filterable
{
    /**
     * Make a new filterer, pass in the builder
     * and any filters that you want to apply
     *
     * @return Builder
     * @param array $filers
     * @return Builder
     */
    public function scopeWithFilters(Builder $builder, array $filters = [])
    {
        return (new Filterer(request()))->apply($builder, $filters);
    }
}
