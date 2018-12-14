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
