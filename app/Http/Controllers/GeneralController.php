<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmRegistration;
use App\User;
use App\UserLog;
use App\Faq;

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
            elseif(Auth::user()->privilege == 5) {
                return redirect()->route('member_dashboard');
            }
            else {
                return view('landing-page');
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
                
                if(Auth::user()->privilege == 5) {
                    Auth::logout();
                    return redirect()->route('get_member_login')->with('error_msg', 'Your Accout is Inactive! Please contact the administrator.');
                }
                return redirect()->back()->with('error_msg', 'Your Accout is Inactive! Please contact the administrator.');
            }

            $log = new UserLog();

            if(Auth::user()->privilege == 1) {
                $log->user = Auth::user()->username;
                $log->action = 'Admin Login';
                $log->save();
                return redirect()->route('admin_dashboard');
            }
            elseif(Auth::user()->privilege == 5) {
                $log->user = Auth::user()->username;
                $log->action = 'Member Login';
                $log->save();
                return redirect()->route('member_dashboard');
            }


          
        }

        /*
         * Redirect to Login form if the user id or password is incorrect or if not in database
         */
        return redirect()->route('get_member_login')->with('error_msg', 'ID or Password Incorrect!');

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



    // public function sendConfirmationEmail()
    // {
    //     Mail::to('madamt0001@gmail.com')->send(new ConfirmRegistration());

    //     return 'Test Email Sent.';
    // }

    public function geMembertLogin()
    {
        return view('member-login');
    }



    // method to view faq
    public function getFaq()
    {   
        $faqs = Faq::orderBy('question', 'asc')->paginate(10);
        return view('faq', ['faqs' => $faqs]);
    }

    public function getViewFaq($id = null)
    {
        $faq = Faq::findorfail($id);

        return view('faq-view', ['faq' => $faq]);
    }


    // method to view whats new
    public function whatsNew()
    {
        return view('whats-new');
    }

}
