<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

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
}
