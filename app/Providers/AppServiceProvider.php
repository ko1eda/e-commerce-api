<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider;
use App\Cart\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->singleton(Cart::class, function ($app) {
            return new Cart($app->auth->user());
        });
    }
}
