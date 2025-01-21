<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

use Livewire\WithPagination;

class ArchivedPosts extends Component
{
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';

    public function setSortBy($sortByField){

        if($this->sortBy === $sortByField){
            $this->sortDir = ($this->sortDir == "ASC") ? "DESC" : "ASC";
            return;
        }
        $this->sortBy = $sortByField;

    }

    public function render()
    {
        $posts = Post::where('is_archived', 1)
            ->where('is_approved', 1)
            ->withCount(['likes', 'comments'])
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(10);
        // $posts = Post::withCount('likes')
        // ->where('is_archived', 1)
        // ->withCount(['likes', 'comments'])
        // ->orderBy($this->sortBy, $this->sortDir)
        // ->paginate(10);

        return view('livewire.archived-posts', [
            'posts' => $posts,
        ]);
    }
}
