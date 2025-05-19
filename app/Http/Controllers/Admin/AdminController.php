<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //direct to admin Dashboard
    public function mainDashboard(){
        return view('admin.dashboard.mainDashboard');
    }
}
