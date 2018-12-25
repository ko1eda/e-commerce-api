<?php

namespace Tests\Feature\Middleware;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Http\Middleware\SetCurrency;
use App\Models\User;

class SetCurrencyTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->make();
        
        $this->request = new Request;

        // sanity check before each test
        $this->assertEquals('USD', config('app.currency'));
    }


    public function test_it_sets_the_global_currency_for_a_specific_user()
    {
        // Given we have a user and that user has a currency set
        // and that user makes a request to our api
        $this->request->setUserResolver(function () {
            return $this->user; // note this method is used internally by request to resolve the auth user
        });

        // when our middlewares handle method is called
        // then the default currency should be set accordingly
        $middleware = (new SetCurrency)->handle($this->request, function () {
            $this->assertEquals($this->user->currency, config('app.currency'));
        });
    }

    public function test_it_defaults_to_config_currency_if_there_is_no_authenticated_user()
    {
        // given that a request is made without an authenticated user
        // when our middlewares handle method is called
        // then the default currency should remain the same
        $middleware = (new SetCurrency)->handle($this->request, function () {
            $this->assertEquals('USD', config('app.currency'));
        });
    }

    public function test_it_defaults_to_config_currency_if_the_user_has_not_set_their_currency()
    {
        // given we have an auth user who didn't set their currency
        unset($this->user->currency);
        
         $this->request->setUserResolver(function () {
             return $this->user;
         });
         
         // when our middlewares handle method is called
         // then the default currency should remain the same
         $middleware = (new SetCurrency)->handle($this->request, function () {
            $this->assertEquals('USD', config('app.currency'));
         });
    }
}
