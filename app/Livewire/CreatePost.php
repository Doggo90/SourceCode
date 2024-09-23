<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
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
    public $selectedCategories = [];

    public function createPost()
    {

        $this->validate([
            'title' => 'required | min:2',
            'body' => 'required | min:2',
            'tags' => 'required | min:2',
            'selectedCategories' => 'required',
        ]);
        $post = Post::create([
            'title' => $this->title,
            'body' => $this->body,
            'tags' => $this->tags,
            'user_id' => auth()->user()->id,
            // 'comments_count' => 0,
        ]);

        $post->categories()->attach($this->selectedCategories);
        toastr()->success('Post Created Successfully!');
        $this->title = '';
        $this->body = '';
        $this->tags = '';
        $this->selectedCategories = [];
        $this->redirect('/dashboard');


    }


    public function render()
    {
        return view('livewire.create-post');
    }
}
