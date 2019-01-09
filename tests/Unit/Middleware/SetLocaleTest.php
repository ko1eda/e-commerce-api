<?php

namespace Tests\Feature\Middleware;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Http\Middleware\SetLocale;
use App\Models\User;

class SetLocaleTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->make();

        $this->request = new Request;

        // sanity check before each test
        $this->assertEquals('en_US', config('app.locale'));
    }

    public function test_it_sets_the_global_locale_for_a_specific_user()
    {
        // if that user is authenticated
        $this->request->setUserResolver(function () {
            return $this->user;
        });

        // when our middlewares handle method is called
        // then the default locale should be set accordingly
        $middleware = (new SetLocale)->handle($this->request, function () {
            $this->assertEquals($this->user->locale, config('app.locale'));
        });
    }

    public function test_it_defaults_to_config_locale_if_there_is_no_authenticated_user()
    {
        // Given we have no authenticated user
        // when our middlewares handle method is called
        // then the default locale should remain the same
        $middleware = (new SetLocale)->handle($this->request, function () {
            $this->assertEquals('en_US', config('app.locale'));
        });
    }

    public function test_it_defaults_to_config_locale_if_the_user_has_not_set_their_locale()
    {
        // Given we have a user
        // and that user doesn't have their locale set
        unset($this->user->locale);

        // given that user makes a request to any endpoint
        // if that user is authenticated
        $this->request->setUserResolver(function () {
            return $this->user;
        });
 
        // when our middlewares handle method is called
        // then the default locale should remain the same
        $middleware = (new SetLocale)->handle($this->request, function () {
            $this->assertEquals('en_US', config('app.locale'));
        });
    }
}
