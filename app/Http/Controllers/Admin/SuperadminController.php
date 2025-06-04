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
        $rules = [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email',
            'password' => 'required|min:5|max:255',
            'confirmPassword' => 'required|min:5|max:255|same:password'
        ];
        $messages = [
            'email.email' => 'Enter a valid email address.',
            'password.min' => 'Password must be at least 5 characters.',
            'confirmPassword.same' => 'Password and confirm password do not match.'
        ];

        $validation = $request->validate($rules, $messages);
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
        $query = User::select('id', 'name', 'nickname', 'email', 'phone', 'address', 'profile', 'role','provider', 'created_at')
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
    //Admin Account View
    public function adminAccountView($accountId){
        $admin = User::find($accountId);
        return view('admin.profile.adminView',compact('admin'));
    }
    //Update Admin Account
    public function adminAccountUpdate($accountId){
        $admin = User::find($accountId);
        return view('admin.profile.adminAccountEdit',compact('admin'));
    }
    public function adminAccountUpdateStore(Request $request,$accountId){
        $this->adminDataValidation($request);
        $data = $this->getAdminData($request);
        //Get the profile of the admin account
        $adminProfile = User::where('id',$accountId)->value('profile');

        if($request->hasFile('image')){
            // Delete the old profile image in the project if it exists and is not the default image
            if($adminProfile != null){
                if(file_exists(public_path('admin/profileImages/' . $adminProfile))){
                    unlink(public_path('admin/profileImages/' . $adminProfile));
                }
            }

            // Save the new uploaded image in the project
            $file = $request->image;
            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $file->move(public_path('admin/profileImages/'),$fileName);

            // Push the new image name into the data which will be stored in the database
            $data['profile'] = $fileName;
        } else {
            $data['profile'] = $adminProfile;
        }
        //Store the data in the database
        User::where('id',$accountId)->update($data);

        Alert::success('Profile Update', 'Profile updated successfully...');
        return back();
    }

    //Check Validation for profile updating data
    private function adminDataValidation($request){
        $validation = $request->validate(
            [
                'image' => 'image|mimes:jpeg,png,jpg,gif,webp,csv,svg',
                'name' => 'required|min:2|max:30',
                'nickname' => 'max:50',
                'email' => 'required|min:5|max:50',
                'phone' => 'max:20',
                'address' => 'max:200'
            ],
            [
                'image.mimes' => 'The supported image format are jpeg,png,jpg,gif,webp,csv,svg.',
                'phone.integer' => 'Phone Number must be all positive integer..like 09xxxxx.',
            ]
            );
            return $validation;
    }

    // Get the data from $request to update on database
    private function getAdminData($request){
        $data = [
            'name' => $request->name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
        return $data;
    }

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
