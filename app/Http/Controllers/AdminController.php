<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /*
     * admin dashboard
     */
    public function adminDashboard()
    {
    	return view('admin.admin-dashboard');
    }
}
