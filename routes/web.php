<?php

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

Route::get('/', function () {
    return view('mainpage');
});

Route::get('/info', function() {
    return view('info');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');
Route::get('/info', 'HomeController@getInfo')->name('info');
Route::get('/search', 'SearchController@mainPage')->name('search');

Route::get('/account', 'AccountController@view')->middleware('auth')->name('account');
Route::post('updateAccount', 'AccountController@updateAccount')->middleware('auth')->name('updateAccount');
