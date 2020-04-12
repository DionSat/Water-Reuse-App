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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get("/states", "DataControllers\StateController@getAllStates")->name("states-api");
Route::get("/counties/{state_id?}", "DataControllers\CountyController@getCountiesInState")->name("counties-api");
Route::get("/cities/{county_id?}", "DataControllers\CityController@getCitiesInCounty")->name("cities-api");

Route::get('/mySources', 'RegulationController@getAllSources')->name('my-sources-api');
Route::get('/myDestination', 'RegulationController@getAllDestinations')->name('my-destination-api');
