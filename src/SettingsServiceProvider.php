<?php

namespace Hamada\Settings;

use App\Hamada\Settings\Commands\SeedSettingsCommand;
use Hamada\Settings\Services\SettingsService;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    private string $appPath =  __DIR__ . '/../App/';
    private string $databasePath = __DIR__ . '/../Database/';

    public function boot()
    {
        // Publish migration & config
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->databasePath . 'migrations/' => database_path('migrations'),
            ], 'migrations');

            $this->publishes([
                $this->databasePath . 'Seeders/' => database_path('Seeders'),
            ], 'seeders');

            $this->publishes([
                $this->appPath => app_path(),
            ], 'settings');
        }

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    public function register()
    {
        $this->app->singleton('settings-service', function ($app) {
            return new SettingsService();
        });
    }
}
