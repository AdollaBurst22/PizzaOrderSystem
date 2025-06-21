<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //direct to user home
    public function userHome(){
        $products = Product::leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->when(request('categoryId'), function($query) {
                $query->where('products.category_id', request('categoryId'));
            })
            ->when(request('searchKey'), function($query) {
                $searchKey = request('searchKey');
                $query->where(function($q) use ($searchKey) {
                    $q->where('products.name', 'like', '%' . $searchKey . '%')
                      ->orWhere('products.description', 'like', '%' . $searchKey . '%');
                });
            })
            ->when(request('minPrice') || request('maxPrice'), function($query) {
                if(request('minPrice')) {
                    $query->where('products.price', '>=', request('minPrice'));
                }
                if(request('maxPrice')) {
                    $query->where('products.price', '<=', request('maxPrice'));
                }
            })
            ->when(request('sortingType'), function($query) {
                switch(request('sortingType')) {
                    case 'asc':
                        $query->orderBy('products.price', 'asc');
                        break;
                    case 'desc':
                        $query->orderBy('products.price', 'desc');
                        break;
                    case 'nameAsc':
                        $query->orderBy('products.name', 'asc');
                        break;
                    case 'nameDesc':
                        $query->orderBy('products.name', 'desc');
                        break;
                    case 'dateAsc':
                        $query->orderBy('products.created_at', 'asc');
                        break;
                    case 'dateDesc':
                        $query->orderBy('products.created_at', 'desc');
                        break;
                }
            })
            ->get();
        $categories = Category::select('id', 'name')->get();
        return view('user.home.list', compact('products', 'categories'));
    }

    //Direct to Product Details Page
    public function productDetails($productId){
        $product = Product::leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->where('products.id', $productId)
            ->first();

            //Get the related products
        $relatedProducts = Product::leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.category_id', $product->category_id)
            ->where('products.id', '!=', $productId)
            ->select('products.*', 'categories.name as category_name')
            ->get();
        //Comments of the product
        $comments = Comment::leftJoin('users','comments.user_id','=','users.id')
            ->where('comments.product_id',$productId)
            ->select('comments.*','users.name as user_name','users.id as user_id','users.profile as user_profile','users.nickname as user_nickname')
            ->get();

        //Product Average Rating
        $averageRating = Rating::where('product_id', $productId)->avg('count');
        $averageRating = ceil($averageRating);
        $product->averageRating = $averageRating;

        //User's rating count
        $userRatingCount = Rating::where('product_id', $productId)
            ->where('user_id', Auth::user()->id)
            ->value('count');
        $product->userRatingCount = $userRatingCount;
        return view('user.home.details', compact('product', 'relatedProducts','comments'));
    }

    // Product Comment
    public function productComment(Request $request){
        $validation = $request->validate([
            'comment' => 'required'
        ],
        [
            'comment.required' => 'Please fill your review comment!...'
        ]);
        $data = [
            'product_id' => $request->productId,
            'user_id' => Auth::user()->id,
            'message' => $request->comment
        ];
        Comment::create($data);

        Alert::success('Comment', 'Thank you for your feedbacks...');
        return back();
    }

    //Delete Comment
    public function deleteComment($commentId){
        Comment::destroy($commentId);
        Alert::success('Comment', 'You deleted your comment successfully...');
        return back();
    }
    //Rate Product
    public function rateProduct(Request $request){
        $data = [
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId,
            'count' => $request->productRating
        ];

    Rating::updateOrCreate([
        'user_id' => $data['user_id'],
        'product_id' => $data['product_id']
    ], [
        'count' => $data['count']
    ]);

    Alert::success('Rating', 'Your have successfully rated the product!');
    return back();
    }

    //Direct to Cart Page
    public function cartCreate(){
        $cartProducts = Cart::leftJoin('products','carts.product_id','products.id')
            ->where('carts.user_id',Auth::user()->id)
            ->select('carts.*','products.name as product_name','products.price as product_price','products.image as product_image')
            ->get();
        return view('user.home.cart',compact('cartProducts'));
    }
    //Add products to Cart
    public function cartStore(Request $request){
        Cart::updateOrCreate([
            'user_id' => $request->userId,
            'product_id' => $request->productId
        ], [
            'quantity' => $request->count
        ]);
        Alert::success('Added To Cart', 'Your have successfully added the product to your shopping cart!');
        return back();
    }

    //Update cart quantities
    public function updateCart(Request $request) {
        try {
            $updates = $request->updates;

            if (!$updates) {
                return response()->json(['success' => false, 'message' => 'No updates provided'], 400);
            }
            //Save the data from the cart in the session to use for payment and order rendering
            Session::put('tempOrder', $updates);

            foreach ($updates as $update) {
                if (!isset($update['cartId']) || !isset($update['quantity'])) {
                    return response()->json(['success' => false, 'message' => 'Invalid update data'], 400);
                }

                Cart::where('id', $update['cartId'])
                    ->where('user_id', Auth::user()->id)
                    ->update(['quantity' => $update['quantity']]);
            }


            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            logger('Cart update error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while updating cart'], 500);
        }
    }

    //Remove item from cart
    public function removeFromCart($cartId) {
        Cart::where('id', $cartId)
            ->where('user_id', Auth::user()->id)
            ->delete();

        return response()->json(['success' => true]);
    }

    //Direct to payment page (will use the data saved in the session named as tempOrder)
    public function paymentCreate(){
        $paymentMethods = Payment::orderBy('account_type')->get();
        $order = Session::get('tempOrder');
        return view('user.home.payment',compact('order','paymentMethods'));
    }

    //Payment Store
    public function paymentStore(Request $request){
        $request->validate(
            [
                'phone' => 'required|min:5|max:20',
                'address' => 'required|min:5',
                'paymentType' => 'required',
                'payslipImage' => 'required|file|mimes:jpeg,png,jpg,gif,webp,csv,svg',
            ],
            [
                'phone.required' => 'Please enter your phone number to contact.',
                'address.required' => 'Please enter your address to deliver to.'
            ]
            );
        $payslipImage = $request->file('payslipImage');
        $payslipImageName = uniqid() . '_' . $payslipImage->getClientOriginalName();
        $payslipImage->move(public_path('payslipImages'), $payslipImageName);

        $data = [
            'user_id' => Auth::user()->id,
            'phone' => $request->phone,
            'address' => $request->address,
            'payslip_image' => $payslipImageName,
            'payment_method' => $request->paymentType,
            'order_code' => $request->orderCode,
            'total_amount' => $request->totalAmount
        ];
        PaymentHistory::create($data);

        //Create an order
        $orderData = Session::get('tempOrder');
        foreach($orderData as $item){
            $data = [
                'user_id' => Auth::user()->id,
                'product_id' => $item['productId'],
                'count' => $item['quantity'],
                'total_price' => $item['total'],
                'status' => $item['status'],
                'order_code' => $item['orderCode'],
            ];
            Order::create($data);
        };
        Cart::where('user_id',Auth::user()->id)->delete();
        Session::forget('tempOrder');

        Alert::success('Order', 'Your have successfully placed your order. Thank you for shopping with us!');

        //Redirect to order page after payment
        return to_route('user.orderPage');
    }

    //Direct to Order Page
    public function orderPage(){
        // Get unique order codes with their details
        $orders = Order::select('order_code', 'status', 'created_at')
            ->where('user_id', Auth::user()->id)
            ->groupBy('order_code')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.home.order', compact('orders'));
    }

    //Direct To Contact Us Page
    public function contactPage(){
        return view('user.home.contact');
    }

    //Store the messages from users
    public function message(Request $request){
        $request->validate(
            [
                'name' => 'required|min:3|max:50',
                'email' => 'required|min:3|max:50',
                'subject' => 'required|min:3|max:50',
                'message' => 'required|min:3'
            ]
        );
        $data = [
            'user_id' => Auth::user()->id,
            'user_name' => $request->name,
            'user_email' => $request->email,
            'title' => $request->subject,
            'message' => $request->message,
        ];
        Contact::create($data);
        Alert::success('Message', 'Thank you for reaching out to us!');
        return back();
    }

}
