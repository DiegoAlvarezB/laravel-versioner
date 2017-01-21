<?php

namespace Diegoalvarezb\Versioner;

use Illuminate\Support\ServiceProvider;
use Diegoalvarezb\Versioner\Commands\Generate;
use Diegoalvarezb\Versioner\Commands\Show;

class VersionerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // add commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Generate::class,
                Show::class,
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
