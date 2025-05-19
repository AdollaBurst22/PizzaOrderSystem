<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    //Social Login Redirect
    public function socialRedirect($provider) {
        return Socialite::driver($provider)
        ->stateless()
        ->redirect();
    }

    //Social Login Callback function
    public function socialCallback($provider) {
        $socialLoginUser = Socialite::driver($provider)
        ->stateless()
        ->user();

        $user = User::updateOrCreate([
            'provider_id' => $socialLoginUser->id,
        ], [
            'name' => $socialLoginUser->name,
            'nickname' => $socialLoginUser->nickname ?? null,
            'email' => $socialLoginUser->email,
            'profile' => $socialLoginUser->avatar,
            'provider' => $provider, //provider => google | github
            'provider_id' => $socialLoginUser->id,
            'provider_token' => $socialLoginUser->token,
        ]);

        Auth::login($user);

        return redirect()->route('user#homePage');

    }
};


