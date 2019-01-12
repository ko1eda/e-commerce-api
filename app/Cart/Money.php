<?php

namespace App\Cart;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as BaseMoney;

/**
 * This class is a convienience wrapper
 * for php money package, it is used in
 * Priceable.php
 */
class Money
{
    /**
     * the Money\Money object
     *
     * @var BaseMoney
     */
    protected $money;

    /**
     * Creates a new money object
     * set to the users default currency
     * which is checked via middleware
     *
     * @param int $value
     * @return void
     */
    public function __construct(int $value)
    {
        $this->money = BaseMoney::{config('app.currency')}($value);
    }

    /**
     * Expose the value of the  Money\Money object
     *
     * @return int
     */
    public function amount() : int
    {
        return $this->money->getAmount();
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
    public function formatted() : String
    {
        $moneyFormatter = new IntlMoneyFormatter(
            new \NumberFormatter(config('app.locale'), \NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        return $moneyFormatter->format($this->money);
    }
}
