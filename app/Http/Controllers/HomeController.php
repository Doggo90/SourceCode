<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comments;
use App\Models\User;
use App\Http\Controllers\CommentsController;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\Post;
class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $announcements = Announcement::all();
        $sortBy = $request->input('sort_by', 'created_at');
        $postsQuery = Post::query();
        $categories = Category::all();
        $allposts = Post::all();

        // Apply sorting based on the selected criteria
        if ($sortBy === 'title') {
            $postsQuery->orderBy('title');
        } elseif ($sortBy === 'comments_count') {
            $postsQuery->orderBy('comments_count', 'desc');
        } elseif ($sortBy === 'created_at') {
            $postsQuery->latest();
        }
        $posts = $postsQuery->filter(request(['tag', 'search']))->get();
        return view('pages.dashboard', compact('posts','allposts', 'sortBy', 'announcements', 'categories'));
    }
}
