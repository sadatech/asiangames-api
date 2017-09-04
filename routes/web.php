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

	/* Model(s) */

	/** Branch Sports **/
	Route::get('branchsport', 'Master\BranchSportController@index');
	Route::get('branchsport/create', 'Master\BranchSportController@create');
	Route::post('branchsport', 'Master\BranchSportController@store');
	Route::get('branchsport/edit/{id}', 'Master\BranchSportController@edit');
	Route::patch('branchsport/{id}', 'Master\BranchSportController@update');
	Route::delete('branchsport/{id}', 'Master\BranchSportController@destroy');

	/** Kind Sports **/
	Route::get('kindsport', 'Master\KindSportController@index');
	Route::get('kindsport/create', 'Master\KindSportController@create');
	Route::post('kindsport', 'Master\KindSportController@store');
	Route::get('kindsport/edit/{id}', 'Master\KindSportController@edit');
	Route::patch('kindsport/{id}', 'Master\KindSportController@update');
	Route::delete('kindsport/{id}', 'Master\KindSportController@destroy');

	/* Datatables */
	Route::post('datatable/branchsports', ['as'=> 'datatable.branchsports','uses'=>'Master\BranchSportController@masterDataTable']);
	Route::post('datatable/kindsports', ['as'=> 'datatable.kindsports','uses'=>'Master\KindSportController@masterDataTable']);

	/* Select2 */
	Route::post('data/branchsports', ['as'=> 'data.branchsports','uses'=>'Master\BranchSportController@getDataWithFilters']);
});

Auth::routes();

/* Fix method jika user logout lewat url */
Route::get('logout', 'Auth\LoginController@logout');

/* Buat batasin akses register, dan reset password */
Route::match(['get', 'post'], 'register', function(){
    return redirect('/');
});

Route::match(['get', 'post'], 'password/reset', function(){
    return redirect('/');
});

Route::match(['get', 'post'], 'password/email', function(){
    return redirect('/');
});