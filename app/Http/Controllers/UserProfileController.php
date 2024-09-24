<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserProfileController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        // $posts = $user->posts()->paginate(5);
        return view('pages.user-profile', compact('user'));
    }

    public function update(Request $request ,$id)
    {
        $attributes = $request->validate([
            'bio' => ['max:255']
        ]);

        auth()->user()->update([
            'bio' => $request->get('bio'),
        ]);
        toastr()->success('Profile updated successfully!');
        return redirect()->back();
    }
}
