<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Filters\Contracts\Filter;

class CategoryFilter implements Filter
{
    /**
     * Return builder where the category slug is
     * the same as the $value passed in
     *
     * @param mixed $builder
     * @param mixed $value : the value of the query string parameter we are filtering by
     * @return void
     */
    public function apply($builder, $value)
    {
        $builder->whereHas('categories', function ($q) use ($value) {
            return $q->where('slug', $value);
        });
    }
}
