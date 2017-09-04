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
    return view('auth.login');
});

Route::group(['middleware' => ['auth']], function () {
	Route::get('/', 'DashboardController@index');
	Route::get('ok', 'DashboardController@index');

	// Branch Sports
	Route::get('branchsport', 'Master\BranchSportController@index');
	Route::get('branchsport/create', 'Master\BranchSportController@create');
	Route::post('branchsport', 'Master\BranchSportController@store');
	Route::get('branchsport/edit/{id}', 'Master\BranchSportController@edit');
	Route::patch('branchsport/{id}', 'Master\BranchSportController@update');
	Route::delete('branchsport/{id}', 'Master\BranchSportController@destroy');

	// Datatables
	Route::post('datatable/sports', ['as'=> 'datatable.sports','uses'=>'Master\BranchSportController@getData']);
});

Auth::routes();

// Fix method jika user logout lewat url
Route::get('logout', 'Auth\LoginController@logout');

// Buat batasin akses register, dan reset password
Route::match(['get', 'post'], 'register', function(){
    return redirect('/');
});

Route::match(['get', 'post'], 'password/reset', function(){
    return redirect('/');
});

Route::match(['get', 'post'], 'password/email', function(){
    return redirect('/');
});