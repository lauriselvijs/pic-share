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
    }

    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        CanManipulateFiles::class => DropboxFileService::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
