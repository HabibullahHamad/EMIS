@extends('new')

@section('page_title', __('emis.settings'))

@section('content')

<style>
    .settings-page {
        max-width: 1450px;
        margin: 0 auto;
    }

    .settings-hero {
        background: linear-gradient(135deg, #0b3563 0%, #114f93 100%);
        border-radius: 20px;
        padding: 24px 28px;
        color: #fff;
        margin-bottom: 20px;
        box-shadow: 0 10px 30px rgba(11, 53, 99, 0.18);
    }

    .settings-hero-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .settings-hero-subtitle {
        font-size: 13px;
        opacity: .9;
        margin-bottom: 0;
    }

    .settings-layout {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 20px;
    }

    .side-card,
    .content-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 6px 22px rgba(15, 23, 42, 0.06);
    }

    .side-card {
        padding: 20px;
        position: sticky;
        top: 78px;
        height: fit-content;
    }

    .system-badge {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        background: #eff6ff;
        color: #0b3563;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin-bottom: 16px;
    }

    .side-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .side-subtitle {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 18px;
    }

    .mini-stat {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #eef2f7;
    }

    .mini-stat:last-child {
        border-bottom: none;
    }

    .mini-stat-label {
        font-size: 13px;
        color: #64748b;
    }

    .mini-stat-value {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
    }

    .settings-sections {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .content-card {
        padding: 22px;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }

    .section-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #f8fafc;
        color: #0b3563;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        border: 1px solid #e2e8f0;
    }

    .section-title {
        font-size: 17px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .section-subtitle {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }

    .form-label {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        min-height: 44px;
        border-radius: 12px;
        border: 1px solid #dbe4ef;
        box-shadow: none !important;
    }

    textarea.form-control {
        min-height: 110px;
        resize: vertical;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0b3563;
    }

    .option-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .option-box {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px;
        background: #fcfdff;
    }

    .option-box-title {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .option-box-text {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 10px;
    }

    .setting-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #eef2f7;
    }

    .setting-line:last-child {
        border-bottom: none;
    }

    .setting-line h6 {
        margin: 0 0 4px 0;
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
    }

    .setting-line p {
        margin: 0;
        font-size: 12px;
        color: #64748b;
    }

    .form-check-input {
        width: 46px;
        height: 24px;
        cursor: pointer;
    }

    .logo-box {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 22px;
        text-align: center;
        background: #f8fafc;
    }

    .logo-box i {
        font-size: 24px;
        color: #0b3563;
        margin-bottom: 10px;
    }

    .logo-box p {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 0;
    }

    .current-logo {
        max-height: 70px;
        max-width: 180px;
        object-fit: contain;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 6px;
        background: #fff;
        margin-bottom: 12px;
    }

    .settings-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 6px;
        flex-wrap: wrap;
    }

    .btn-settings-save {
        background: #0b3563;
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-settings-save:hover {
        background: #082847;
        color: #fff;
    }

    .btn-settings-cancel {
        background: #f8fafc;
        color: #334155;
        border: 1px solid #dbe4ef;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
    }

    @media (max-width: 1100px) {
        .settings-layout {
            grid-template-columns: 1fr;
        }

        .side-card {
            position: relative;
            top: auto;
        }
    }

    @media (max-width: 768px) {
        .option-grid {
            grid-template-columns: 1fr;
        }

        .settings-hero {
            padding: 18px;
        }

        .content-card {
            padding: 16px;
        }
    }
</style>

<div class="settings-page">
<H3>settings </H3>
    <div class="settings-hero">
        <div class="settings-hero-title">{{ __('emis.settings') }}</div>
        <p class="settings-hero-subtitle">
            {{ __('emis.manage_system_preferences') ?? 'Configure core system preferences, security, notifications, branding, and organization details.' }}
        </p>
    </div>
<h1>System Settings</h1>
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="settings-layout">

            {{-- LEFT PANEL --}}
            <div class="side-card">
                <div class="system-badge">
                    <i class="fa-solid fa-sliders"></i>
                </div>

                <div class="side-title">{{ $settings->system_short_name ?? 'EMIS' }}</div>
                <div class="side-subtitle">
                    {{ $settings->system_name ?? 'Executive Management Information System' }}
                </div>

                <div class="mini-stat">
                    <div class="mini-stat-label">{{ __('emis.language') }}</div>
                    <div class="mini-stat-value">{{ strtoupper($settings->default_language ?? app()->getLocale()) }}</div>
                </div>

                <div class="mini-stat">
                    <div class="mini-stat-label">{{ __('emis.timezone') ?? 'Timezone' }}</div>
                    <div class="mini-stat-value">{{ $settings->timezone ?? 'Asia/Kabul' }}</div>
                </div>

                <div class="mini-stat">
                    <div class="mini-stat-label">{{ __('emis.date_format') ?? 'Date Format' }}</div>
                    <div class="mini-stat-value">{{ $settings->date_format ?? 'Y-m-d' }}</div>
                </div>

                <div class="mini-stat">
                    <div class="mini-stat-label">{{ __('emis.organization') ?? 'Organization' }}</div>
                    <div class="mini-stat-value">{{ $settings->organization_name ?? '-' }}</div>
                </div>

                <div class="mini-stat">
                    <div class="mini-stat-label">{{ __('emis.department') }}</div>
                    <div class="mini-stat-value">{{ $settings->department_name ?? '-' }}</div>
                </div>
            </div>

            {{-- RIGHT PANEL --}}
            <div class="settings-sections">

                {{-- General --}}
                <div class="content-card">
                    <div class="section-header">
                        <div class="section-icon"><i class="fa-solid fa-gear"></i></div>
                        <div>
                            <div class="section-title">{{ __('emis.general_settings') ?? 'General Settings' }}</div>
                            <p class="section-subtitle">{{ __('emis.general_settings_desc') ?? 'Basic system identity and interface defaults.' }}</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('emis.system_name') }}</label>
                            <input type="text" name="system_name" class="form-control" value="{{ old('system_name', $settings->system_name ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">{{ __('emis.system_short_name') }}</label>
                            <input type="text" name="system_short_name" class="form-control" value="{{ old('system_short_name', $settings->system_short_name ?? '') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">{{ __('emis.language') }}</label>
                            <select name="default_language" class="form-select">
                                <option value="en" {{ old('default_language', $settings->default_language ?? app()->getLocale()) == 'en' ? 'selected' : '' }}>English</option>
                                <option value="ps" {{ old('default_language', $settings->default_language ?? app()->getLocale()) == 'ps' ? 'selected' : '' }}>پښتو</option>
                                <option value="fa" {{ old('default_language', $settings->default_language ?? app()->getLocale()) == 'fa' ? 'selected' : '' }}>دری</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">{{ __('emis.timezone') ?? 'Timezone' }}</label>
                            <input type="text" name="timezone" class="form-control" value="{{ old('timezone', $settings->timezone ?? 'Asia/Kabul') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">{{ __('emis.date_format') ?? 'Date Format' }}</label>
                            <select name="date_format" class="form-select">
                                <option value="Y-m-d" {{ old('date_format', $settings->date_format ?? '') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                <option value="d-m-Y" {{ old('date_format', $settings->date_format ?? '') == 'd-m-Y' ? 'selected' : '' }}>DD-MM-YYYY</option>
                                <option value="d/m/Y" {{ old('date_format', $settings->date_format ?? '') == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">{{ __('emis.description') }}</label>
                            <textarea name="system_description" class="form-control">{{ old('system_description', $settings->system_description ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Organization --}}
                <div class="content-card">
                    <div class="section-header">
                        <div class="section-icon"><i class="fa-solid fa-building-columns"></i></div>
                        <div>
                            <div class="section-title">{{ __('emis.organization') ?? 'Organization' }}</div>
                            <p class="section-subtitle">{{ __('emis.organization_desc') ?? 'Institutional and contact details for the system.' }}</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('emis.organization_name') ?? 'Organization Name' }}</label>
                            <input type="text" name="organization_name" class="form-control" value="{{ old('organization_name', $settings->organization_name ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">{{ __('emis.department') }}</label>
                            <input type="text" name="department_name" class="form-control" value="{{ old('department_name', $settings->department_name ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">{{ __('emis.email') }}</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings->contact_email ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">{{ __('emis.phone') ?? 'Phone' }}</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings->contact_phone ?? '') }}">
                        </div>
                    </div>
                </div>

                {{-- Feature Options --}}
                <div class="content-card">
                    <div class="section-header">
                        <div class="section-icon"><i class="fa-solid fa-layer-group"></i></div>
                        <div>
                            <div class="section-title">{{ __('emis.system_configuration') ?? 'System Configuration' }}</div>
                            <p class="section-subtitle">{{ __('emis.system_configuration_desc') ?? 'Control major system modules and operational behavior.' }}</p>
                        </div>
                    </div>

                    <div class="option-grid">
                        <div class="option-box">
                            <div class="option-box-title">{{ __('emis.documents') }}</div>
                            <div class="option-box-text">{{ __('emis.enable_document_tracking_desc') ?? 'Track incoming and outgoing document flow.' }}</div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="enable_document_tracking" value="1"
                                    {{ old('enable_document_tracking', $settings->enable_document_tracking ?? false) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="option-box">
                            <div class="option-box-title">{{ __('emis.tasks_management') }}</div>
                            <div class="option-box-text">{{ __('emis.enable_task_notifications_desc') ?? 'Enable task alerts and reminders.' }}</div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="enable_task_notifications" value="1"
                                    {{ old('enable_task_notifications', $settings->enable_task_notifications ?? false) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="option-box">
                            <div class="option-box-title">{{ __('emis.notifications') }}</div>
                            <div class="option-box-text">{{ __('emis.browser_notifications_desc') ?? 'Show browser and in-system notifications.' }}</div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="browser_notifications" value="1"
                                    {{ old('browser_notifications', $settings->browser_notifications ?? false) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="option-box">
                            <div class="option-box-title">{{ __('emis.users') ?? 'Users' }}</div>
                            <div class="option-box-text">{{ __('emis.enable_user_registration_desc') ?? 'Allow administrators to add new users.' }}</div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="enable_user_registration" value="1"
                                    {{ old('enable_user_registration', $settings->enable_user_registration ?? false) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Security and Notifications --}}
                <div class="content-card">
                    <div class="section-header">
                        <div class="section-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <div>
                            <div class="section-title">{{ __('emis.security') ?? 'Security & Notifications' }}</div>
                            <p class="section-subtitle">{{ __('emis.security_settings_desc') ?? 'Configure security policy and notification channels.' }}</p>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('emis.minimum_password_length') ?? 'Minimum Password Length' }}</label>
                            <input type="number" name="password_min_length" class="form-control" value="{{ old('password_min_length', $settings->password_min_length ?? 8) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">{{ __('emis.session_timeout') ?? 'Session Timeout (minutes)' }}</label>
                            <input type="number" name="session_timeout" class="form-control" value="{{ old('session_timeout', $settings->session_timeout ?? 30) }}">
                        </div>
                    </div>

                    <div class="setting-line">
                        <div>
                            <h6>{{ __('emis.email_notifications') ?? 'Email Notifications' }}</h6>
                            <p>{{ __('emis.email_notifications_desc') ?? 'Send important alerts by email.' }}</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="email_notifications" value="1"
                                {{ old('email_notifications', $settings->email_notifications ?? false) ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="setting-line">
                        <div>
                            <h6>{{ __('emis.maintenance_mode') ?? 'Maintenance Mode' }}</h6>
                            <p>{{ __('emis.maintenance_mode_desc') ?? 'Temporarily disable or limit system access.' }}</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1"
                                {{ old('maintenance_mode', $settings->maintenance_mode ?? false) ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="setting-line">
                        <div>
                            <h6>{{ __('emis.debug_mode') ?? 'Debug Mode' }}</h6>
                            <p>{{ __('emis.debug_mode_desc') ?? 'Use only for troubleshooting and testing.' }}</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="debug_mode" value="1"
                                {{ old('debug_mode', $settings->debug_mode ?? false) ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>

                {{-- Branding --}}
                <div class="content-card">
                    <div class="section-header">
                        <div class="section-icon"><i class="fa-solid fa-image"></i></div>
                        <div>
                            <div class="section-title">{{ __('emis.branding') ?? 'Branding' }}</div>
                            <p class="section-subtitle">{{ __('emis.branding_settings_desc') ?? 'Upload logo and define visual identity.' }}</p>
                        </div>
                    </div>

                    @if(!empty($settings->logo_path))
                        <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Logo" class="current-logo">
                    @endif

                    <div class="logo-box">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p>{{ __('emis.upload_logo_hint') ?? 'Upload official EMIS or ministry logo.' }}</p>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">{{ __('emis.logo') ?? 'Logo' }}</label>
                        <input type="file" name="logo" class="form-control">
                    </div>
                </div>

                <div class="settings-footer">
                    <button type="reset" class="btn-settings-cancel">{{ __('emis.cancel') }}</button>
                    <button type="submit" class="btn-settings-save">{{ __('emis.save') }}</button>
                </div>

            </div>
        </div>
    </form>
</div>

@endsection