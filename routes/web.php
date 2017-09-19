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

	/* Model(s) Master */

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

	/** Countries **/
	Route::get('countries', 'Master\CountriesController@index');
	Route::get('countries/create', 'Master\CountriesController@create');
	Route::post('countries', 'Master\CountriesController@store');
	Route::get('countries/edit/{id}', 'Master\CountriesController@edit');
	Route::patch('countries/{id}', 'Master\CountriesController@update');
	Route::delete('countries/{id}', 'Master\CountriesController@destroy');

	/** Athletes **/
	Route::get('athletes', 'Master\AthleteControllers@index');
	Route::get('athletes/create', 'Master\AthleteControllers@create');
	Route::post('athletes', 'Master\AthleteControllers@store');
	Route::get('athletes/edit/{id}', 'Master\AthleteControllers@edit');
	Route::patch('athletes/{id}', 'Master\AthleteControllers@update');
	Route::delete('athletes/{id}', 'Master\AthleteControllers@destroy');

	/** Schedules **/
	Route::get('schedules', 'Master\ScheduleController@index');
	Route::get('schedules/create', 'Master\ScheduleController@create');
	Route::post('schedules', 'Master\ScheduleController@store');
	Route::get('schedules/edit/{id}', 'Master\ScheduleController@edit');
	Route::patch('schedules/{id}', 'Master\ScheduleController@update');
	Route::delete('schedules/{id}', 'Master\ScheduleController@destroy');

	/** Match Entries **/
	Route::get('matchentries', 'Master\MatchEntryController@index');
	Route::get('matchentries/create', 'Master\MatchEntryController@create');
	Route::post('matchentries', 'Master\MatchEntryController@store');
	Route::get('matchentries/edit/{id}', 'Master\MatchEntryController@edit');
	Route::patch('matchentries/{id}', 'Master\MatchEntryController@update');
	Route::delete('matchentries/{id}', 'Master\MatchEntryController@destroy');

	/** Match Groups **/	
	Route::get('matchgroups/create', 'Master\MatchGroupController@create');
	Route::post('matchgroups', 'Master\MatchGroupController@store');
	Route::get('matchgroups/edit/{id}', 'Master\MatchGroupController@edit');
	Route::patch('matchgroups/{id}', 'Master\MatchGroupController@update');
	Route::delete('matchgroups/{id}', 'Master\MatchGroupController@destroy');

	/** Schedule Details **/	
	Route::get('scheduledetails', 'Master\ScheduleDetailController@index');
	Route::get('scheduledetails/create', 'Master\ScheduleDetailController@create');
	Route::post('scheduledetails', 'Master\ScheduleDetailController@store');
	Route::get('scheduledetails/edit/{id}', 'Master\ScheduleDetailController@edit');
	Route::patch('scheduledetails/{id}', 'Master\ScheduleDetailController@update');
	Route::delete('scheduledetails/{id}', 'Master\ScheduleDetailController@destroy');
	Route::delete('scheduledetailsone/{scid}/{meid}', 'Master\ScheduleDetailController@destroyOne');

	/* Utilities */

	/* Datatables */
	Route::post('datatable/branchsports', ['as'=> 'datatable.branchsports','uses'=>'Master\BranchSportController@masterDataTable']);
	Route::post('datatable/kindsports', ['as'=> 'datatable.kindsports','uses'=>'Master\KindSportController@masterDataTable']);
	Route::post('datatable/typesports', ['as'=> 'datatable.typesports','uses'=>'Master\TypeSportController@masterDataTable']);
	Route::post('datatable/countries', ['as'=> 'datatable.countries','uses'=>'Master\CountriesController@masterDataTable']);
	Route::post('datatable/athletes', ['as'=> 'datatable.athletes','uses'=>'Master\AthleteControllers@masterDataTable']);
	Route::post('datatable/schedules', ['as'=> 'datatable.schedules','uses'=>'Master\ScheduleController@masterDataTable']);
	Route::post('datatable/matchentries', ['as'=> 'datatable.matchentries','uses'=>'Master\MatchEntryController@masterDataTable']);
	Route::post('datatable/matchgroups', ['as'=> 'datatable.matchgroups','uses'=>'Master\MatchGroupController@masterDataTable']);
	Route::post('datatable/scheduledetails', ['as'=> 'datatable.scheduledetails','uses'=>'Master\ScheduleDetailController@masterDataTable']);

	/* Relation */
	Route::post('relation/branchkind', ['as'=> 'relation.branchkind','uses'=>'RelationController@branchKindRelation']);
	Route::post('relation/kindtype', ['as'=> 'relation.kindtype','uses'=>'RelationController@kindTypeRelation']);
	Route::post('relation/countryathlete', ['as'=> 'relation.countryathlete','uses'=>'RelationController@countryAthleteRelation']);
	Route::post('relation/typematch', ['as'=> 'relation.typematch','uses'=>'RelationController@typeMatchRelation']);
	Route::post('relation/typeschedule', ['as'=> 'relation.typeschedule','uses'=>'RelationController@typeScheduleRelation']);
	Route::post('relation/typeathlete', ['as'=> 'relation.typeathlete','uses'=>'RelationController@typeAthleteRelation']);
	Route::post('relation/athletematchgroup', ['as'=> 'relation.athletematchgroup','uses'=>'RelationController@athleteMatchGroupRelation']);
	Route::post('relation/matchentrymatchgroup', ['as'=> 'relation.matchentrymatchgroup','uses'=>'RelationController@matchEntryMatchGroupRelation']);
	Route::post('relation/matchentryscheduledetails', ['as'=> 'relation.matchentryscheduledetails','uses'=>'RelationController@matchEntryScheduleDetailsRelation']);
	Route::post('relation/schedulescheduledetails', ['as'=> 'relation.schedulescheduledetails','uses'=>'RelationController@scheduleScheduleDetailsRelation']);

	/* Data with filter (select2, list) */
	Route::post('data/branchsports', ['as'=> 'data.branchsports','uses'=>'Master\BranchSportController@getDataWithFilters']);
	Route::post('data/kindsports', ['as'=> 'data.kindsports','uses'=>'Master\KindSportController@getDataWithFilters']);
	Route::post('data/typesports', ['as'=> 'data.typesports','uses'=>'Master\TypeSportController@getDataWithFilters']);
	Route::post('data/countries', ['as'=> 'data.countries','uses'=>'Master\CountriesController@getDataWithFilters']);
	Route::post('data/athletes', ['as'=> 'data.athletes','uses'=>'Master\AthleteControllers@getDataWithFilters']);
	Route::post('data/matchentries', ['as'=> 'data.matchentries','uses'=>'Master\MatchEntryController@getDataWithFilters']);
	Route::post('data/schedules', ['as'=> 'data.schedules','uses'=>'Master\ScheduleController@getDataWithFilters']);

	/* Util Method(s) */
	Route::post('util/checkscheduledetail', ['as'=> 'util.checkscheduledetail','uses'=>'UtilController@checkScheduleDetail']);

	/* Page(s) & etc */

	/* Summary */
	Route::get('sport', 'PageController@sportSummary');

	/* Services */
	Route::get('service/matchentrycode', 'ServiceController@getMatchEntryCode');
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