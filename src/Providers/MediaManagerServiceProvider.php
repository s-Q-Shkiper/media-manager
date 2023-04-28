<?php

namespace Shkiper\MediaManager\Providers;

use Illuminate\Support\ServiceProvider;

class MediaManagerServiceProvider extends ServiceProvider
{
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
        $this->loadRoutesFrom(__DIR__.'/../routes/mediamanager.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mediamanager');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/mediamanager'),
            __DIR__.'/../public/media-manager-asset' => public_path('media-manager-asset'),
            __DIR__.'/../database/migrations/2023_04_17_062213_create_media_table.php' => 'database/migrations/2023_04_17_062213_create_media_table.php',
        ]);
    }
}
