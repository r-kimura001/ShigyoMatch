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
// ログインユーザー
Route::get('/customer', 'CustomerController@customer')->name('customer');

// customers
Route::get('/customers', 'CustomerController@index')->name('customer.index');
Route::put('/customers/{id}', 'CustomerController@update')->name('customer.update');
Route::get('/customers/{id}', 'CustomerController@show')->name('customer.show');
Route::get('/customers/{id}/works', 'CustomerController@worksByOwner')->name('customer.worksByOwner');
Route::get('/customers/{id}/favoriteWorks', 'CustomerController@favoriteWorks')->name('customer.favoriteWorks');

// works
Route::get('/works', 'WorkController@index')->name('work.index');
Route::post('/works/store', 'WorkController@store')->name('work.store');
Route::put('/works/{id}', 'WorkController@update')->name('work.update');
Route::get('/works/{id}', 'WorkController@show')->name('work.show');
Route::delete('/works/{id}', 'WorkController@destroy')->name('work.destroy');

// いいね機能
Route::put('/works/{id}/favorite', 'WorkController@favorite')->name('work.favorite');
Route::delete('/works/{id}/unfavorite', 'WorkController@unfavorite')->name('work.unfavorite');

// profession_types
Route::get('/professions', 'ProfessionTypeController@index')->name('professionType.index');
Route::get('/professions/{id}/selectables', 'ProfessionTypeController@selectables')->name('professionType.selectables');

// prefectures
Route::get('/prefectures', 'PrefectureController@index')->name('prefecture.index');

//アセット画像アップロード
Route::post('/asset/register', 'AssetController@register')->name('asset.register');
