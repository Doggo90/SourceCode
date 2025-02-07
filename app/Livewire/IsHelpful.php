<?php

namespace App\Livewire;

use Livewire\Component;

class IsHelpful extends Component
{
    public $comment;
    public function toggleHelpful(){
        $this->comment->is_helpful = !$this->comment->is_helpful;
        $this->comment->save();
        if($this->comment->is_helpful == 1){
            // toastr()->success('Marked as helpful!');
            flash('Marked as helpful!','success');

        }else
        {
            // toastr()->success('Unmarked as helpful!');
            flash('Unmarked as helpful!','success');
        }
   }
    public function render()
    {
        return view('livewire.is-helpful');
    }
}
