<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Reports;
use Blaspsoft\Blasp\Facades\Blasp;

class PostReport extends Component
{
    public Post $post;
    public $reason;
    protected $debug = true;

    public function reportPost()
    {
        if (auth()->guest()) {
            return $this->redirect(route('login'));
        }
        $totalReportsPerMonth = 5;

        // dd(empty($this->reason));

        $user = auth()->user();
        // ------------------------------- PROFANIY DETECTION -------------------------------
        $blasp = Blasp::check($this->reason);
        // dd($blasp);
        if ($blasp->hasProfanity()) {
            $profanities = implode(', ', $blasp->uniqueProfanitiesFound);
            flash('Profanity Detected! Words: '. $profanities, 'warning');
            $this->reset('reason');
            return;
        }
        // ------------------------------- PROFANIY DETECTION -------------------------------
        if ($user->reports_counter < $totalReportsPerMonth) {
            $this->validate([
                'reason' => 'required | min:2 | max:255',
            ]);
            $report = Reports::create([
                'reporter_id' => auth()->id(),
                'reported_id' => $this->post->author->id,
                'reportable_id' => $this->post->id,
                'reportable_type' => Post::class,
                'reason' => $this->reason,
            ]);

            $user->increment('reports_counter', 1);
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
