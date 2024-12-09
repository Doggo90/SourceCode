<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

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
        $posts = Post::withCount('likes')
            ->orderBy($this->sortBy, $this->sortDir)
            ->get();

        return view('livewire.archived-posts', [
            'posts' => $posts,
        ]);
    }
}
