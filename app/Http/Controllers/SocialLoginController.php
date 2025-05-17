<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    //Social Login Redirect
    public function socialRedirect($provider) {
        return Socialite::driver($provider)->redirect();
    }

    //Social Login Callback function
    public function socialCallback($provider) {
        $user = Socialite::driver($provider)->user();
        dd($user);
        /*
        $user = User::updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
        */
    }
};


