<?php

use hamada\Settings\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class SettingController
{
    public function index()
    {
        $settings = Setting::all();

        return response()->json($settings);
    }

    public function show($id)
    {
        $setting = Setting::findOrFail($id);

        return response()->json($setting);
    }

    /**
     * Only update the VALUE of the setting, not the other attributes
     * to update the other attributes, use the SettingsSeeder and SettingsConfigFactory
     */
    public function update(FormRequest $request, Setting $setting)
    {
        $validated = $request->validated();

        $setting->update($validated);

        return response()->json($setting);
    }
}
