<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //Redirect ot profile edit page
    public function create(){
        return view('user.profile.edit');
    }
    //Store the profile update data
    public function store(Request $request){
        $this->validationCheck($request);
        $data = $this->getData($request);

        //check if the user uploaded the profile image or not
        if($request->hasFile('image')){
            // Get the old image path
            $oldImage = Auth::user()->profile;

            // Delete old image if exists
            if($oldImage && File::exists(public_path('user/profileImages/'.$oldImage))){
                File::delete(public_path('user/profileImages/'.$oldImage));
            }

            // Get the new image
            $file = $request->file('image');
            $fileName = uniqid() . '_' . $file->getClientOriginalName();

            // Move the new image to profileImages folder
            $file->move(public_path('user/profileImages'), $fileName);

            // Add image name to data array
            $data['profile'] = $fileName;
        }else{
            $data['profile'] = Auth::user()->profile;
        }

        // Update user profile
        User::where('id',Auth::user()->id)->update($data);

        Alert::success('Profile Update', 'Profile updated successfully...');
        return redirect()->back();
    }

    //Check Validation
    private function validationCheck($request){
        $rules = [
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp,csv,svg',
            'name' => 'required|min:3|max:255',
            'nickname' => 'max:255',
            'email' => 'required|max:255',
            'phone' => 'required|max:20|min:5',
            'address' => 'max:255'
        ];
        $messages = [
            'image.mimes' => 'The supported image format are jpeg,png,jpg,gif,webp,csv,svg.',
            'name.required' => 'Please fill your name.',
            'name.min' => 'Name must be at least three characters.'
        ];
        return $request->validate($rules, $messages);
    }

    private function getData($request){
        $data = [
            'name' => $request->name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
        return $data;
    }


    //Password Change
    public function changePassword(){
        return view('user.profile.changePassword');
    }
    public function changePasswordStore(Request $request){
        $this->changePasswordValidation($request);

        // Get the current user
        $user = Auth::user();

        // Check if old password matches
        if(!Hash::check($request->oldPassword, $user->password)){
            Alert::error('Password Change Failed', 'Old password is incorrect!');
            return redirect()->back();
        }

        // Update the password
        User::where('id', $user->id)->update([
            'password' => Hash::make($request->newPassword)
        ]);

        Alert::success('Password Changed', 'Your password has been updated successfully!');
        return redirect()->back();
    }

    private function changePasswordValidation($request){
        $rules = [
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newPassword'
        ];

        $messages = [
            'oldPassword.required' => 'Please enter your old password',
            'oldPassword.min' => 'Old password must be at least 6 characters',
            'newPassword.required' => 'Please enter your new password',
            'newPassword.min' => 'New password must be at least 6 characters',
            'confirmPassword.required' => 'Please confirm your new password',
            'confirmPassword.same' => 'New password and confirm password must match'
        ];

        return $request->validate($rules, $messages);
    }
}
