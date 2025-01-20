<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\User;
use App\Http\Controllers\CommentsController;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\Post;
use App\Livewire\SortButton;
use Livewire\WithPagination;
class PostController extends Controller
{
    use WithPagination;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $latestAnn = Announcement::latest()->first();
        $announcements = Announcement::where('created_at', '<', $latestAnn->created_at)->orderBy('created_at', 'desc')->get();
        // dd($announcements);
        $categories = Category::all()->take(3);
        $allCat = Category::all()->skip(3);
        $allposts = Post::all();
        $mostUpvotes = Post::withCount('likes')
        ->orderByDesc('likes_count')
        ->first();
        $mostComments = Post::all()
        ->sortByDesc('comments_count')
        ->first();
        $first = User::orderByDesc('reputation')->first();
        $second = User::orderByDesc('reputation')->skip(1)->take(1)->first();
        $third = User::orderByDesc('reputation')->skip(2)->take(1)->first();
        $firstOrgs = $first->organizations()->get();
        $secOrgs = $second->organizations()->get();
        $thirdOrgs = $third->organizations()->get();
        $topRep = User::orderByDesc('reputation')->skip(3)->take(7)->get();
        // dd($topRep);

        return view('pages.dashboard', compact('allposts','mostUpvotes','mostComments','announcements','categories', 'topRep', 'first', 'second', 'third','allCat', 'latestAnn', 'firstOrgs', 'secOrgs','thirdOrgs'));
    }

    public function AnnouncementShow(Announcement $announcement){
        $latestAnn = Announcement::latest()->first();
        $announcements = Announcement::where('created_at', '<', $latestAnn->created_at)->orderBy('created_at', 'desc')->get();
        $categories = Category::all()->take(3);
        $allCat = Category::all()->skip(3);
        // $announcements = Announcement::all();
        $users = User::all();
        $announcement = Announcement::with('author')->find($announcement->id);

        return view('pages.announcement', compact('users', 'announcement', 'announcements','latestAnn','categories' ,'allCat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function CategoryShow($id)
    {
        $latestAnn = Announcement::latest()->first();
        $announcements = Announcement::where('created_at', '<', $latestAnn->created_at)->orderBy('created_at', 'desc')->get();
        // $announcements = Announcement::all();
        $catName = Category::find($id);
        $categories1 = Post::whereHas('categories', function ($query) use ($id) {
            $query->where('category_id', $id);
        })->latest()->get();
        $catPosts = Category::with('posts')->paginate(3)->find($id);
        // $categories1 = Category::all();
        $categories = Category::all()->take(3);
        $allCat = Category::all()->skip(3);
        $mostUpvotes = Post::withCount('likes')
        ->orderByDesc('likes_count')
        ->first();
        $mostComments = Post::all()
        ->sortByDesc('comments_count')
        ->first();
        return view('pages.category', compact('mostUpvotes','mostComments','announcements','categories','categories1','latestAnn','allCat', 'catName','catPosts'));
    }

    public function AllCategories(Category $category)
    {
        $categories = Category::all();
        return view('pages.categories', compact('categories'));
    }


    public function create()
    {
        //
    }
    public function allTags($tag)
    {

        $latestAnn = Announcement::latest()->first();
        $announcements = Announcement::where('created_at', '<', $latestAnn->created_at)->orderBy('created_at', 'desc')->get();
        $categories = Category::all()->take(3);
        $allCat = Category::all()->skip(3);
        $allposts = Post::all();
        $mostUpvotes = Post::withCount('likes')
        ->orderByDesc('likes_count')
        ->first();
        $mostComments = Post::all()
        ->sortByDesc('comments_count')
        ->first();
        $topRep = User::orderByDesc('reputation')->take(3)->get();
        $posts = Post::where('tags', 'like', '%' . $tag . '%')
        ->where('is_approved', 1)
        ->where('is_archived', 0)
        ->paginate(10);
        $first = User::orderByDesc('reputation')->first();
        $second = User::orderByDesc('reputation')->skip(1)->take(1)->first();
        $third = User::orderByDesc('reputation')->skip(2)->take(1)->first();
        $firstOrgs = $first->organizations()->get();
        $secOrgs = $second->organizations()->get();
        $thirdOrgs = $third->organizations()->get();
        $topRep = User::orderByDesc('reputation')->skip(3)->take(7)->get();
        return view('pages.alltags', compact('posts', 'allposts','mostUpvotes','mostComments','announcements','categories', 'topRep','latestAnn','allCat', 'topRep', 'first', 'second', 'third', 'firstOrgs', 'secOrgs', 'thirdOrgs', 'tag'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    public function show(Post $post)
    {
        $latestAnn = Announcement::latest()->first();
        $announcements = Announcement::where('created_at', '<', $latestAnn->created_at)->orderBy('created_at', 'desc')->get();
        $post1 = Post::with('categories')->find($post->id);
        $users = User::all();
        $post = Post::with('author')->find($post->id);
        // $announcements = Announcement::all();
        $categories1 = Category::all();
        $postIds = Comment::pluck('post_id')->unique()->toArray();
        $tags = explode(',', $post->tags);
        // dd($tags);
        $comments = Comment::with('post')  // Assuming your relationship is named 'post'
            ->where('post_id', $postIds)   // Replace $postId with the actual post ID
            ->get();

        return view('pages.show', compact('users','comments', 'post', 'post1', 'announcements','categories1', 'tags', 'latestAnn'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function archives(Request $request)
    {
        $announcements = Announcement::all();
        $allposts = Post::all();
        return view('pages.archives', compact('announcements', 'allposts'));
    }
    public function firstLogin(Request $request)
    {
        $organizations = Organization::all();
        $user = auth()->user();
        return view('pages.firstLogin', compact('user', 'organizations'));
    }
    public function firstLoginUpdate(Request $request, User $user)
    {
        $attributes = $request->validate([
            'bio' => ['max:255'],
        ]);



        auth()->user()->update([
            'bio' => $request->get('bio'),
        ]);

        $user = auth()->user();
        $user->organizations()->sync($request->input('organizations'));

        // toastr()->success('');
        return redirect('/dashboard')->with('success', 'Profile created successfully!');
    }
    public function suspended()
    {
        if(auth()->user()->is_suspended == 1){

            return view('pages.suspended');
        }
    }



}
