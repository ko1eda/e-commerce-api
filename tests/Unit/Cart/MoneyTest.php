<?php

namespace Tests\Unit\Cart;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Cart\Money;

class MoneyTest extends TestCase
{
 
    public function test_it_returns_a_formatted_money_string_for_current_locale_and_currency()
    {
        // Note default locale is en_US
        // And the default currency is USD
        $this->assertEquals('$50.00', ($moneyObj = new Money(5000))->formatted());

        // however if we change the locale
        config(['app.locale' => 'en_CA']);
        
        $this->assertEquals('US$50.00', $moneyObj->formatted());

        // And if we make a new money object with new currency
        config(['app.locale' => 'en_GB']);
        config(['app.currency' => 'GBP']);

        // then it will return a formatted string with correct locale and currency
        $this->assertEquals('£50.00', ($moneyObj = new Money(5000))->formatted());
    }
}
