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
    	return view('landing-page');
    }


    // method use to get to aobut page
    // other additional elements in about page goes here
    public function getAboutPage()
    {
    	return view('about-page');
    }


    // method use to get to the register page of the website
    public function getRegister()
    {
    	return view('register');
    }


    // method use to get to login page of amin
    public function getLogin()
    {
        return view('login');
    }


    // method use to login all users
    public function postLogin(Request $request)
    {
        return "Post Login";
    }

}
