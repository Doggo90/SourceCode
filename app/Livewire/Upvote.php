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
            flash('Upvote Removed!', 'info');
            return;
        }
        if($user->likes_counter < $totalLikesPerWeek){
            $user->likes()->attach($this->post);
            $user->increment('reputation', 1);
            $user->increment('likes_counter', 1);
            flash( 'Upvoted!','success');
        }else{
            // toastr()->error('Total likes per week reached!');
            // return redirect()->back()->with('success', 'Post Submitted!');
            flash( 'Total likes per week reached! Resets every Monday @ 6AM','error');
            // ->with('success', 'Total likes per week reached!');

        }


   }

    public function render()
    {
        // dd();
        return view('livewire.upvote');
    }



}
