<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Filterer;

class Product extends Model
{
    /**
     * Override the default route key
     *
     * @return String
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }


    /**
     * A Product is associated with multiple categories
     *
     * @return void
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Make a new filterer, pass in the builder
     * and any filters that you want ot apply
     *
     * @param array $filers
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithFilters(Builder $builder, array $filters = [])
    {
        return (new Filterer(request()))->apply($builder, $filters);
    }
}
