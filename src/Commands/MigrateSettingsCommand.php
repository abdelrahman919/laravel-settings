<?php 
namespace Hamada\Settings\Commands;

use Hamada\Settings\Helpers\PathsHelper;
use Illuminate\Console\Command;

class MigrateSettingsCommand extends Command
{
    protected $signature = 'settings:migrate';
    protected $description = 'Run the migration for the settings table';

    public function handle()
    {
        $migration = PathsHelper::getMigrationsPath();
        if(!$migration) {
            $this->error('Migration file not found, please publish the package first.');
            return;
        }

        $this->call('migrate', [
            '--path' => 'vendor/vendorname/packagename/database/migrations/' . $migration, 
            '--realpath' => true
        ]);

        $this->info('Settings table migration run successfully.');
    }
}
