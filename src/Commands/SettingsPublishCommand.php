<?php 
namespace Hamada\Settings\Commands;

use Illuminate\Console\Command;

class SettingsPublishCommand extends Command
{
    protected $signature = 'settings:publish {--tag= : Specific tag to publish (e.g. migrations, config)}';
    protected $description = 'Publish Hamada Settings package resources';

    public function handle()
    {
        $params = [
            '--provider' => "Hamada\\Settings\\SettingsServiceProvider",
        ];

        if ($tag = $this->option('tag')) {
            $params['--tag'] = $tag;
        }

        $this->call('vendor:publish', $params);
    }
}
