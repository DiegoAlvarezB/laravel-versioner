<?php

namespace Diegoalvarezb\Versioner;

use Illuminate\Support\ServiceProvider;

class VersionerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // add GenerateVersion command
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateVersion::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
