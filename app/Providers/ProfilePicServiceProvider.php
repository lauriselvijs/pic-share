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
    }

    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        CanGenerateProfilePic::class =>  PixelenCounterService::class,
    ];

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
