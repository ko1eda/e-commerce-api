<?php

namespace App\Traits;

use App\Cart\Money;

trait Priceable
{
    /**
     * Creates a custom money object
     * which is really just a convienience
     * wrapper for Money\Money package
     * return the price as a newly configured money object
     * set to the users configured currency
     *
     * @return Money;
     */
    public function getPriceAttribute($value)
    {
        return new Money($value);
    }

    /**
     * Return a formatted price string
     * for the given money object
     * formatted to the users configured locale
     *
     * @return String
     */
    public function getFormattedPriceAttribute()
    {
        return $this->price->formatted();
    }
}
