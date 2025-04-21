<?php

use App\Hamada\Settings\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')
    ->middleware('api')
    ->group(function () {
        Route::get('/settings', [SettingsController::class, 'index']);
    });

Route::prefix('api')
    ->middleware('api')
    ->group(function () {
        Route::put('/settings/{setting}', [SettingsController::class, 'update']);
    });

Route::prefix('api')
    ->middleware('api')
    ->group(function () {
        Route::get('/settings/{key}', [SettingsController::class, 'showByKey']);
    });
