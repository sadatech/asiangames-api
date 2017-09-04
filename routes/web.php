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

	/** Type Sports **/
	Route::get('typesport', 'Master\TypeSportController@index');
	Route::get('typesport/create', 'Master\TypeSportController@create');
	Route::post('typesport', 'Master\TypeSportController@store');
	Route::get('typesport/edit/{id}', 'Master\TypeSportController@edit');
	Route::patch('typesport/{id}', 'Master\TypeSportController@update');
	Route::delete('typesport/{id}', 'Master\TypeSportController@destroy');

	/* Datatables */
	Route::post('datatable/branchsports', ['as'=> 'datatable.branchsports','uses'=>'Master\BranchSportController@masterDataTable']);
	Route::post('datatable/kindsports', ['as'=> 'datatable.kindsports','uses'=>'Master\KindSportController@masterDataTable']);
	Route::post('datatable/typesports', ['as'=> 'datatable.typesports','uses'=>'Master\TypeSportController@masterDataTable']);

	/* Select2 */
	Route::post('data/branchsports', ['as'=> 'data.branchsports','uses'=>'Master\BranchSportController@getDataWithFilters']);
	Route::post('data/kindsports', ['as'=> 'data.kindsports','uses'=>'Master\KindSportController@getDataWithFilters']);
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

/* Method untuk daftar admin ketika aplikasi first run */
Route::get('createadmin', 'Auth\OnceController@createAdmin');