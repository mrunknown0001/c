<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmRegistration;
use App\User;
use App\UserLog;
use App\Member;
use App\SellActivationCode;
use App\Setting;
use App\SellCodeOwner;
use App\Payment;
use App\MemberBalance;
use App\Payout;
use App\MyCash;
use App\PaymentOption;
use App\PayoutOption;
use App\DirectReferral;
use App\CashMonitor;
use App\SystemCash;


class AdminController extends Controller
{
    

    /*
     * admin dashboard
     */
    public function adminDashboard()
    {
    	return view('admin.admin-dashboard');
    }


    /*
     * sell activation method
     */
    public function adminSellActivation()
    {
        $codes = SellActivationCode::whereActive(0)
                                    ->whereUsed(0)
                                    ->paginate(10);

    	return view('admin.admin-activate-code', ['codes' => $codes]);

    }


    /*
     * sell activation code
     * 6 digit alphanumeric characters used to activate users who registered in the site
     * this method is use to create unique activation codes
     */
    public function createActivationCode()
    {
        $code = $this->generateCode();

        if($this->checkCode($code)) {
            return createActivationCode();
        }

        return $code;
    }


    private function generateCode($length = 6)
    {
		return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    private function checkCode($code)
    {
    	return SellActivationCode::whereCode($code)->exists();
    }



    /*
     * method used to sell activated activation codes
     */
    public function adminSellCode()
    {
        $codes = SellCodeOwner::paginate(10);

        return view('admin.admin-sell-code', ['codes' => $codes]);

    }





    // method use to send sms
    private function sendSms($number = null, $message = null)
    {
        // if($number == null) {
        //     return '';
        // }

        $ch = curl_init();
        $parameters = array(
            'apikey' => '8f934d4c8d91337dc98445e52faf85ab', //Your API KEY
            'number' =>  $number,
            'message' => $message,
            'sendername' => 'CLLRTrading'
        );
        curl_setopt( $ch, CURLOPT_URL,'http://api.semaphore.co/api/v4/messages' );
        curl_setopt( $ch, CURLOPT_POST, 1 );

        //Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);

        //Show the server response
        // return $output;

    }



    // method in cash monitor
    private function cashMonitor($type = null, $method = null, $via = null, $from = null, $to = null, $amount = null, $remarks = null)
    {


        $cm = new CashMonitor();
        $cm->type = $type;
        $cm->method = $method;
        $cm->via = $via;
        $cm->from = $from;
        $cm->to = $to;
        $cm->amount = $amount;
        $cm->remarks = $remarks;
        $cm->save();

        // log
        $log = new UserLog();
        $log->user = 'admin';
        $log->action = 'Admin Saved Cash Monitor';
        $log->save();
    }




    /*
     * method use to go to create sell code
     */
    public function createSellCode(Request $request)
    {
        $this->validate($request, [
            'number' => 'required|numeric'
        ]);

        $number = $request['number'];

        for($x = 1; $x <= $number; $x++) {
            $new_codes[] = ['code' => $this->createActivationCode()];
        }

        if(DB::table('sell_activation_codes')->insert($new_codes)) {
            $log = new UserLog();
            $log->user = Auth::user()->username;
            $log->action = 'Activate ' . $number . ' number(s) of code.';
            $log->save();


            return redirect()->route('admin_create_sell_code')->with('success', 'Successfully Created ' . $number . ' codes!');
        }

        return 'Error! Please Contact the developer. AdminController@createSellCode';

    }


    // method use to activate/assign sell code to member as owner
    public function postSellActivation(Request $request)
    {
        $this->validate($request, [
            'id_number' => 'required|numeric'
        ]);

        $id = $request['id_number'];  // user id of the member
        $code_id = $request['code_id']; // id of the code

        $member = User::whereUid($id)->first();
        $code = SellActivationCode::findorfail($code_id);

        // check member if acdtive and/or presetn
        if(count($member) == 0) {
            return redirect()->route('admin_sell_activation')->with('error_msg', 'Member Not Found');

        }

        $code_owner = new SellCodeOwner();
        $code_owner->member_uid = $member->uid;
        $code_owner->code_id = $code->id;

        if($code_owner->save()) {
            $code->active = 1;
            $code->save();


            $log = new UserLog();
            $log->user = Auth::user()->username;
            $log->action = 'Sell Activation. Sold to member with ID Number: ' . $member->uid . '.';
            $log->save();

            return redirect()->route('admin_sell_activation')->with('success', 'Sell Code Activated!');

        }

        return 'Error! Please Contact the developer. AdminController@postSellActivation';


    }


    // method use to view used sell codes
    public function adminUsedSellCodes()
    {
        return view('admin.admin-view-used-codes');
    }




    // method use to search members
    public function memberSearch(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required'
        ]);

        $keyword = $request['keyword'];

        $members = User::where('uid', 'like', "%$keyword%")
                    ->orwhere('firstname', 'like', "%$keyword%")
                    ->orwhere('lastname', 'like', "%$keyword%")
                    ->orwhere('username', 'like', "%$keyword%")
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);


        // admin log
        $log = new UserLog();
        $log->user = 1;
        $log->action = 'Super Admin Search "' . $keyword . '" keyword';
        $log->save(); 


        return view('admin.admin-member-search-result', ['members' => $members]);
    }



    /*
     * adminPaymentReview method is used to show the payment to be reviewed by the admins
     */
    public function adminPaymentReview()
    {
        $pending_payments = Payment::whereStatus(0)->orderBy('created_at', 'asc')->paginate(3);

        return view('admin.admin-payment-review', ['pending_payments' => $pending_payments]);
    }



    /*
     * method use to view successful/verified payment of members
     */
    public function paymentSuccessfulVerified()
    {
        $verified = Payment::whereStatus(1)->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.admin-payment-verified', ['verified_payments' => $verified]);
    }



    /*
     * mothod us to verify payment of member
     */
    public function postPaymentVerify(Request $request)
    {
        $amount = $request['amount'];

        $member = User::findorfail($request['member_id']);

 
        $account = $member->accounts->where('status', 0)->first();


        // check if the amount is not zero or empty
        if($amount == 0 || $amount == null) {
            return redirect()->back()->with('error_msg', 'Please Input Verified Amount Payed!');
        }


        $payment = Payment::findorfail($request['payment_id']);

        $payment->status = 1;

        if($payment->save()) {

            // remove the balance or deduct the balance of the member
            $balance = $member->member->balance;

            $difference = $balance->current - $amount;
            
            // check if the balance 0
            if($balance->current == 0) {
                $balance->current = 0;
            }
            else {
                $balance->current = $difference;
            }

            $balance->save();
            
            if($difference < 1) {
                if(count($account) == 0) {
                    // CREATE SELL CODE ACTIVATION
                    $code_count = 5 * intdiv($amount, 500);


                    for($x = 0; $x < $code_count; $x++) {


                        $code = $this->createActivationCode();
                        // save the code to sell_activation_codes
                        $new_code = new SellActivationCode();
                        $new_code->code = $code;
                        $new_code->save();

                        // activate the account of the member
                        // $account->status = 1;
                        // $account->save();    


                        // assign the code to the firist account of the member
                        $owner = new SellCodeOwner();
                        $owner->member_uid = $member->uid;
                        $owner->member_account = $payment->account_id;
                        $owner->code_id = $new_code->id;
                        $owner->save();

                    }
                }
                else {
                    // add sell code to the account of the member/payee
                    // create sell code
                    
                    // CODE count creation iteration
                    $code_count = 5 * intdiv($amount, 500);

                    for($x = 0; $x < $code_count; $x++) {


                        $code = $this->createActivationCode();
                        // save the code to sell_activation_codes
                        $new_code = new SellActivationCode();
                        $new_code->code = $code;
                        $new_code->active = 1;
                        $new_code->save();

                        // activate the account of the member
                        $account->status = 1;
                        $account->save();    


                        // assign the code to the firist account of the member
                        $owner = new SellCodeOwner();
                        $owner->member_uid = $member->uid;
                        // the account of the owner
                        $owner->member_account = $payment->account_id;
                        $owner->code_id = $new_code->id;
                        $owner->save();

                    }

                    // if the difference is negative, it means that there is excess in the payment made
                }

                // if($difference < 1) {
                //     $excess = $difference * -1;
                // }
            }

            // $cash = MyCash::whereUserId($member->id)->first();
            // $cash->total = $cash->total + $excess;
            // $cash->total_sent = $cash->total_sent + $amount;
            // $cash->save();


            // find account of member
            $member_account = Member::where('uid', $member->uid)->first();

            // add 300 to payees cash to where he/she buys the code or the upline
             
            // and less 1 sell code to the upline/sponsor
            if($member_account->sponsor != null) {
                $sponsor_account = User::where('uid', $member_account->sponsor)->first();


                // check if auto deduct is active 
                // if active only 50 pesos will go to member cash
                // and 250 will go to the sell code fund


                // add 300 to the cash of the sponsor
                $cash = MyCash::whereUserId($sponsor_account->id)->first();

                if($sponsor_account->autodeduct->status == 1) {
                    $cash->total = $cash->total + 50;
                    $sponsor_account->autodeduct->cash = $sponsor_account->autodeduct->cash + 250;
                    $sponsor_account->autodeduct->save();
                }
                else {
                    $cash->total = $cash->total + 300;    
                }
                
                $cash->total_sent = $cash->total_sent + $amount;
                $cash->save();

                // less on sell activation code of the sponsor
                $code = SellCodeOwner::where('member_uid', $sponsor_account->uid)->where('usage', 0)->first();
                if($code->count() > 1) {
                    $code->usage = 1;
                    $code->save();
                }


                // add direct referral bonnus monitor
                $drb = new DirectReferral();
                $drb->sponsor = $sponsor_account->uid;
                $drb->member = $member->uid;
                $drb->save();
            }

            
            // CASH MONITOR
            // CASH MONITOR
            $type = 'in';
            $method = 'deposit';
            $via = $payment->sent_thru;
            $from = $member->uid;
            $to = 'admin';
            $remarks = 'member bought sell code';
            $this->cashMonitor($type, $method, $via, $from, $to, $amount, $remarks);


            // system cash
            // SYSTEM CASH
            $system_cash = SystemCash::find(1);
            $system_cash->in_cash = $system_cash->in_cash + $amount;
            $system_cash->save();


            $log = new UserLog();

            $log->user = Auth::user()->username;
            $log->action = 'Verified Payment of ' . ucwords($payment->payee->user->firstname) . ' ' . ucwords($payment->payee->user->lastname . '. Amount: ' . $amount);

            $log->save();

            return redirect()->route('admin_payment_successful_verified')->with('success', 'Successfully Verified Payment of ' . ucwords($payment->payee->user->firstname) . ' ' . ucwords($payment->payee->user->lastname));
        }

        return 'Error. Contact the developer. AdminController@postPaymentVerify';
    }



    // method use to cancel invalid payment
    public function postPaymentCancel(Request $request)
    {
        $payment = Payment::findorfail($request['payment_id']);
        $member = User::findorfail($request['member_id']);


        $payment->status = 2;
        $payment->save();

        // user log
        $log = new UserLog();
        $log->user = 'admin';
        $log->action = "Cancelled Payment of " . ucwords($member->firstname . ' ' . $member->lastname) . ':' . $member->uid;
        $log->save();

        return redirect()->route('admin_payment_review')->with('success', 'Payment Cancelled. Click here to view cancelled payment ' . url('/admin/payment/cancelled') );

    }



    // method use to return to review a cancelled payment
    public function postPaymentReviewAgain(Request $request)
    {
        $payment = Payment::findorfail($request['payment_id']);
        $member = User::findorfail($request['member_id']);


        $payment->status = 0;
        $payment->save();

        // user log
        $log = new UserLog();
        $log->user = 'admin';
        $log->action = "Returned to Review Payment of " . ucwords($member->firstname . ' ' . $member->lastname) . ':' . $member->uid;
        $log->save();

        return redirect()->route('admin_payment_review')->with('success', 'Cancelled Payment Returned to Review.');
    }


    // method use to view cancelled payments
    public function adminPaymentCancelled()
    {
        $payments = Payment::whereStatus(2)
                        ->orderBy('updated_at', 'asc')
                        ->paginate(5);

        return view('admin.admin-payment-cancelled', ['payments' => $payments]);
    }


    // method to view request payout
    public function verifyPayoutRequest()
    {
        $payouts = Payout::whereStatus(0)->orderBy('created_at', 'dest')->paginate(3);

        return view('admin.admin-verify-payout-request', ['payouts' => $payouts]);
    }


    // method to view successful payout
    public function viewSuccessfulPayout()
    {
        $payouts = Payout::whereStatus(1)->orderBy('created_at', 'dest')->paginate(10);

        return view('admin.admin-view-successful-payout', ['payouts' => $payouts]);
    }


    /*
     * method use to go to members page in admin
     */
    public function getMembers()
    {

        $members = user::wherePrivilege(5)
                        ->whereActive(1)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('admin.admin-members', ['members' => $members]);
    }


    /*
     * method use to go to members page in admin
     */
    public function getAllMembers()
    {

        $members = user::wherePrivilege(5)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('admin.admin-members', ['members' => $members]);
    }



    /*
     * method use to go to members page in admin
     */
    public function getInactiveMembers()
    {

        $members = user::wherePrivilege(5)
                        ->whereActive(0)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('admin.admin-members', ['members' => $members]);
    }




    /*
     * method to view details of the member
     */
    public function getMemberInfo($uid = null)
    {
        $member = User::whereUid($uid)->first();

        return view('admin.admin-member-info', ['member' => $member]);
    }



    /*
     * method to return all user logs
     */
    public function userLogs()
    {

        $logs = UserLog::orderBy('created_at', 'desc')->paginate(10);

    	return view('admin.user-logs', ['logs' => $logs]);
    }


    /*
     * method use to view member balance
     */
    public function getMemberBalance()
    {
        // get all members with balance
        $balances = MemberBalance::where('current', '!=', 0)->paginate(10);

        return view('admin.admin-member-balance', ['balances' => $balances]);
    }

    // system setting
    public function adminSystemSettings()
    {
        $setting = Setting::findorfail(1);

        return view('admin.admin-system-settings', ['setting' => $setting]);
    }


    // update system settings
    public function postAdminSystemSettings(Request $request)
    {
        // validation
        $this->validate($request, [
            'system_name' => 'required'
            ]);

        $name = $request['system_name'];

        $setting = Setting::findorfail(1);

        $setting->system_name = $name;
        $setting->save();

        return redirect()->route('admin_system_settings')->with('success', 'Settings Updated!');
    }


    // method use to add/edit/remove/ faq
    public function viewFaq()
    {
        return view('admin.admin-faq');
    }


    // method use to change password of admin
    public function adminChangePassword()
    {
        return view('admin.admin-change-password');
    }


    // method to post change password of admin
    public function postAdminChangePassword(Request $request)
    {
        // validation
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        $old_password = $request['old_password'];
        $password = $request['password'];


        $user = User::find(Auth::user()->id);


        $password_compare = password_verify($old_password, $user->password);


        if($password_compare != true) {
            return redirect()->back()->with('error_msg', 'Password Entered is Incorred!');
        }

        $user->password = bcrypt($password);
        $user->save();

        // user log
        $log = new UserLog();
        $log->user = 'admin';
        $log->action = 'Password Change';
        $log->save();

        return redirect()->route('admin_dashboard')->with('success', 'Password Changed Successful!');
    }


    // method use to changep profile picture of the admin
    public function adminChangeProfilePicture()
    {
        return view('admin.admin-change-profile-picture');
    }


    // method use to update payment option 
    public function adminPaymentOptions()
    {
        $options = PaymentOption::orderby('name', 'asc')->get();

        return view('admin.admin-payment-options', ['options' => $options]);
    }


    // method to show add payment options
    public function addPaymentOption()
    {
        return view('admin.admin-add-payment-options');
    }

    // method to add payment option
    public function postAddPaymentOption(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:payment_options'
        ]);

        $name = $request['name'];
        $description = $request['description'];

        $option = new PaymentOption();
        $option->name = $name;
        $option->description = $description;
        $option->save();

        $log = new UserLog();
        $log->user = 'Admin';
        $log->action = 'Admin: Added Payment Option';
        $log->save();

        return redirect()->route('admin_payment_options')->with('success', 'Payment Option Added');
    }

    // method use to update payment option
    public function updatePaymentOption($name = null)
    {
        $option = PaymentOption::whereName($name)->first();

        return view('admin.admin-update-payment-option', ['option' => $option]);
    }

    // method use to update payment option
    public function postUpdatePaymentOption(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $name = $request['name'];
        $description = $request['description'];

        $option = PaymentOption::findorfail($request['id']);
        $option->name = $name;
        $option->description = $description;
        $option->save();


        // user log
        $log = new UserLog();
        $log->user = 'admin';
        $log->action = 'Updated Payment Option: ' . $name;
        $log->save();

        return redirect()->route('admin_payment_options')->with('success', 'Payment Option Updated');
    }


    // method use to remove payment option
    public function removePaymentOption($name = null)
    {
        $option = PaymentOption::whereName($name)->first();
        $option->forceDelete();

        $log = new UserLog();
        $log->user = 'Admin';
        $log->action = 'Deleted Payment Option';
        $log->save();

        return redirect()->route('admin_payment_options')->with('success', 'Payment Option Removed');

    }


    // method use to view payout options
    public function adminPayoutOptions()
    {
        $options = PayoutOption::get();

        return view('admin.admin-payout-options', ['options' => $options]);
    }

    public function addPayoutOption()
    {
        return view('admin.admin-add-payout-options');
    }


    // method use to add payout option
    public function postAddPayoutOption(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:payout_options'
        ]);

        $name = $request['name'];
        $description = $request['description'];

        $option = new PayoutOption();
        $option->name = $name;
        $option->description = $description;
        $option->save();

        $log = new UserLog();
        $log->user = 'Admin';
        $log->action = 'Admin: Added Payout Option';
        $log->save();

        return redirect()->route('admin_payout_options')->with('success', 'Payout Option Added');
    }


    // method to remove payout option
    public function removePayoutOption($name = null)
    {
        $option = PayoutOption::whereName($name)->first();
        $option->forceDelete();

        $log = new UserLog();
        $log->user = 'Admin';
        $log->action = 'Deleted Payout Option';
        $log->save();

        return redirect()->route('admin_payout_options')->with('success', 'Payout Option Removed');
    }


    // method use to display payout option to update
    public function updatePayoutOption($name = null)
    {
        $option = PayoutOption::whereName($name)->first();

        return view('admin.admin-update-payout-option', ['option' => $option]);
    }


    // post method update payout option
    public function postUpdatePayoutOption(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $name = $request['name'];
        $description = $request['description'];

        $option = PayoutOption::findorfail($request['id']);

        $option->name = $name;
        $option->description = $description;
        $option->save();

        $log = new UserLog();
        $log->user = 'Admin';
        $log->action = 'Admin Updated Payout Option';
        $log->save();


        return redirect()->route('admin_payout_options')->with('success', 'Payout Option Updated');
    }

    // method use to view profile of the admin
    public function adminViewProfile()
    {

        return view('admin.admin-view-profile');
    }




    // method to view unpaid direct referral
    public function getAvailableDirectReferral()
    {
        $dr = DirectReferral::where('paid', 0)->orderBy('created_at', 'asc')->paginate(1);

        return view('admin.admin-direct-referral', ['referrals' => $dr]);
    }



    public function postDirectReferralPay(Request $request)
    {
        $this->validate($request, [
            'sponsor' => 'required'
        ]);

        $sponsor = $request['sponsor'];
        $id = $request['id'];

        $dr = DirectReferral::findorfail($id);
        // check if the sponsor is correct
        if($dr->sponsor == $sponsor) {
            // pay the sposnor
            
            $sponsor_account = User::whereUid($sponsor)->first();

            $cash = MyCash::whereUserId($sponsor_account->id)->first();
            $cash->total = $cash->total + 50; // for the direct referal
            $cash->save();

            $dr->paid = 1;
            $dr->save();

            // log
            $log = new UserLog();
            $log->user = 'Admin';
            $log->action = 'Payed DirectReferral Bonus';
            $log->save();

            return redirect()->route('admin_available_direct_referral')->with('success', 'Direct Referral Bonus Paid!');
        }

        return redirect()->route('admin_available_direct_referral')->with('error_msg', 'Sponsor ID incorrect!');

    }


    public function getCashMonitor()
    {
        $monitors = CashMonitor::paginate(8);

        $cash = SystemCash::find(1);

        return view('admin.admin-cash-monitor', ['monitors' => $monitors, 'cash' => $cash]);

    }

}
