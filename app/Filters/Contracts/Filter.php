<?php

namespace App\Filters\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    /**
     * Filter the given query by the given value.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function apply(Builder $builder, $value);
}
