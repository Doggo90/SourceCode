<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\User;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // LIKES COUNTER RESET EVERY MONDAYS AT 6 AM
        $schedule->call(function () {
            $users = User::all();
            foreach ($users as $user) {
                $user->update(['likes_counter' => 0]);
                $user->save();
            }
        })->weekly()->mondays()->at('06:00');
        //
        // REPUTATION RESET EVERY SEM AND ADDED TO THEIR TOTAL REPUTATION
        // $schedule->call(function () {
        //     $users = User::all();
        //     foreach ($users as $user) {
        //         $user->update(['total_reputation' => $user->total_reputation + $user->reputation]);
        //         $user->update(['reputation' => 0]);
        //         $user->save();
        //     }
        // })->quarterlyOn(1, '6:00');
        // REPUTATION RESET EVERY 1ST DAY OF THE MONTH AT 6 AM
        // $schedule->call(function () {
        //     info('Start reputation reset');
        //     $users = User::all();
        //     $reputationHistory = [];
        //     $now = Carbon::now();
        //     $currMonth = $now->format('F');

        //     foreach ($users as $user) {
        //         $newReputationValue = $user->reputation;
        //         $reputationHistory[$user->id] = [$user->reputation];
        //         $user = User::find($user->id);
        //         $reputationHistory = json_decode($user->reputation_history, true) ?? [];
        //         $reputationHistory[$currMonth] = $newReputationValue;
        //         $user->update(['reputation_history' => json_encode($reputationHistory)]);
        //         $user->update(['reputation' => 0]);
        //         $user->save();
        //     }
        //     info('End reputation reset');
        // })->monthlyOn(1,'6:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
