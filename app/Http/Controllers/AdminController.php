<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmRegistration;
use App\User;
use App\UserLog;
use App\Member;
use App\SellActivationCode;
use App\Setting;
use App\UsedSellActivation;

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

        $new = new SellActivationCode();
        $new->code = $code;
        $new->save();

        // return /redirect to desired page in admin
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

        return view('admin.admin-sell-code');

    }


    /*
     * method use to go to create sell code
     */
    public function createSellCode(Request $request)
    {
        
    }




    /*
     * method to return all user logs
     */
    public function userLogs()
    {
    	return view('admin.user-logs');
    }
}
