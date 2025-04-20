<?php 
namespace src;

use App\Hamada\Settings\Commands\SeedSettingsCommand;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    private static string $publishablePath = __DIR__.'/../Publishable/';
    private string $appPath =  __DIR__.'/../Publishable/' . 'App/';
    private string $databasePath = __DIR__.'/../Publishable/' . 'Database/';
    public function boot()
    {
        // Publish migration & config
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->databasePath.'migrations/' => database_path('migrations'),
            ], 'migrations');

            $this->publishes([
                $this->databasePath.'Seeders/' => database_path('Seeders'),
            ], 'seeders');

            $this->publishes([
                $this->appPath => app_path(),
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