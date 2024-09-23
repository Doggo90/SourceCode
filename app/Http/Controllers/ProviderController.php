<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{
    public function redirect(){
            return Socialite::driver('google')->redirect();
    }
    public function callback() {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            // User doesn't exist, create a new user
            $user = User::create([
                'google_id' => $googleUser->id,
                'name' => $googleUser->name,
                'username' => User::generateUsername($googleUser->nickname),
                'email' => $googleUser->email,
                'google_token' => $googleUser->token,
                'photo' => $googleUser->getAvatar(),
            ]);

            Auth::login($user);
            $user = Auth::user();
            $user->status = 'active';
            $user->save();
            return redirect('/welcome')->with('message', 'Welcome! You are now logged in.');
        } else {
            // User already exists, log them in
            Auth::login($user);
            $user = Auth::user();
            $user->status = 'active';
            $user->save();

            if($user->is_suspended == 1){
                Auth::logout();
                return redirect('/login')->with('error', 'Your account has been suspended. Please contact the admin for further info.');
            }
            return redirect('/dashboard')->with('message', 'Logged in Successfully');
        }
    }
}
