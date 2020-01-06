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
|
*/

//認証
Route::post('/register', 'CustomerController@register')->name('register');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::post('/asset/register', 'AssetController@register')->name('asset.register');

// ログインユーザー
Route::get('/customer', 'CustomerController@customer')->name('customer');

// profession_types
Route::get('/professions', 'ProfessionTypeController@index')->name('professionType.index');

