<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasChildren
{
    /**
     * Return all parent categories with their children (subcategories) as relations.
     * Then filter those children from the top level of the returned collection
     *
     * @param mixed $query
     * @return void
     */
    public function scopeParents($query)
    {
        return $query->where('parent_id', null);
    }
}
