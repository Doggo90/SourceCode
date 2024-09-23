<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class ArchiveButton extends Component
{
    public Post $post;
    protected $debug = true;

    public function toggleArchive(){
        $this->post->is_archived = !$this->post->is_archived;
        $this->post->save();
   }
    public function render()
    {
        return view('livewire.archive-button',);
    }
}
