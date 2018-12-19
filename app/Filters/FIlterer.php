<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Filters\Contracts\Filter;

class Filterer
{
    protected $builder;

    protected $filters;

    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Loop through all filters passed in,
     * call the apply method on each filter,
     * passing in the query paramter aka key for each filter if it exists
     *
     * return the builder after all filters are applied
     * @param mixed $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($builder, $filters)
    {
        foreach ($filters as $key => $filter) {
            if (!$filter instanceof Filter) {
                throw new \Error('This filter must implement App\Filters\Contracts\Filter');
            }
            
            if (!$this->request->has($key)) {
                return ;
            }

            $filter->apply($builder, $this->request->get($key));
        }

        return $builder;
    }
}
