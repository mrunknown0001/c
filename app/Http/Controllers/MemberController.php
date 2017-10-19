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


            for($x = 1; $x <= $member->number_of_accounts; $x++) {
                // create accounts
                // account naming is username and 1 2 3
                $account = new MemberAccount();
                $account->user_name = $user->username;
                $account->user_id = $user->id;
                $account->account_alias = $user->username . '_' . $x;
                $account->save();

            }


    		// send welcome email and/or sms
            // Mail::to($user->email)->send(new WelcomeEmail());
            // email is temporaryly inactive
    		

    		// redirect to member login
    		return redirect()->route('get_member_login')->with('success', 'Account Confirmation Successful. You can now login and start trading');


    	}

    	return 'Error. Contact the admin. MemberController@confirmationRegistration';
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


    // this methos is use to go to member cash
    public function memberCash()
    {
        return view('member.member-cash');
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


    // this methos is use to go to member payout pending
    public function memberPayoutPending()
    {
        return view('member.member-payout-pending');
    }


    // this method is use to go to member claimed payout
    public function memberPayoutClaimed()
    {
        return view('member.member-payout-claimed');
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

        $member = Member::whereUid(Auth::user()->uid)->first();


        $member_accounts = MemberAccount::whereUserId(Auth::user()->id)->get();

        $number = count($member_accounts) + 1;

        $account = new MemberAccount();
        $account->user_name = Auth::user()->username;
        $account->user_id = Auth::user()->id;
        $account->account_alias = Auth::user()->username . '_' . $number;
        $account->save();


        $member->number_of_accounts = $number;
        $member->save();


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

}
