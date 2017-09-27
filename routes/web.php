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


// route to register new member of the site
Route::post('register', [
	'uses' => 'MemberController@memberRegistration',
	'as' => 'member_registration'
]);


// route to go to login page of admin
Route::get('login', [
	'uses' => 'GeneralController@getLogin',
	'as' => 'get_login'
]);



// route use to login all users
Route::post('login', [
	'uses' => 'GeneralController@postLogin',
	'as' => 'post_login'	
]);


// route use to logout all users
Route::get('logout', [
	'uses' => 'GeneralController@getLogout',
	'as' => 'get_logout'
]);


/***********************************************
************ ADMIN ROUTE GROUP *****************
***********************************************/
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'checkadmin']], function () {
	
	// admin dashboard
	Route::get('/', [
		'uses' => 'AdminController@adminDashboard',
		'as' => 'admin_dashboard'
	]);
});
/***********************************************
********** END OF ADMIN ROUTE GROUP ************
***********************************************/


/***********************************************
************ MEMBER ROUTE GROUP ****************
***********************************************/
Route::group(['prefix' => 'member', 'middleware' => ['auth']], function () {

	// member dashboard
	Route::get('/', [
		'uses' => 'MemberController@memberDashboard',
		'as' => 'member_dashboard'
	]);
});
/***********************************************
********** END OF MEMBER ROUTE GROUP ***********
***********************************************/



// Route::get('send', [
// 	'uses' => 'GeneralController@sendConfirmationEmail'
// ]);



// confirm registration of the user in email here
Route::get('confirm/{code}', [
	'uses' => 'MemberController@confirmRegistration'
]);