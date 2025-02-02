<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\User;
use App\Models\Reports;
use Blaspsoft\Blasp\Facades\Blasp;

class UserReport extends Component
{
    public Post $post;
    public User $user;
    public $reason;
    protected $debug = true;

    public function reportPost()
    {
        if (auth()->guest()) {
            return $this->redirect(route('login'));
        }
        $totalReportsPerMonth = 5;

        // dd(empty($this->reason));

        $user1 = auth()->user();
        // ------------------------------- PROFANIY DETECTION -------------------------------
        $blasp = Blasp::check($this->reason);
        if ($blasp->hasProfanity()) {
            flash('Profanity Detected!', 'error');
            $this->reset('reason');
            return;
        }
        // ------------------------------- PROFANIY DETECTION -------------------------------
        if ($user1->reports_counter < $totalReportsPerMonth) {
            $this->validate([
                'reason' => 'required | min:2 | max:255',
            ]);
            $report = Reports::create([
                'reporter_id' => auth()->id(),
                'reported_id' => $this->user->id,
                'reportable_id' => $this->user->id,
                'reportable_type' => User::class,
                'reason' => $this->reason,
            ]);

            $user1->increment('reports_counter', 1);
            // dd($report);
            $this->reset('reason');
            // $this->dispatchBrowserEvent('close-modal');
            flash('Thank you for reporting!', 'success');
        }else{
            flash('Total reports per month reached! Resets every 1st @ 6AM', 'error');
        }
    }
    public function render()
    {
        return view('livewire.post-report');
    }
}
