<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //Direct to order list page
    public function orderList(){
        $orders = Order::leftJoin('users','orders.user_id','users.id')
            ->leftJoin('products','orders.product_id','products.id')
            ->when(request('searchKey'),function($query){
                $query->where('orders.order_code', 'like', '%'.request('searchKey').'%')
                      ->orWhere('users.name', 'like', '%'.request('searchKey').'%')
                      ->orWhere('users.nickname', 'like', '%'.request('searchKey').'%');
            })
            ->when(request()->has('filter'),function($query){
                $filterType = request('filter');
                $query->where('orders.status',$filterType);
            })
            ->select('orders.created_at','orders.order_code','orders.count','users.id as user_id','users.name as user_name','users.nickname as user_nickname','orders.status as order_status','products.stock as product_stock')
            ->groupBy('order_code')
            ->orderBy('created_at','desc')
            ->paginate(10);
        $totalOrders = count($orders);
        return view('admin.order.orderlist',compact('orders','totalOrders'));
    }

    //Direct to order Details Page
    public function orderDetails($orderCode){
        $order = Order::where('order_code', $orderCode)
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.*', 'users.name as user_name', 'users.phone as user_phone','users.address as user_address','users.email as user_email', 'products.name as product_name', 'products.price as product_price','products.image as product_image','products.stock as product_stock')
            ->get();
        $payment = PaymentHistory::where('order_code',$orderCode)->first();

        $stockStatus = true;
        foreach($order as $item){
            if($item->count > $item->product_stock){
                $stockStatus = false;
                break;
            }
        };
        return view('admin.order.orderdetails', compact('order','payment','stockStatus'));
    }

    //Order Reject
    public function orderReject(){
        $orderCode = request('orderCode');
        Order::where('order_code',$orderCode)->update(['status' => '2']);

        return response()->json(['success' => true]);
    }

    //Order Confirm
    public function orderConfirm(){
        $orderCode = request('orderCode');
        logger($orderCode);
        $orders = Order::leftJoin('products','orders.product_id','products.id')
        ->where('orders.order_code',$orderCode)
        ->select('orders.*','products.stock as product_stock','products.id as product_id')
        ->get();

        foreach($orders as $order){
            $stockLeft = $order->product_stock - $order->count;

            //Update Product Stock after each order purchased
            Product::where('id',$order->product_id)
            ->update(['stock' => $stockLeft]);

            //Update order status after confirmation
            Order::where('order_code',$order->order_code)
            ->update(['status' => 1]);
        };
        return response()->json(['success' => true]);

    }

    //Delivery Status update from order List Page
    public function updateStatus(Request $request){
    $request->validate([
        'order_code' => 'required|string',
        'status' => 'required|in:0,1,2',
    ]);

    $orders = Order::where('order_code', $request->order_code)->get();
    if (!$orders) {
        return response()->json(['success' => false, 'message' => 'Order not found.']);
    }

    Order::where('order_code',$request->order_code)->update(['status'=>$request->status]);

    //Update Stock Quantity in products table
    if($request->status == 1){
        $orders = Order::leftJoin('products','orders.product_id','products.id')
        ->where('orders.order_code',$request->order_code)
        ->select('orders.count','products.stock as product_stock','products.id as product_id')
        ->get();

        foreach($orders as $order){
            $stockLeft = $order->product_stock - $order->count;

            Product::where('id',$order->product_id)
            ->decrement('stock', $order->count);
        };
    }

    return response()->json(['success' => true]);
}

}
