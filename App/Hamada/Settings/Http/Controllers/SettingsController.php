<?php

namespace App\Hamada\Settings\Http\Controllers;

use App\Hamada\Settings\Http\Requests\UpdateSettingsRequest;
use Hamada\Settings\Models\Setting;
use App\Http\Controllers\Controller;
use Hamada\Settings\Facades\Settings;

/**
 * Class SettingsController
 *
 * Published controller for customizable json payloads.
 *
 */
class SettingsController extends Controller
{

    /**
     * Display a listing of the settings with optional filtering by group.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $group = request()->query('group');
        
        $settings = Settings::getAllSettings($group);
        
        return response()->json(
            [
                'settings' => $settings,
            ]
        );
    }

    /**
     * Display the specified setting.
     *
     * @param  \App\Hamada\Settings\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        return response()->json([
            'setting' => $setting,
        ]);
    }

    /**
     * Display the specified setting by key.
     *
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function showByKey(string $key)
    {
        $setting = Settings::getSetting($key);

        if (!$setting) {
            return response()->json([
                'message' => 'Setting not found!',
            ], 404);
        }

        return response()->json([
            'setting' => $setting,
        ]);
    }

    /**
     * Update the specified setting VALUE in the database.
     *
     * @param  \App\Hamada\Settings\Http\Requests\UpdateSettingsRequest  $request
     * @param  \App\Hamada\Settings\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettingsRequest $request, Setting $setting)
    {
        $validated = $request->validated();
        $setting->value = $validated['value'];
        $setting->save();

        return response()->json([
            'message' => 'Settings updated successfully!',
            'setting' => $setting,
        ]);
    }
}
