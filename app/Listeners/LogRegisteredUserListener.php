<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogRegisteredUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegisteredEvent  $event
     * @return void
     */
    public function handle(UserRegisteredEvent $event): void
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/user_registered.log'),
        ])->info('New user ' . $event->user->name . ' registered');
    }
}
