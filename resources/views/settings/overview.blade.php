@extends('settings.layout')

@section('settings-content')

@php
    /*
    |--------------------------------------------------------------------------
    | Translation helper
    |--------------------------------------------------------------------------
    |
    | If a Settings translation key is not available yet,
    | display a clean English fallback.
    |
    */

    $settingsText = function (
        string $key,
        string $fallback
    ): string {
        $translated = __($key);

        return $translated === $key
            ? $fallback
            : $translated;
    };


    /*
    |--------------------------------------------------------------------------
    | Safe health values
    |--------------------------------------------------------------------------
    */

    $application =
        $health['application'] ?? [];

    $database =
        $health['database'] ?? [];

    $storage =
        $health['storage'] ?? [];

    $administrator =
        $health['administrator'] ?? [];


    /*
    |--------------------------------------------------------------------------
    | Overall health
    |--------------------------------------------------------------------------
    */

    $databaseHealthy =
        (bool) (
            $database['connected']
            ?? false
        );

    $storageHealthy =
        (bool) (
            $storage['writable']
            ?? false
        );

    $maintenanceMode =
        (bool) (
            $application['maintenance_mode']
            ?? false
        );

    $debugEnabled =
        (bool) (
            $application['debug']
            ?? false
        );

    $overallHealthy =
        $databaseHealthy
        && $storageHealthy
        && !$maintenanceMode;
@endphp


{{-- =========================================================
     PAGE HEADER
     ========================================================= --}}

<div class="settings-overview-header">

    <div>

        <div class="settings-overview-title-row">

            <div class="settings-overview-title-icon">
                <i class="fa-solid fa-gauge-high"></i>
            </div>

            <div>

                <h2 class="settings-overview-title">
                    {{
                        $settingsText(
                            'emis.settings_overview',
                            'Overview & System Health'
                        )
                    }}
                </h2>

                <p class="settings-overview-description">
                    {{
                        $settingsText(
                            'emis.settings_overview_description',
                            'View the current application, database, storage and environment status.'
                        )
                    }}
                </p>

            </div>

        </div>

    </div>


    <div
        class="settings-health-badge
            {{
                $overallHealthy
                    ? 'healthy'
                    : 'warning'
            }}"
    >

        <i
            class="fa-solid
                {{
                    $overallHealthy
                        ? 'fa-circle-check'
                        : 'fa-triangle-exclamation'
                }}"
        ></i>

        <span>

            @if($overallHealthy)

                {{
                    $settingsText(
                        'emis.system_healthy',
                        'System Healthy'
                    )
                }}

            @else

                {{
                    $settingsText(
                        'emis.attention_required',
                        'Attention Required'
                    )
                }}

            @endif

        </span>

    </div>

</div>


{{-- =========================================================
     HEALTH SUMMARY
     ========================================================= --}}

<div class="settings-health-grid">

    {{-- Application --}}
    <div class="settings-health-card">

        <div class="settings-health-card-icon application">
            <i class="fa-solid fa-server"></i>
        </div>

        <div class="settings-health-card-content">

            <div class="settings-health-card-label">
                {{
                    $settingsText(
                        'emis.application',
                        'Application'
                    )
                }}
            </div>

            <div class="settings-health-card-value">

                @if($maintenanceMode)

                    {{
                        $settingsText(
                            'emis.maintenance',
                            'Maintenance'
                        )
                    }}

                @else

                    {{
                        $settingsText(
                            'emis.active',
                            'Active'
                        )
                    }}

                @endif

            </div>

        </div>

        <span
            class="settings-status-dot
                {{
                    $maintenanceMode
                        ? 'warning'
                        : 'success'
                }}"
        ></span>

    </div>


    {{-- Database --}}
    <div class="settings-health-card">

        <div class="settings-health-card-icon database">
            <i class="fa-solid fa-database"></i>
        </div>

        <div class="settings-health-card-content">

            <div class="settings-health-card-label">
                {{
                    $settingsText(
                        'emis.database',
                        'Database'
                    )
                }}
            </div>

            <div class="settings-health-card-value">

                @if($databaseHealthy)

                    {{
                        $settingsText(
                            'emis.connected',
                            'Connected'
                        )
                    }}

                @else

                    {{
                        $settingsText(
                            'emis.disconnected',
                            'Disconnected'
                        )
                    }}

                @endif

            </div>

        </div>

        <span
            class="settings-status-dot
                {{
                    $databaseHealthy
                        ? 'success'
                        : 'danger'
                }}"
        ></span>

    </div>


    {{-- Storage --}}
    <div class="settings-health-card">

        <div class="settings-health-card-icon storage">
            <i class="fa-solid fa-hard-drive"></i>
        </div>

        <div class="settings-health-card-content">

            <div class="settings-health-card-label">
                {{
                    $settingsText(
                        'emis.storage',
                        'Storage'
                    )
                }}
            </div>

            <div class="settings-health-card-value">

                @if($storageHealthy)

                    {{
                        $settingsText(
                            'emis.writable',
                            'Writable'
                        )
                    }}

                @else

                    {{
                        $settingsText(
                            'emis.not_writable',
                            'Not Writable'
                        )
                    }}

                @endif

            </div>

        </div>

        <span
            class="settings-status-dot
                {{
                    $storageHealthy
                        ? 'success'
                        : 'danger'
                }}"
        ></span>

    </div>


    {{-- Environment --}}
    <div class="settings-health-card">

        <div class="settings-health-card-icon environment">
            <i class="fa-solid fa-code-branch"></i>
        </div>

        <div class="settings-health-card-content">

            <div class="settings-health-card-label">
                {{
                    $settingsText(
                        'emis.environment',
                        'Environment'
                    )
                }}
            </div>

            <div class="settings-health-card-value">
                {{
                    ucfirst(
                        (string) (
                            $application['environment']
                            ?? 'unknown'
                        )
                    )
                }}
            </div>

        </div>

        <span class="settings-status-dot neutral"></span>

    </div>

</div>


{{-- =========================================================
     WARNINGS
     ========================================================= --}}

@if($debugEnabled)

    <div class="settings-system-notice warning">

        <div class="settings-system-notice-icon">
            <i class="fa-solid fa-bug"></i>
        </div>

        <div>

            <strong>
                {{
                    $settingsText(
                        'emis.debug_mode_enabled',
                        'Debug mode is enabled'
                    )
                }}
            </strong>

            <div>
                {{
                    $settingsText(
                        'emis.debug_mode_warning',
                        'Debug mode should normally be disabled in a production environment.'
                    )
                }}
            </div>

        </div>

    </div>

@endif


@if($maintenanceMode)

    <div class="settings-system-notice warning">

        <div class="settings-system-notice-icon">
            <i class="fa-solid fa-screwdriver-wrench"></i>
        </div>

        <div>

            <strong>
                {{
                    $settingsText(
                        'emis.maintenance_mode_enabled',
                        'Maintenance mode is enabled'
                    )
                }}
            </strong>

            <div>
                {{
                    $settingsText(
                        'emis.maintenance_mode_notice',
                        'Normal application access may currently be restricted.'
                    )
                }}
            </div>

        </div>

    </div>

@endif


@if(!$databaseHealthy)

    <div class="settings-system-notice danger">

        <div class="settings-system-notice-icon">
            <i class="fa-solid fa-database"></i>
        </div>

        <div>

            <strong>
                {{
                    $settingsText(
                        'emis.database_unavailable',
                        'Database connection unavailable'
                    )
                }}
            </strong>

            <div>
                {{
                    $settingsText(
                        'emis.database_unavailable_description',
                        'The application could not confirm a working database connection.'
                    )
                }}
            </div>

        </div>

    </div>

@endif


@if(!$storageHealthy)

    <div class="settings-system-notice danger">

        <div class="settings-system-notice-icon">
            <i class="fa-solid fa-folder-open"></i>
        </div>

        <div>

            <strong>
                {{
                    $settingsText(
                        'emis.storage_not_writable',
                        'Storage is not writable'
                    )
                }}
            </strong>

            <div>
                {{
                    $settingsText(
                        'emis.storage_not_writable_description',
                        'Uploads, logs, cache files or generated documents may fail.'
                    )
                }}
            </div>

        </div>

    </div>

@endif


{{-- =========================================================
     INFORMATION GRID
     ========================================================= --}}

<div class="settings-overview-sections">

    {{-- Application Information --}}
    <section class="settings-card">

        <div class="settings-card-header">

            <h3 class="settings-card-title">

                <i class="fa-solid fa-cube"></i>

                {{
                    $settingsText(
                        'emis.application_information',
                        'Application Information'
                    )
                }}

            </h3>

            <p class="settings-card-description">
                {{
                    $settingsText(
                        'emis.application_information_description',
                        'Safe runtime information about the current EMIS installation.'
                    )
                }}
            </p>

        </div>

        <div class="settings-card-body">

            <div class="settings-info-list">

                <div class="settings-info-row">

                    <span class="settings-info-label">
                        {{
                            $settingsText(
                                'emis.application_name',
                                'Application Name'
                            )
                        }}
                    </span>

                    <span class="settings-info-value">
                        {{
                            $application['name']
                            ?? 'EMIS'
                        }}
                    </span>

                </div>


                <div class="settings-info-row">

                    <span class="settings-info-label">
                        {{
                            $settingsText(
                                'emis.environment',
                                'Environment'
                            )
                        }}
                    </span>

                    <span class="settings-info-value">
                        {{
                            ucfirst(
                                (string) (
                                    $application['environment']
                                    ?? 'unknown'
                                )
                            )
                        }}
                    </span>

                </div>


                <div class="settings-info-row">

                    <span class="settings-info-label">
                        {{
                            $settingsText(
                                'emis.laravel_version',
                                'Laravel Version'
                            )
                        }}
                    </span>

                    <span class="settings-info-value code-value">
                        {{
                            $application['laravel_version']
                            ?? '—'
                        }}
                    </span>

                </div>


                <div class="settings-info-row">

                    <span class="settings-info-label">
                        {{
                            $settingsText(
                                'emis.php_version',
                                'PHP Version'
                            )
                        }}
                    </span>

                    <span class="settings-info-value code-value">
                        {{
                            $application['php_version']
                            ?? '—'
                        }}
                    </span>

                </div>


                <div class="settings-info-row">

                    <span class="settings-info-label">
                        {{
                            $settingsText(
                                'emis.timezone',
                                'Timezone'
                            )
                        }}
                    </span>

                    <span class="settings-info-value">
                        {{
                            $application['timezone']
                            ?? '—'
                        }}
                    </span>

                </div>


                <div class="settings-info-row">

                    <span class="settings-info-label">
                        {{
                            $settingsText(
                                'emis.default_language',
                                'Current Language'
                            )
                        }}
                    </span>

                    <span class="settings-info-value">
                        {{
                            strtoupper(
                                (string) (
                                    $application['locale']
                                    ?? app()->getLocale()
                                )
                            )
                        }}
                    </span>

                </div>


                <div class="settings-info-row">

                    <span class="settings-info-label">
                        {{
                            $settingsText(
                                'emis.debug_mode',
                                'Debug Mode'
                            )
                        }}
                    </span>

                    <span
                        class="settings-inline-status
                            {{
                                $debugEnabled
                                    ? 'warning'
                                    : 'success'
                            }}"
                    >

                        {{
                            $debugEnabled
                                ? $settingsText(
                                    'emis.enabled',
                                    'Enabled'
                                )
                                : $settingsText(
                                    'emis.disabled',
                                    'Disabled'
                                )
                        }}

                    </span>

                </div>

            </div>

        </div>

    </section>


    {{-- Database Information --}}
    <section class="settings-card">

        <div class="settings-card-header">

            <h3 class="settings-card-title">

                <i class="fa-solid fa-database"></i>

                {{
                    $settingsText(
                        'emis.database_information',
                        'Database Information'
                    )
                }}

            </h3>

            <p class="settings-card-description">
                {{
                    $settingsText(
                        'emis.database_information_description',
                        'Current database connectivity and driver status.'
                    )
                }}
            </p>

        </div>

        <div class="settings-card-body">

            <div class="settings-info-list">

                <div class="settings-info-row">

                    <span class="settings-info-label">
                        {{
                            $settingsText(
                                'emis.connection_status',
                                'Connection Status'
                            )
                        }}
                    </span>

                    <span
                        class="settings-inline-status
                            {{
                                $databaseHealthy
                                    ? 'success'
                                    : 'danger'
                            }}"
                    >

                        {{
                            $databaseHealthy
                                ? $settingsText(
                                    'emis.connected',
                                    'Connected'
                                )
                                : $settingsText(
                                    'emis.disconnected',
                                    'Disconnected'
                                )
                        }}

                    </span>

                </div>


                <div class="settings-info-row">

                    <span class="settings-info-label">
                        {{
                            $settingsText(
                                'emis.database_name',
                                'Database Name'
                            )
                        }}
                    </span>

                    <span class="settings-info-value code-value">
                        {{
                            $database['database']
                            ?? '—'
                        }}
                    </span>

                </div>


                <div class="settings-info-row">

                    <span class="settings-info-label">
                        {{
                            $settingsText(
                                'emis.database_driver',
                                'Database Driver'
                            )
                        }}
                    </span>

                    <span class="settings-info-value">
                        {{
                            strtoupper(
                                (string) (
                                    $database['driver']
                                    ?? '—'
                                )
                            )
                        }}
                    </span>

                </div>

            </div>

        </div>

    </section>


    {{-- Storage Information --}}
    <section class="settings-card">

        <div class="settings-card-header">

            <h3 class="settings-card-title">

                <i class="fa-solid fa-hard-drive"></i>

                {{
                    $settingsText(
                        'emis.storage_information',
                        'Storage Information'
                    )
                }}

            </h3>

            <p class="settings-card-description">
                {{
                    $settingsText(
                        'emis.storage_information_description',
                        'Storage write access and available disk capacity.'
                    )
                }}
            </p>

        </div>

        <div class="settings-card-body">

            <div class="settings-info-list">

                <div class="settings-info-row">

                    <span class="settings-info-label">
                        {{
                            $settingsText(
                                'emis.storage_writable',
                                'Storage Writable'
                            )
                        }}
                    </span>

                    <span
                        class="settings-inline-status
                            {{
                                $storageHealthy
                                    ? 'success'
                                    : 'danger'
                            }}"
                    >

                        {{
                            $storageHealthy
                                ? $settingsText(
                                    'emis.yes',
                                    'Yes'
                                )
                                : $settingsText(
                                    'emis.no',
                                    'No'
                                )
                        }}

                    </span>

                </div>


                <div class="settings-info-row">

                    <span class="settings-info-label">
                        {{
                            $settingsText(
                                'emis.available_disk_space',
                                'Available Disk Space'
                            )
                        }}
                    </span>

                    <span class="settings-info-value">
                        {{
                            $storage['free_space']
                            ?? '—'
                        }}
                    </span>

                </div>

            </div>

        </div>

    </section>


    {{-- Current Administrator --}}
    <section class="settings-card">

        <div class="settings-card-header">

            <h3 class="settings-card-title">

                <i class="fa-solid fa-user-shield"></i>

                {{
                    $settingsText(
                        'emis.current_administrator',
                        'Current Administrator'
                    )
                }}

            </h3>

            <p class="settings-card-description">
                {{
                    $settingsText(
                        'emis.current_administrator_description',
                        'The authenticated user currently viewing the Settings Center.'
                    )
                }}
            </p>

        </div>

        <div class="settings-card-body">

            <div class="settings-admin-profile">

                <div class="settings-admin-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div class="settings-admin-information">

                    <div class="settings-admin-name">
                        {{
                            $administrator['name']
                            ?? $settingsText(
                                'emis.not_available',
                                'Not Available'
                            )
                        }}
                    </div>

                    <div class="settings-admin-email">
                        {{
                            $administrator['email']
                            ?? '—'
                        }}
                    </div>

                    @if(!empty($administrator['id']))

                        <div class="settings-admin-id">
                            ID:
                            {{
                                $administrator['id']
                            }}
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </section>

</div>


{{-- =========================================================
     SAFETY NOTE
     ========================================================= --}}

<div class="settings-overview-safety-note">

    <i class="fa-solid fa-shield-halved"></i>

    <span>
        {{
            $settingsText(
                'emis.settings_security_notice',
                'Sensitive credentials such as APP_KEY, database passwords and mail passwords are not displayed in the Settings Center.'
            )
        }}
    </span>

</div>

@endsection


@push('styles')

<style>

    /*
    |--------------------------------------------------------------------------
    | Overview Header
    |--------------------------------------------------------------------------
    */

    .settings-overview-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 20px;

        margin-bottom: 20px;
    }

    .settings-overview-title-row {
        display: flex;
        align-items: flex-start;

        gap: 12px;
    }

    .settings-overview-title-icon {
        width: 42px;
        height: 42px;

        flex: 0 0 42px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        color: #173d7a;
        background: #edf4ff;

        font-size: 17px;
    }

    .settings-overview-title {
        margin: 0;

        color: #172033;

        font-size: 20px;
        font-weight: 700;
    }

    .settings-overview-description {
        margin: 5px 0 0;

        color: #758195;

        font-size: 12.5px;
        line-height: 1.6;
    }


    /*
    |--------------------------------------------------------------------------
    | Overall Status
    |--------------------------------------------------------------------------
    */

    .settings-health-badge {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        flex: 0 0 auto;

        padding: 7px 11px;

        border-radius: 999px;

        font-size: 11px;
        font-weight: 700;
    }

    .settings-health-badge.healthy {
        color: #166534;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
    }

    .settings-health-badge.warning {
        color: #92400e;
        background: #fffbeb;
        border: 1px solid #fde68a;
    }


    /*
    |--------------------------------------------------------------------------
    | Summary Cards
    |--------------------------------------------------------------------------
    */

    .settings-health-grid {
        display: grid;

        grid-template-columns:
            repeat(
                4,
                minmax(0, 1fr)
            );

        gap: 12px;

        margin-bottom: 20px;
    }

    .settings-health-card {
        position: relative;

        display: flex;
        align-items: center;

        gap: 10px;

        min-width: 0;

        padding: 13px;

        border: 1px solid #e7ebf0;
        border-radius: 11px;

        background: #ffffff;
    }

    .settings-health-card-icon {
        width: 38px;
        height: 38px;

        flex: 0 0 38px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        font-size: 14px;
    }

    .settings-health-card-icon.application {
        background: #edf4ff;
        color: #2459a9;
    }

    .settings-health-card-icon.database {
        background: #ecfdf5;
        color: #15803d;
    }

    .settings-health-card-icon.storage {
        background: #fff7ed;
        color: #c2410c;
    }

    .settings-health-card-icon.environment {
        background: #f5f3ff;
        color: #6d28d9;
    }

    .settings-health-card-content {
        min-width: 0;
        flex: 1;
    }

    .settings-health-card-label {
        color: #7d8899;

        font-size: 9.5px;
        font-weight: 600;
    }

    .settings-health-card-value {
        margin-top: 2px;

        color: #172033;

        font-size: 12.5px;
        font-weight: 700;

        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .settings-status-dot {
        width: 8px;
        height: 8px;

        flex: 0 0 8px;

        border-radius: 50%;
    }

    .settings-status-dot.success {
        background: #22c55e;
    }

    .settings-status-dot.warning {
        background: #f59e0b;
    }

    .settings-status-dot.danger {
        background: #ef4444;
    }

    .settings-status-dot.neutral {
        background: #64748b;
    }


    /*
    |--------------------------------------------------------------------------
    | Notices
    |--------------------------------------------------------------------------
    */

    .settings-system-notice {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        margin-bottom: 14px;
        padding: 11px 13px;

        border-radius: 9px;

        font-size: 11px;
        line-height: 1.55;
    }

    .settings-system-notice-icon {
        margin-top: 1px;
        flex: 0 0 auto;
    }

    .settings-system-notice.warning {
        color: #92400e;

        background: #fffbeb;

        border: 1px solid #fde68a;
    }

    .settings-system-notice.danger {
        color: #991b1b;

        background: #fef2f2;

        border: 1px solid #fecaca;
    }


    /*
    |--------------------------------------------------------------------------
    | Detailed Information
    |--------------------------------------------------------------------------
    */

    .settings-overview-sections {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 16px;
    }

    .settings-card-title i {
        margin-inline-end: 6px;

        color: #315b96;
    }

    .settings-info-list {
        width: 100%;
    }

    .settings-info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 16px;

        padding: 10px 0;

        border-bottom: 1px solid #f0f2f5;
    }

    .settings-info-row:first-child {
        padding-top: 0;
    }

    .settings-info-row:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .settings-info-label {
        color: #667085;

        font-size: 11px;
        font-weight: 600;
    }

    .settings-info-value {
        max-width: 60%;

        color: #172033;

        font-size: 11.5px;
        font-weight: 600;

        text-align: end;

        overflow-wrap: anywhere;
    }

    .code-value {
        padding: 3px 6px;

        border-radius: 5px;

        color: #344054;
        background: #f5f7fa;

        font-family:
            Consolas,
            Monaco,
            monospace;

        font-size: 10.5px;
    }


    /*
    |--------------------------------------------------------------------------
    | Inline Status
    |--------------------------------------------------------------------------
    */

    .settings-inline-status {
        display: inline-flex;
        align-items: center;

        padding: 4px 8px;

        border-radius: 999px;

        font-size: 9.5px;
        font-weight: 700;
    }

    .settings-inline-status.success {
        color: #166534;
        background: #dcfce7;
    }

    .settings-inline-status.warning {
        color: #92400e;
        background: #fef3c7;
    }

    .settings-inline-status.danger {
        color: #991b1b;
        background: #fee2e2;
    }


    /*
    |--------------------------------------------------------------------------
    | Administrator
    |--------------------------------------------------------------------------
    */

    .settings-admin-profile {
        display: flex;
        align-items: center;

        gap: 12px;
    }

    .settings-admin-avatar {
        width: 48px;
        height: 48px;

        flex: 0 0 48px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        color: #173d7a;
        background: #edf4ff;

        font-size: 16px;
    }

    .settings-admin-information {
        min-width: 0;
    }

    .settings-admin-name {
        color: #172033;

        font-size: 13px;
        font-weight: 700;
    }

    .settings-admin-email {
        margin-top: 2px;

        color: #667085;

        font-size: 10.5px;

        overflow-wrap: anywhere;
    }

    .settings-admin-id {
        margin-top: 3px;

        color: #98a2b3;

        font-size: 9px;
    }


    /*
    |--------------------------------------------------------------------------
    | Safety Notice
    |--------------------------------------------------------------------------
    */

    .settings-overview-safety-note {
        display: flex;
        align-items: center;

        gap: 8px;

        margin-top: 18px;
        padding: 10px 12px;

        color: #667085;

        background: #f8fafc;

        border: 1px solid #e8edf3;
        border-radius: 9px;

        font-size: 10.5px;
        line-height: 1.5;
    }

    .settings-overview-safety-note i {
        color: #315b96;
    }


    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1200px) {

        .settings-health-grid {
            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );
        }

    }

    @media (max-width: 700px) {

        .settings-overview-header {
            flex-direction: column;
        }

        .settings-health-grid,
        .settings-overview-sections {
            grid-template-columns: 1fr;
        }

        .settings-info-row {
            align-items: flex-start;
        }

        .settings-info-value {
            max-width: 55%;
        }

    }

    @media (max-width: 480px) {

        .settings-info-row {
            flex-direction: column;

            gap: 5px;
        }

        .settings-info-value {
            max-width: 100%;
            text-align: start;
        }

    }

</style>

@endpush