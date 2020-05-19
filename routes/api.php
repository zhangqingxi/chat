<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['namespace' => 'Api'], function () {

    Route::post('login', 'AuthController@login');

    Route::post('register', 'AuthController@register');

    Route::group(['middleware' => 'auth:api'], function () {

        Route::group(['prefix' => 'user'], function (){

            Route::get('/', 'UserController@index');

            Route::PUT('update', 'UserController@update');

        });

        Route::group(['prefix' => 'search'], function (){

            Route::get('/', 'SearchController@index');

        });

        Route::group(['prefix' => 'contact'], function (){

            Route::get('add', 'ContactController@add');

        });

        Route::group(['prefix' => 'friend'], function (){

            Route::post('add', 'FriendController@add');

            Route::get('list', 'FriendController@lists');

            Route::get('new', 'FriendController@apply');

            Route::post('validate', 'FriendController@verify');

            Route::PUT('remarks', 'FriendController@remarks');

        });

    });

});

