<?php

namespace Teckipro\Admin\Domains\Google\Http\Controllers;

use Teckipro\Admin\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class GoogleLoginController 
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->email)->first();
        if(!$user)
        {
            $user = User::create(['name' => $googleUser->name, 'email' => $googleUser->email, 'password' => \Hash::make(rand(100000,999999))]);
        }

        Auth::login($user);

        //
        if (session()->exists('loginRequestOnStripePaymentOrderPage')) {
            return redirect()->route('stripe.revieworder')->withInput();

        }elseif (session()->exists('loginRequestOnPaddlePaymentOrderPage')) {
            return redirect()->route('paddle.revieworder')->withInput();
        }else{
            return redirect(RouteServiceProvider::HOME);
        }
        
    }
}