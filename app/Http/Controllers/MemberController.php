<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

use Image;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmRegistration;
use App\Mail\WelcomeEmail;
use App\User;
use App\UserLog;
use App\Member;
use App\AccountConfirmation;
use App\Payment;
use App\MemberAccount;
use App\SellCodeOwner;
use App\MemberBalance;
use App\Payout;
use App\MyCash;
use App\PasswordReset;

class MemberController extends Controller
{


	/*
	 * This Private Function generate
	 * unique user identification
	 */
	private function generateUidNumber() {
	    $number = mt_rand(100000000, 999999999);

	    if ($this->idNoExists($number)) {
	        return generateUidNumber();
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



    // method use to check and add id
    private function createAccountId()
    {
        $account = $this->generateAccountId();

        if($this->checkAccountId($account)) {
            return createAccountId();
        }

        return $account;
    }


    // method use to generate if of accounts of members
    private function generateAccountId($length = 15)
    {
        return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }


    // check account id if exists
    private function checkAccountId($account)
    {
        return MemberAccount::where('account_id', $account)->exists();
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



        if($sponsor != '') {
            // check sponsor id if present
            $member = User::where('uid', $sponsor)->first();

            if(count($member) == 0) {
                // return 'Sponsor ID is incorrect!';
                return redirect()->back()->with('error_msg', 'Sponsor ID is incorrect. Please re-check.');
            }

            // check if the sponsor has at least 1 activated account
            if(count($member->accounts->where('status', 1)->first()) == 0) {
                return redirect()->back()->with('error_msg', 'Sponsor has NO active account(s).');
            }
        }


    	// number of account will be openend by the user
    	$no_of_account = $request['account'];
    	if($no_of_account == 0) {
    		$account = 1;
    	}
    	else {
    		$account = $request['number_of_accounts'];
    	}

        // create unique code for activate email
        $code = md5(uniqid(rand(), true)) . md5($username);


        // send email first before saving
        // send email confirmation, to active status, containing the code
        // Mail::to($email)->send(new ConfirmRegistration($code));
        // send sms to the user if requested



    	// save user/member data to users table
    	$user = new User();
    	$user->uid = $uid;
    	$user->username = $username;
    	$user->firstname = $firstname;
    	$user->lastname = $lastname;
    	$user->mobile = $mobile;
    	$user->email = $email;
    	$user->password = bcrypt($password);
        $user->save();


    	// save user/member data to members table
    	$member = new Member();
    	$member->uid = $uid;
    	$member->number_of_accounts = $account;
    	if($sponsor != null) {
    		$member->sponsor = $sponsor;
    	}
        $member->save();


        // save the balance of the member
        // depending on how many account will be opening
        $member_balance_record = MemberBalance::where('uid', $uid)->first();

        if(count($member_balance_record) == 0) {
            $balance = new MemberBalance();
            $balance->uid = $uid;
            $balance->current = $account * 500;
            $balance->save();
        }
        else {
            $member_balance_record->current = $member_balance_record + 500;
            $member_balance_record->save();
        }



    	// save code to account confirmation table
    	$ac = new AccountConfirmation();
    	$ac->user_id = $user->id;
        $ac->full_url = url('/confirm/' . $code);
    	$ac->code = $code;
        $ac->save();
   	



    	// log user activity
    	$log = new UserLog();
    	$log->user = $uid;
    	$log->action = 'New User Registered but not confirmed';
    	$log->save();


    	return redirect()->route('get_register')->with('success', 'Successfully Registered Please Check Your Email for confirmation');



    }



    // thie method is use to confirm new account using link send in email
    public function confirmRegistration($code = null)
    {

    	if($code == null)
    		abort(404);

    	$u_confirm = AccountConfirmation::where('code', $code)->where('status', 0)->first();


    	if(count($u_confirm) < 1) {
    		return redirect()->route('get_member_login')->with('notice', 'Member Already Active.');
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



            // create account(s)
            // first get number of accounts
            $member = Member::where('uid', $user->uid)->first();

            $available = MemberAccount::where('available', 1)->first();

            if($member->sponsor == '') {
                // find available account
                
                if(count($available) != 0) {
                    $available->user_name = $user->username;
                    $available->user_id = $user->id;
                    $available->account_alias = $user->username . '_' . '1';
                    $available->account_id = $this->createAccountId();
                    $available->status = 0;
                    $available->available = 0;
                    $available->save();

                    $log = new UserLog();
                    $log->user = $user->id;
                    $log->acton = 'Registered and find an available vacant account';
                    $log->save();

                }
                elseif(count($available) == 0) {

                    for($x = 1; $x <= $member->number_of_accounts; $x++) {
                        // create accounts
                        // account naming is username and 1 2 3
                        $account = new MemberAccount();
                        $account->user_name = $user->username;
                        $account->user_id = $user->id;
                        $account->account_alias = $user->username . '_' . $x;


                        $account->account_id = $this->generateAccountId();

                        // check if the member has upline
                        if($member->sponsor != null) {
                            $account->sponsor = $member->sponsor;
                        }

                        $account->save();

                    }
                }
                

            }
            else {

                for($x = 1; $x <= $member->number_of_accounts; $x++) {
                    // create accounts
                    // account naming is username and 1 2 3
                    $account = new MemberAccount();
                    $account->user_name = $user->username;
                    $account->user_id = $user->id;
                    $account->account_alias = $user->username . '_' . $x;
                    $account->downline_level = 0;


                    $account->account_id = $this->generateAccountId();

                    // check if the member has upline
                    if($member->sponsor != null) {
                        $account->sponsor = $member->sponsor;
                    }

                    $account->save();

                }
            }


    		// send welcome email and/or sms
            // Mail::to($user->email)->send(new WelcomeEmail());
            // email is temporaryly inactive
            // 
            // 
            
            $cash = new MyCash();
            $cash->user_id = $user->id;
            $cash->save();

            $cash_log = new UserLog();
            $cash_log->user = $user->uid;
            $cash_log->action = "System Activates a member and create a cash of the member: " . $user->uid;
            $cash_log->save();
    		

    		// redirect to member login
    		return redirect()->route('get_member_login')->with('success', 'Account Confirmation Successful. You can now login and start trading');


    	}

    	return 'Error. Contact the admin. MemberController@confirmationRegistration';
    }



    // password reset form
    public function passwordReset()
    {
        return view('password-reset');
    }


    public function postPasswordReset(Request $request)
    {
       $this->validate($request, [
            'email' => 'required|email'
       ]);

       $email = $request['email'];

       $user = User::whereEmail($email)->first();


       if(count($user) == 0) {
            return redirect()->route('password_reset')->with('error_msg', 'Email Not Found!');
       }

       // generate token
      $token =  uniqid() . time() . md5('$email');

      $reset = new PasswordReset();
      $reset->email = $email;
      $reset->token = $token;
      $reset->save();

      // send reset link to email of the user
      

      // userlog
      $log = new UserLog();
      $log->user = $user->id;
      $log->action = 'The user password reset attemp';
      $log->save();

      return redirect()->route('password_reset')->with('success', 'Reset Link Sent to your email!');
       
       
    }


    // reset password token method
    public function resetPasswordToken($token = null)
    {
        // check if token is valid and exist in database
        $check_token = PasswordReset::whereToken($token)->whereStatus(0)->first();

        if(count($check_token) == 0) {
            abort(404);
        }

        return view('password-reset-form', ['email' => $check_token->email, 'token' => $check_token->token]);
    }


    // final step method to reset password of the user
    public function postResetPasswordToken(Request $request)
    {

        $this->validate($request, [
            'password' => 'required|confirmed'
        ]);

        $password = $request['password'];
        $email = $request['email'];
        $token = $request['token'];

        $user = User::whereEmail($email)->first();
        $check_token = PasswordReset::whereToken($token)->whereStatus(0)->first();

        $user->password = bcrypt($password);
        $user->save();

        $check_token->status = 1;
        $check_token->save();

        // email or sms if possible
        // emai or sms if possible
        

        // user log
        $log = new UserLog();
        $log->user = $user->id;
        $log->action = 'The user reset his password using the link sent to the registered email';
        $log->save();


        if($user->privilege == 5) {
            return redirect()->route('get_member_login')->with('success', 'Your Password Is Reset! You Can Login With Your New Password');
        }

        return 'admin reset password successful';
        
    }



    // this method will go to member dashboard
    public function memberDashboard()
    {
    	// $api = file_get_contents('https://blockchain.info/ticker');
    	// $rate = json_decode($api);
        

        $balance = MemberBalance::where('uid', Auth::user()->uid)->first();
        

    	return view('member.member-dashboard', ['balance' => $balance]);
    }


    // this method is use to go to member tbc account
    public function memberTbcWallet()
    {
        return view('member.member-tbc-wallet');
    }


    // this methos is use to go to member  
    public function memberCash()
    {

        $cash = MyCash::whereUserId(Auth::user()->id)->first();
        
        return view('member.member-cash', ['cash' => $cash]);
    }


    // this method is use to go to member sell activation code
    public function sellActivationCode()
    {

        $code = SellCodeOwner::where('member_uid', Auth::user()->uid)->orderBy('created_at', 'desc')->paginate(5);

        return view('member.member-sell-activation-code', ['codes' => $code]);
    }


    // method use to request a member to buy a code from upline or from admin
    public function memberRequestcode($id = null)
    {
        return 'request code';
    }


    // this method is use to go to member downlines
    public function memberGeneology()
    {
        return view('member.member-geneology');
    }


    // this method is use to go to member payout request
    public function memberPayoutRequest()
    {
        return view('member.member-payout-request');
    }



    // this method is use to send payout request
    public function postMemberPayoutRequest(Request $request)
    {
        $this->validate($request, [
            'sent_thru' => 'required',
            'amount' => 'required|numeric'
        ]);

        $sent_thru = $request['sent_thru'];
        $amount = $request['amout'];
        $description = $request['description'];

        $payout = new Payout();
        $payout->user = Auth::user()->uid;
        $payout->sent_thru = $sent_thru;
        $payout->amount = $amount;
        $payout->description = $description;
        $payout->save();

        // user log
        $log = new UserLog();
        $log->user = Auth::user()->uid;
        $log->action = "Member: " . Auth::user()->uid . ' has requested a payout with amount of ' . $amount . ' via ' . $sent_thru;

        return redirect()->route('member_payout_request')->with('success', 'Payout Request Has Been Sent.');

    }



    // this methos is use to go to member payout pending
    public function memberPayoutPending()
    {

        $payouts = Payout::whereStatus(0)->orderBy('created_at', 'desc')->paginate(10);

        return view('member.member-payout-pending', ['payouts' => $payouts]);
    }


    // this method is use to go to member claimed payout
    public function memberPayoutReceived()
    {
        return view('member.member-payout-received');
    }


    // this method is use to go to member send payment
    public function memberPaymentSend()
    {
        return view('member.member-payment-send');
    }


    // this method is use to send payment to admin
    public function postMemberPaymentSend(Request $request)
    {
        $this->validate($request, [
            'payment_image' => 'required|image',
            'sent_thru' => 'required'
        ]);

        $sent_thru = $request['sent_thru'];
        $description = $request['description'];

        if( $request->hasFile('payment_image') ) {
            $file = $request->file('payment_image');

            $img = time() . "__n" . uniqid() . '.' . $file->getClientOriginalExtension();

            Image::make($file)->save(public_path('/uploads/payments/' . $img));


            // save payment
            $payment = new Payment();
            $payment->user = Auth::user()->uid;
            $payment->sent_thru = $sent_thru;
            $payment->image_file = $img;
            $payment->description = $description;
            $payment->save();


            // user log
            $log = new UserLog();
            $log->user = Auth::user()->uid;
            $log->action = 'Uploaded Payment Image';
            $log->save();

            return redirect()->route('member_payment_send')->with('success', 'Payment Upload Successful. Please wait for the approval of the admin.');
        }




        return "Error! Please Contanct the developer. MemberController@postMemberPaymentSend";

    }



    // this method is use to acdtivate member account using its own sell code
    public function memberActivateAccount(Request $request)
    {
        // input validation
        $this->validate($request, [
            'code' => 'required'
        ]);

        $code_id = $request['code']; //  id in sell_code_owners table
        $account_id = $request['account_id']; // id of the account in member_accounts table

        $account = MemberAccount::findorfail($account_id);
        $code = SellCodeOwner::findorfail($code_id);

        // usage count
        $usage = $code->usage;

        // check if the code is used
        if($code->usage > 4) {
            return "Error. Trying to use code that is invalid!";
        }

        // activate account here
        $account->status = 1; // to make it active

        // save the account status
        if($account->save()) {
            // change usage count add by 1
            $code->usage = $usage + 1;
            $code->save();

            // user log here
            $log = new UserLog();
            $log->user = Auth::user()->uid;
            $log->action = 'Activated Member Account:' . $account->account_alias . '. Using its own Sell Code: ' . $code->code->code;
            $log->save();

            return redirect()->route('member_dashboard')->with('success', 'Your account ' . $account->account_alias . ' has activated!');
        }


        return 'Error. Contanct the developer MemberController@memberActivateAccount';


    }


    // method to add account
    public function postAddMemberAccount(Request $request)
    {
        $upline = $request['upline'];


        $upline_account = MemberAccount::findorfail($upline);
        $member = Member::whereUid(Auth::user()->uid)->first();


        $member_accounts = MemberAccount::whereUserId(Auth::user()->id)->get();

        $number = count($member_accounts) + 1;

        $account = new MemberAccount();
        $account->user_name = Auth::user()->username;
        $account->user_id = Auth::user()->id;
        $account->account_alias = Auth::user()->username . '_' . $number;
        $account->account_id = $this->createAccountId();
        $account->upline_account_id = $upline_account->id;
        $account->upline_account = $upline_account->account_id;
        $account->downline_level = $upline_account->downline_level + 1;
        $account->save();


        $member->number_of_accounts = $number;
        $member->save();


        // check where to postion of the downline
        if($upline_account->downline_1 == null) {
            $upline_account->downline_1 = $account->id;
        }
        elseif ($upline_account->downline_2 == null) {
            $upline_account->downline_2 = $account->id;
        }
        elseif ($upline_account->downline_3 == null) {
            $upline_account->downline_3 = $account->id;
        }
        elseif ($upline_account->downline_4 == null) {
            $upline_account->downline_4 = $account->id;
        }
        elseif ($upline_account->downline_5 == null) {
            $upline_account->downline_5 = $account->id;
        }

        // save the upline account
        $upline_account->save();


        // add in member balance 5 hundrer per account
        $balance = MemberBalance::whereUid($member->uid)->first();
        $balance->current = $balance->current + 500;
        $balance->save();

        $log = new UserLog();
        $log->user = Auth::user()->uid;
        $log->action = 'Added new account: ' . Auth::user()->username . '_' . $number;
        $log->save();

        return redirect()->route('member_dashboard')->with('success', 'Successful Added new account: ' . Auth::user()->username . '_' . $number);
        
    }



    // method use to view send payment
    public function memberPaymentSent()
    {
        $payments = Payment::whereUser(Auth::user()->uid)
                            ->whereStatus(0)
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);

        return view('member.member-payment-sent', ['payments' => $payments]);
    }



    // this method is use to go to member received payment
    public function memberPaymentReceived()
    {
        $payments = Payment::whereStatus(1)->paginate(10);

        return view('member.member-payment-received', ['payments' => $payments]);
    }




    // method to view cancelled or rejected payments
    public function memberCancelledPayment()
    {
        return 'cancelled payment';
    }



    // method use to view the member's balane
    public function viewMemberBalance()
    {
        $balance = MemberBalance::where('uid', Auth::user()->uid)->first();

        return view('member.member-view-balance', ['balance' => $balance]);
    }



    // method use to show auto deduct toggle 
    public function memberAutoDeductToggle()
    {
        return view('member.member-auto-deduct');
    }



    // method to view member account downlines
    public function viewAccountDownlines($account_id = null)
    {
        $account = MemberAccount::findorfail($account_id);

        return view('member.member-downlines-view');
    }

}
