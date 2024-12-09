<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;

class CreatePost extends Component
{
    public $errorMessage = '';
    #[Validate('required|min:2')]
    public $title = '';
    #[Validate('required|min:2')]
    public $body = '';
    #[Validate('required|min:2')]
    public $tags = '';
    #[Validate('required|array|min:1')]
    public $selectedCategories = [];

    public function createPost()
    {
        if (!$this->title || !$this->tags || empty($this->selectedCategories) || !$this->body) {
            $this->errorMessage = 'Missing Inputs Found!';
            return;
        }

        $this->validate([
            'title' => 'required | min:2',
            'body' => 'required | min:2 | max:255',
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
        // dd($this->selectedCategories);
        $this->dispatch('close-modal');

        $post->categories()->attach($this->selectedCategories);
        toastr()->success('Post Created Successfully!');
        $this->redirect('/dashboard');
        $this->title = '';
        $this->body = '';
        $this->tags = '';
        $this->selectedCategories = [];


    }

    public function render()
    {
        return view('livewire.create-post');
    }
}
