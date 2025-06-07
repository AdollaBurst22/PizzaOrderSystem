<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Payment;
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
    public function accountList($accountType){
        // Base query to get accounts based on accountType
        $query = User::select('id', 'name', 'nickname', 'email', 'phone', 'address', 'profile', 'role','provider', 'created_at');

        // Filter based on accountType
        if($accountType === 'admin') {
            $query->where(function($query) {
                $query->where('role', 'admin')
                      ->orWhere('role', 'superadmin');
            });
        } else if($accountType === 'user') {
            $query->where('role', 'user');
        }

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
        $accounts = $query->orderBy('name')
                              ->paginate(5)
                              ->withQueryString();

        // Get total count of accounts based on accountType
        $totalAccounts = User::when($accountType === 'admin', function($query) {
            $query->where(function($q) {
                $q->where('role', 'admin')
                  ->orWhere('role', 'superadmin');
            });
        })->when($accountType === 'user', function($query) {
            $query->where('role', 'user');
        })->count();

        if($accountType == 'admin'){
            return view('admin.profile.adminList', compact('accounts', 'totalAccounts'));
        }else{
            return view('admin.profile.userList', compact('accounts', 'totalAccounts'));
        }
    }
    //Delete Admin Account

    public function accountDelete($accountId){
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
    public function accountView($accountId){
        $account = User::find($accountId);
        if($account->role === 'admin' || $account->role === 'superadmin'){
            return view('admin.profile.adminView',compact('account'));
        }else{
            return view('admin.profile.userView',compact('account'));
        }
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

    //View the payment methods
    public function paymentMethodList(){
        $methods = Payment::select('id','account_name','account_type','account_number')
        ->orderBy('account_name')
        ->paginate(5);
        return view('admin.payment.methodlist',compact('methods'));
    }
    //Create a Payment Method
    public function paymentMethodCreate(Request $request){
        $this->paymentMethodValidation($request);
        $data = $this->paymentMethodData($request);
        $methods = Payment::create($data);

        Alert::success('Payment Method Create', 'Payment Method Created successfully...');
        return redirect(route('superadmin.paymentMethodList'));
    }
    private function paymentMethodValidation($request){
        $validation = $request->validate(
            [
                'accountName' =>'required|min:5|max:255',
                'accountType' =>'required|min:5|max:255',
                'accountNumber' =>'required|regex:/^[0-9]+$/|unique:payments,account_number,'.$request->methodId
            ],
            [
                'accountNumber.regex' => 'Account Number must contain only numbers.',
                'accountNumber.unique' => 'This account number is already registered.'
            ]
            );
            return $validation;
    }
    private function paymentMethodData($request){
        $data = [
            'account_name' => $request->accountName,
            'account_type' => $request->accountType,
            'account_number' => $request->accountNumber
        ];
        return $data;
    }
    //Delete Payment Method Delete
    public function paymentMethodDelete($methodId){
        Payment::destroy($methodId);
        return back();
    }

    public function paymentMethodUpdate($methodId){
        $method = Payment::find($methodId);
        return view('admin.payment.methodUpdate',compact('method'));
    }
    public function paymentMethodUpdateStore(Request $request){
        $this->paymentMethodValidation($request);
        $data = $this->paymentMethodData($request);
        Payment::where('id',$request->methodId)->update($data);

        Alert::success('Payment Method Update', 'Payment Method Updated successfully...');
        return redirect(route('superadmin.paymentMethodList'));
    }
}
