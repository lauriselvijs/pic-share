<?php

namespace App\Jobs;

use App\Models\Admin;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessDeleteAdmins implements ShouldQueue, ShouldBeUnique
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Admin $admin, private string $deleteKey)
    {
        $this->admin = $admin;
        $this->deleteKey = $deleteKey;

        $this->connection = 'redis';
        $this->queue = 'delete';
    }

    /**
     * The unique ID of the job.
     */
    public function uniqueId(): string
    {
        return  $this->deleteKey;
    }

    /**
     * Horizon tags
     *
     * @return array<string>
     */
    public function tags(): array
    {
        return ['transaction:' . $this->deleteKey];
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...

            return;
        }

        // Do something here
    }


    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
    }
}
