<?php
namespace Elison\ProgressiveSeeder;

use Elison\ProgressiveSeeder\Console\Commands\ProgressiveSeederCommand;
use Illuminate\Support\ServiceProvider;

class ProgressiveSeederProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ProgressiveSeederCommand::class,
            ]);
        }
    }

    public function register()
    {
        //
    }
}
