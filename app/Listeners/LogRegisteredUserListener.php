<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogRegisteredUserListener implements ShouldQueue
{

    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'redis';

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'logs';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        if (config('app.env') == 'production') {
            $this->connection = 'database';
        }
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
            'path' => storage_path('logs/registered_users.log'),
        ])->info('New user ' . $event->user->name . ' registered');
    }
}
