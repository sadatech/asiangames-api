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

/* No Authentication Route */

Route::get('athletes', 'AthleteControllers@index');
Route::get('countries', 'CountriesController@index');
Route::get('branch_sports', 'BranchSportController@index');
Route::get('tour', 'TourController@index');
Route::post('nearby_competition', 'BranchSportController@nearby_competition');
Route::post('nearby_tour', 'TourController@nearby_competition');

/* JWT Authentication */

Route::post('auth/login', 'Api\AuthController@authenticate');

/* End point module(s) */

Route::group(['middleware' => 'jwt.auth'], function () {
	  
	Route::get('/getUser', 'Api\AuthController@getAuthenticatedUser');

});
