<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{

    /**
     * A category can have child categories
     *
     * @return void
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    
    /**
     * Return all parent categories with their children (subcategories) as relations.
     * Then filter those children from the top level of the returned collection
     *
     * @param mixed $query
     * @return void
     */
    public function scopeParents($query)
    {
        return $query->with('children')->where('parent_id', null);
    }
}
