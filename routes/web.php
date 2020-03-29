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



//Registered User Routes
Route::middleware('auth')->group(function () {
    Route::get('/submission', 'SubmissionController@view')->middleware('auth')->name('submission');

    Route::get('/account', 'AccountController@view')->middleware('auth')->name('account');
    Route::get('/accountUpdate', 'AccountController@getUpdatePage')->middleware('auth')->name('updatePage');
    Route::post('/accountUpdate', 'AccountController@updateAccount')->middleware('auth')->name('updateAccount');
    Route::get('/changePassword', 'AccountController@getPasswordPage')->middleware('auth')->name('password');
    Route::post('changePassword', 'AccountController@changePassword')->middleware('auth')->name('changePassword');
});

//Admin Routes
Route::prefix('admin')->middleware('auth')->middleware('admin')->group(function () {
    Route::get('/', 'AdminController@getBasicAdminPage')->name('admin');
    Route::post('/', 'AdminController@updateAdminInformation')->name('adminSave');
    Route::post('/save', 'AdminController@updateAdminRedirect')->name('adminRedirect');

    // Database CRUD Page Routes
    Route::prefix('database')->group(function (){
        Route::get('/', 'DatabaseController@getDatabasePage')->name('database');

        // City Routes
        Route::get('/cities', 'DataControllers\CityController@allCities')->name('cityView');
        Route::get('/cities/add', 'DataControllers\CityController@addCity')->name('cityAdd');
        Route::post('/cities/add', 'DataControllers\CityController@addCitySubmit')->name('cityAddSubmit');
        Route::post('/cities/delete', 'DataControllers\CityController@deleteCity')->name('deleteCity');

        // County Routes
        Route::get('/counties', 'DataControllers\CountyController@allCounties')->name('countyView');
        Route::get('/counties/add', 'DataControllers\CountyController@addCounty')->name('countyAdd');
        Route::post('/counties/add', 'DataControllers\CountyController@addCountySubmit')->name('countyAddSubmit');
        Route::post('/counties/delete', 'DataControllers\CountyController@deleteCounty')->name('deleteCounty');

        // State Routes
        Route::get('/states', 'DataControllers\StateController@allStates')->name('stateView');
        Route::get('/states/add', 'DataControllers\StateController@addState')->name('stateAdd');
        Route::post('/states/add', 'DataControllers\StateController@addStateSubmit')->name('stateAddSubmit');
        Route::post('/states/delete', 'DataControllers\StateController@deleteState')->name('deleteState');

        // Source Routes
        Route::get('/sources', 'DataControllers\SourceController@allSources')->name('sourceView');
        Route::get('/sources/add', 'DataControllers\SourceController@addSource')->name('sourceAdd');
        Route::post('/sources/add', 'DataControllers\SourceController@addSourceSubmit')->name('sourceAddSubmit');
        Route::post('/sources/delete', 'DataControllers\SourceController@deleteSource')->name('deleteSource');

        // Destination Routes
        Route::get('/destinations', 'DataControllers\destinationController@allDestinations')->name('destinationView');
        // TODO

        // Link Routes
        // TODO


    });

});

