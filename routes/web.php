<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['namespace' => 'Web'], function () {

    Route::get('login', 'ViewController@login');

    Route::get('register', 'ViewController@register');

    Route::get('/', 'ViewController@index');

    Route::get('user', 'ViewController@user');

    Route::get('search', 'ViewController@search');

    Route::group(['prefix' => 'user'], function (){

        Route::get('find/{id}', 'ViewController@findUserResult');

    });

});
