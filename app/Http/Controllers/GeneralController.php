<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;

use App\User;
use App\UserLog;

class GeneralController extends Controller
{
    // method use to get to landing page
    // other addtional elements in lading page goes here
    public function getLandingPage()
    {
        /*
         * Checking if there are authenticated user and redirecting
         * to the corrent path
         */
        if(Auth::check()) {
            if(Auth::user()->privilege == 1) {
                return redirect()->route('admin_dashboard');
            }
            else {
                return view('get_landing_page');
            }
        }

    	return view('landing-page');
    }


    // method use to get to aobut page
    // other additional elements in about page goes here
    public function getAboutPage()
    {
        Auth::logout();

    	return view('about-page');
    }


    // method use to get to the register page of the website
    public function getRegister()
    {
        Auth::logout();

    	return view('register');
    }


    // method use to get to login page of amin
    public function getLogin()
    {
        Auth::logout();
        
        return view('login');
    }


    // method use to login all users
    public function postLogin(Request $request)
    {
        $this->validate($request, [
                'username' => 'required',
                'password' => 'required'
            ]);


        /*
         * Add the login code == equal to the user privilege code 
         * to know where to redirect a user
         */

        $id = $request['username'];
        $password = $request['password'];


        if(Auth::attempt(['username' => $id, 'password' => $password], True)) {
            
            /*
             * Check if the user is inactive
             * the user will not login and redirect to login with error message
             */
            if(Auth::user()->active != 1) {
                Auth::logout();
                return redirect()->back()->with('error_msg', 'Your Accout is Inactive! Please contact the administrator.');
            }

            $log = new UserLog();

            if(Auth::user()->privilege == 1) {
                $log->user = Auth::user()->username;
                $log->action = 'Admin Login';
                $log->save();
                return redirect()->route('admin_dashboard');
            }

            // save log

          
        }

        /*
         * Redirect to Login form if the user id or password is incorrect or if not in database
         */
        return redirect()->back()->with('error_msg', 'ID or Password Incorrect!');

    }


    /*
     * method use to logout all users
     */
    public function getLogout()
    {

        if(empty(Auth::user())) {
            return redirect()->route('get_landing_page')->with('notice', 'Login first!');
        }

        /*
         * UserLog 
         */

        $user_log = new UserLog();

        $user_log->user = Auth::user()->username;
        if(Auth::user()->privilege == 1) {
            $user_log->action = 'Admin Logout';
        }
        else {
            $user_log->action = 'Member Logout';
        }

        $user_log->save();

        Auth::logout();

        return redirect()->route('get_landing_page');
    }

}
