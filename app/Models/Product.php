<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Filterable;
use App\Traits\Priceable;

class Product extends Model
{
    use Filterable, Priceable;



    protected $appends = ['total_stock', 'in_stock'];


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
     * -----------------------------------------
     * Methods & Attributes
     * -----------------------------------------
     */
    public function getTotalStockAttribute()
    {
        return $this->variations->sum('current_stock');
    }


    public function getInStockAttribute()
    {
        return $this->total_stock > 0;
    }

    /**
     * -----------------------------------------
     * Relationships
     * -----------------------------------------
     */

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
        return $this->hasMany(ProductVariation::class)->orderBy('order', 'asc');
    }
}
