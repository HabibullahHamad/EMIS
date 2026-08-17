<?php

use App\Http\Controllers\Settings\SettingsOverviewController;
use App\Http\Controllers\Settings\SettingsSectionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\SettingsHistoryController;
use App\Http\Controllers\Settings\AboutSystemController;
/*
|--------------------------------------------------------------------------
| EMIS Settings Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('admin/settings')
    ->name('settings.')
    ->group(function (): void {

        /*
        |--------------------------------------------------------------------------
        | Settings overview
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/',
            SettingsOverviewController::class
        )->name('overview');




                /*
        |--------------------------------------------------------------------------
        | Settings history
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/history',
            SettingsHistoryController::class
        )->name('history');
                /*
        |--------------------------------------------------------------------------
        | About System
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/about',
            AboutSystemController::class
        )->name('about');
        /*
        |--------------------------------------------------------------------------
        | Individual Settings sections
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/{section}',
            [SettingsSectionController::class, 'edit']
        )->name('section.edit');

        Route::put(
            '/{section}',
            [SettingsSectionController::class, 'update']
        )->name('section.update');
    });