<?php

namespace Hamada\Settings;

use Hamada\Settings\Commands\UninstallCommand;
use Hamada\Settings\Helpers\PathsHelper;
use Hamada\Settings\Services\SettingsService;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{

    protected $migrationsPath = __DIR__ . '/../database/migrations/';
    protected $seedersPath = __DIR__ . '/../database/seeders/';
    protected $routesPath = __DIR__ . '/../routes/api.php';
    protected $appPath = __DIR__ . '/../App/';

    public function boot()
    {
        // Publish migration & config
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->migrationsPath =>
                database_path('migrations/' . PathsHelper::createMigrationFileName()),
            ], 'migrations');

            $this->publishes([
                $this->seedersPath => database_path('Seeders'),
            ], 'seeders');

            $this->publishes([
                $this->appPath => app_path(),
            ], 'settings');
        }

        // Load routes
        $this->loadRoutesFrom($this->routesPath);
    }

    public function register()
    {
        $this->app->singleton('settings-service', function ($app) {
            return new SettingsService();
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                UninstallCommand::class,
            ]);
        }
    }
}
