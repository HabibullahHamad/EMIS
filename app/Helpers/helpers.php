<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        $settings = Setting::current();

        return $settings->{$key} ?? $default;
    }
}