<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;

class SaleInformation extends Controller
{
    // Direct to Sale List Page
    public function saleList(){

        $sales = Order::leftJoin('users','orders.user_id','users.id')
            ->leftJoin('products','orders.product_id','products.id')
            ->when(request('searchKey'),function($query){
                $query->where('orders.order_code', 'like', '%'.request('searchKey').'%')
                      ->orWhere('users.name', 'like', '%'.request('searchKey').'%')
                      ->orWhere('users.nickname', 'like', '%'.request('searchKey').'%');
            })
            ->select('orders.created_at','orders.order_code','orders.count','users.id as user_id','users.name as user_name','users.nickname as user_nickname','orders.status as order_status','products.stock as product_stock')
            ->where('orders.status',1)
            ->groupBy('order_code')
            ->orderBy('created_at','desc')
            ->paginate(5);
        $totalSales = count($sales);
        return view('admin.saleInfo.saleList',compact('sales','totalSales'));
    }

    //Direct to sale Details Page
    public function saleDetails($orderCode){
        $order = Order::where('order_code', $orderCode)
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.*', 'users.name as user_name', 'users.phone as user_phone','users.address as user_address','users.email as user_email', 'products.name as product_name', 'products.price as product_price','products.image as product_image','products.stock as product_stock')
            ->get();
        $payment = PaymentHistory::where('order_code',$orderCode)->first();

        return view('admin.saleInfo.saleDetails', compact('order','payment'));
    }
}
