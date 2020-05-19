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


Auth::routes();


Route::get('/', 'HomeController@index')->name('home');
Route::get('/info', 'HomeController@getInfo')->name('info');
Route::get('/search', 'SearchController@mainPage')->name('search');
Route::get('/search/query', 'SearchController@handleSubmit')->name('search-submit');



//Registered User Routes
Route::middleware('auth')->group(function () {

    // User account welcome/overview page
    Route::get('/overview', 'HomeController@overview')->name('overview');

    //submission routes for each individual user
    Route::get('/submissions', 'UserSubmissionController@userSubmissionListPage')->name('submission');
    Route::get('/submission/view/{type?}/{state?}/{itemId?}', 'UserSubmissionController@viewSubmission')->name("viewSubmission");

    Route::get('/submission/edit/{type?}/{state?}/{itemId?}', 'UserSubmissionController@submissionEdit')->name('submissionEdit');
    Route::post('/submission/edit/{type?}/{state?}/{itemId?}', 'UserSubmissionController@submissionEditSubmit')->name('submissionEditUpdate');

    Route::post('/submissions/delete', 'UserSubmissionController@deleteItem')->name('deleteItem');

    Route::get('/account', 'AccountController@view')->name('account');
    Route::get('/accountUpdate', 'AccountController@getUpdatePage')->name('updatePage');
    Route::post('/accountUpdate', 'AccountController@updateAccount')->name('updateAccount');
    Route::get('/changePassword', 'AccountController@getPasswordPage')->name('password');
    Route::post('/changePassword', 'AccountController@changePassword')->name('changePassword');

    Route::get('/userSubmission', 'RegulationController@userRegulationSubmissionPage')->name('userSubmission');
    Route::post('/regSubmit', 'RegulationController@addRegulationSubmit')->name('regSubmit');


});

//Admin Routes
Route::prefix('admin')->middleware('auth')->middleware('admin')->group(function () {
    Route::get('/', 'AdminController@getBasicAdminPage')->name('admin');
    Route::get('update', 'AdminController@getUsers')->name('getUsers');
    Route::get('update/search', 'AdminController@searchUsers')->name('searchUsers');
    //Route::get('/database', 'DatabaseController@getDatabasePage')->name('database');
    Route::post('/update', 'AdminController@updateUserAccess')->name('updateUser');
    Route::get('viewUser', 'AdminController@viewUser')->name('viewUser');
    Route::get('/viewEmail', 'AdminController@viewEmail')->name('viewEmail');
    Route::get('/email/scheduled', 'AdminController@scheduledEmailView')->name('scheduledEmails');
    Route::post('/email/scheduled', 'AdminController@scheduledEmailSubmit')->name('scheduledEmailsSubmit');

    //User submission Routes
    Route::get('/adminUserSubmissionView', 'AdminSubmissionController@all')->name('adminUserSubmissionView');

    //user city submissions Routes
    Route::get('/userSubmission/userCitySubmission', 'AdminSubmissionController@userCity')->name('userCityView');
    Route::get('/userSubmission/userCitySubmissionItem/{itemid?}', 'AdminSubmissionController@userCityView')->name('userCitySubmissionItem');
    Route::post('/userSubmission/userCitySubmission/add', 'MergeController@addCityMergeSubmit')->name('addCityMergeSubmit');
    Route::post('/userSubmission/userCitySubmission/delete', 'MergeController@deleteCityMerge')->name('cityDelete');

    //user state submissions Routes
    Route::get('/userSubmission/userStateSubmission', 'AdminSubmissionController@userState')->name('userStateView');
    Route::get('/userSubmission/userStateSubmissionItem/{itemid?}', 'AdminSubmissionController@userStateView')->name('userStateSubmissionItem');
    Route::post('/userSubmission/userStateSubmission/add', 'MergeController@addStateMergeSubmit')->name('addStateMergeSubmit');
    Route::post('/userSubmission/userStateSubmission/delete', 'MergeController@deleteStateMerge')->name('stateDelete');

    //user county submissions Routes
    Route::get('/userSubmission/userCountySubmission', 'AdminSubmissionController@userCounty')->name('userCountyView');
    Route::get('/userSubmission/userCountySubmissionItem/{itemid?}', 'AdminSubmissionController@userCountyView')->name('userCountySubmissionItem');
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
        Route::get('/states/modify', 'StateController@modify')->name('modifyState');
        Route::post('/states/modify', 'StateController@modifyStateSubmit')->name('modifyStateSubmit');

        // ReuseNode Routes
        Route::get('/reuseNodes', 'ReuseNodeController@allReuseNodes')->name('reuseNodeView');
        Route::get('/reuseNodes/add', 'ReuseNodeController@addReuseNode')->name('reuseNodeAdd');
        Route::post('/reuseNodes/add', 'ReuseNodeController@addReuseNodeSubmit')->name('reuseNodeAddSubmit');
        Route::post('/reuseNodes/delete', 'ReuseNodeController@deleteReuseNode')->name('deleteReuseNode');
        Route::get('/reuseNodes/modify', 'ReuseNodeController@modify')->name('modifyReuseNode');
        Route::post('/reuseNodes/modify', 'ReuseNodeController@modifyReuseNodeSubmit')->name('modifyReuseNodeSubmit');

        // Link Routes
        Route::get('/links', 'LinkController@allLinks')->name('linkView');
        Route::get('/links/add', 'LinkController@addLink')->name('linkAdd');
        Route::post('/links/add', 'LinkController@addLinkSubmit')->name('linkAddSubmit');
        Route::post('/links/delete', 'LinkController@deleteLink')->name('deleteLink');
        Route::get('/links/modify', 'LinkController@modify')->name('modifyLink');
        Route::post('/links/modify', 'LinkController@modifyLinkSubmit')->name('modifyLinkSubmit');
        Route::post('/links/status', 'LinkController@checkLinkStatus')->name('checkLinkStatus');

        // Allowed Routes
        Route::get('/allowedTypes', 'AllowedTypesController@allAllowedTypes')->name('allowedView');
        Route::get('/allowedTypes/add', 'AllowedTypesController@addAllowedType')->name('allowedAdd');
        Route::post('/allowedTypes/add', 'AllowedTypesController@addAllowedTypeSubmit')->name('allowedAddSubmit');
        Route::post('/allowedTypes/delete', 'AllowedTypesController@deleteAllowedType')->name('deleteAllowed');
        Route::get('/allowedTypes/modify', 'AllowedTypesController@modify')->name('modifyAllowed');
        Route::post('/allowedTypes/modify', 'AllowedTypesController@modifyAllowedSubmit')->name('modifyAllowedSubmit');
    });
});

