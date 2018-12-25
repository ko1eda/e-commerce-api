<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

trait Priceable
{
    /**
     * Creates a new money object
     * set to the users default currency
     * which is checked via middleware
     * If no currency is set, it will use the default
     *
     * @return Money
     */
    public function getPriceAttribute($value)
    {
        return Money::{config('app.currency')}($value);
    }

    /**
     * create a money formatter
     * taking in a php number formatter set
     * to the correct locale (which is checked via middleware)
     * and the ISO currency list
     * return the formatted price string
     *
     * @return String
     */
    public function getFormattedPriceAttribute()
    {
        $moneyFormatter = new IntlMoneyFormatter(
            new \NumberFormatter(config('app.locale'), \NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );
        
        return $moneyFormatter->format($this->price);
    }
}
