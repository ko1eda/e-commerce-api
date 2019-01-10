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
Route::apiResource('cart', 'CartController');

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
