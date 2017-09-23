<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
