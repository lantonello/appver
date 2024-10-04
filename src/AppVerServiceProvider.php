<?php

namespace Codimais\AppVer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\AboutCommand;
use Codimais\AppVer\Console\InitCommand;

class AppVerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerAboutCommand();

        if( $this->app->runningInConsole() )
        {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('appver.php'),
            ], 'config');

            // Registering package commands.
            $this->registerArtisanCommands();
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'appver');

        // Register the main class to use with the facade
        $this->app->singleton('appver', function () {
            return new AppVer;
        });
    }

    protected function registerArtisanCommands(): void
    {
        $this->commands([
            InitCommand::class,
        ]);
    }

    /**
     * Register the `php artisan about` command integration.
     */
    protected function registerAboutCommand(): void
    {
        // The about command is only available in Laravel 9 and up so we need to check if it's available to us
        if( !class_exists(AboutCommand::class) )
        {
            return;
        }

        AboutCommand::add('AppVer', fn () => ['Version' => '1.0.0']);
    }
}
