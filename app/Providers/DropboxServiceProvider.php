<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;;

class DropboxServiceProvider extends ServiceProvider
{
    public final const CACHE_KEY = "dropbox_token";
    public final const CACHE_TIME = 60 * 60 * 4;

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $newToken = cache()->remember(self::CACHE_KEY, self::CACHE_TIME, function () {
            return Http::asForm()
                ->post('https://api.dropbox.com/oauth2/token', [
                    'refresh_token' => config('services.dropbox.refresh_token'),
                    'client_secret' => config('services.dropbox.app_secret'),
                    'client_id' => config('services.dropbox.app_key'),
                    'grant_type' => 'refresh_token',
                ])
                ->json('access_token');
        });

        Storage::extend('dropbox', function (Application $app, array $config) use ($newToken) {
            $client = new DropboxClient(
                $newToken
            );

            $adapter = new DropboxAdapter($client, $config['root'] ?? "");

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }
}
