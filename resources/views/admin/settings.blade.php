@extends('new')
@section('title', __('emis.settings') . ' | ' . config('app.name'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('emis.dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('emis.settings') }}</li>
@endsection
@section('page_title', __('emis.settings'))

@section('content')

<style>
    :root {
        --bg-card: #ffffff;
        --border-card: #e2e8f0;
        --text-primary: #0f172a;
        --text-secondary: #64748b;
        --brand: #0b3563;
        --brand-soft: #eff6ff;
        --surface: #f8fafc;
    }

    .settings-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 1.5rem 1rem;
    }

    .settings-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }

    .settings-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .settings-subtitle {
        max-width: 760px;
        font-size: 1rem;
        color: var(--text-secondary);
        margin-top: 0.5rem;
        line-height: 1.7;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 1.5rem;
    }

    .settings-sidebar,
    .settings-card {
        background: var(--bg-card);
        border: 1px solid var(--border-card);
        border-radius: 1.25rem;
        box-shadow: 0 14px 32px rgba(15, 23, 42, 0.06);
    }

    .settings-sidebar {
        padding: 1.25rem;
        position: sticky;
        top: 80px;
    }

    .settings-nav {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .settings-nav li + li {
        margin-top: 0.75rem;
    }

    .settings-nav a {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 0.75rem;
        align-items: center;
        padding: 0.95rem 1rem;
        border-radius: 0.85rem;
        color: var(--text-primary);
        text-decoration: none;
        transition: 0.2s ease;
        font-size: 0.95rem;
        font-weight: 600;
    }

    .settings-nav a:hover,
    .settings-nav a.active {
        background: var(--brand-soft);
        color: var(--brand);
    }

    .settings-content {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .settings-card {
        padding: 1.5rem;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.35rem;
    }

    .card-subtitle {
        font-size: 0.95rem;
        color: var(--text-secondary);
        margin-bottom: 1.25rem;
    }

    .settings-form {
        display: grid;
        gap: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .form-control,
    .form-select,
    textarea.form-control {
        width: 100%;
        border-radius: 0.85rem;
        min-height: 3rem;
        border: 1px solid #cbd5e1;
        box-shadow: none;
        padding: 0.9rem 1rem;
        color: var(--text-primary);
        background: #ffffff;
    }

    .form-control:focus,
    .form-select:focus,
    textarea.form-control:focus {
        border-color: var(--brand);
        outline: none;
        box-shadow: 0 0 0 3px rgba(11, 53, 99, 0.12);
    }

    textarea.form-control {
        min-height: 10rem;
        resize: vertical;
    }

    .field-grid {
        display: grid;
        gap: 1rem;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .settings-switch {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .settings-switch:last-child {
        border-bottom: none;
    }

    .switch-text h6 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .switch-text p {
        margin: 0;
        font-size: 0.88rem;
        color: var(--text-secondary);
    }

    .form-check {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .form-check-input {
        width: 50px;
        height: 28px;
        cursor: pointer;
    }

    .settings-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .btn-emis-primary {
        background: var(--brand);
        color: #fff;
        border: none;
        padding: 0.95rem 1.4rem;
        border-radius: 0.85rem;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-emis-primary:hover {
        background: #082847;
    }

    .btn-emis-light {
        background: var(--surface);
        color: var(--text-primary);
        border: 1px solid #cbd5e1;
        padding: 0.95rem 1.4rem;
        border-radius: 0.85rem;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
    }

    .info-badges {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .info-badge {
        background: var(--surface);
        border: 1px solid var(--border-card);
        border-radius: 1rem;
        padding: 1rem;
    }

    .info-badge .label {
        font-size: 0.82rem;
        color: var(--text-secondary);
        margin-bottom: 0.4rem;
    }

    .info-badge .value {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .upload-box {
        border: 2px dashed #cbd5e1;
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        background: var(--surface);
    }

    .upload-box i {
        font-size: 1.5rem;
        color: var(--brand);
        margin-bottom: 0.8rem;
    }

    .upload-box p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    @media (max-width: 992px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }

        .settings-sidebar {
            position: relative;
            top: auto;
        }

        .field-grid {
            grid-template-columns: 1fr;
        }

        .info-badges {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="settings-wrapper">

    <div class="settings-header">
        <div>
            <h2 class="settings-title">{{ __('emis.settings') }}</h2>
            <p class="settings-subtitle">
                {{ __('emis.manage_system_preferences') ?? 'Manage system preferences, user access, notifications, branding, and localization from one centralized dashboard.' }}
            </p>
        </div>
    </div>

    <div class="settings-grid">

        <aside class="settings-sidebar" aria-label="{{ __('emis.settings_navigation') }}">
            <ul class="settings-nav">
                <li><a href="#general" class="active"><i class="fa-solid fa-gear"></i> {{ __('emis.general_settings') ?? 'General Settings' }}</a></li>
                <li><a href="#profile"><i class="fa-solid fa-user"></i> {{ __('emis.profile') }}</a></li>
                <li><a href="#system"><i class="fa-solid fa-sliders"></i> {{ __('emis.system_configuration') ?? 'System Configuration' }}</a></li>
                <li><a href="#notifications"><i class="fa-solid fa-bell"></i> {{ __('emis.notifications') }}</a></li>
                <li><a href="#security"><i class="fa-solid fa-shield-halved"></i> {{ __('emis.security') ?? 'Security' }}</a></li>
                <li><a href="#branding"><i class="fa-solid fa-image"></i> {{ __('emis.branding') ?? 'Branding' }}</a></li>
            </ul>
        </aside>

        <main class="settings-content">

            <form class="settings-form" method="POST" action="{{ route('admin.settings.update') ?? '#' }}" enctype="multipart/form-data">
                @csrf
                @if(Route::has('admin.settings.update'))
                    @method('PUT')
                @endif

                <section class="settings-card" id="general">
                    <div class="card-title">{{ __('emis.general_settings') ?? 'General Settings' }}</div>
                    <div class="card-subtitle">{{ __('emis.general_settings_desc') ?? 'Update system identity, localization and default interface settings.' }}</div>

                    <div class="field-grid">
                        <div>
                            <label for="system_name" class="form-label">{{ __('emis.system_name') }}</label>
                            <input id="system_name" type="text" name="system_name" class="form-control"
                                   value="{{ old('system_name', $settings->system_name ?? 'Executive Management Information System') }}">
                        </div>

                        <div>
                            <label for="system_short_name" class="form-label">{{ __('emis.system_short_name') }}</label>
                            <input id="system_short_name" type="text" name="system_short_name" class="form-control"
                                   value="{{ old('system_short_name', $settings->system_short_name ?? 'EMIS') }}">
                        </div>

                        <div>
                            <label for="default_language" class="form-label">{{ __('emis.language') }}</label>
                            <select id="default_language" name="default_language" class="form-select">
                                <option value="en" {{ old('default_language', $settings->default_language ?? app()->getLocale()) == 'en' ? 'selected' : '' }}>English</option>
                                <option value="ps" {{ old('default_language', $settings->default_language ?? app()->getLocale()) == 'ps' ? 'selected' : '' }}>پښتو</option>
                                <option value="fa" {{ old('default_language', $settings->default_language ?? app()->getLocale()) == 'fa' ? 'selected' : '' }}>دری</option>
                            </select>
                        </div>

                        <div>
                            <label for="timezone" class="form-label">{{ __('emis.timezone') ?? 'Timezone' }}</label>
                            <input id="timezone" type="text" name="timezone" class="form-control"
                                   value="{{ old('timezone', $settings->timezone ?? 'Asia/Kabul') }}"
                                   placeholder="Asia/Kabul">
                        </div>

                        <div>
                            <label for="date_format" class="form-label">{{ __('emis.date_format') ?? 'Date Format' }}</label>
                            <select id="date_format" name="date_format" class="form-select">
                                <option value="Y-m-d" {{ old('date_format', $settings->date_format ?? 'Y-m-d') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                <option value="d-m-Y" {{ old('date_format', $settings->date_format ?? '') == 'd-m-Y' ? 'selected' : '' }}>DD-MM-YYYY</option>
                                <option value="d/m/Y" {{ old('date_format', $settings->date_format ?? '') == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                            </select>
                        </div>

                        <div>
                            <label for="number_format" class="form-label">{{ __('emis.number_format') ?? 'Number Format' }}</label>
                            <select id="number_format" name="number_format" class="form-select">
                                <option value="1,234.56" {{ old('number_format', $settings->number_format ?? '1,234.56') == '1,234.56' ? 'selected' : '' }}>1,234.56</option>
                                <option value="1.234,56" {{ old('number_format', $settings->number_format ?? '') == '1.234,56' ? 'selected' : '' }}>1.234,56</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="system_description" class="form-label">{{ __('emis.description') }}</label>
                        <textarea id="system_description" name="system_description" class="form-control">{{ old('system_description', $settings->system_description ?? '') }}</textarea>
                    </div>
                </section>

                <section class="settings-card" id="profile">
                    <div class="card-title">{{ __('emis.profile') }}</div>
                    <div class="card-subtitle">{{ __('emis.profile_settings_desc') ?? 'Review the current administrator profile and access role.' }}</div>

                    <div class="info-badges">
                        <div class="info-badge">
                            <div class="label">{{ __('emis.name') }}</div>
                            <div class="value">{{ auth()->user()->name ?? 'Admin User' }}</div>
                        </div>
                        <div class="info-badge">
                            <div class="label">{{ __('emis.email') }}</div>
                            <div class="value">{{ auth()->user()->email ?? 'admin@example.com' }}</div>
                        </div>
                        <div class="info-badge">
                            <div class="label">{{ __('emis.roles') }}</div>
                            <div class="value">{{ auth()->user()->role->display_name ?? auth()->user()->role->name ?? 'Administrator' }}</div>
                        </div>
                    </div>
                </section>

                <section class="settings-card" id="system">
                    <div class="card-title">{{ __('emis.system_configuration') ?? 'System Configuration' }}</div>
                    <div class="card-subtitle">{{ __('emis.system_configuration_desc') ?? 'Control core behavior, user access and automated workflows.' }}</div>

                    <div class="settings-switch">
                        <div class="switch-text">
                            <h6>{{ __('emis.enable_user_registration') ?? 'Enable User Registration' }}</h6>
                            <p>{{ __('emis.enable_user_registration_desc') ?? 'Allow administrators to register new system users.' }}</p>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="enable_user_registration" value="0">
                            <input class="form-check-input" type="checkbox" id="enable_user_registration" name="enable_user_registration" value="1" {{ old('enable_user_registration', $settings->enable_user_registration ?? true) ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="settings-switch">
                        <div class="switch-text">
                            <h6>{{ __('emis.enable_task_notifications') ?? 'Enable Task Notifications' }}</h6>
                            <p>{{ __('emis.enable_task_notifications_desc') ?? 'Send reminders for new, updated, and overdue tasks.' }}</p>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="enable_task_notifications" value="0">
                            <input class="form-check-input" type="checkbox" id="enable_task_notifications" name="enable_task_notifications" value="1" {{ old('enable_task_notifications', $settings->enable_task_notifications ?? true) ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="settings-switch">
                        <div class="switch-text">
                            <h6>{{ __('emis.enable_document_tracking') ?? 'Enable Document Tracking' }}</h6>
                            <p>{{ __('emis.enable_document_tracking_desc') ?? 'Track incoming and outgoing document movement.' }}</p>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="enable_document_tracking" value="0">
                            <input class="form-check-input" type="checkbox" id="enable_document_tracking" name="enable_document_tracking" value="1" {{ old('enable_document_tracking', $settings->enable_document_tracking ?? true) ? 'checked' : '' }}>
                        </div>
                    </div>
                </section>

                <section class="settings-card" id="notifications">
                    <div class="card-title">{{ __('emis.notifications') }}</div>
                    <div class="card-subtitle">{{ __('emis.notification_settings_desc') ?? 'Choose which system alerts and reminders are active.' }}</div>

                    <div class="settings-switch">
                        <div class="switch-text">
                            <h6>{{ __('emis.email_notifications') ?? 'Email Notifications' }}</h6>
                            <p>{{ __('emis.email_notifications_desc') ?? 'Receive email alerts for important actions.' }}</p>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="email_notifications" value="0">
                            <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" value="1" {{ old('email_notifications', $settings->email_notifications ?? false) ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="settings-switch">
                        <div class="switch-text">
                            <h6>{{ __('emis.browser_notifications') ?? 'Browser Notifications' }}</h6>
                            <p>{{ __('emis.browser_notifications_desc') ?? 'Show alerts directly inside the dashboard.' }}</p>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="browser_notifications" value="0">
                            <input class="form-check-input" type="checkbox" id="browser_notifications" name="browser_notifications" value="1" {{ old('browser_notifications', $settings->browser_notifications ?? true) ? 'checked' : '' }}>
                        </div>
                    </div>
                </section>

                <section class="settings-card" id="security">
                    <div class="card-title">{{ __('emis.security') ?? 'Security' }}</div>
                    <div class="card-subtitle">{{ __('emis.security_settings_desc') ?? 'Manage password policy and administrative protection settings.' }}</div>

                    <div class="field-grid">
                        <div>
                            <label for="password_min_length" class="form-label">{{ __('emis.minimum_password_length') ?? 'Minimum Password Length' }}</label>
                            <input id="password_min_length" type="number" name="password_min_length" class="form-control" min="6" value="{{ old('password_min_length', $settings->password_min_length ?? 8) }}">
                        </div>

                        <div>
                            <label for="session_timeout" class="form-label">{{ __('emis.session_timeout') ?? 'Session Timeout (minutes)' }}</label>
                            <input id="session_timeout" type="number" name="session_timeout" class="form-control" min="5" value="{{ old('session_timeout', $settings->session_timeout ?? 30) }}">
                        </div>
                    </div>
                </section>

                <section class="settings-card" id="branding">
                    <div class="card-title">{{ __('emis.branding') ?? 'Branding' }}</div>
                    <div class="card-subtitle">{{ __('emis.branding_settings_desc') ?? 'Update system logo and display identity.' }}</div>

                    <div class="upload-box">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p>{{ __('emis.upload_logo_hint') ?? 'Upload official EMIS or ministry logo here.' }}</p>
                        <input type="file" name="logo" class="form-control" accept="image/png,image/jpeg,image/svg+xml" style="margin-top:1rem; border:none; padding:0;">
                    </div>
                </section>

                <div class="settings-actions">
                    <button type="reset" class="btn-emis-light">{{ __('emis.cancel') }}</button>
                    <button type="submit" class="btn-emis-primary">{{ __('emis.save') }}</button>
                </div>
            </form>

        </main>
    </div>
</div>

@endsection