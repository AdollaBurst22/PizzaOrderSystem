<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //direct to admin Dashboard
    public function mainDashboard(){
        //Total sell amount (only delivered and pending orders)
        $totalSellAmt = Order::whereIn('status',[0,1])->sum('total_price');
        $totalOrderCount = Order::whereIn('status', [0, 1])->count();
        $totalUserCount = User::where('role', 'user')->count();
        $pendingOrderCount = Order::where('status', 0)->count();

        $dashboardData = [
            'totalSellAmt' => $totalSellAmt,
            'totalOrderCount' => $totalOrderCount,
            'totalUserCount' => $totalUserCount,
            'pendingOrderCount' => $pendingOrderCount,
        ];
        return view('admin.dashboard.mainDashboard',compact('dashboardData'));
    }
}
