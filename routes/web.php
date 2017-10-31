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


// route to go to faq view
Route::get('faq', [
	'uses' => 'GeneralController@getFaq', 
	'as' => 'get_faq'
]);



// route to go to whats new view
Route::get('whats-new', [
	'uses' => 'GeneralController@whatsNew',
	'as' => 'whats_new'
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
Route::get('login-me', [
	'uses' => 'GeneralController@getLogin',
	'as' => 'get_login'
]);


// route to go to member login page
Route::get('member/login', [
	'uses' => 'GeneralController@geMembertLogin',
	'as' => 'get_member_login'
]);

Route::get('login', function() {
	return redirect()->route('get_member_login');
});


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


	// route to search members
	Route::get('member/search', [
		'uses' => 'AdminController@memberSearch',
		'as' => 'admin_member_search'
	]);


	// route to activate sell activation codes page
	Route::get('sell-activation/activate', [
		'uses' => 'AdminController@adminSellActivation',
		'as' => 'admin_sell_activation'
	]);


	// route to create sell activation codes
	Route::get('sell-activation/create', [
		'uses' => 'AdminController@createActivationCode',
		'as' => 'create_activation_code'
	]);


	// route to sell activated activation codes
	Route::get('sell-activation/sell', [
		'uses' => 'AdminController@adminSellCode',
		'as' => 'admin_sell_code'
	]);

	Route::get('sell-activation', function () {
		abort(404);
	});

	// route to activate/assign owner of the sell code
	Route::post('sell-activation', [
		'uses' => 'AdminController@postSellActivation',
		'as' => 'admin_post_sell_activation'
	]);


	// route to go to sell code creation
	Route::get('create-sell-code', function () {
		return view('admin.admin-create-sell-code');
	})->name('admin_create_sell_code');

	Route::post('create-sell-code', [
		'uses' => 'AdminController@createSellCode',
		'as' => 'post_admin_create_sell_code'
	]);


	// route view used codes
	Route::get('sell-activation/used', [
		'uses' => 'AdminController@adminUsedSellCodes',
		'as' => 'admin_used_sell_codes'
	]);


	// route to go to members page
	Route::get('members', [
		'uses' => 'AdminController@getMembers',
		'as' => 'admin_get_members'
	]);


	// route to user logs
	Route::get('user-logs', [
		'uses' => 'AdminController@userLogs',
		'as' => 'user_logs'
	]);


	// route to member payments review
	Route::get('payment/review', [
		'uses' => 'AdminController@adminPaymentReview',
		'as' => 'admin_payment_review'
	]);


	// route to view verified/successful payments of members
	Route::get('payment/successful/verified', [
		'uses' => 'AdminController@paymentSuccessfulVerified',
		'as' => 'admin_payment_successful_verified'
	]);


	// route use to verify send payment by admin
	Route::post('payment/verify', [
		'uses' => 'AdminController@postPaymentVerify',
		'as' => 'post_payment_verify'
	]);


	// rotue use to cancel invalid payment
	Route::post('payment/cancelled', [
		'uses' => 'Admincontroller@postPaymentCancel',
		'as' => 'post_cancel_payment'
	]);



	// route to revie payment again
	Route::post('payment/review/iterate', [
		'uses' => 'AdminController@postPaymentReviewAgain',
		'as' => 'post_payment_review_again'
	]);


	// route to view cancelled payments
	Route::get('payment/cancelled', [
		'uses' => 'AdminController@adminPaymentCancelled',
		'as' => 'admin_cancelled_payment'
	]);


	// route to view payout request of the members
	Route::get('payout/request', [
		'uses' => 'AdminController@verifyPayoutRequest',
		'as' => 'admin_verify_payout_request'
	]);


	// route to view successful payout
	Route::get('payout/successful', [
		'uses' => 'AdminController@viewSuccessfulPayout',
		'as' => 'admin_view_successful_payout'
	]);


	// route to view members balances
	Route::get('member/balance', [
		'uses' => 'AdminController@getMemberBalance',
		'as' => 'get_member_balance'
	]);


	// route to go to system seettings
	Route::get('system/settings', [
		'uses' => 'AdminController@adminSystemSettings',
		'as' => 'admin_system_settings'
	]);

	// route to save system setting
	Route::post('system/settings', [
		'uses' => 'AdminController@postAdminSystemSettings',
		'as' => 'post_admin_admin_system_settings'
	]);


	// route to add/edit/delete frequently ask question
	Route::get('faq', [
		'uses' => 'AdminController@viewFaq',
		'as' => 'admin_view_faq'
	]);


	// route to change password of admin
	Route::get('change/password', [
		'uses' => 'AdminController@adminChangePassword',
		'as' => 'admin_change_password'
	]);


	// rout to view admin profile
	Route::get('profile/view', [
		'uses' => 'AdminController@adminViewProfile',
		'as' => 'admin_view_profile'
	]);


	// route to change profile picture of the admin
	Route::get('change/profile/picture', [
		'uses' => 'AdminController@adminChangeProfilePicture',
		'as' => 'admin_change_profile_picture'
	]);


	// route to pament option
	Route::get('payment/options', [
		'uses' => 'AdminController@adminPaymentOptions',
		'as' => 'admin_payment_options'
	]);

	// route to add payment options
	Route::get('payment/options/add', [
		'uses' => 'AdminController@addPaymentOption',
		'as' => 'add_payment_option'
	]);

	// route to add post payment option
	Route::post('payment/options/add', [
		'uses' => 'AdminController@postAddPaymentOption',
		'as' => 'post_add_payment_option'
	]);

	// route to update view of payment option
	Route::get('payment/options/update/{name}', [
		'uses' => 'AdminController@updatePaymentOption',
		'as' => 'admin_update_payment_option'
	]);

	// route to update payment option
	Route::post('payment/options/update', [
		'uses' => 'AdminController@postUpdatePaymentOption',
		'as' => 'post_update_payment_option'
	]);


	// route to remove payment option
	Route::get('payment/options/remove/{name}', [
		'uses' => 'AdminController@removePaymentOption',
		'as' => 'admin_remove_payment_option'
	]);

	// route to payout option
	Route::get('payout/options', [
		'uses' => 'AdminController@adminPayoutOptions',
		'as' => 'admin_payout_options'
	]);

	// route to view add payout
	Route::get('payout/option/add', [
		'uses' => 'AdminController@addPayoutOption',
		'as' => 'add_payout_option'
	]);

	// route to view add payout
	Route::post('payout/option/add', [
		'uses' => 'AdminController@postAddPayoutOption',
		'as' => 'post_add_payout_option'
	]);


	// route to remove payout option
	Route::get('payout/options/remove/{name}', [
		'uses' => 'AdminController@removePayoutOption',
		'as' => 'admin_remove_payout_option'
	]);


	// route to update payout option
	Route::get('payout/options/update/{name}', [
		'uses' => 'AdminController@updatePayoutOption',
		'as' => 'admin_update_payout_option'
	]);

	// route to post update payout option
	Route::post('payout/options/update', [
		'uses' => 'AdminController@postUpdatePayoutOption',
		'as' => 'post_update_payout_option'
	]);


	// route to view member info
	Route::get('member/{uid}/info/view', [
		'uses' => 'AdminController@getMemberInfo',
		'as' => 'admin_get_member_info'
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


	// route to update details view
	Route::get('profile/update', [
		'uses' => 'MemberController@memberProfileUpdate',
		'as' => 'member_profile_update'
	]);



	// route to change profile picture view
	Route::get('profile/picture/change', [
		'uses' => 'MemberController@memberProfilePictureChange',
		'as' => 'member_profile_picture_change'
	]);



	// route to change password view
	Route::get('password/change', [
		'uses' => 'MemberController@memberPasswordChange',
		'as' => 'member_password_change'
	]);


	// route to change password
	Route::post('password/change', [
		'uses' => 'MemberController@postMemberPasswordChange',
		'as' => 'post_member_password_change'
	]);


	// route to member tbc wallet note: temporary down
	Route::get('account/tbc/wallet', [
		'uses' => 'MemberController@memberTbcWallet',
		'as' => 'member_tbc_wallet'
	]);


	// route to member cash page
	Route::get('cash', [
		'uses' => 'MemberController@memberCash',
		'as' => 'member_cash'
	]);


	// route to member sell activation codes
	Route::get('sell-activation-codes', [
		'uses' => 'MemberController@sellActivationCode',
		'as' => 'member_sell_activation_code'
	]);


	// route to request code from upline or admin
	Route::get('code/request/{!id}', [
		'uses' => 'MemberController@memberRequestcode',
		'as' => 'member_post_request_code'
	]);


	// route to member downlines
	Route::get('geneology', [
		'uses' => 'MemberController@memberGeneology',
		'as' => 'member_geneology'
	]);


	// route to member request payout
	Route::get('payout/request', [
		'uses' => 'MemberController@memberPayoutRequest',
		'as' => 'member_payout_request'
	]);


	// route to use to send payout request
	Route::post('payout/request', [
		'uses' => 'MemberController@postMemberPayoutRequest',
		'as' => 'post_member_payout_request'
	]);


	// route to member pending payout
	Route::get('payout/pending', [
		'uses' => 'MemberController@memberPayoutPending',
		'as' => 'member_payout_pending'
	]);


	// route to member claimed payout
	Route::get('payout/received', [
		'uses' => 'MemberController@memberPayoutReceived',
		'as' => 'member_payout_received'
	]);


	// route to member payment
	Route::get('payment/send', [
		'uses' => 'MemberController@memberPaymentSend',
		'as' => 'member_payment_send'
	]);

	Route::post('payment/send', [
		'uses' => 'MemberController@postMemberPaymentSend',
		'as' => 'post_member_payment_send'
	]);

	// route to member payment
	Route::get('payment/received', [
		'uses' => 'MemberController@memberPaymentReceived',
		'as' => 'member_payment_received'
	]);


	// route to member sent payment
	Route::get('payment/sent', [
		'uses' => 'MemberController@memberPaymentSent',
		'as' => 'member_payment_sent'
	]);


	// route to activate member account
	Route::post('member/activate/account', [
		'uses' => 'MemberController@memberActivateAccount',
		'as' => 'post_member_activate_account'
	]);


	// route to add account of a member
	Route::post('account/add', [
		'uses' => 'MemberController@postAddMemberAccount',
		'as' => 'post_add_member_account'
	]);


	// route to go cancelled rejected payment method
	Route::get('payment/cancelled', [
		'uses' => 'MemberController@memberCancelledPayment',
		'as' => 'member_cancelled_payment'
	]);


	// route to view balance of the member/account
	Route::get('cash/balance/view', [
		'uses' => 'MemberController@viewMemberBalance',
		'as' => 'view_member_balance'
	]);


	// route to on and off auto deduct
	Route::get('auto-deduct/setting', [
		'uses' => 'MemberController@memberAutoDeductToggle',
		'as' => 'member_auto_deduct_toggle'
	]);


	// route to view account downlines
	Route::get('member/account/{account_id}/downlines/view', [
		'uses' => 'MemberController@viewAccountDownlines',
		'as' => 'member_view_account_downlines'
	]);



	// rotue to view pending downline of the member
	Route::get('member/pending/downlines', [
		'uses' => 'MemberController@memberPendingdownlines',
		'as' => 'member_pending_downlines'
	]);


	

});
/***********************************************
********** END OF MEMBER ROUTE GROUP ***********
***********************************************/




// confirm registration of the user in email here
Route::get('confirm/{code}', [
	'uses' => 'MemberController@confirmRegistration'
]);



// password reset form
Route::get('password/reset', [
	'uses' => 'MemberController@passwordReset',
	'as' => 'password_reset'
]);


// password reset post
Route::post('password/reset', [
	'uses' => 'MemberController@postPasswordReset',
	'as' => 'post_password_reset'
]);


// password reset link
Route::get('password/reset/token/{token}', [
	'uses' => 'MemberController@resetPasswordToken',
]);


Route::post('password/reset/token', [
	'uses' => 'MemberController@postResetPasswordToken',
	'as' => 'post_password_reset_token'
]);


Route::get('sendsms', [
	'uses' => 'AdminController@sendSms'
]);