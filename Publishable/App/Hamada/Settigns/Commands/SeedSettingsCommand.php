<?php 

namespace App\Hamada\Settings\Commnads;

use Database\Seeders\SettingsSeeder;
use Illuminate\Console\Command;


class SeedSettingsCommand extends Command
{
    protected $signature = 'settings:seed';
    protected $description = 'Seed new settings into the database';

    public function handle()
    {
        $this->info('Seeding settings...');
        $this->call(SettingsSeeder::class);
        $this->info('Done.');
    }
}