<?php 

namespace Database\Seeders;


use App\Hamada\Settings\Models\Setting;
use App\Hamada\Settings\Factories\SettingsConfigFactory;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = SettingsConfigFactory::getDefaults();

        foreach ($settings as $setting) {
            Setting::updateOrCreate([
                'key' => $setting->Key,
                'value' => ['value' => $setting->value],
                'authority' => $setting->authority,
                'group' => $setting->group,
                'description' => $setting->description,
                'type' => $setting->type,
                'validation_rules' => $setting->validation_rules,
            ]);
        }
    }
}