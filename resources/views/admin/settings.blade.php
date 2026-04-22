@extends('new')

@section('page_title', __('emis.settings'))

@section('content')

<style>
    .settings-page {
        max-width: 1450px;
        margin: 0 auto;
    }

    .settings-header {
        margin-bottom: 20px;
    }

    .settings-title {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .settings-subtitle {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 0;
    }

    .settings-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 18px;
    }

    .strip-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .strip-card h6 {
        margin: 0;
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
    }

    .strip-card h4 {
        margin: 6px 0 0;
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
    }

    .strip-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 19px;
    }

    .bg-blue { background: #0b3563; }
    .bg-green { background: #16a34a; }
    .bg-orange { background: #ea580c; }
    .bg-red { background: #dc2626; }

    .settings-section {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .section-head {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 22px;
        border-bottom: 1px solid #eef2f7;
        background: #f8fafc;
    }

    .section-head-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #eaf2ff;
        color: #0b3563;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .section-head h5 {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #1e293b;
    }

    .section-head p {
        margin: 3px 0 0;
        font-size: 12px;
        color: #64748b;
    }

    .section-body {
        padding: 22px;
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

    .horizontal-options {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .option-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px;
        background: #fcfdff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 150px;
    }

    .option-card h6 {
        margin: 0 0 6px;
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
    }

    .option-card p {
        margin: 0 0 14px;
        font-size: 12px;
        color: #64748b;
    }

    .option-card .form-check {
        margin-top: auto;
    }

    .form-check-input {
        width: 46px;
        height: 24px;
        cursor: pointer;
    }

    .branding-row {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 20px;
        align-items: start;
    }

    .logo-preview {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 18px;
        padding: 18px;
        text-align: center;
        min-height: 180px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .logo-preview i {
        font-size: 26px;
        color: #0b3563;
        margin-bottom: 10px;
    }

    .logo-preview p {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }

    .current-logo {
        max-width: 160px;
        max-height: 80px;
        object-fit: contain;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 6px;
        background: #fff;
        margin-bottom: 10px;
    }

    .actions-bar {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 18px;
        flex-wrap: wrap;
    }

    .btn-settings-save {
        background: #0b3563;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 10px 18px;
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
        border-radius: 12px;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 600;
    }

    @media (max-width: 1200px) {
        .settings-strip {
            grid-template-columns: repeat(2, 1fr);
        }

        .horizontal-options {
            grid-template-columns: repeat(2, 1fr);
        }

        .branding-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .settings-strip,
        .horizontal-options {
            grid-template-columns: 1fr;
        }

        .section-body {
            padding: 16px;
        }
    }
</style>

<div class="settings-page">

    <div class="settings-header">
        <div class="settings-title">{{ __('emis.settings') }}</div>
        <p class="settings-subtitle">
            {{ __('emis.manage_system_preferences') ?? 'Manage system identity, organization information, security controls, notifications, and branding.' }}
        </p>
    </div>

    <div class="settings-strip">
        <div class="strip-card">
            <div>
                <h6>{{ __('emis.system_short_name') }}</h6>
                <h4>{{ $settings->system_short_name ?? 'EMIS' }}</h4>
            </div>
            <div class="strip-icon bg-blue">
                <i class="fa-solid fa-desktop"></i>
            </div>
        </div>

        <div class="strip-card">
            <div>
                <h6>{{ __('emis.language') }}</h6>
                <h4>{{ strtoupper($settings->default_language ?? app()->getLocale()) }}</h4>
            </div>
            <div class="strip-icon bg-green">
                <i class="fa-solid fa-language"></i>
            </div>
        </div>

        <div class="strip-card">
            <div>
                <h6>{{ __('emis.timezone') ?? 'Timezone' }}</h6>
                <h4>{{ $settings->timezone ?? 'Asia/Kabul' }}</h4>
            </div>
            <div class="strip-icon bg-orange">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>

        <div class="strip-card">
            <div>
                <h6>{{ __('emis.department') }}</h6>
                <h4>{{ $settings->department_name ?? '-' }}</h4>
            </div>
            <div class="strip-icon bg-red">
                <i class="fa-solid fa-building"></i>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Section 1 --}}
        <div class="settings-section">
            <div class="section-head">
                <div class="section-head-icon"><i class="fa-solid fa-gear"></i></div>
                <div>
                    <h5>{{ __('emis.general_settings') ?? 'General Settings' }}</h5>
                    <p>{{ __('emis.general_settings_desc') ?? 'Basic system identity and interface defaults.' }}</p>
                </div>
            </div>

            <div class="section-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('emis.system_name') }}</label>
                        <input type="text" name="system_name" class="form-control" value="{{ old('system_name', $settings->system_name ?? '') }}">
                    </div>

                    <div class="col-md-4">
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

                    <div class="col-md-4">
                        <label class="form-label">{{ __('emis.organization_name') ?? 'Organization Name' }}</label>
                        <input type="text" name="organization_name" class="form-control" value="{{ old('organization_name', $settings->organization_name ?? '') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">{{ __('emis.description') }}</label>
                        <textarea name="system_description" class="form-control">{{ old('system_description', $settings->system_description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2 --}}
        <div class="settings-section">
            <div class="section-head">
                <div class="section-head-icon"><i class="fa-solid fa-building-columns"></i></div>
                <div>
                    <h5>{{ __('emis.organization') ?? 'Organization & Contact' }}</h5>
                    <p>{{ __('emis.organization_desc') ?? 'Department and official contact details.' }}</p>
                </div>
            </div>

            <div class="section-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('emis.department') }}</label>
                        <input type="text" name="department_name" class="form-control" value="{{ old('department_name', $settings->department_name ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">{{ __('emis.email') }}</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings->contact_email ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">{{ __('emis.phone') ?? 'Phone' }}</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings->contact_phone ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3 --}}
        <div class="settings-section">
            <div class="section-head">
                <div class="section-head-icon"><i class="fa-solid fa-layer-group"></i></div>
                <div>
                    <h5>{{ __('emis.system_configuration') ?? 'System Configuration' }}</h5>
                    <p>{{ __('emis.system_configuration_desc') ?? 'Enable and control major modules horizontally.' }}</p>
                </div>
            </div>

            <div class="section-body">
                <div class="horizontal-options">
                    <div class="option-card">
                        <div>
                            <h6>{{ __('emis.enable_user_registration') ?? 'User Registration' }}</h6>
                            <p>{{ __('emis.enable_user_registration_desc') ?? 'Allow user creation and onboarding.' }}</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="enable_user_registration" value="1"
                                {{ old('enable_user_registration', $settings->enable_user_registration ?? false) ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="option-card">
                        <div>
                            <h6>{{ __('emis.enable_task_notifications') ?? 'Task Notifications' }}</h6>
                            <p>{{ __('emis.enable_task_notifications_desc') ?? 'Send reminders and alerts for tasks.' }}</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="enable_task_notifications" value="1"
                                {{ old('enable_task_notifications', $settings->enable_task_notifications ?? false) ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="option-card">
                        <div>
                            <h6>{{ __('emis.enable_document_tracking') ?? 'Document Tracking' }}</h6>
                            <p>{{ __('emis.enable_document_tracking_desc') ?? 'Track incoming and outgoing document flow.' }}</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="enable_document_tracking" value="1"
                                {{ old('enable_document_tracking', $settings->enable_document_tracking ?? false) ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="option-card">
                        <div>
                            <h6>{{ __('emis.browser_notifications') ?? 'Browser Notifications' }}</h6>
                            <p>{{ __('emis.browser_notifications_desc') ?? 'Show alerts inside the interface.' }}</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="browser_notifications" value="1"
                                {{ old('browser_notifications', $settings->browser_notifications ?? false) ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 4 --}}
        <div class="settings-section">
            <div class="section-head">
                <div class="section-head-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div>
                    <h5>{{ __('emis.security') ?? 'Security' }}</h5>
                    <p>{{ __('emis.security_settings_desc') ?? 'Security policy, sessions, and debug controls.' }}</p>
                </div>
            </div>

            <div class="section-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('emis.minimum_password_length') ?? 'Minimum Password Length' }}</label>
                        <input type="number" name="password_min_length" class="form-control" value="{{ old('password_min_length', $settings->password_min_length ?? 8) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">{{ __('emis.session_timeout') ?? 'Session Timeout' }}</label>
                        <input type="number" name="session_timeout" class="form-control" value="{{ old('session_timeout', $settings->session_timeout ?? 30) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">{{ __('emis.email_notifications') ?? 'Email Notifications' }}</label>
                        <select name="email_notifications" class="form-select">
                            <option value="1" {{ old('email_notifications', $settings->email_notifications ?? false) ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ !old('email_notifications', $settings->email_notifications ?? false) ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.maintenance_mode') ?? 'Maintenance Mode' }}</label>
                        <select name="maintenance_mode" class="form-select">
                            <option value="0" {{ !old('maintenance_mode', $settings->maintenance_mode ?? false) ? 'selected' : '' }}>Disabled</option>
                            <option value="1" {{ old('maintenance_mode', $settings->maintenance_mode ?? false) ? 'selected' : '' }}>Enabled</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.debug_mode') ?? 'Debug Mode' }}</label>
                        <select name="debug_mode" class="form-select">
                            <option value="0" {{ !old('debug_mode', $settings->debug_mode ?? false) ? 'selected' : '' }}>Disabled</option>
                            <option value="1" {{ old('debug_mode', $settings->debug_mode ?? false) ? 'selected' : '' }}>Enabled</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 5 --}}
        <div class="settings-section">
            <div class="section-head">
                <div class="section-head-icon"><i class="fa-solid fa-image"></i></div>
                <div>
                    <h5>{{ __('emis.branding') ?? 'Branding' }}</h5>
                    <p>{{ __('emis.branding_settings_desc') ?? 'Upload logo and define visual identity.' }}</p>
                </div>
            </div>

            <div class="section-body">
                <div class="branding-row">
                    <div class="logo-preview">
                        @if(!empty($settings->logo_path))
                            <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Logo" class="current-logo">
                        @endif
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p>{{ __('emis.upload_logo_hint') ?? 'Upload official EMIS or ministry logo here.' }}</p>
                    </div>

                    <div>
                        <label class="form-label">{{ __('emis.logo') ?? 'Logo' }}</label>
                        <input type="file" name="logo" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="actions-bar">
            <button type="reset" class="btn-settings-cancel">{{ __('emis.cancel') }}</button>
            <button type="submit" class="btn-settings-save">{{ __('emis.save') }}</button>
        </div>
    </form>
</div>

@endsection