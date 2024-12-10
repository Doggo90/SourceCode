<?php

namespace App\Livewire;


use App\Models\User;
use App\Models\Post;
use Livewire\Component;
class Upvote extends Component
{
    public Post $post;
    protected $debug = true;



   public function toggleUpvote(){
        $totalLikesPerWeek = 5;
        if(auth()->guest()){
            return $this->redirect(route('login'));
        }
        $user = auth()->user();

        if($user->hasUpvoted($this->post)){
            $user->likes()->detach($this->post);
            $user->decrement('reputation', 1);
            $user->decrement('likes_counter', 1);
            toastr()->info('Upvote removed!');
            return;
        }
        if($user->likes_counter < $totalLikesPerWeek){
            $user->likes()->attach($this->post);
            $user->increment('reputation', 1);
            $user->increment('likes_counter', 1);
            toastr()->success('Upvoted!');
        }else{
            toastr()->error('Total likes per week reached!');
            return redirect()->back();

        }


   }

    public function render()
    {
        // dd();
        return view('livewire.upvote');
    }



}
