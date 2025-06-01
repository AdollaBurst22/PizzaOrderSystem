<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    public function productCreate(){
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        return view('admin.product.productCreate', compact('categories'));
    }
    //store product in the database table
    public function productCreateStore(Request $request){
        $this->checkValidation($request, 'create');
        $data = $this->getData($request);
        //Move the uploaded product image to the project
        if($request->hasFile('image')){
            $file = $request->image;
            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $file->move(public_path('admin/products'),$fileName);

            $data['image'] = $fileName;
        }
        Product::create($data);
        //Sweet Alert
        Alert::success('Product Create', 'Product Created successfully.');

        //Redirect back to the Category page
        return back();

    }

    //Productlist
    public function productList($action = 'default'){
        $products = Product::leftJoin('categories','products.category_id', '=','categories.id')
        ->select('products.id','products.name','products.price','products.image','categories.name as category_name','products.stock','products.created_at')
        //query condition for low Amount Products
        ->when($action == 'lowAmount',function($query){
            $query->where('products.stock','<=',3);
            })
        //query condition fro searching products
        ->when(request('searchKey'),function($query){
            $query->where('products.name', 'like', '%'.request('searchKey').'%')
                  ->orWhere('products.price', 'like', '%'.request('searchKey').'%')
                  ->orWhere('categories.name', 'like', '%'.request('searchKey').'%');
        })
        ->orderBy('created_at','desc')
        ->paginate(10);

        $totalProducts = Product::count();

        return view('admin.product.productList', compact('products', 'totalProducts'));
    }
    //Product Details
    public function productDetails($productId){

        $product = Product::leftJoin('categories','products.category_id', '=','categories.id')
        ->select('products.id','products.name','products.price','products.image','categories.name as category_name','products.stock','products.description','products.created_at')
        ->where('products.id',$productId)
        ->first();

        /*
        $product = Product::find($productId);
        $categoryName = Category::select('name')->where('id', $product->category_id)->first();
        */
        return view('admin.product.productDetail',compact('product'));

    }
    //product Delete
    public function productDelete($productId){
        $product = Product::find($productId);
        if(file_exists(public_path('admin/products/'.$product->image))){
            unlink(public_path('admin/products/'.$product->image));
        };
        Product::destroy($productId);
        return back();
    }
    //product Update
    public function productUpdate($productId){
        $product = Product::find($productId);
        $categories = Category::get();
        return view('admin.product.productUpdate', compact('product','categories'));
    }
    //product Update , Store data in the database
    public function productUpdateStore(Request $request){
        $this->checkValidation($request,'update');
        $data = $this->getData($request);
        if($request->hasFile('image')){
            $file = $request->image;
            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $file->move(public_path('admin/products'),$fileName);

            // Delete the old photo when the user upload a new photo when updating
            if(file_exists(public_path('admin/products/'.$request->oldPhoto))){
                unlink(public_path('admin/products/'.$request->oldPhoto));
            };
            $data['image'] = $fileName;
        }else{
            $data['image'] = $request->oldPhoto;
        };
        Product::where('id',$request->productId)->update($data);
        return to_route('admin.productList');
    }
    //check Validation
    private function checkValidation($request, $action){
        $rules=[
            'name' => 'required|min:3|max:500|unique:products,name,'.$request->productId,
            'categoryId' =>'required',
            'price' =>'required|min:2|max:20',
            'stock' =>'required|integer|min:0',
            'description' =>'required|min:3|max:2000'
        ];
        $messages =[
            'image.required' => 'The product Image is required.',
            'image.image' => 'The uploaded image is not the valid format. Accept jpeg,png,jpg,gif,webp,csv,svg.',
            'name.required' => 'The product name is required.',
            'name.min' => 'The product name must be at least 3 characters.',
            'name.max' => 'The product name must not exceed 500 characters.',
            'categoryId.required' => 'Category is required.',
            'stock.min' => 'The stock must be at least 1.'
        ];

        $rules['image'] = $action == 'create'
            ? 'required|image|mimes:jpeg,png,jpg,gif,webp,csv,svg'
            : 'image|mimes:jpeg,png,jpg,gif,webp,csv,svg';

        $validation = $request->validate($rules, $messages);
        return $validation;
    }
    //get data to add to database
    private function getData($request){
        $data =[
            'name' => $request->name,
            'price' => $request->price,
            'category_id'=>$request->categoryId,
            'stock'=>$request->stock,
            'description' =>$request->description
        ];

        return $data;
    }
}
