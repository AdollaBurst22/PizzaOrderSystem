<?php

namespace App\Http\Controllers\User;

use App\Models\Rating;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
}
