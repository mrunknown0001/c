<?php

// route to go to landing page of the app
Route::get('/', [
	'uses' => 'GeneralController@getLandingPage',
	'as' => 'get_landing_page'
]);


// route to go to about page of the app
Route::get('about', [
	'uses' => 'GeneralController@getAboutPage',
	'as' => 'get_about_page'
]);


// route to register new member of the site
Route::get('register', [
	'uses' => 'GeneralController@getRegister',
	'as' => 'get_register'
]);


// route to go to login page of admin
Route::get('login', [
	'uses' => 'GeneralController@getLogin',
	'as' => 'get_login'
]);


// route use to login a user
Route::post('login', [
	'uses' => 'GeneralController@postLogin',
	'as' => 'post_login'	
]);


/***********************************************
************ ADMIN ROUTE GROUP *****************
***********************************************/
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'checkadmin']], function () {
	
	// admin dashboard
	Route::get('/', function () {
		return "Admin Dashboard";
	})->name('admin_dashboard');
});
/***********************************************
********** END OF ADMIN ROUTE GROUP ************
***********************************************/