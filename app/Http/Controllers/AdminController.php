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
use App\MemberAccount;
use App\AccountSellCodeMonitor;
use App\Faq;


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


    private function generateCode($length = 10)
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
        // get the actual amount of the deposited payment
        $amount = $request['amount'];

        $amount_orig = $amount;

        // find the user/member who paid
        $member = User::findorfail($request['member_id']);

        // get the payment details
        $payment = Payment::findorfail($request['payment_id']);
 
        // find account with status 0, to activate and assign 5 sell activation code
        $account_to_activate = MemberAccount::where('user_id', $member->id)->where('status', 0)->first();


        // check if the amount is not zero or empty
        if($amount == 0 || $amount == null) {
            return redirect()->back()->with('error_msg', 'Please Input Verified Amount Payed!');
        }


        // referral approve to prove if the reffaral is valid
        $referral_approve = 0;

        // change the status of payment of paid/confirmed
        $payment->status = 1;

        // save the payment transaction
        if($payment->save()) {

            // remove the balance or deduct the balance of the member
            $balance = $member->member->balance;

            $difference = $balance->current - $amount;
            
            // check if the balance 0
            if($difference == 0) {
                $balance->current = 0;
            }
            else {
                if($difference > 0) {
                    $balance->current = $difference;
                    
                }
                else {


                    $balance->current = 0;

                    
                    // check if the amount is greater than 500
                    // if the advance payment is divisiable by 500 and has remainder, add the remainder in advance payment again for the next purchase
                    // set the amount to the number exactly divisible by 500 with noremainder 
 
                    $ap = ($member->cash->advance_payment + $amount) % 500;


                    $amount = 500 * intdiv($member->cash->advance_payment + $amount, 500);


                    $member->cash->advance_payment = $ap;
                    $member->cash->save();


                    $referral_approve = 1;

                
                }
                
            }

            // save the current balance of the member who pay
            $balance->save();
            
            // the condition will the system if the difference is 0
            if($difference < 1) {
                if(count($account_to_activate) < 1) {
                    // CREATE SELL CODE ACTIVATION

                    $loop_count = intdiv($amount, 500);

                    $payee_account = MemberAccount::find($payment->account_id);

                    if($payee_account->account_alias != 'cllr_1') {

                        $payee_upline_account = MemberAccount::where('account_id', $payee_account->upline_account)->first();
                    }

                    // start loop here
                    for($l = 0; $l < $loop_count; $l++) {

                        for($x = 0; $x < 5; $x++) {


                            $code = $this->createActivationCode();
                            // save the code to sell_activation_codes
                            $new_code = new SellActivationCode();
                            $new_code->code = $code;
                            $new_code->save();


                            // assign the code to the firist account of the member
                            $owner = new SellCodeOwner();
                            $owner->number = $x + 1;
                            $owner->member_uid = $member->uid;
                            $owner->member_account = $payment->account_id;
                            $owner->code_id = $new_code->id;
                            $owner->save();

                        }

                        // less on sell activtion on the upline
                        // if there is no sel activation the sell code sales will go to the company
                        // account upline
                        // payout account_id, check the upline of  the account id

                        if($payee_account->account_alias != 'cllr_1') {
                            $upline_cash = MyCash::where('user_id', $payee_upline_account->user_id)->first();

                            if(count($payee_upline_account) > 0) {
                                // find available codes and deduct abling to gain sell codes sales
                                $sell_code = $payee_upline_account->codes->where('usage', 0)->first();

                                if(count($sell_code) < 1) {
                                    // do noting the sales will go to the compnay
                                    
                                }
                                else {
                                    // create a loop lessing sell code sales 
                                    // in the upline
                                    for($x = 0; $x < $loop_count; $x++) {
                                        $sell_code = $payee_upline_account->codes->where('usage', 0)->first();

                                        if(count($sell_code) > 0) {
                                            $sell_code->usage = 1;
                                            $sell_code->save();
                                        


                                            // check if the upline has activated auto deduct
                                            // if yes, the 250 pesos will add to the auto deduct fund
                                            if($payee_upline_account->member->autodeduct->status == 1) {
                                                if($sell_code->number < 3) {
                                                    $payee_upline_account->ad_fund->ad_fund += 250;
                                                    $payee_upline_account->ad_fund->save();

                                                    $upline_cash->total += 50;
                                                    $upline_cash->save();
                                                
                                                }
                                                else {
                                                    // add cash sales 300
                                                    $upline_cash->total += 300;
                                                    $upline_cash->save();
                                                }
                                            }
                                            else {

                                                // add cash sales 300
                                                $upline_cash->total += 300;
                                                $upline_cash->save();
                                            }
                                        }
                                    }
                                    // end the loop in sales in sell code


                                    // if the upline account here has 500 ad fund
                                    // the system will automatically purchase another 
                                    // 500 worth of sell activation code
                                    if($payee_upline_account->ad_fund->ad_fund == 500) {
                                        // purchase 5 sell code
                                        for($x = 0; $x < 5; $x++) {


                                            $code = $this->createActivationCode();
                                            // save the code to sell_activation_codes
                                            $new_code = new SellActivationCode();
                                            $new_code->code = $code;
                                            $new_code->number = $x + 1;
                                            $new_code->active = 1;
                                            $new_code->save();

                                            


                                            // assign the code to the firist account of the member
                                            $owner = new SellCodeOwner();
                                            $owner->member_uid = $payee_upline_account->member->uid;
                                            // the account of the owner
                                            $owner->member_account = $payee_upline_account->id;
                                            $owner->code_id = $new_code->id;
                                            $owner->save();

                                        }

                                        // make the auto deduct fund to 0
                                        $payee_upline_account->ad_fund->ad_fund = 0;
                                        $payee_upline_account->ad_fund->save();
                                        
                                    }

                                }
                            }
                        }

                    }
                    // end loop here
                    
                    // find account in acccount sell code monitor in database and delete if any
                    $account_in_monitor = AccountSellCodeMonitor::where('account_id', $payee_account->id)->first();

                    if(count($account_in_monitor) > 0) {
                        $account_in_monitor->delete();
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

                        


                        // assign the code to the firist account of the member
                        $owner = new SellCodeOwner();
                        $owner->number = $x + 1;
                        $owner->member_uid = $member->uid;
                        // the account of the owner
                        $owner->member_account = $payment->account_id;
                        $owner->code_id = $new_code->id;
                        $owner->save();

                    }

                    // find the upline and deduct the sell code on it
                    // if there is no sell code
                    // the sales on sell code will go to the company
                    $upline_account_to = MemberAccount::where('account_id', $account_to_activate->upline_account)->where('status', 1)->first();
                    
                    // upline_account_to sell code deduct by 1
                    $sell_code = $upline_account_to->codes->where('usage', 0)->first();

                    // check if the account has sell code if there is no sell code
                    // the account will be active and there is no cash in the side of 
                    // upline
                    if(count($sell_code) > 0) {
                        // start of loop count 2
                        // in deducting sell code
                        $loop_count = intdiv($amount, 500);

                        for($x = 0; $x < $loop_count; $x++) {
                            $sell_code = $upline_account_to->codes->where('usage', 0)->first();
                            if(count($sell_code) > 0) {
                                $sell_code->usage = 1;
                                $sell_code->save();
                            

                                $find_member_upline_account_to = User::find($upline_account_to->user_id);
                                // add 300 to the cash of the sponsor
                                // check if auto deduct is active 
                                // if active only 50 pesos will go to member cash
                                // and 250 will go to the sell code fund
                                $cash = MyCash::whereUserId($find_member_upline_account_to->id)->first();
                                
                                
                                if($find_member_upline_account_to->autodeduct->status == 1) {
                                    // check if auto deduct is 500 the cast will go to the total cash of the member
                                    if($upline_account_to->ad_fund->ad_fund < 500) {
                                        if($sell_code->number < 3) {
                                            $cash->total = $cash->total + 50; 
                                            $upline_account_to->ad_fund->ad_fund = $upline_account_to->ad_fund->ad_fund + 250;
                                            $upline_account_to->ad_fund->save();
                                        }
                                        else {
                                            $cash->total = $cash->total + 300;
                                            
                                        }
                                        
                                    }
                                    else {
                                        // if the auto deduct is equal to 500
                                        $cash->total = $cash->total + 300;
                                        
                                    }
                                    

                                }
                                else {
                                    // check if the sponsor has activation code
                                    $cash->total = $cash->total + 300;    
                                }
                                

                                $cash->total_sent = $cash->total_sent + $amount;
                                $cash->save();
                            }
                        }
                        // end of loop count 2
                        // for deducting sell code

                        // if auto deduct fund of the account is 500 the system will
                        // automatically purchase another 500 worth of sell code (5 sell code)
                        // that will assign to the account to be able to sell 
                        if($upline_account_to->ad_fund->ad_fund == 500) {
                            // purchase 5 sell code
                            for($x = 0; $x < 5; $x++) {


                                $code = $this->createActivationCode();
                                // save the code to sell_activation_codes
                                $new_code = new SellActivationCode();
                                $new_code->code = $code;
                                $new_code->active = 1;
                                $new_code->save();

                                


                                // assign the code to the firist account of the member
                                $owner = new SellCodeOwner();
                                $owner->number = $x + 1;
                                $owner->member_uid = $upline_account_to->member->uid;
                                // the account of the owner
                                $owner->member_account = $upline_account_to->id;
                                $owner->code_id = $new_code->id;
                                $owner->save();

                            }

                            // make the auto deduct fund to 0
                            $upline_account_to->ad_fund->ad_fund = 0;
                            $upline_account_to->ad_fund->save();
                            
                        }


                    }

                    
                    // set upline account to downline

                    if($upline_account_to->downline_1 == null) {
                        $upline_account_to->downline_1 = $account_to_activate->id;
                        $upline_account_to->save();
                    }
                    elseif($upline_account_to->downline_2 == null) {
                        $upline_account_to->downline_2 = $account_to_activate->id;
                        $upline_account_to->save();
                    }
                    elseif($upline_account_to->downline_3 == null) {
                        $upline_account_to->downline_3 = $account_to_activate->id;
                        $upline_account_to->save();
                    }
                    elseif($upline_account_to->downline_4 == null) {
                        $upline_account_to->downline_4 = $account_to_activate->id;
                        $upline_account_to->save();
                    }
                    elseif($upline_account_to->downline_5 == null) {
                        $upline_account_to->downline_5 = $account_to_activate->id;
                        $upline_account_to->save();
                    }
                    else {
                        // spill over finding
                        // find all account with lower downline level than the current upline to be account
                        // plus 1 to get lower downline level
                        $downline_level = $upline_account_to->downline_level + 1;
                        $find = 0;

                        do {
                            // find all active accounts with this downline level
                            $active_accounts = MemberAccount::where('downline_level', $downline_level)->where('status', 1)->orderBy('id','asc')->get();

                            foreach($active_accounts as $aac) {
                                if($aac->downline_1 == null) {
                                    $aac->downline_1 = $account_to_activate->id;
                                    $aac->save();
                                    $find = 1;
                                }
                                elseif($aac->downline_2 == null) {
                                    $aac->downline_2 = $account_to_activate->id;
                                    $aac->save();
                                    $find = 1;
                                }
                                elseif($aac->downline_3 == null) {
                                    $aac->downline_3 = $account_to_activate->id;
                                    $aac->save();
                                    $find = 1;
                                }
                                elseif($aac->downline_4 == null) {
                                    $aac->downline_4 = $account_to_activate->id;
                                    $aac->save();
                                    $find = 1;
                                }
                                elseif($aac->downline_5 == null) {
                                    $aac->downline_5 = $account_to_activate->id;
                                    $aac->save();
                                    $find = 1;
                                }

                                // if there is no available account in the current downline
                                // the system will find it to the next downline level
                                $downline_level += 1;
                            }

                        } while($find == 0);

                    }


                    // activate the account of the member
                    $account_to_activate->status = 1;
                    $account_to_activate->save();    

                    // if the difference is negative, it means that there is excess in the payment made
                }


            }



            // find account of member
            $member_account = Member::where('uid', $member->uid)->where('confirmed', 0)->first();

            
            if(count($member_account) > 0) {
                // give the referral to the sponsor
                // if the member doesnt have sponsor the referral bonus will go to the copany account
                if($member_account->sponsor != null) {
                    $sponsor_account = User::where('uid', $member_account->sponsor)->first();

                    $sponsor_cash = MyCash::whereUserId($sponsor_account->id)->first();

                    // add cash for the direct referral of the new member
                    $sponsor_cash->direct_referral += 50;
                    $sponsor_cash->save();
                    // add log here


                    $member_account->confirmed = 1;
                    $member_account->save();
                }

   
            }
            else {
                // the there is no active account 
                // if it posible to have an 50 pesos referal bonus
                // the member itseft wil benefit the referral bonus
                
                if(count($account_to_activate) > 0) {
                    if($referral_approve == 1 ) {
                        $member_cash = $member->cash;
                        $member_cash->direct_referral += 50;
                        $member_cash->save();
                    }
                }
            }
            

            // CASH MONITOR
            // CASH MONITOR
            $type = 'in';
            $method = 'deposit';
            $via = $payment->sent_thru;
            $from = $member->uid;
            $to = 'admin';
            $remarks = 'member bought sell code';
            $this->cashMonitor($type, $method, $via, $from, $to, $amount_orig, $remarks);

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
        $payouts = Payout::whereStatus(1)->orderBy('updated_at', 'desc')->paginate(10);

        return view('admin.admin-view-successful-payout', ['payouts' => $payouts]);
    }



    // payout mandatory every friday
    public function viewMemberPayouts()
    {

        // find all member that has available payout amount
        // $members = MyCash::where('total', '>', 0)
                    // ->orwhere('direct_referral', '>', 0)->paginate(10);
        
        $members = MyCash::where('pending', '>', 0)->paginate(10);
        
        return view('admin.admin-member-payout', ['members' => $members]);
    }




    // method to view payout filter in date range
    public function payoutDatetFilter(Request $request)
    {
        // validate
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);

        // assign to variables
        $from = $request['from'];
        $to = $request['to'];

        // filter here
        // $payouts = 
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
        $faqs = Faq::orderBy('question', 'asc')->paginate(10);

        return view('admin.admin-faq', ['faqs' => $faqs]);
    }


    // method use to add faq
    public function addFaq()
    {
        return view('admin.admin-add-faq');
    }


    // method use to add faq
    public function postAddFaq(Request $request)
    {
        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required'
        ]);

        // assign to variable
        $question = $request['question'];
        $answer = $request['answer'];

        // add record to the faqs table
        $faq = new Faq();
        $faq->question = $question;
        $faq->answer = $answer;
        $faq->save();

        return 'FAQ SAved!';
    }


    // method use to view faq item
    public function viewFaqItem($id = null)
    {
        $faq = Faq::findorfail($id);

        return view('admin.admin-view-faq-item', ['faq' => $faq]);
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
        $monitors = CashMonitor::orderBy('created_at', 'desc')->paginate(8);

        $cash = SystemCash::find(1);

        return view('admin.admin-cash-monitor', ['monitors' => $monitors, 'cash' => $cash]);

    }



    // method use to move to process payout
    public function adminProcessPayout()
    {
        // copy all cash pending in payout
        $members = MyCash::where('pending', '>', 0)->get();

        // copy to pending
        foreach($members as $m) {
            $payout = new Payout();
            $payout->user = $m->member->uid; // 11 digit user id
            $payout->sent_thru = $m->member->default_payout->mop;
            $payout->amount = $m->pending;
            $payout->save();

            $m->pending = 0;
            $m->save();
        }

        // return to processing payout view
        return redirect()->route('admin_process_payout_view')->with('success', 'Payment Processing...');
        
    }


    // method use to view processing payout
    public function adminViewProcessPayout()
    {
        $payouts = Payout::where('status', 0)->get();

        return view('admin.admin-processing-payout', ['payouts' => $payouts]);
    }


    // method use to mark payout as success
    public function markPayoutSuccess()
    {

        // get all payouts that has status 0
        $payouts = Payout::where('status', 0)->get();

        // make payout success 1
        foreach($payouts as $payout) {
            $payout->status = 1;
            $payout->save();
        }

        return redirect()->route('admin_view_successful_payout')->with('success', 'Payout Paid and Processed Successfully!');
    }

}
