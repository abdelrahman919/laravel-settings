<?php 
namespace Hamada\Settings\Commands;

use Illuminate\Console\Command;
use Database\Seeders\SettingsSeeder;

class SeedSettingsCommand extends Command
{
    protected $signature = 'settings:seed';
    protected $description = 'Seed the settings table with default values';

    public function handle()
    {
        $this->call('db:seed', [
            '--class' => SettingsSeeder::class,
        ]);
    }
}
