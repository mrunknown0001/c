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



    /*
     * method use to go to members page in admin
     */
    public function getMembers()
    {
        return view('admin.admin-members');
    }




    /*
     * method to return all user logs
     */
    public function userLogs()
    {
    	return view('admin.user-logs');
    }
}
