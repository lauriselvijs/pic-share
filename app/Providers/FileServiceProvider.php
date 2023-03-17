<?php

namespace App\Providers;

use App\Contracts\CanManipulateFiles;
use App\Services\DropboxFileService;
use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CanManipulateFiles::class, DropboxFileService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
