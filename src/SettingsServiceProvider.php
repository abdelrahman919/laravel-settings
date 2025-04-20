<?php 
namespace Hamada\Settings;

use App\Hamada\Settings\Commnads\SeedSettingsCommand;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    private string $basePackageName = 'laravel-settings';
    public function boot()
    {
        // Publish migration & config
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/Database/migrations/' => database_path('migrations'),
            ], 'migrations');

            $this->publishes([
                __DIR__.'/Database/Seeders/' => database_path('Seeders'),
            ], 'seeders');

            $this->publishes([
                __DIR__.'/Publisable/App/' => app_path(),
            ], 'settings');

        /*  $this->publishes([
                __DIR__.'/Config/settings.php' => app_path('settings.php'),
            ], 'config'); */

/*             $this->publishes([
                __DIR__.'/Config/settings.php' => app_path('settings.php'),
            ], 'config'); */

            $this->commands([
                SeedSettingsCommand::class,
            ]);
        }

        // Merge config
        // $this->mergeConfigFrom(__DIR__.'/Config/settings.php', 'settings');
    }

/*     public function register()
    {
        $this->app->bind(SettingStoreInterface::class, DbSettingStore::class);
    } */
}