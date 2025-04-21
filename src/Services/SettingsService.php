<?php

namespace Hamada\Settings\Services;

use App\Hamada\Settings\Enums\SettingsKeys;
use Hamada\Settings\Models\Setting;

class SettingsService
{
    /**
     * Get the value of a setting by its key.
     *
     * @param string $key The key of the setting.
     * @return mixed The value of the setting, or null if not found.
     */
    public function getValue(SettingsKeys $key)
    {
        $setting = Setting::where('key', $key->value)->first();

        return $setting ? $setting->value : null;
    }

    /**
     * Retrieve a setting by its key.
     *
     * @param string $key The key of the setting.
     * @return Setting|null The Setting model instance, or null if not found.
     */
    public function getSetting(SettingsKeys $key): ?Setting
    {
        return Setting::where('key', $key->value)->first();
    }

}

