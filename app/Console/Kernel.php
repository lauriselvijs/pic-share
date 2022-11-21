<?php

namespace App\Console;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // Remove failed jobs from DB every month
        $schedule->command('queue:prune-failed')->name('deleted:jobs')
            ->everyMonth()
            ->appendOutputTo(storage_path('/logs/deleted_jobs.log'))
            ->onOneServer()
            ->runInBackground();

        // Delete all pruned models
        $schedule->command('model:prune')->name('pruned:models')
            ->daily()
            ->appendOutputTo(storage_path('/logs/pruned_users.log'))
            ->onOneServer()
            ->runInBackground();;
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
