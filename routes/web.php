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
    Route::get('Update', 'AdminController@getUsers')->name('getUsers');
    Route::get('/database', 'DatabaseController@getDatabasePage')->name('database');
    Route::post('/Update', 'AdminController@updateUserAccess')->name('updateUser');
    Route::get('viewUser', 'AdminController@viewUser')->name('viewUser');
    Route::get('/userSubmission', 'UserSubmissionController@basicPage')->name('userSubmission');

    // Database CRUD Page Routes
    Route::prefix('database')->namespace('DataControllers')->group(function (){

        // City Routes
        Route::get('/cities', 'CityController@allCities')->name('cityView');
        Route::get('/cities/add', 'CityController@addCity')->name('cityAdd');
        Route::post('/cities/add', 'CityController@addCitySubmit')->name('cityAddSubmit');
        Route::post('/cities/delete', 'CityController@deleteCity')->name('deleteCity');

        // County Routes
        Route::get('/counties', 'CountyController@allCounties')->name('countyView');
        Route::get('/counties/add', 'CountyController@addCounty')->name('countyAdd');
        Route::post('/counties/add', 'CountyController@addCountySubmit')->name('countyAddSubmit');
        Route::post('/counties/delete', 'CountyController@deleteCounty')->name('deleteCounty');

        // State Routes
        Route::get('/states', 'StateController@allStates')->name('stateView');
        Route::get('/states/add', 'StateController@addState')->name('stateAdd');
        Route::post('/states/add', 'StateController@addStateSubmit')->name('stateAddSubmit');
        Route::post('/states/delete', 'StateController@deleteState')->name('deleteState');

        // Source Routes
        Route::get('/sources', 'SourceController@allSources')->name('sourceView');
        Route::get('/sources/add', 'SourceController@addSource')->name('sourceAdd');
        Route::post('/sources/add', 'SourceController@addSourceSubmit')->name('sourceAddSubmit');
        Route::post('/sources/delete', 'SourceController@deleteSource')->name('deleteSource');

        // Destination Routes
        Route::get('/destinations', 'DestinationController@allDestinations')->name('destinationView');
        Route::get('/destinations/add', 'DestinationController@addDestination')->name('destinationAdd');
        Route::post('/destinations/add', 'DestinationController@addDestinationSubmit')->name('destinationAddSubmit');
        Route::post('/destinations/delete', 'DestinationController@deleteDestination')->name('deleteDestination');

        // Link Routes
        Route::get('/links', 'LinkController@allLinks')->name('linkView');
        Route::get('/links/add', 'LinkController@addLink')->name('linkAdd');
        Route::post('/links/add', 'LinkController@addLinkSubmit')->name('linkAddSubmit');
        Route::post('/links/delete', 'LinkController@deleteLink')->name('deleteLink');

    });

});

