<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class SuperadminController extends Controller
{
    //Create New admin Account
    public function newAdminCreate(){
        return view('admin.profile.adminCreate');
    }
    public function newAdminStore(Request $request){
        $this->checkValidation($request);
        $data =$this->getData($request);
        User::create($data);

        Alert::success('Success', 'New admin account created successfully.');
        return back();
    }

    private function checkValidation($request){
        $validation = $request->validate(
            [
                'name' => 'required|min:3|max:255',
                'email' => 'required|email',
                'password' => 'required|min:5|max:255',
                'confirmPassword' => 'required|min:5|max:255|same:password'
            ],
            [
                'email.email' => 'Enter a valid email address.',
                'password.min' => 'Password must be at least 5 characters.',
                'confirmPassword.same' => 'Password and confirm password do not match.'
            ]
            );
            return $validation;
    }
    private function getData($request){
        $data =[
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ];
        return $data;
    }

    //Admin Accounts List
    public function adminList(){
        // Base query to get admin and superadmin accounts
        $query = User::select('id', 'name', 'nickname', 'email', 'phone', 'address', 'profile', 'role', 'created_at')
            ->where(function($query) {
                $query->where('role', 'admin')
                      ->orWhere('role', 'superadmin');
            });

        // Apply search if searchKey exists
        if(request('searchKey')) {
            $searchKey = request('searchKey');
            $query->where(function($q) use ($searchKey) {
                $q->where('name', 'like', '%' . $searchKey . '%')
                  ->orWhere('nickname', 'like', '%' . $searchKey . '%')
                  ->orWhere('email', 'like', '%' . $searchKey . '%')
                  ->orWhere('phone', 'like', '%' . $searchKey . '%')
                  ->orWhere('address', 'like', '%' . $searchKey . '%')
                  ->orWhere('role', 'like', '%' . $searchKey . '%');
            });
        }

        // Get paginated results
        $adminAccounts = $query->orderBy('name')
                              ->paginate(5)
                              ->withQueryString();

        // Get total count of admin accounts
        $totalAdmin = User::where(function($query) {
            $query->where('role', 'admin')
                  ->orWhere('role', 'superadmin');
        })->count();

        return view('admin.profile.adminList', compact('adminAccounts', 'totalAdmin'));
    }
    //Delete Admin Account
/*
    public function adminDelete($accountId){
        $user = User::find($accountId);
        if($user->profile != null){
            if(file_exists(public_path('admin/profileImages/'. $user->profile))){
                unlink(public_path('admin/profileImages/'. $user->profile));
            };
        };

        User::destroy($accountId);
        return back();

    }
*/
    //User Accounts List
    public function userList(){
        dd('View the user accounts list.');
    }

    //Create a Payment Method
    public function paymentMethodCreate(){
        dd('Create a payment method.');
    }

    //View the payment methods
    public function paymentMethodList(){
        dd('View the payment methods list.');
    }
}
