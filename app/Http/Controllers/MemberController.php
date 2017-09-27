<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmRegistration;
use App\User;
use App\UserLog;
use App\Member;
use App\AccountConfirmation;

class MemberController extends Controller
{


	/*
	 * This Private Function generate
	 * unique user identification
	 */
	private function generateUidNumber() {
	    $number = mt_rand(100000000, 999999999);

	    if ($this->idNoExists($number)) {
	        return generateBarcodeNumber();
	    }
	    return $number;
	}

	/*
	 * This Private method checks the generated
	 * user identification if already exist
	 */
	private function idNoExists($number) {
	    return User::whereUid($number)->exists();
	}


    // method use to register the new member
    // note: the account that will register will no be active until the user, confirm its email
    public function memberRegistration(Request $request)
    {


    	// validate the input in member registration
    	$this->validate($request, [
    			'firstname' => 'required',
    			'lastname' => 'required',
    			'email' => 'required|email|unique:users',
    			'mobile_number' => 'required',
    			'address' => 'required',
    			'username' => 'required|unique:users',
    			'password' => 'required|confirmed',
    			'tbc' => 'required'
    		]);

    	// assigning variables from the registration page
    	$firstname = $request['firstname'];
    	$lastname = $request['lastname'];
    	$email = $request['email'];
    	$mobile = $request['mobile_number'];
    	$address = $request['address'];
    	$username = $request['username'];
    	$password = $request['password'];
    	$sponsor = $request['sponsor_id'];

    	$uid = $this->generateUidNumber();


    	// number of account will be openend by the user
    	$no_of_account = $request['account'];
    	if($no_of_account == 0) {
    		$account = 1;
    	}
    	else {
    		$account = $request['number_of_accounts'];
    	}


    	// save user/member data to users table
    	$user = new User();
    	$user->uid = $uid;
    	$user->username = $username;
    	$user->firstname = $firstname;
    	$user->lastname = $lastname;
    	$user->mobile = $mobile;
    	$user->email = $email;
    	$user->password = bcrypt($password);
    	// save here
    	$user->save();


    	// save user/member data to members table
    	$member = new Member();
    	$member->uid = $uid;
    	$member->number_of_accounts = $account;
    	if($sponsor != null) {
    		$member->sponsor = $sponsor;
    	}
    	// save here
    	$member->save();


    	// create unique code for activate email
    	$code = md5(uniqid(rand(), true)) . md5($username);
    	// save code to account confirmation table
    	$ac = new AccountConfirmation();
    	$ac->user_id = $user->id;
    	$ac->code = $code;
    	// save here
    	$ac->save();


    	// send email confirmation, to active status, containing the code
    	Mail::to($user->email)->send(new ConfirmRegistration($code));
    	// send sms to the user if requested
    	

    	// log user activity
    	$log = new UserLog();
    	$log->user = $uid;
    	$log->action = 'New User Registered but not confirmed';
    	$log->save();


    	return "Successfully Registered Please Check Your Email for contrimation";



    }



    // thie method is use to confirm new account using link send in email
    public function confirmRegistration($code = null)
    {

    	if($code == null)
    		abort(404);

    	$u_confirm = AccountConfirmation::where('code', $code)->where('status', 0)->first();


    	if(count($u_confirm) < 1) {
    		return redirect()->route('get_landing_page');
    	}

    	// find user 
    	$user = User::findorfail($u_confirm->user_id);

    	$user->active = 1;

    	if($user->save()) {
    		// log user activity here
    		$log = new UserLog();
    		$log->user = $user->uid;
    		$log->action = 'User click confirmation link send in email upon registration';
    		$log->save();

    		// make code invalid
    		$u_confirm->status = 1;
    		$u_confirm->save();


    		// send welcome email and/or sms
    		

    		// redirect to member login
    		return view('member-login')->with('success', 'Account Confirmation Successful. You can now login and start trading');


    	}

    	return 'Error Occurred';
    }


    // this method will go to member dashboard
    public function memberDashboard()
    {
    	// $api = file_get_contents('https://blockchain.info/ticker');
    	// $rate = json_decode($api);

    	return view('member.member-dashboard');
    }
}
