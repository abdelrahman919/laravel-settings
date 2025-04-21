<?php

namespace Hamada\Settings;

use Hamada\Settings\Commands\MigrateSettingsCommand;
use Hamada\Settings\Commands\SeedSettingsCommand;
use Hamada\Settings\Commands\SettingsPublishCommand;
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
            $filename = PathsHelper::createMigrationFileName();

            $this->publishes([
                $this->migrationsPath . '2025_01_01_000000_create_settings_table.php' => database_path('migrations/' . $filename),
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
                MigrateSettingsCommand::class,
                SeedSettingsCommand::class,
                SettingsPublishCommand::class,
            ]);
        }
    }
}
