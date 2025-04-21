<?php 
namespace Hamada\Settings\Commands;

use Hamada\Settings\Helpers\PathsHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UninstallCommand extends Command
{
    protected $signature = 'settings:uninstall {--rollback} {--force}';
    protected $description = 'Uninstall the settings package (optionally drops table and deletes published files)';

    public function handle()
    {
        $confirmed = $this->option('force') || $this->confirm('Are you sure you want to uninstall the package?');

        if (! $confirmed) {
            $this->warn('Uninstallation cancelled.');
            return;
        }

        // Rollback migrations (optional)
        if ($this->option('rollback')) {
            // Check if the settings table exists before rolling back
            $migrationName = PathsHelper::getPublishedMigration();
            if($migrationName) {
                $this->call('migrate:rollback', ['--path' => "database/migrations/$migrationName"]);
            } else {
                $this->error('Migration file was not found, Proccedingd with uninstallation.');
            }
        }

        // Delete published files
        $filePaths = PathsHelper::getPublishedFilesPaths();

        foreach ($filePaths as $path) {
            if (File::exists($path)) {
                File::delete($path);
                $this->info("Deleted: $path");
            }
        }

        // Delete published directories
        $foldersPaths = PathsHelper::getPublishedDirsPaths();
        
        foreach ($foldersPaths as $path) {
            if (File::exists($path)) {
                File::deleteDirectory($path);
                $this->info("Deleted directory: $path");
            }
        }

        // Optional: run composer remove (only works in interactive shells)
        if ($this->confirm('Do you want to run composer remove abdelrahman919/laravel-settings?')) {
            exec('composer remove abdelrahman919/laravel-settings');
        }

        $this->info('Package uninstalled successfully.');
    }
}
