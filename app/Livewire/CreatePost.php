<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Category;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;

class CreatePost extends Component
{
    #[Validate('required|min:2')]
    public $title = '';
    #[Validate('required|min:2')]
    public $body = '';
    #[Validate('required|min:2')]
    public $tags = '';
    #[Validate('required|array')]
    public $selectedCategories = [];

    public function mount()
    {
        // Fetch categories
        $this->categories = Category::all();
        // Set default to first category if it exists
        if ($this->categories->isNotEmpty()) {
            $this->selectedCategories = [$this->categories->first()->id]; // Default to first category
        }
    }
    public function createPost()
    {

        $validatedData = $this->validate([
            'title' => 'required | min:2',
            'body' => 'required | min:2 | max:255',
            'tags' => 'required | min:2',
            'selectedCategories' => 'required|array|min:1',
        ]);

        $post = Post::create([
            'title' => $this->title,
            'body' => $this->body,
            'tags' => $this->tags,
            'user_id' => auth()->user()->id,
        ]);
        // dd($post);
        $categories = $validatedData['selectedCategories'];
        unset($validatedData['selectedCategories']);
        $post->categories()->attach($categories);

        toastr()->success('Post Created Successfully!');
        $this->redirect('/dashboard');
        $this->reset('title', 'body', 'tags', 'selectedCategories');
        // $this->title = '';
        // $this->body = '';
        // $this->tags = '';
        // $this->selectedCategories = [];


    }


    public function render()
    {
        return view('livewire.create-post');
    }
}
