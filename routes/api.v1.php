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

// Auth
Route::prefix('auth')->group(function () {
    Route::post('register', 'RegisterController@register')->name('register');
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout')->name('logout');
    Route::post('refresh', 'AuthController@refresh')->name('refresh');
    Route::post('me', 'AuthController@me')->name('me');
});
