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

Auth::routes();


Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');
Route::get('/info', 'HomeController@getInfo')->name('info');
Route::get('/search', 'SearchController@mainPage')->name('search');




//Registered User Routes
Route::middleware('auth')->group(function () {
    //submission routes for each indiviual user
    Route::get('/submissions', 'SubmissionController@view')->middleware('auth')->name('submission');
    Route::get('/submissions/citySubmissionItem/{itemId?}', 'SubmissionController@pendingCity')->middleware('auth')->name('citySubmission');
    Route::get('/submissions/stateSubmissionItem/{itemId?}', 'SubmissionController@pendingState')->middleware('auth')->name('stateSubmission');
    Route::get('/submissions/countySubmissionItem/{itemId?}', 'SubmissionController@pendingCounty')->middleware('auth')->name('countySubmission');

    //Approved submissions
    Route::get('/submissions/cityApprovedItem/{itemId?}', 'SubmissionController@city')->middleware('auth')->name('cityApprove');
    Route::get('/submissions/stateApprovedItem/{itemId?}', 'SubmissionController@state')->middleware('auth')->name('stateApprove');
    Route::get('/submissions/countyApprovedItem/{itemId?}', 'SubmissionController@county')->middleware('auth')->name('countyApprove');

    Route::get('/account', 'AccountController@view')->middleware('auth')->name('account');
    Route::get('/accountUpdate', 'AccountController@getUpdatePage')->middleware('auth')->name('updatePage');
    Route::post('/accountUpdate', 'AccountController@updateAccount')->middleware('auth')->name('updateAccount');
    Route::get('/changePassword', 'AccountController@getPasswordPage')->middleware('auth')->name('password');
    Route::post('/changePassword', 'AccountController@changePassword')->middleware('auth')->name('changePassword');

    Route::get('/userSubmission', 'RegulationController@allStates')->name('userSubmission');

});

//Admin Routes
Route::prefix('admin')->middleware('auth')->middleware('admin')->group(function () {
    Route::get('/', 'AdminController@getBasicAdminPage')->name('admin');
    Route::get('update', 'AdminController@getUsers')->name('getUsers');
    Route::get('update/search', 'AdminController@searchUsers')->name('searchUsers');
    Route::get('/database', 'DatabaseController@getDatabasePage')->name('database');
    Route::post('/update', 'AdminController@updateUserAccess')->name('updateUser');
    Route::get('viewUser', 'AdminController@viewUser')->name('viewUser');
    Route::get('/viewEmail', 'AdminController@viewEmail')->name('viewEmail');

    //User submission Routes
    Route::get('/userSubmission2', 'UserSubmissionController@all')->name('userSubmission2');

    //user city submissions Routes
    Route::get('/userSubmission/userCitySubmission', 'UserSubmissionController@userCity')->name('userCityView');
    Route::get('/userSubmission/userCitySubmissionItem/{itemid?}', 'UserSubmissionController@userCityView')->name('userCitySubmissionItem');
    Route::post('/userSubmission/userCitySubmission/add', 'MergeController@addCityMergeSubmit')->name('addCityMergeSubmit');
    Route::post('/userSubmission/userCitySubmission/delete', 'MergeController@deleteCityMerge')->name('cityDelete');

    //user state submissions Routes
    Route::get('/userSubmission/userStateSubmission', 'UserSubmissionController@userState')->name('userStateView');
    Route::get('/userSubmission/userStateSubmissionItem/{itemid?}', 'UserSubmissionController@userStateView')->name('userStateSubmissionItem');
    Route::post('/userSubmission/userStateSubmission/add', 'MergeController@addStateMergeSubmit')->name('addStateMergeSubmit');
    Route::post('/userSubmission/userStateSubmission/delete', 'MergeController@deleteStateMerge')->name('stateDelete');

    //user county submissions Routes
    Route::get('/userSubmission/userCountySubmission', 'UserSubmissionController@userCounty')->name('userCountyView');
    Route::get('/userSubmission/userCountySubmissionItem/{itemid?}', 'UserSubmissionController@userCountyView')->name('userCountySubmissionItem');
    Route::post('/userSubmission/userCountySubmission/add', 'MergeController@addCountyMergeSubmit')->name('addCountyMergeSubmit');
    Route::post('/userSubmission/userCountySubmission/delete', 'MergeController@deleteCountyMerge')->name('countyDelete');

    // Database CRUD Page Routes
    Route::prefix('database')->namespace('DataControllers')->group(function (){

        // City Routes
        Route::get('/cities', 'CityController@allCities')->name('cityView');
        Route::get('/cities/add', 'CityController@addCity')->name('cityAdd');
        Route::post('/cities/add', 'CityController@addCitySubmit')->name('cityAddSubmit');
        Route::post('/cities/delete', 'CityController@deleteCity')->name('deleteCity');
        Route::get('/cities/modify', 'CityController@modify')->name('modifyCity');
        Route::post('/cities/modify', 'CityController@modifyCitySubmit')->name('modifyCitySubmit');

        // County Routes
        Route::get('/counties', 'CountyController@allCounties')->name('countyView');
        Route::get('/counties/add', 'CountyController@addCounty')->name('countyAdd');
        Route::post('/counties/add', 'CountyController@addCountySubmit')->name('countyAddSubmit');
        Route::post('/counties/delete', 'CountyController@deleteCounty')->name('deleteCounty');
        Route::get('/counties/modify', 'CountyController@modify')->name('modifyCounty');
        Route::post('/counties/modify', 'CountyController@modifyCountySubmit')->name('modifyCountySubmit');

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

