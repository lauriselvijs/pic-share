<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        if (config('app.server_type') == 'default') {

            // Remove failed jobs from DB every month
            $schedule->command('queue:prune-failed')->name('deleted:jobs')
                ->monthly()
                ->appendOutputTo(storage_path('/logs/deleted_jobs.log'))
                ->onOneServer()
                ->runInBackground();

            // Delete all pruned models daily
            $schedule->command('model:prune')->name('pruned:models')
                ->daily()
                ->appendOutputTo(storage_path('/logs/pruned_users.log'))
                ->onOneServer()
                ->runInBackground();

            // Back up
            $schedule->command('backup:run')->name('run:backup')
                ->daily()
                ->onOneServer()
                ->runInBackground();
            $schedule->command('backup:clean')->name('cleaned:backup')
                ->daily()
                ->onOneServer()
                ->runInBackground();
        }

        if (config('app.server_type') == 'monitor') {
            $schedule->command('backup:monitor')->name('monitored:backup')
                ->daily()
                ->at('03:00')
                ->onOneServer()
                ->runInBackground();
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
