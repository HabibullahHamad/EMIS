@php
    /*
    |--------------------------------------------------------------------------
    | Translation helper
    |--------------------------------------------------------------------------
    |
    | If a translation key has not yet been added to emis.php,
    | display a clean English fallback instead of:
    |
    | emis.settings_overview
    |
    */

    $settingLabel = function (
        string $key,
        string $fallback
    ): string {
        $translated = __($key);

        if (!is_string($translated)) {
            return $fallback;
        }

        return $translated === $key
            ? $fallback
            : $translated;
    };

    /*
    |--------------------------------------------------------------------------
    | Current Settings section
    |--------------------------------------------------------------------------
    */

    $currentSection = request()->route(
        'section'
    );

    /*
    |--------------------------------------------------------------------------
    | Available routes
    |--------------------------------------------------------------------------
    */

    $hasOverviewRoute = Route::has(
        'settings.overview'
    );

    $hasSectionRoute = Route::has(
        'settings.section.edit'
    );
@endphp


<nav class="settings-navigation">

    {{-- =========================================================
         Navigation Heading
         ========================================================= --}}

    <div class="settings-navigation-header">

        <div class="settings-navigation-header__icon">
            <i class="fa-solid fa-sliders"></i>
        </div>

        <div>

            <div class="settings-navigation-title">
                {{
                    $settingLabel(
                        'emis.settings',
                        'Settings'
                    )
                }}
            </div>

            <div class="settings-navigation-subtitle">
                {{
                    $settingLabel(
                        'emis.system_configuration',
                        'System Configuration'
                    )
                }}
            </div>

        </div>

    </div>


    <div class="settings-navigation-list">

        {{-- =====================================================
             1. Overview
             ===================================================== --}}

        @if($hasOverviewRoute)

            <a
                href="{{ route('settings.overview') }}"
                class="settings-navigation-link
                    {{
                        request()->routeIs(
                            'settings.overview'
                        )
                            ? 'active'
                            : ''
                    }}"
            >

                <span class="settings-navigation-icon">
                    <i class="fa-solid fa-gauge-high"></i>
                </span>

                <span class="settings-navigation-text">

                    <span class="settings-navigation-label">
                        {{
                            $settingLabel(
                                'emis.settings_overview',
                                'Overview & System Health'
                            )
                        }}
                    </span>

                    <span class="settings-navigation-help">
                        {{
                            $settingLabel(
                                'emis.settings_overview_short',
                                'Status and diagnostics'
                            )
                        }}
                    </span>

                </span>

            </a>

        @else

            <div class="settings-navigation-link disabled">

                <span class="settings-navigation-icon">
                    <i class="fa-solid fa-gauge-high"></i>
                </span>

                <span class="settings-navigation-text">

                    <span class="settings-navigation-label">
                        {{
                            $settingLabel(
                                'emis.settings_overview',
                                'Overview & System Health'
                            )
                        }}
                    </span>

                    <span class="settings-navigation-help">
                        {{
                            $settingLabel(
                                'emis.settings_overview_short',
                                'Status and diagnostics'
                            )
                        }}
                    </span>

                </span>

            </div>

        @endif


        {{-- =====================================================
             2. General Settings
             ===================================================== --}}

        @if($hasSectionRoute)

            <a
                href="{{
                    route(
                        'settings.section.edit',
                        [
                            'section' => 'general',
                        ]
                    )
                }}"
                class="settings-navigation-link
                    {{
                        request()->routeIs(
                            'settings.section.*'
                        )
                        && $currentSection === 'general'
                            ? 'active'
                            : ''
                    }}"
            >

                <span class="settings-navigation-icon">
                    <i class="fa-solid fa-sliders"></i>
                </span>

                <span class="settings-navigation-text">

                    <span class="settings-navigation-label">
                        {{
                            $settingLabel(
                                'emis.general_settings',
                                'General Settings'
                            )
                        }}
                    </span>

                    <span class="settings-navigation-help">
                        {{
                            $settingLabel(
                                'emis.general_settings_short',
                                'Identity and support'
                            )
                        }}
                    </span>

                </span>

            </a>

        @else

            <div class="settings-navigation-link disabled">

                <span class="settings-navigation-icon">
                    <i class="fa-solid fa-sliders"></i>
                </span>

                <span class="settings-navigation-text">

                    <span class="settings-navigation-label">
                        {{
                            $settingLabel(
                                'emis.general_settings',
                                'General Settings'
                            )
                        }}
                    </span>

                </span>

            </div>

        @endif


        {{-- Registered additional Settings sections --}}

        @php
            $registeredSections = collect(
                $sections
                ?? config(
                    'emis-settings.sections',
                    []
                )
            )
                ->except([
                    'general',
                ])
                ->sortBy(
                    fn (
                        array $definition
                    ): int =>
                        (int) (
                            $definition['order']
                            ?? 999
                        )
                );

            $hasHistoryRoute =
                \Illuminate\Support\Facades\Route::has(
                    'settings.history'
                );
        @endphp

        @if(
            $registeredSections->isNotEmpty()
            || $hasHistoryRoute
        )
            <div class="settings-navigation-divider">
                <span>
                    {{
                        $settingLabel(
                            'emis.additional_sections',
                            'Additional Sections'
                        )
                    }}
                </span>
            </div>
        @endif

        @foreach(
            $registeredSections
            as $sectionKey => $definition
        )
            @php
                $sectionIcon =
                    $definition['icon']
                    ?? 'fa-solid fa-gear';

                $sectionTitle =
                    $definition['title']
                    ?? $sectionKey;

                $sectionDescription =
                    $definition['description']
                    ?? null;

                $sectionFallback = str(
                    $sectionKey
                )
                    ->replace('_', ' ')
                    ->replace('-', ' ')
                    ->title()
                    ->toString();

                $resolvedDescription =
                    is_string($sectionDescription)
                        ? $settingLabel(
                            $sectionDescription,
                            'Manage settings'
                        )
                        : 'Manage settings';

                $sectionIsActive =
                    request()->routeIs(
                        'settings.section.*'
                    )
                    && $currentSection
                        === $sectionKey;
            @endphp

            @if($hasSectionRoute)
                <a
                    href="{{
                        route(
                            'settings.section.edit',
                            [
                                'section' =>
                                    $sectionKey,
                            ]
                        )
                    }}"
                    class="settings-navigation-link
                        {{
                            $sectionIsActive
                                ? 'active'
                                : ''
                        }}"
                >
                    <span class="settings-navigation-icon">
                        <i class="{{ $sectionIcon }}"></i>
                    </span>

                    <span class="settings-navigation-text">
                        <span class="settings-navigation-label">
                            {{
                                $settingLabel(
                                    $sectionTitle,
                                    $sectionFallback
                                )
                            }}
                        </span>

                        <span class="settings-navigation-help">
                            {{ $resolvedDescription }}
                        </span>
                    </span>
                </a>
            @endif
        @endforeach

        @if($hasHistoryRoute)
            <a
                href="{{ route('settings.history') }}"
                class="settings-navigation-link
                    {{
                        request()->routeIs(
                            'settings.history'
                        )
                            ? 'active'
                            : ''
                    }}"
            >
                <span class="settings-navigation-icon">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </span>

                <span class="settings-navigation-text">
                    <span class="settings-navigation-label">
                        {{
                            $settingLabel(
                                'emis.settings_history',
                                'Settings History'
                            )
                        }}
                    </span>

                    <span class="settings-navigation-help">
                        {{
                            $settingLabel(
                                'emis.settings_history_short',
                                'Configuration audit trail'
                            )
                        }}
                    </span>
                </span>
            </a>
        @endif
@if(
    \Illuminate\Support\Facades\Route::has(
        'settings.about'
    )
)
    <a
        href="{{ route('settings.about') }}"
        class="settings-navigation-link
            {{
                request()->routeIs('settings.about')
                    ? 'active'
                    : ''
            }}"
    >
        <span class="settings-navigation-icon">
            <i class="fa-solid fa-circle-info"></i>
        </span>

        <span class="settings-navigation-text">
            <span class="settings-navigation-label">
                {{
                    $settingLabel(
                        'emis.about_system',
                        'About System'
                    )
                }}
            </span>

            <span class="settings-navigation-help">
                {{
                    $settingLabel(
                        'emis.about_system_short',
                        'Version and system information'
                    )
                }}
            </span>
        </span>
    </a>
@endif

    </div>

</nav>


@push('styles')

<style>

    /*
    |--------------------------------------------------------------------------
    | Settings Internal Navigation
    |--------------------------------------------------------------------------
    */

    .settings-navigation {
        width: 100%;
    }

    .settings-navigation-header {
        display: flex;
        align-items: center;
        gap: 10px;

        padding: 16px;

        border-bottom:
            1px solid
            #edf0f4;

        background: #fafbfd;
    }

    .settings-navigation-header__icon {
        width: 36px;
        height: 36px;

        flex: 0 0 36px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        background: #edf4ff;
        color: #173d7a;

        font-size: 15px;
    }

    .settings-navigation-title {
        color: #172033;

        font-size: 14px;
        font-weight: 700;

        line-height: 1.3;
    }

    .settings-navigation-subtitle {
        margin-top: 2px;

        color: #8a94a4;

        font-size: 10.5px;
    }

    .settings-navigation-list {
        padding: 8px;
    }


    /*
    |--------------------------------------------------------------------------
    | Navigation Links
    |--------------------------------------------------------------------------
    */

    .settings-navigation-link {
        position: relative;

        display: flex;
        align-items: center;

        gap: 10px;

        width: 100%;

        margin-bottom: 3px;
        padding: 9px 10px;

        color: #465268;

        text-decoration: none;

        border: 1px solid transparent;
        border-radius: 9px;

        transition:
            background-color 0.15s ease,
            border-color 0.15s ease,
            color 0.15s ease;
    }

    a.settings-navigation-link:hover {
        color: #173d7a;

        background: #f4f7fc;

        border-color: #e5ebf5;
    }

    .settings-navigation-link.active {
        color: #173d7a;

        background: #edf4ff;

        border-color: #d6e4fa;
    }

    .settings-navigation-link.active::before {
        content: "";

        position: absolute;

        inset-block:
            8px;

        inset-inline-start:
            0;

        width: 3px;

        border-radius: 3px;

        background: #173d7a;
    }


    /*
    |--------------------------------------------------------------------------
    | Icon
    |--------------------------------------------------------------------------
    */

    .settings-navigation-icon {
        width: 30px;
        height: 30px;

        flex: 0 0 30px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 8px;

        background: #f3f5f8;

        color: #607086;

        font-size: 12px;
    }

    .settings-navigation-link.active
    .settings-navigation-icon {
        background: #ffffff;

        color: #173d7a;
    }


    /*
    |--------------------------------------------------------------------------
    | Text
    |--------------------------------------------------------------------------
    */

    .settings-navigation-text {
        flex: 1;

        min-width: 0;

        display: flex;
        flex-direction: column;

        gap: 1px;
    }

    .settings-navigation-label {
        font-size: 12.5px;
        font-weight: 600;

        line-height: 1.35;
    }

    .settings-navigation-help {
        color: #8b95a5;

        font-size: 9.5px;

        line-height: 1.35;
    }


    /*
    |--------------------------------------------------------------------------
    | Disabled Future Sections
    |--------------------------------------------------------------------------
    */

    .settings-navigation-link.disabled {
        cursor: default;

        opacity: 0.58;
    }

    .settings-navigation-lock {
        flex: 0 0 auto;

        color: #9aa4b2;

        font-size: 9px;
    }


    /*
    |--------------------------------------------------------------------------
    | Divider
    |--------------------------------------------------------------------------
    */

    .settings-navigation-divider {
        display: flex;
        align-items: center;

        gap: 8px;

        margin:
            12px
            5px
            7px;

        color: #8a94a4;

        font-size: 9px;
        font-weight: 700;

        text-transform: uppercase;

        letter-spacing: 0.04em;
    }

    .settings-navigation-divider::after {
        content: "";

        flex: 1;

        height: 1px;

        background: #edf0f4;
    }


    /*
    |--------------------------------------------------------------------------
    | RTL
    |--------------------------------------------------------------------------
    */

    [dir="rtl"]
    .settings-navigation-link.active::before {
        left: auto;
        right: 0;
    }

</style>

@endpush