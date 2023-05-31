<?php

namespace App\Jobs;


use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class ProcessDeleteAdmins implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct(private array $ids, private string $deleteKey, private string $cacheKey, private int $expirationTime)
    {
        $this->ids = $ids;
        $this->deleteKey = $deleteKey;
        $this->cacheKey = $cacheKey;
        $this->expirationTime = $expirationTime;

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
    }


    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
    }
}
