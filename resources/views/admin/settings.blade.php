@extends('new')

@section('page_title', __('emis.settings'))

@section('content')

<style>
    .settings-shell {
        max-width: 1450px;
        margin: 0 auto;
    }

    .settings-topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .settings-heading h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .settings-heading p {
        margin: 4px 0 0;
        font-size: 13px;
        color: #64748b;
    }

    .settings-summary {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .summary-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .summary-card h6 {
        margin: 0;
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
    }

    .summary-card h4 {
        margin: 6px 0 0;
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
    }

    .summary-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #fff;
    }

    .bg-primary-emis { background: #0b3563; }
    .bg-green-emis { background: #16a34a; }
    .bg-orange-emis { background: #ea580c; }
    .bg-red-emis { background: #dc2626; }

    .settings-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .settings-panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .panel-head {
        padding: 18px 20px;
        border-bottom: 1px solid #eef2f7;
        background: #f8fafc;
    }

    .panel-head h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }

    .panel-head p {
        margin: 4px 0 0;
        font-size: 12px;
        color: #64748b;
    }

    .panel-body {
        padding: 20px;
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

    .form-control:focus,
    .form-select:focus {
        border-color: #0b3563;
    }

    textarea.form-control {
        min-height: 110px;
        resize: vertical;
    }

    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 14px 0;
        border-bottom: 1px solid #eef2f7;
    }

    .setting-item:last-child {
        border-bottom: none;
    }

    .setting-item h6 {
        margin: 0 0 4px;
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
    }

    .setting-item p {
        margin: 0;
        font-size: 12px;
        color: #64748b;
    }

    .form-check-input {
        width: 46px;
        height: 24px;
        cursor: pointer;
    }

    .branding-box {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 22px;
        text-align: center;
        background: #f8fafc;
    }

    .branding-box i {
        font-size: 26px;
        color: #0b3563;
        margin-bottom: 10px;
    }

    .branding-box p {
        margin: 0;
        font-size: 12px;
        color: #64748b;
    }

    .current-logo {
        max-width: 180px;
        max-height: 80px;
        object-fit: contain;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 6px;
        background: #fff;
        margin-bottom: 14px;
    }

    .actions-bar {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 22px;
        flex-wrap: wrap;
    }

    .btn-emis-save {
        background: #0b3563;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-emis-save:hover {
        background: #082847;
        color: #fff;
    }

    .btn-emis-cancel {
        background: #f8fafc;
        color: #334155;
        border: 1px solid #dbe4ef;
        border-radius: 12px;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 600;
    }

    @media (max-width: 1200px) {
        .settings-summary {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .settings-summary {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="settings-shell">

    <div class="settings-topbar">
        <div class="settings-heading">
            <h2>{{ __('emis.settings') }}</h2>
            <p>{{ __('emis.manage_system_preferences') ?? 'Manage system identity, organization details, notifications, security, and branding.' }}</p>
        </div>
    </div>

    <div class="settings-summary">
        <div class="summary-card">
            <div>
                <h6>{{ __('emis.system_short_name') }}</h6>
                <h4>{{ $settings->system_short_name ?? 'EMIS' }}</h4>
            </div>
            <div class="summary-icon bg-primary-emis">
                <i class="fa-solid fa-desktop"></i>
            </div>
        </div>

        <div class="summary-card">
            <div>
                <h6>{{ __('emis.language') }}</h6>
                <h4>{{ strtoupper($settings->default_language ?? app()->getLocale()) }}</h4>
            </div>
            <div class="summary-icon bg-green-emis">
                <i class="fa-solid fa-language"></i>
            </div>
        </div>

        <div class="summary-card">
            <div>
                <h6>{{ __('emis.timezone') ?? 'Timezone' }}</h6>
                <h4>{{ $settings->timezone ?? 'Asia/Kabul' }}</h4>
            </div>
            <div class="summary-icon bg-orange-emis">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>

        <div class="summary-card">
            <div>
                <h6>{{ __('emis.department') }}</h6>
                <h4>{{ $settings->department_name ?? '-' }}</h4>
            </div>
            <div class="summary-icon bg-red-emis">
                <i class="fa-solid fa-building"></i>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="settings-grid">

            {{-- LEFT COLUMN --}}
            <div class="d-flex flex-column gap-4">

                <div class="settings-panel">
                    <div class="panel-head">
                        <h5>{{ __('emis.general_settings') ?? 'General Settings' }}</h5>
                        <p>{{ __('emis.general_settings_desc') ?? 'System identity and primary configuration values.' }}</p>
                    </div>
                    <div class="panel-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">{{ __('emis.system_name') }}</label>
                                <input type="text" name="system_name" class="form-control"
                                       value="{{ old('system_name', $settings->system_name ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('emis.system_short_name') }}</label>
                                <input type="text" name="system_short_name" class="form-control"
                                       value="{{ old('system_short_name', $settings->system_short_name ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('emis.language') }}</label>
                                <select name="default_language" class="form-select">
                                    <option value="en" {{ old('default_language', $settings->default_language ?? app()->getLocale()) == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="ps" {{ old('default_language', $settings->default_language ?? app()->getLocale()) == 'ps' ? 'selected' : '' }}>پښتو</option>
                                    <option value="fa" {{ old('default_language', $settings->default_language ?? app()->getLocale()) == 'fa' ? 'selected' : '' }}>دری</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('emis.timezone') ?? 'Timezone' }}</label>
                                <input type="text" name="timezone" class="form-control"
                                       value="{{ old('timezone', $settings->timezone ?? 'Asia/Kabul') }}">
                            </div>

                            <div class="col-md-6">
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
                </div>

                <div class="settings-panel">
                    <div class="panel-head">
                        <h5>{{ __('emis.organization') ?? 'Organization' }}</h5>
                        <p>{{ __('emis.organization_desc') ?? 'Institutional contact and department information.' }}</p>
                    </div>
                    <div class="panel-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('emis.organization_name') ?? 'Organization Name' }}</label>
                                <input type="text" name="organization_name" class="form-control"
                                       value="{{ old('organization_name', $settings->organization_name ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('emis.department') }}</label>
                                <input type="text" name="department_name" class="form-control"
                                       value="{{ old('department_name', $settings->department_name ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('emis.email') }}</label>
                                <input type="email" name="contact_email" class="form-control"
                                       value="{{ old('contact_email', $settings->contact_email ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('emis.phone') ?? 'Phone' }}</label>
                                <input type="text" name="contact_phone" class="form-control"
                                       value="{{ old('contact_phone', $settings->contact_phone ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="d-flex flex-column gap-4">

                <div class="settings-panel">
                    <div class="panel-head">
                        <h5>{{ __('emis.system_configuration') ?? 'System Configuration' }}</h5>
                        <p>{{ __('emis.system_configuration_desc') ?? 'Enable or disable important system functions.' }}</p>
                    </div>
                    <div class="panel-body">

                        <div class="setting-item">
                            <div>
                                <h6>{{ __('emis.enable_user_registration') ?? 'Enable User Registration' }}</h6>
                                <p>{{ __('emis.enable_user_registration_desc') ?? 'Allow administrators to add and manage new users.' }}</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="enable_user_registration" value="1"
                                    {{ old('enable_user_registration', $settings->enable_user_registration ?? false) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="setting-item">
                            <div>
                                <h6>{{ __('emis.enable_task_notifications') ?? 'Enable Task Notifications' }}</h6>
                                <p>{{ __('emis.enable_task_notifications_desc') ?? 'Send notifications and reminders for task workflow.' }}</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="enable_task_notifications" value="1"
                                    {{ old('enable_task_notifications', $settings->enable_task_notifications ?? false) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="setting-item">
                            <div>
                                <h6>{{ __('emis.enable_document_tracking') ?? 'Enable Document Tracking' }}</h6>
                                <p>{{ __('emis.enable_document_tracking_desc') ?? 'Track incoming and outgoing document movement.' }}</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="enable_document_tracking" value="1"
                                    {{ old('enable_document_tracking', $settings->enable_document_tracking ?? false) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="setting-item">
                            <div>
                                <h6>{{ __('emis.browser_notifications') ?? 'Browser Notifications' }}</h6>
                                <p>{{ __('emis.browser_notifications_desc') ?? 'Display system alerts inside the interface.' }}</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="browser_notifications" value="1"
                                    {{ old('browser_notifications', $settings->browser_notifications ?? false) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="setting-item">
                            <div>
                                <h6>{{ __('emis.email_notifications') ?? 'Email Notifications' }}</h6>
                                <p>{{ __('emis.email_notifications_desc') ?? 'Send important alerts via email.' }}</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="email_notifications" value="1"
                                    {{ old('email_notifications', $settings->email_notifications ?? false) ? 'checked' : '' }}>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="settings-panel">
                    <div class="panel-head">
                        <h5>{{ __('emis.security') ?? 'Security & Branding' }}</h5>
                        <p>{{ __('emis.security_settings_desc') ?? 'Security policy, session rules, and system identity.' }}</p>
                    </div>
                    <div class="panel-body">

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('emis.minimum_password_length') ?? 'Minimum Password Length' }}</label>
                                <input type="number" name="password_min_length" class="form-control"
                                       value="{{ old('password_min_length', $settings->password_min_length ?? 8) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('emis.session_timeout') ?? 'Session Timeout' }}</label>
                                <input type="number" name="session_timeout" class="form-control"
                                       value="{{ old('session_timeout', $settings->session_timeout ?? 30) }}">
                            </div>
                        </div>

                        <div class="setting-item">
                            <div>
                                <h6>{{ __('emis.maintenance_mode') ?? 'Maintenance Mode' }}</h6>
                                <p>{{ __('emis.maintenance_mode_desc') ?? 'Temporarily restrict system access for maintenance.' }}</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1"
                                    {{ old('maintenance_mode', $settings->maintenance_mode ?? false) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="setting-item">
                            <div>
                                <h6>{{ __('emis.debug_mode') ?? 'Debug Mode' }}</h6>
                                <p>{{ __('emis.debug_mode_desc') ?? 'Enable detailed application debugging for administrators.' }}</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="debug_mode" value="1"
                                    {{ old('debug_mode', $settings->debug_mode ?? false) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <hr class="my-4">

                        @if(!empty($settings->logo_path))
                            <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Logo" class="current-logo">
                        @endif

                        <div class="branding-box">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <p>{{ __('emis.upload_logo_hint') ?? 'Upload official EMIS or ministry logo here.' }}</p>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">{{ __('emis.logo') ?? 'Logo' }}</label>
                            <input type="file" name="logo" class="form-control">
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="actions-bar">
            <button type="reset" class="btn-emis-cancel">{{ __('emis.cancel') }}</button>
            <button type="submit" class="btn-emis-save">{{ __('emis.save') }}</button>
        </div>
    </form>
</div>

@endsection