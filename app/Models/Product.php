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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * A Product can have many variations
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variations()
    {
        return $this->hasMany(ProductVariation::class)->orderBy('name', 'asc');
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
