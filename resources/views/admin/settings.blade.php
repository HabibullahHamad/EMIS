@extends('new')

@section('page_title', __('emis.settings'))

@section('content')

<style>
    .settings-wrapper{
        max-width: 1400px;
        margin: 0 auto;
    }

    .settings-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:14px;
        margin-bottom:20px;
        flex-wrap:wrap;
    }

    .settings-title{
        font-size:22px;
        font-weight:700;
        color:#1e293b;
        margin:0;
    }

    .settings-subtitle{
        font-size:13px;
        color:#64748b;
        margin-top:4px;
    }

    .settings-grid{
        display:grid;
        grid-template-columns: 280px 1fr;
        gap:20px;
    }

    .settings-sidebar,
    .settings-card{
        background:#fff;
        border-radius:18px;
        box-shadow:0 8px 24px rgba(15, 23, 42, 0.06);
        border:1px solid #e2e8f0;
    }

    .settings-sidebar{
        padding:14px;
        height:fit-content;
        position:sticky;
        top:80px;
    }

    .settings-nav{
        list-style:none;
        margin:0;
        padding:0;
    }

    .settings-nav li{
        margin-bottom:8px;
    }

    .settings-nav a{
        display:flex;
        align-items:center;
        gap:10px;
        padding:12px 14px;
        border-radius:12px;
        color:#334155;
        text-decoration:none;
        transition:.2s ease;
        font-size:14px;
        font-weight:600;
    }

    .settings-nav a:hover,
    .settings-nav a.active{
        background:#eff6ff;
        color:#0b3563;
    }

    .settings-content{
        display:flex;
        flex-direction:column;
        gap:20px;
    }

    .settings-card{
        padding:22px;
    }

    .card-title{
        font-size:18px;
        font-weight:700;
        color:#1e293b;
        margin-bottom:4px;
    }

    .card-subtitle{
        font-size:13px;
        color:#64748b;
        margin-bottom:20px;
    }

    .settings-form .form-label{
        font-size:13px;
        font-weight:700;
        color:#334155;
        margin-bottom:8px;
    }

    .settings-form .form-control,
    .settings-form .form-select{
        border-radius:12px;
        min-height:44px;
        border:1px solid #dbe4ef;
        box-shadow:none !important;
    }

    .settings-form textarea.form-control{
        min-height:110px;
        resize:vertical;
    }

    .settings-form .form-control:focus,
    .settings-form .form-select:focus{
        border-color:#0b3563;
    }

    .settings-switch{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:16px;
        padding:14px 0;
        border-bottom:1px solid #eef2f7;
    }

    .settings-switch:last-child{
        border-bottom:none;
    }

    .switch-text h6{
        margin:0 0 4px 0;
        font-size:14px;
        font-weight:700;
        color:#1e293b;
    }

    .switch-text p{
        margin:0;
        font-size:12px;
        color:#64748b;
    }

    .form-check-input{
        width:46px;
        height:24px;
        cursor:pointer;
    }

    .settings-actions{
        display:flex;
        justify-content:flex-end;
        gap:10px;
        flex-wrap:wrap;
        margin-top:20px;
    }

    .btn-emis-primary{
        background:#0b3563;
        color:#fff;
        border:none;
        padding:10px 18px;
        border-radius:12px;
        font-size:14px;
        font-weight:600;
    }

    .btn-emis-primary:hover{
        background:#082847;
        color:#fff;
    }

    .btn-emis-light{
        background:#f8fafc;
        color:#334155;
        border:1px solid #dbe4ef;
        padding:10px 18px;
        border-radius:12px;
        font-size:14px;
        font-weight:600;
    }

    .info-badges{
        display:grid;
        grid-template-columns:repeat(3, 1fr);
        gap:14px;
        margin-top:8px;
    }

    .info-badge{
        background:#f8fafc;
        border:1px solid #e2e8f0;
        border-radius:14px;
        padding:16px;
    }

    .info-badge .label{
        font-size:12px;
        color:#64748b;
        margin-bottom:6px;
    }

    .info-badge .value{
        font-size:16px;
        font-weight:700;
        color:#1e293b;
    }

    .upload-box{
        border:2px dashed #cbd5e1;
        border-radius:16px;
        padding:24px;
        text-align:center;
        background:#f8fafc;
    }

    .upload-box i{
        font-size:26px;
        color:#0b3563;
        margin-bottom:10px;
    }

    .upload-box p{
        margin:0;
        color:#64748b;
        font-size:13px;
    }

    @media (max-width: 992px){
        .settings-grid{
            grid-template-columns:1fr;
        }

        .settings-sidebar{
            position:relative;
            top:auto;
        }

        .info-badges{
            grid-template-columns:1fr;
        }
    }
</style>

<div class="settings-wrapper">

    <div class="settings-header">
        <div>
            <h2 class="settings-title">{{ __('emis.settings') }}</h2>
            <div class="settings-subtitle">
                {{ __('emis.manage_system_preferences') ?? 'Manage system preferences, profile details, notifications, and interface settings.' }}
            </div>
        </div>
    </div>

    <div class="settings-grid">

        {{-- Left Navigation --}}
        <div class="settings-sidebar">
            <ul class="settings-nav">
                <li><a href="#general" class="active"><i class="fa-solid fa-gear"></i> {{ __('emis.general_settings') ?? 'General Settings' }}</a></li>
                <li><a href="#profile"><i class="fa-solid fa-user"></i> {{ __('emis.profile') }}</a></li>
                <li><a href="#system"><i class="fa-solid fa-sliders"></i> {{ __('emis.system_configuration') ?? 'System Configuration' }}</a></li>
                <li><a href="#notifications"><i class="fa-solid fa-bell"></i> {{ __('emis.notifications') }}</a></li>
                <li><a href="#security"><i class="fa-solid fa-shield-halved"></i> {{ __('emis.security') ?? 'Security' }}</a></li>
                <li><a href="#branding"><i class="fa-solid fa-image"></i> {{ __('emis.branding') ?? 'Branding' }}</a></li>
            </ul>
        </div>

        {{-- Right Content --}}
        <div class="settings-content">

            {{-- General Settings --}}
            <div class="settings-card" id="general">
                <div class="card-title">{{ __('emis.general_settings') ?? 'General Settings' }}</div>
                <div class="card-subtitle">{{ __('emis.general_settings_desc') ?? 'Update basic system information and interface defaults.' }}</div>

                <form class="settings-form" method="POST" action="{{ route('admin.settings.update') ?? '#' }}">
                    @csrf
                    @if(Route::has('admin.settings.update'))
                        @method('PUT')
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('emis.system_name') }}</label>
                            <input type="text" name="system_name" class="form-control"
                                   value="{{ old('system_name', $settings->system_name ?? 'Executive Management Information System') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">{{ __('emis.system_short_name') }}</label>
                            <input type="text" name="system_short_name" class="form-control"
                                   value="{{ old('system_short_name', $settings->system_short_name ?? 'EMIS') }}">
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
                            <input type="text" name="timezone" class="form-control"
                                   value="{{ old('timezone', $settings->timezone ?? 'Asia/Kabul') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">{{ __('emis.date_format') ?? 'Date Format' }}</label>
                            <select name="date_format" class="form-select">
                                <option value="Y-m-d" {{ old('date_format', $settings->date_format ?? 'Y-m-d') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                <option value="d-m-Y" {{ old('date_format', $settings->date_format ?? '') == 'd-m-Y' ? 'selected' : '' }}>DD-MM-YYYY</option>
                                <option value="d/m/Y" {{ old('date_format', $settings->date_format ?? '') == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">{{ __('emis.description') }}</label>
                            <textarea name="system_description" class="form-control">{{ old('system_description', $settings->system_description ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="settings-actions">
                        <button type="reset" class="btn-emis-light">{{ __('emis.cancel') }}</button>
                        <button type="submit" class="btn-emis-primary">{{ __('emis.save') }}</button>
                    </div>
                </form>
            </div>

            {{-- Profile Settings --}}
            <div class="settings-card" id="profile">
                <div class="card-title">{{ __('emis.profile') }}</div>
                <div class="card-subtitle">{{ __('emis.profile_settings_desc') ?? 'Manage administrator profile and account details.' }}</div>

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
            </div>

            {{-- System Configuration --}}
            <div class="settings-card" id="system">
                <div class="card-title">{{ __('emis.system_configuration') ?? 'System Configuration' }}</div>
                <div class="card-subtitle">{{ __('emis.system_configuration_desc') ?? 'Control system behavior and operational preferences.' }}</div>

                <div class="settings-switch">
                    <div class="switch-text">
                        <h6>{{ __('emis.enable_user_registration') ?? 'Enable User Registration' }}</h6>
                        <p>{{ __('emis.enable_user_registration_desc') ?? 'Allow administrators to register new system users.' }}</p>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>

                <div class="settings-switch">
                    <div class="switch-text">
                        <h6>{{ __('emis.enable_task_notifications') ?? 'Enable Task Notifications' }}</h6>
                        <p>{{ __('emis.enable_task_notifications_desc') ?? 'Send reminders for new, updated, and overdue tasks.' }}</p>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>

                <div class="settings-switch">
                    <div class="switch-text">
                        <h6>{{ __('emis.enable_document_tracking') ?? 'Enable Document Tracking' }}</h6>
                        <p>{{ __('emis.enable_document_tracking_desc') ?? 'Track incoming and outgoing document movement.' }}</p>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>
            </div>

            {{-- Notification Settings --}}
            <div class="settings-card" id="notifications">
                <div class="card-title">{{ __('emis.notifications') }}</div>
                <div class="card-subtitle">{{ __('emis.notification_settings_desc') ?? 'Choose which system alerts and reminders are active.' }}</div>

                <div class="settings-switch">
                    <div class="switch-text">
                        <h6>{{ __('emis.email_notifications') ?? 'Email Notifications' }}</h6>
                        <p>{{ __('emis.email_notifications_desc') ?? 'Receive email alerts for important actions.' }}</p>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox">
                    </div>
                </div>

                <div class="settings-switch">
                    <div class="switch-text">
                        <h6>{{ __('emis.browser_notifications') ?? 'Browser Notifications' }}</h6>
                        <p>{{ __('emis.browser_notifications_desc') ?? 'Show alerts directly inside the dashboard.' }}</p>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>
            </div>

            {{-- Security Settings --}}
            <div class="settings-card" id="security">
                <div class="card-title">{{ __('emis.security') ?? 'Security' }}</div>
                <div class="card-subtitle">{{ __('emis.security_settings_desc') ?? 'Manage password policy and administrative protection settings.' }}</div>

                <div class="row g-3 settings-form">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.minimum_password_length') ?? 'Minimum Password Length' }}</label>
                        <input type="number" class="form-control" value="{{ old('password_min_length', $settings->password_min_length ?? 8) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.session_timeout') ?? 'Session Timeout (minutes)' }}</label>
                        <input type="number" class="form-control" value="{{ old('session_timeout', $settings->session_timeout ?? 30) }}">
                    </div>
                </div>
            </div>

            {{-- Branding --}}
            <div class="settings-card" id="branding">
                <div class="card-title">{{ __('emis.branding') ?? 'Branding' }}</div>
                <div class="card-subtitle">{{ __('emis.branding_settings_desc') ?? 'Update system logo and display identity.' }}</div>

                <div class="upload-box">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <p>{{ __('emis.upload_logo_hint') ?? 'Upload official EMIS or ministry logo here.' }}</p>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection