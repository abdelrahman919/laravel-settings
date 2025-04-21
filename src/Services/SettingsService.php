<?php

namespace Hamada\Settings\Services;

use Hamada\Settings\Models\Setting;
use Illuminate\Support\Collection;

class SettingsService
{
    /**
     * Get the value of a setting by its key.
     *
     * @param string $key The key of the setting.
     * @return mixed The value of the setting, or null if not found.
     */
    public function getValue(string $key): mixed
    {
        $setting = Setting::where('key', $key)->first();

        return $setting ? $setting->value : null;
    }

    /**
     * Retrieve a setting by its key.
     *
     * @param string $key The key of the setting.
     * @return Setting|null The Setting model instance, or null if not found.
     */
    public function getSetting(string $key): ?Setting
    {
        return Setting::where('key', $key)->first();
    }

    /**
     * Retrieve all settings, optionally filtered by a group.
     *
     * @param string|null $group The group of settings to filter by, or null to retrieve all settings.
     * @return \Illuminate\Database\Eloquent\Collection|Setting[] A collection of settings.
     */
    public function getAllSettings(?string $group = null): Collection
    {
        $settings = $group 
        ? Setting::where('group', $group)->get() 
        : Setting::all();

        return $settings;
    }
}

