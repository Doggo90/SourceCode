<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Post;

class UserProfileController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        $posts = Post::with('author')->where('is_approved', 1)->where('user_id', $user->id)->get();
        // dd($posts);
        $userOrgs = $user->organizations()->get();
        return view('pages.user-profile', compact('user', 'userOrgs', 'posts'));
    }

    public function update(Request $request ,$id)
    {
        // dd($request);
        $attributes = $request->validate([
            'bio' => ['max:255']
        ]);

        auth()->user()->update([
            'bio' => $request->get('bio'),
        ]);
        // toastr()->success('Profile updated successfully!');
        return redirect()->back()->with('success', 'Profile Updated!');
    }
}
