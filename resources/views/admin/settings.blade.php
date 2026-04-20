@extends('new')

@section('page_title', __('emis.settings'))

@section('content')

<style>
.settings-container {
    max-width: 1400px;
    margin: auto;
}
.settings-header {
    margin-bottom: 20px;
}
.settings-title {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
}
.settings-subtitle {
    font-size: 13px;
    color: #64748b;
}
.settings-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.settings-tab {
    padding: 10px 16px;
    border-radius: 10px;
    background: #f1f5f9;
    cursor: pointer;
    font-weight: 600;
    font-size: 13px;
}
.settings-tab.active {
    background: #0b3563;
    color: white;
}
.settings-card {
    background: white;
    border-radius: 16px;
    padding: 22px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 6px 20px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}
.section-title {
    font-size: 17px;
    font-weight: 700;
    margin-bottom: 4px;
}
.section-subtitle {
    font-size: 12px;
    color: #64748b;
    margin-bottom: 18px;
}
.form-control, .form-select {
    border-radius: 10px;
    min-height: 42px;
}
textarea.form-control {
    min-height: 100px;
}
.setting-row {
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 0;
    border-bottom:1px solid #eef2f7;
    gap: 16px;
}
.setting-row:last-child {
    border:none;
}
.setting-text h6 {
    margin:0;
    font-size:14px;
    font-weight:600;
}
.setting-text p {
    margin:0;
    font-size:12px;
    color:#64748b;
}
.settings-actions {
    display:flex;
    justify-content:flex-end;
    gap:10px;
}
.btn-save {
    background:#0b3563;
    color:white;
    border-radius:10px;
    padding:10px 18px;
    border:none;
}
.btn-save:hover {
    background:#082847;
    color:white;
}
.tab-content {
    display:none;
}
.tab-content.active {
    display:block;
}
.current-logo {
    max-height: 70px;
    max-width: 160px;
    object-fit: contain;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 6px;
    background: #fff;
}
</style>

<div class="settings-container">

    <div class="settings-header">
        <div class="settings-title">{{ __('emis.settings') }}</div>
        <div class="settings-subtitle">{{ __('emis.manage_system_preferences') ?? 'Manage system configuration and administration settings.' }}</div>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="settings-tabs">
            <div class="settings-tab active" data-tab="general">⚙️ {{ __('emis.general_settings') ?? 'General' }}</div>
            <div class="settings-tab" data-tab="organization">🏢 {{ __('emis.organization') ?? 'Organization' }}</div>
            <div class="settings-tab" data-tab="documents">📄 {{ __('emis.documents') }}</div>
            <div class="settings-tab" data-tab="tasks">📋 {{ __('emis.tasks_management') }}</div>
            <div class="settings-tab" data-tab="security">🔐 {{ __('emis.security') ?? 'Security' }}</div>
            <div class="settings-tab" data-tab="system">🧠 {{ __('emis.system_configuration') ?? 'System' }}</div>
            <div class="settings-tab" data-tab="branding">🖼️ {{ __('emis.branding') ?? 'Branding' }}</div>
        </div>

        <div class="tab-content active" id="general">
            <div class="settings-card">
                <div class="section-title">{{ __('emis.general_settings') ?? 'General Settings' }}</div>
                <div class="section-subtitle">{{ __('emis.general_settings_desc') ?? 'Basic system identity and language defaults.' }}</div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label>{{ __('emis.system_name') }}</label>
                        <input type="text" name="system_name" class="form-control"
                               value="{{ old('system_name', $settings->system_name) }}">
                    </div>

                    <div class="col-md-6">
                        <label>{{ __('emis.system_short_name') }}</label>
                        <input type="text" name="system_short_name" class="form-control"
                               value="{{ old('system_short_name', $settings->system_short_name) }}">
                    </div>

                    <div class="col-md-4">
                        <label>{{ __('emis.language') }}</label>
                        <select name="default_language" class="form-select">
                            <option value="en" {{ old('default_language', $settings->default_language) == 'en' ? 'selected' : '' }}>English</option>
                            <option value="ps" {{ old('default_language', $settings->default_language) == 'ps' ? 'selected' : '' }}>پښتو</option>
                            <option value="fa" {{ old('default_language', $settings->default_language) == 'fa' ? 'selected' : '' }}>دری</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>{{ __('emis.timezone') ?? 'Timezone' }}</label>
                        <input type="text" name="timezone" class="form-control"
                               value="{{ old('timezone', $settings->timezone) }}">
                    </div>

                    <div class="col-md-4">
                        <label>{{ __('emis.date_format') ?? 'Date Format' }}</label>
                        <select name="date_format" class="form-select">
                            <option value="Y-m-d" {{ old('date_format', $settings->date_format) == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                            <option value="d-m-Y" {{ old('date_format', $settings->date_format) == 'd-m-Y' ? 'selected' : '' }}>DD-MM-YYYY</option>
                            <option value="d/m/Y" {{ old('date_format', $settings->date_format) == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label>{{ __('emis.description') }}</label>
                        <textarea name="system_description" class="form-control">{{ old('system_description', $settings->system_description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content" id="organization">
            <div class="settings-card">
                <div class="section-title">{{ __('emis.organization') ?? 'Organization' }}</div>
                <div class="section-subtitle">{{ __('emis.organization_desc') ?? 'Institution and contact details.' }}</div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label>{{ __('emis.organization_name') ?? 'Organization Name' }}</label>
                        <input type="text" name="organization_name" class="form-control"
                               value="{{ old('organization_name', $settings->organization_name) }}">
                    </div>

                    <div class="col-md-6">
                        <label>{{ __('emis.department') }}</label>
                        <input type="text" name="department_name" class="form-control"
                               value="{{ old('department_name', $settings->department_name) }}">
                    </div>

                    <div class="col-md-6">
                        <label>{{ __('emis.email') }}</label>
                        <input type="email" name="contact_email" class="form-control"
                               value="{{ old('contact_email', $settings->contact_email) }}">
                    </div>

                    <div class="col-md-6">
                        <label>{{ __('emis.phone') ?? 'Phone' }}</label>
                        <input type="text" name="contact_phone" class="form-control"
                               value="{{ old('contact_phone', $settings->contact_phone) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content" id="documents">
            <div class="settings-card">
                <div class="section-title">{{ __('emis.documents') }}</div>

                <div class="setting-row">
                    <div class="setting-text">
                        <h6>{{ __('emis.enable_document_tracking') ?? 'Enable Document Tracking' }}</h6>
                        <p>{{ __('emis.enable_document_tracking_desc') ?? 'Track incoming and outgoing document movement.' }}</p>
                    </div>
                    <input type="checkbox" class="form-check-input" name="enable_document_tracking" value="1"
                           {{ old('enable_document_tracking', $settings->enable_document_tracking) ? 'checked' : '' }}>
                </div>
            </div>
        </div>

        <div class="tab-content" id="tasks">
            <div class="settings-card">
                <div class="section-title">{{ __('emis.tasks_management') }}</div>

                <div class="setting-row">
                    <div class="setting-text">
                        <h6>{{ __('emis.enable_task_notifications') ?? 'Enable Task Notifications' }}</h6>
                        <p>{{ __('emis.enable_task_notifications_desc') ?? 'Send alerts for tasks and reminders.' }}</p>
                    </div>
                    <input type="checkbox" class="form-check-input" name="enable_task_notifications" value="1"
                           {{ old('enable_task_notifications', $settings->enable_task_notifications) ? 'checked' : '' }}>
                </div>

                <div class="setting-row">
                    <div class="setting-text">
                        <h6>{{ __('emis.browser_notifications') ?? 'Browser Notifications' }}</h6>
                        <p>{{ __('emis.browser_notifications_desc') ?? 'Display notifications inside the dashboard.' }}</p>
                    </div>
                    <input type="checkbox" class="form-check-input" name="browser_notifications" value="1"
                           {{ old('browser_notifications', $settings->browser_notifications) ? 'checked' : '' }}>
                </div>

                <div class="setting-row">
                    <div class="setting-text">
                        <h6>{{ __('emis.email_notifications') ?? 'Email Notifications' }}</h6>
                        <p>{{ __('emis.email_notifications_desc') ?? 'Send email alerts for important actions.' }}</p>
                    </div>
                    <input type="checkbox" class="form-check-input" name="email_notifications" value="1"
                           {{ old('email_notifications', $settings->email_notifications) ? 'checked' : '' }}>
                </div>
            </div>
        </div>

        <div class="tab-content" id="security">
            <div class="settings-card">
                <div class="section-title">{{ __('emis.security') ?? 'Security' }}</div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label>{{ __('emis.minimum_password_length') ?? 'Minimum Password Length' }}</label>
                        <input type="number" name="password_min_length" class="form-control"
                               value="{{ old('password_min_length', $settings->password_min_length) }}">
                    </div>

                    <div class="col-md-6">
                        <label>{{ __('emis.session_timeout') ?? 'Session Timeout (minutes)' }}</label>
                        <input type="number" name="session_timeout" class="form-control"
                               value="{{ old('session_timeout', $settings->session_timeout) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content" id="system">
            <div class="settings-card">
                <div class="section-title">{{ __('emis.system_configuration') ?? 'System Configuration' }}</div>

                <div class="setting-row">
                    <div class="setting-text">
                        <h6>{{ __('emis.enable_user_registration') ?? 'Enable User Registration' }}</h6>
                        <p>{{ __('emis.enable_user_registration_desc') ?? 'Allow administrators to register users.' }}</p>
                    </div>
                    <input type="checkbox" class="form-check-input" name="enable_user_registration" value="1"
                           {{ old('enable_user_registration', $settings->enable_user_registration) ? 'checked' : '' }}>
                </div>

                <div class="setting-row">
                    <div class="setting-text">
                        <h6>{{ __('emis.maintenance_mode') ?? 'Maintenance Mode' }}</h6>
                        <p>{{ __('emis.maintenance_mode_desc') ?? 'Temporarily limit public access.' }}</p>
                    </div>
                    <input type="checkbox" class="form-check-input" name="maintenance_mode" value="1"
                           {{ old('maintenance_mode', $settings->maintenance_mode) ? 'checked' : '' }}>
                </div>

                <div class="setting-row">
                    <div class="setting-text">
                        <h6>{{ __('emis.debug_mode') ?? 'Debug Mode' }}</h6>
                        <p>{{ __('emis.debug_mode_desc') ?? 'Enable detailed system debugging.' }}</p>
                    </div>
                    <input type="checkbox" class="form-check-input" name="debug_mode" value="1"
                           {{ old('debug_mode', $settings->debug_mode) ? 'checked' : '' }}>
                </div>
            </div>
        </div>

        <div class="tab-content" id="branding">
            <div class="settings-card">
                <div class="section-title">{{ __('emis.branding') ?? 'Branding' }}</div>
                <div class="section-subtitle">{{ __('emis.branding_settings_desc') ?? 'Upload official logo and visual identity.' }}</div>

                @if($settings->logo_path)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Logo" class="current-logo">
                    </div>
                @endif

                <div class="mb-3">
                    <label>{{ __('emis.logo') ?? 'Logo' }}</label>
                    <input type="file" name="logo" class="form-control">
                </div>
            </div>
        </div>

        <div class="settings-actions">
            <button type="submit" class="btn-save">{{ __('emis.save') }}</button>
        </div>
    </form>
</div>

<script>
document.querySelectorAll('.settings-tab').forEach(tab => {
    tab.addEventListener('click', function(){
        document.querySelectorAll('.settings-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

        this.classList.add('active');
        document.getElementById(this.dataset.tab).classList.add('active');
    });
});
</script>

@endsection