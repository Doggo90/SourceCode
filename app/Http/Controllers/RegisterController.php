<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required','max:255'],
            'email' => ['required', 'email','max:255', 'unique:users'],
            'password' => ['required','min:8'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>Hash::make($request->password),
        ]);

        Auth::login($user);
        $currUser = Auth::user();
        $currUser->status = 'active';
        $currUser->save();
        return redirect('/welcome')->with('message', 'Registered and Logged In Successfully!');
    }
}
