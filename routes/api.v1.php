<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
| Resourceful routing https://laravel.com/docs/5.7/controllers#resource-controllers
*/

// Categories
Route::apiResource('categories', 'CategoryController');

// Products
Route::apiResource('products', 'ProductController');

// Cart
// Note: since cart simply represents the pivot table between
// product variations and users, we use the product variation id on any dynamic routes
Route::group([], function () {
    Route::delete('cart/empty', 'CartController@empty')->name('cart.empty');
    Route::apiResource('cart', 'CartController')->parameters(['cart' => 'productVariation']);
});


// Auth
// all files in directory namespace /Api/v1/Auth
// all routes prefixed with auth ex: /api/v1/auth/login
Route::namespace('Auth')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', 'RegistrationController@register')->name('register');
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('logout', 'AuthController@logout')->name('logout');
        Route::post('refresh', 'AuthController@refresh')->name('refresh');
        Route::get('me', 'AuthController@me')->name('me');
    });
});
