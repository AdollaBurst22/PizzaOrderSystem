<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    public function categoryList()
    {
        //Fetch all the categories from the server
        $categories = Category::orderBy('created_at', 'desc')->paginate(5);
        return view('admin.category.categorylist',compact('categories'));
    }
    public function categoryCreate(Request $request){

        //Custom Validation message Validation process
        $this->checkValidation($request);

        //Save the category in server table
        Category::create([
            'name' => $request->categoryName,
        ]);

        //Sweet Alert
        Alert::success('Category Create', 'Category Created successfully.');

        //Redirect back to the Category page
        return back();
    }
            //Check Validation
    private function checkValidation($request){
        $validation = $request->validate([
            'categoryName' => 'required|min:3|max:30|unique:categories,name,'.$request->id,
        ], [
            'categoryName.required' => 'Category Name is required.',
            'categoryName.min' => 'Category Name must be at least 3 Characters.',
            'categoryName.max' => 'Category Name must not exceed 30 Characters.',
            'categoryName.unique' => 'This Category Name is already taken.'
        ]);
        return $validation;
    }
    //Go to category update page
    public function categoryUpdate($id){
        $category = Category::find($id);
        return view('admin.category.categoryUpdate', compact('category'));
    }

    //Update category Name
    public function categoryUpdateStore(Request $request){
        $this->checkValidation($request);
        Category::where('id', $request->id)->update([
            'name' => $request->categoryName
        ]);

        Alert::success('Category Update', 'Category Updated successfully.');
        return redirect()->route('admin#categoryList');
    }
    //Category Delete
    public function categoryDelete($id){
        Category::destroy($id);
        return back();
    }

}
