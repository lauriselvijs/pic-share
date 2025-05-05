<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogRegisteredUserListener implements ShouldQueue
{
    /**
     * The name of the connection the job should be sent to.
     */
    public ?string $connection = 'redis';

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
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(UserRegisteredEvent $event): void
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/registered_users.log'),
        ])->info('New user '.$event->user->name.' registered');
    }
}
