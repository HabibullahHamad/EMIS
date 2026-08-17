<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\Settings\SystemSettingService;
use Illuminate\Foundation\Application;
use Illuminate\View\View;

class AboutSystemController extends Controller
{
    public function __construct(
        private readonly SystemSettingService $settings
    ) {
    }

    /**
     * Display safe EMIS application information.
     */
    public function __invoke(): View
    {
        $general =
            $this->settings->group(
                'general'
            );

        $organization =
            $this->settings->group(
                'organization'
            );

        $localization =
            $this->settings->group(
                'localization'
            );

        $system = [
            'name' =>
                $general['system_name']
                ?? config(
                    'app.name',
                    'EMIS'
                ),

            'short_name' =>
                $general['short_name']
                ?? 'EMIS',

            'description' =>
                $general['system_description']
                ?? null,

            'settings_version' =>
                config(
                    'emis-settings.version',
                    1
                ),

            'laravel_version' =>
                Application::VERSION,

            'php_version' =>
                PHP_VERSION,

            'environment' =>
                app()->environment(),

            'timezone' =>
                $localization['timezone']
                ?? config(
                    'app.timezone',
                    'UTC'
                ),

            'default_locale' =>
                $localization['default_locale']
                ?? config(
                    'app.locale',
                    'en'
                ),

            'calendar_type' =>
                $localization['calendar_type']
                ?? 'gregorian',
        ];

        $organizationInfo = [
            'official_name' =>
                $organization['official_name']
                ?? null,

            'organization_code' =>
                $organization['organization_code']
                ?? null,

            'organization_type' =>
                $organization['organization_type']
                ?? null,

            'official_email' =>
                $organization['official_email']
                ?? null,

            'official_phone' =>
                $organization['official_phone']
                ?? null,

            'website' =>
                $organization['website']
                ?? null,

            'address' =>
                $organization['address']
                ?? null,

            'logo' =>
                $organization['logo']
                ?? $general['system_logo']
                ?? null,
        ];

        return view(
            'settings.about',
            [
                'system' =>
                    $system,

                'organizationInfo' =>
                    $organizationInfo,

                'sections' =>
                    config(
                        'emis-settings.sections',
                        []
                    ),
            ]
        );
    }
}