<?php

namespace App\Hamada\Settings\Http\Controllers;

use App\Hamada\Settings\Http\Requests\UpdateSettingsRequest;
use Hamada\Settings\Models\Setting;
use App\Http\Controllers\Controller;



/**
 * Class SettingsController
 *
 * Published controller for customizable json loads.
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
        
        $settings = $group 
            ? Setting::where('group', $group)->get() 
            : Setting::all();
        
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
