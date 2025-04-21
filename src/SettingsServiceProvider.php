<?php

namespace Hamada\Settings;

use Hamada\Settings\Commands\UninstallCommand;
use Hamada\Settings\Helpers\PathsHelper;
use Hamada\Settings\Services\SettingsService;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish migration & config
        if ($this->app->runningInConsole()) {
            $this->publishes([
                PathsHelper::getMigrationsPath() =>
                database_path('migrations/' . PathsHelper::createMigrationFileName()),
            ], 'migrations');

            $this->publishes([
                PathsHelper::getSeedersPath() => database_path('Seeders'),
            ], 'seeders');

            $this->publishes([
                PathsHelper::getPackageAppPath() => app_path(),
            ], 'settings');
        }

        // Load routes
        $this->loadRoutesFrom(PathsHelper::getRoutesPath());
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
