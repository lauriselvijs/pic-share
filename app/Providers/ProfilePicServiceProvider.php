<?php

namespace App\Providers;

use App\Contracts\CanGenerateProfilePic;
use App\Services\PixelenCounterService;
use Illuminate\Support\ServiceProvider;

class ProfilePicServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CanGenerateProfilePic::class, PixelenCounterService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
