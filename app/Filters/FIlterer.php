<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Filters\Contracts\Filter;

class Filterer
{
    /**
     * @var Illuminate\Http\Request;
     */
    protected $request;


    /**
     * __construct
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Loop through all applicable filters
     * call the apply method on each filter,
     * passing in the request parameter value
     * for the given key
     * return the builder with or without filters applied
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($builder, array $filters)
    {
        foreach ($this->siftFilters($filters) as $key => $filter) {
            if (!$filter instanceof Filter) {
                throw new \Error('This filter must implement App\Filters\Contracts\Filter');
            }

            $filter->apply($builder, $this->request->get($key));
        }

        return $builder;
    }

    /**
     * Iterate through the array of allowed filters
     * return an aray of only filters whose keys match the
     * query parameter keys from the request
     *
     * https://secure.php.net/manual/en/function.array-filter.php
     *
     * @param array $filters
     * @return array
     */
    protected function siftFilters(array $filters) : array
    {
        return array_filter($filters, function ($key) {
            return $this->request->has($key);
        }, ARRAY_FILTER_USE_KEY);
    }
}
