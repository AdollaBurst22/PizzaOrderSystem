<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //Password Changing
    public function passwordChange(){
        return view('admin.profile.passwordChange');
    }
    public function passwordChangeStore(Request $request){
        $userPassword = Auth::user()->password;
        $passwordCheck = Hash::check($request->oldPassword, $userPassword);
        if($passwordCheck){
            $this->passwordCheckValidation($request);
            User::where('id',Auth::user()->id)->update(['password' => Hash::make($request->newPassword)]);

            Alert::success('Password Change Success', 'Password is changed successfully...');
            return to_route('admin#mainDashboard');

        }else{
            Alert::error('Password Change Failed', 'Your Old Password is incorrect...Try Again!');
            return back();

        };
    }

    //Password Change Validation
    private function passwordCheckValidation($request){
        $rules = [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:5|max:30',
            'confirmPassword' => 'required|same:newPassword'
        ];
        $messages = [
            'confirmPassword.same' => 'Your confirmation Password must be the same as the New Password...'
        ];
        $validation = $request->validate($rules, $messages);
        return $validation;
    }

    //Profile Updating
    public function profileUpdate(){
        return view('admin.profile.profileUpdate');
    }
    public function profileUpdateStore(Request $request){
        $this->checkValidation($request);
        $data = $this->getProfileData($request);

        if($request->hasFile('image')){
            // Delete the old profile image in the project if it exists and is not the default image
            if(Auth::user()->profile != null){
                if(file_exists(public_path('admin/profileImages/' . Auth::user()->profile))){
                    unlink(public_path('admin/profileImages/' . Auth::user()->profile));
                }
            }

            // Save the new uploaded image in the project
            $file = $request->image;
            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $file->move(public_path('admin/profileImages/'),$fileName);

            // Push the new image name into the data which will be stored in the database
            $data['profile'] = $fileName;
        } else {
            $data['profile'] = Auth::user()->profile;
        }
        //Store the data in the database
        User::where('id',Auth::user()->id)->update($data);

        Alert::success('Profile Update', 'Profile updated successfully...');
        return to_route('admin#mainDashboard');

    }

    //Check Validation for profile updating data
    private function checkValidation($request){
        $validation = $request->validate(
            [
                'image' => 'image|mimes:jpeg,png,jpg,gif,webp,csv,svg',
                'name' => 'required|min:2|max:30',
                'nickname' => 'max:50',
                'email' => 'required|min:5|max:50',
                'phone' => 'required|min:1|max:20',
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
    private function getProfileData($request){
        $data = [
            'name' => $request->name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
        return $data;
    }
}
