<?php

return [

    /*
    |--------------------------------------------------------------------------
    | EMIS Settings Center
    |--------------------------------------------------------------------------
    |
    | This file defines:
    |
    | - Settings sections
    | - Field definitions
    | - Default values
    | - Validation rules
    | - Storage value types
    | - Public/private visibility
    |
    | The actual saved values are stored in:
    |
    | system_settings
    |
    */

    'version' => 1,

    /*
    |--------------------------------------------------------------------------
    | Supported Languages
    |--------------------------------------------------------------------------
    */

    'supported_locales' => [
        'en',
        'ps',
        'fa',
    ],

    /*
    |--------------------------------------------------------------------------
    | Protected Environment Keys
    |--------------------------------------------------------------------------
    |
    | These values must NEVER be editable through the web Settings Center.
    |
    */

    'protected_keys' => [
        'APP_KEY',
        'DB_HOST',
        'DB_PORT',
        'DB_DATABASE',
        'DB_USERNAME',
        'DB_PASSWORD',
        'MAIL_PASSWORD',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sections
    |--------------------------------------------------------------------------
    */

    'sections' => [

        /*
        |--------------------------------------------------------------------------
        | GENERAL SETTINGS
        |--------------------------------------------------------------------------
        */

        'general' => [

            'group' => 'general',

            'title' => 'emis.general_settings',

            'description' =>
                'emis.general_settings_description',

            'icon' => 'fa-solid fa-sliders',

            'order' => 10,

            'permission' => 'settings.manage',

            'fields' => [

                /*
                |--------------------------------------------------------------------------
                | System Name
                |--------------------------------------------------------------------------
                */

                'system_name' => [

                    'label' =>
                        'emis.system_name',

                    'help' =>
                        'emis.system_name_help',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        'Executive Management Information System',

                    'rules' => [
                        'required',
                        'string',
                        'max:150',
                    ],

                    'public' =>
                        true,

                    'placeholder' =>
                        'emis.system_name_placeholder',

                    'column' =>
                        8,

                    'order' =>
                        10,
                ],

                /*
                |--------------------------------------------------------------------------
                | Short Name
                |--------------------------------------------------------------------------
                */

                'short_name' => [

                    'label' =>
                        'emis.system_short_name',

                    'help' =>
                        'emis.system_short_name_help',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        'EMIS',

                    'rules' => [
                        'required',
                        'string',
                        'max:30',
                    ],

                    'public' =>
                        true,

                    'placeholder' =>
                        'EMIS',

                    'column' =>
                        4,

                    'order' =>
                        20,
                ],

                /*
                |--------------------------------------------------------------------------
                | Description
                |--------------------------------------------------------------------------
                */

                'system_description' => [

                    'label' =>
                        'emis.system_description',

                    'help' =>
                        'emis.system_description_help',

                    'input' =>
                        'textarea',

                    'type' =>
                        'text',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'string',
                        'max:1000',
                    ],

                    'public' =>
                        true,

                    'placeholder' =>
                        'emis.system_description_placeholder',

                    'rows' =>
                        3,

                    'column' =>
                        12,

                    'order' =>
                        30,
                ],

                /*
                |--------------------------------------------------------------------------
                | Default Landing Page
                |--------------------------------------------------------------------------
                */

                'default_landing_page' => [

                    'label' =>
                        'emis.default_landing_page',

                    'help' =>
                        'emis.default_landing_page_help',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'dashboard',

                    'rules' => [
                        'required',
                        'string',
                        'in:dashboard,focal-points,inbox,outbox',
                    ],

                    'public' =>
                        false,

                    'options' => [

                        'dashboard' =>
                            'emis.dashboard',

                        'focal-points' =>
                            'emis.focal_points',

                        'inbox' =>
                            'emis.incoming_documents',

                        'outbox' =>
                            'emis.outgoing_documents',
                    ],

                    'column' =>
                        6,

                    'order' =>
                        40,
                ],

                /*
                |--------------------------------------------------------------------------
                | System Status
                |--------------------------------------------------------------------------
                */

                'system_status' => [

                    'label' =>
                        'emis.system_status',

                    'help' =>
                        'emis.system_status_help',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'active',

                    'rules' => [
                        'required',
                        'string',
                        'in:active,maintenance',
                    ],

                    'public' =>
                        true,

                    'options' => [

                        'active' =>
                            'emis.active',

                        'maintenance' =>
                            'emis.maintenance',
                    ],

                    'column' =>
                        6,

                    'order' =>
                        50,
                ],

                /*
                |--------------------------------------------------------------------------
                | Primary Interface Color
                |--------------------------------------------------------------------------
                */

                'primary_color' => [

                    'label' =>
                        'emis.primary_color',

                    'help' =>
                        'emis.primary_color_help',

                    'input' =>
                        'color',

                    'type' =>
                        'color',

                    'default' =>
                        '#173D7A',

                    'rules' => [
                        'required',
                        'regex:/^#[0-9A-Fa-f]{6}$/',
                    ],

                    'public' =>
                        true,

                    'column' =>
                        4,

                    'order' =>
                        60,
                ],

                /*
                |--------------------------------------------------------------------------
                | Support Email
                |--------------------------------------------------------------------------
                */

                'support_email' => [

                    'label' =>
                        'emis.support_email',

                    'help' =>
                        'emis.support_email_help',

                    'input' =>
                        'email',

                    'type' =>
                        'email',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'email',
                        'max:255',
                    ],

                    'public' =>
                        true,

                    'placeholder' =>
                        'support@example.gov.af',

                    'column' =>
                        4,

                    'order' =>
                        70,
                ],

                /*
                |--------------------------------------------------------------------------
                | Support Phone
                |--------------------------------------------------------------------------
                */

                'support_phone' => [

                    'label' =>
                        'emis.support_phone',

                    'help' =>
                        'emis.support_phone_help',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'string',
                        'max:50',
                    ],

                    'public' =>
                        true,

                    'placeholder' =>
                        '+93 ...',

                    'column' =>
                        4,

                    'order' =>
                        80,
                ],

                /*
                |--------------------------------------------------------------------------
                | Helpdesk URL
                |--------------------------------------------------------------------------
                */

                'helpdesk_url' => [

                    'label' =>
                        'emis.helpdesk_url',

                    'help' =>
                        'emis.helpdesk_url_help',

                    'input' =>
                        'url',

                    'type' =>
                        'url',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'url',
                        'max:500',
                    ],

                    'public' =>
                        true,

                    'placeholder' =>
                        'https://...',

                    'column' =>
                        6,

                    'order' =>
                        90,
                ],

                /*
                |--------------------------------------------------------------------------
                | Maintenance Message
                |--------------------------------------------------------------------------
                */

                'maintenance_message' => [

                    'label' =>
                        'emis.maintenance_message',

                    'help' =>
                        'emis.maintenance_message_help',

                    'input' =>
                        'textarea',

                    'type' =>
                        'text',

                    'default' =>
                        'The system is temporarily unavailable for maintenance.',

                    'rules' => [
                        'nullable',
                        'string',
                        'max:1000',
                    ],

                    'public' =>
                        true,

                    'rows' =>
                        3,

                    'column' =>
                        12,

                    'order' =>
                        100,
                ],

                /*
                |--------------------------------------------------------------------------
                | System Logo
                |--------------------------------------------------------------------------
                */

                'system_logo' => [

                    'label' =>
                        'emis.system_logo',

                    'help' =>
                        'emis.system_logo_help',

                    'input' =>
                        'image',

                    'type' =>
                        'image',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'image',
                        'mimes:jpg,jpeg,png,webp',
                        'max:2048',
                    ],

                    'public' =>
                        true,

                    'disk' =>
                        'public',

                    'directory' =>
                        'settings/general',

                    'column' =>
                        6,

                    'order' =>
                        110,
                ],

                /*
                |--------------------------------------------------------------------------
                | Favicon
                |--------------------------------------------------------------------------
                */

                'favicon' => [

                    'label' =>
                        'emis.favicon',

                    'help' =>
                        'emis.favicon_help',

                    'input' =>
                        'image',

                    'type' =>
                        'image',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'image',
                        'mimes:png,ico,jpg,jpeg',
                        'max:1024',
                    ],

                    'public' =>
                        true,

                    'disk' =>
                        'public',

                    'directory' =>
                        'settings/general',

                    'column' =>
                        6,

                    'order' =>
                        120,
                ],
            ],
        ],
                /*
        |--------------------------------------------------------------------------
        | ORGANIZATION PROFILE
        |--------------------------------------------------------------------------
        */

        'organization' => [

            'group' => 'organization',

            'title' =>
                'emis.organization_profile',

            'description' =>
                'emis.organization_profile_description',

            'icon' =>
                'fa-solid fa-building-columns',

            'order' =>
                20,

            'permission' =>
                'settings.manage',

            'fields' => [

                'official_name' => [

                    'label' =>
                        'emis.organization_official_name',

                    'help' =>
                        'emis.organization_official_name_help',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        null,

                    'rules' => [
                        'required',
                        'string',
                        'max:200',
                    ],

                    'public' =>
                        true,

                    'placeholder' =>
                        'Official organization name',

                    'column' =>
                        8,

                    'order' =>
                        10,
                ],

                'organization_code' => [

                    'label' =>
                        'emis.organization_code',

                    'help' =>
                        'emis.organization_code_help',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'string',
                        'max:50',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        'Organization code',

                    'column' =>
                        4,

                    'order' =>
                        20,
                ],

                'name_ps' => [

                    'label' =>
                        'emis.organization_name_ps',

                    'help' =>
                        'emis.organization_name_ps_help',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'string',
                        'max:200',
                    ],

                    'public' =>
                        true,

                    'placeholder' =>
                        'د ادارې رسمي نوم په پښتو',

                    'column' =>
                        6,

                    'order' =>
                        30,
                ],

                'name_fa' => [

                    'label' =>
                        'emis.organization_name_fa',

                    'help' =>
                        'emis.organization_name_fa_help',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'string',
                        'max:200',
                    ],

                    'public' =>
                        true,

                    'placeholder' =>
                        'نام رسمی اداره به دری',

                    'column' =>
                        6,

                    'order' =>
                        40,
                ],

                'organization_type' => [

                    'label' =>
                        'emis.organization_type',

                    'help' =>
                        'emis.organization_type_help',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'directorate',

                    'rules' => [
                        'required',
                        'string',
                        'in:ministry,general_directorate,directorate,independent_agency,other',
                    ],

                    'public' =>
                        true,

                    'options' => [

                        'ministry' =>
                            'emis.organization_type_ministry',

                        'general_directorate' =>
                            'emis.organization_type_general_directorate',

                        'directorate' =>
                            'emis.organization_type_directorate',

                        'independent_agency' =>
                            'emis.organization_type_independent_agency',

                        'other' =>
                            'emis.organization_type_other',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        50,
                ],

                'official_email' => [

                    'label' =>
                        'emis.organization_email',

                    'help' =>
                        'emis.organization_email_help',

                    'input' =>
                        'email',

                    'type' =>
                        'email',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'email',
                        'max:150',
                    ],

                    'public' =>
                        true,

                    'placeholder' =>
                        'info@example.gov.af',

                    'column' =>
                        4,

                    'order' =>
                        60,
                ],

                'official_phone' => [

                    'label' =>
                        'emis.organization_phone',

                    'help' =>
                        'emis.organization_phone_help',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'string',
                        'max:50',
                    ],

                    'public' =>
                        true,

                    'placeholder' =>
                        '+93 ...',

                    'column' =>
                        4,

                    'order' =>
                        70,
                ],

                'website' => [

                    'label' =>
                        'emis.organization_website',

                    'help' =>
                        'emis.organization_website_help',

                    'input' =>
                        'url',

                    'type' =>
                        'url',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'url',
                        'max:255',
                    ],

                    'public' =>
                        true,

                    'placeholder' =>
                        'https://example.gov.af',

                    'column' =>
                        6,

                    'order' =>
                        80,
                ],

                'address' => [

                    'label' =>
                        'emis.organization_address',

                    'help' =>
                        'emis.organization_address_help',

                    'input' =>
                        'textarea',

                    'type' =>
                        'text',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'string',
                        'max:1000',
                    ],

                    'public' =>
                        true,

                    'placeholder' =>
                        'Official office address',

                    'rows' =>
                        3,

                    'column' =>
                        12,

                    'order' =>
                        90,
                ],

                'logo' => [

                    'label' =>
                        'emis.organization_logo',

                    'help' =>
                        'emis.organization_logo_help',

                    'input' =>
                        'image',

                    'type' =>
                        'image',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'image',
                        'mimes:jpg,jpeg,png,webp',
                        'max:2048',
                    ],

                    'public' =>
                        true,

                    'disk' =>
                        'public',

                    'directory' =>
                        'settings/organization',

                    'column' =>
                        6,

                    'order' =>
                        100,
                ],

                'official_seal' => [

                    'label' =>
                        'emis.organization_official_seal',

                    'help' =>
                        'emis.organization_official_seal_help',

                    'input' =>
                        'image',

                    'type' =>
                        'image',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'image',
                        'mimes:jpg,jpeg,png,webp',
                        'max:2048',
                    ],

                    'public' =>
                        false,

                    'disk' =>
                        'public',

                    'directory' =>
                        'settings/organization',

                    'column' =>
                        6,

                    'order' =>
                        110,
                ],
            ],
        ],
                /*
        |--------------------------------------------------------------------------
        | LOCALIZATION & REGIONAL FORMAT
        |--------------------------------------------------------------------------
        */

        'localization' => [

            'group' =>
                'localization',

            'title' =>
                'emis.localization_settings',

            'description' =>
                'emis.localization_settings_description',

            'icon' =>
                'fa-solid fa-language',

            'order' =>
                30,

            'permission' =>
                'settings.manage',

            'fields' => [

                'default_locale' => [

                    'label' =>
                        'emis.default_language',

                    'help' =>
                        'emis.default_language_help',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'en',

                    'rules' => [
                        'required',
                        'string',
                        'in:en,ps,fa',
                    ],

                    'public' =>
                        true,

                    'options' => [
                        'en' => 'English',
                        'ps' => 'پښتو',
                        'fa' => 'دری',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        10,
                ],

                'fallback_locale' => [

                    'label' =>
                        'emis.fallback_language',

                    'help' =>
                        'emis.fallback_language_help',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'en',

                    'rules' => [
                        'required',
                        'string',
                        'in:en,ps,fa',
                    ],

                    'public' =>
                        false,

                    'options' => [
                        'en' => 'English',
                        'ps' => 'پښتو',
                        'fa' => 'دری',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        20,
                ],

                'timezone' => [

                    'label' =>
                        'emis.default_timezone',

                    'help' =>
                        'emis.default_timezone_help',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'Asia/Kabul',

                    'rules' => [
                        'required',
                        'string',
                        'in:Asia/Kabul,UTC',
                    ],

                    'public' =>
                        true,

                    'options' => [
                        'Asia/Kabul' =>
                            'Asia/Kabul (UTC+4:30)',

                        'UTC' =>
                            'UTC',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        30,
                ],

                'calendar_type' => [

                    'label' =>
                        'emis.calendar_type',

                    'help' =>
                        'emis.calendar_type_help',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'solar_hijri',

                    'rules' => [
                        'required',
                        'string',
                        'in:gregorian,solar_hijri,lunar_hijri',
                    ],

                    'public' =>
                        true,

                    'options' => [
                        'gregorian' =>
                            'Gregorian',

                        'solar_hijri' =>
                            'Solar Hijri',

                        'lunar_hijri' =>
                            'Lunar Hijri',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        40,
                ],

                'date_format' => [

                    'label' =>
                        'emis.date_format',

                    'help' =>
                        'emis.date_format_help',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'Y-m-d',

                    'rules' => [
                        'required',
                        'string',
                        'in:Y-m-d,d-m-Y,d/m/Y,m/d/Y',
                    ],

                    'public' =>
                        true,

                    'options' => [
                        'Y-m-d' =>
                            'YYYY-MM-DD',

                        'd-m-Y' =>
                            'DD-MM-YYYY',

                        'd/m/Y' =>
                            'DD/MM/YYYY',

                        'm/d/Y' =>
                            'MM/DD/YYYY',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        50,
                ],

                'time_format' => [

                    'label' =>
                        'emis.time_format',

                    'help' =>
                        'emis.time_format_help',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'H:i',

                    'rules' => [
                        'required',
                        'string',
                        'in:H:i,h:i A',
                    ],

                    'public' =>
                        true,

                    'options' => [
                        'H:i' =>
                            '24-hour',

                        'h:i A' =>
                            '12-hour',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        60,
                ],

                'first_day_of_week' => [

                    'label' =>
                        'emis.first_day_of_week',

                    'help' =>
                        'emis.first_day_of_week_help',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'saturday',

                    'rules' => [
                        'required',
                        'string',
                        'in:saturday,sunday,monday',
                    ],

                    'public' =>
                        true,

                    'options' => [
                        'saturday' =>
                            'Saturday',

                        'sunday' =>
                            'Sunday',

                        'monday' =>
                            'Monday',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        70,
                ],

                'records_per_page' => [

                    'label' =>
                        'emis.records_per_page',

                    'help' =>
                        'emis.records_per_page_help',

                    'input' =>
                        'select',

                    'type' =>
                        'integer',

                    'default' =>
                        25,

                    'rules' => [
                        'required',
                        'integer',
                        'in:10,25,50,100',
                    ],

                    'public' =>
                        false,

                    'options' => [
                        10 => '10',
                        25 => '25',
                        50 => '50',
                        100 => '100',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        80,
                ],
            ],
        ],
                /*
        |--------------------------------------------------------------------------
        | SECURITY & ACCESS CONTROL
        |--------------------------------------------------------------------------
        */

        'security' => [

            'group' =>
                'security',

            'title' =>
                'emis.security_settings',

            'description' =>
                'emis.security_settings_description',

            'icon' =>
                'fa-solid fa-shield-halved',

            'order' =>
                40,

            'permission' =>
                'settings.manage',

            'fields' => [

                'session_timeout_minutes' => [

                    'label' =>
                        'emis.session_timeout_minutes',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        30,

                    'rules' => [
                        'required',
                        'integer',
                        'min:5',
                        'max:480',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        '30',

                    'column' =>
                        4,

                    'order' =>
                        10,
                ],

                'maximum_login_attempts' => [

                    'label' =>
                        'emis.maximum_login_attempts',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        5,

                    'rules' => [
                        'required',
                        'integer',
                        'min:3',
                        'max:20',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        '5',

                    'column' =>
                        4,

                    'order' =>
                        20,
                ],

                'lockout_minutes' => [

                    'label' =>
                        'emis.lockout_minutes',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        15,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:1440',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        '15',

                    'column' =>
                        4,

                    'order' =>
                        30,
                ],

                'password_minimum_length' => [

                    'label' =>
                        'emis.password_minimum_length',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        8,

                    'rules' => [
                        'required',
                        'integer',
                        'min:8',
                        'max:64',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        '8',

                    'column' =>
                        4,

                    'order' =>
                        40,
                ],

                'password_expiry_days' => [

                    'label' =>
                        'emis.password_expiry_days',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        90,

                    'rules' => [
                        'required',
                        'integer',
                        'min:0',
                        'max:365',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        '90',

                    'column' =>
                        4,

                    'order' =>
                        50,
                ],

                'require_uppercase' => [

                    'label' =>
                        'emis.require_uppercase',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        60,
                ],

                'require_lowercase' => [

                    'label' =>
                        'emis.require_lowercase',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        70,
                ],

                'require_number' => [

                    'label' =>
                        'emis.require_number',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        80,
                ],

                'require_special_character' => [

                    'label' =>
                        'emis.require_special_character',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        false,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        90,
                ],

                'two_factor_authentication' => [

                    'label' =>
                        'emis.two_factor_authentication',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        false,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        100,
                ],

                'audit_retention_days' => [

                    'label' =>
                        'emis.audit_retention_days',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        365,

                    'rules' => [
                        'required',
                        'integer',
                        'min:30',
                        'max:3650',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        '365',

                    'column' =>
                        4,

                    'order' =>
                        110,
                ],
            ],
        ],
                /*
        |--------------------------------------------------------------------------
        | NOTIFICATIONS & EMAIL
        |--------------------------------------------------------------------------
        */

        'notifications' => [

            'group' =>
                'notifications',

            'title' =>
                'emis.notification_settings',

            'description' =>
                'emis.notification_settings_description',

            'icon' =>
                'fa-solid fa-bell',

            'order' =>
                50,

            'permission' =>
                'settings.manage',

            'fields' => [

                'email_notifications_enabled' => [

                    'label' =>
                        'emis.email_notifications_enabled',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        10,
                ],

                'in_app_notifications_enabled' => [

                    'label' =>
                        'emis.in_app_notifications_enabled',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        20,
                ],

                'mail_from_name' => [

                    'label' =>
                        'emis.mail_from_name',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        'EMIS',

                    'rules' => [
                        'required',
                        'string',
                        'max:100',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        'EMIS',

                    'column' =>
                        4,

                    'order' =>
                        30,
                ],

                'mail_from_address' => [

                    'label' =>
                        'emis.mail_from_address',

                    'input' =>
                        'email',

                    'type' =>
                        'email',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'email',
                        'max:150',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        'noreply@example.gov.af',

                    'column' =>
                        6,

                    'order' =>
                        40,
                ],

                'administrator_email' => [

                    'label' =>
                        'emis.administrator_notification_email',

                    'input' =>
                        'email',

                    'type' =>
                        'email',

                    'default' =>
                        null,

                    'rules' => [
                        'nullable',
                        'email',
                        'max:150',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        'administrator@example.gov.af',

                    'column' =>
                        6,

                    'order' =>
                        50,
                ],

                'notify_incoming_document' => [

                    'label' =>
                        'emis.notify_incoming_document',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        60,
                ],

                'notify_task_assignment' => [

                    'label' =>
                        'emis.notify_task_assignment',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        70,
                ],

                'notify_deadline_reminder' => [

                    'label' =>
                        'emis.notify_deadline_reminder',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        80,
                ],

                'notify_backup_failure' => [

                    'label' =>
                        'emis.notify_backup_failure',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        90,
                ],

                'daily_summary_enabled' => [

                    'label' =>
                        'emis.daily_summary_enabled',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        false,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        100,
                ],

                'daily_summary_time' => [

                    'label' =>
                        'emis.daily_summary_time',

                    'input' =>
                        'time',

                    'type' =>
                        'time',

                    'default' =>
                        '08:00',

                    'rules' => [
                        'required',
                        'date_format:H:i',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        110,
                ],
            ],
        ],
        // end notifications
                /*
        |--------------------------------------------------------------------------
        | CORRESPONDENCE SETTINGS
        |--------------------------------------------------------------------------
        */

        'correspondence' => [

            'group' =>
                'correspondence',

            'title' =>
                'emis.correspondence_settings',

            'description' =>
                'emis.correspondence_settings_description',

            'icon' =>
                'fa-solid fa-envelope-open-text',

            'order' =>
                60,

            'permission' =>
                'settings.manage',

            'fields' => [

                'incoming_number_format' => [

                    'label' =>
                        'emis.incoming_number_format',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        'IN-{YEAR}-{SEQ}',

                    'rules' => [
                        'required',
                        'string',
                        'max:100',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        'IN-{YEAR}-{SEQ}',

                    'column' =>
                        6,

                    'order' =>
                        10,
                ],

                'outgoing_number_format' => [

                    'label' =>
                        'emis.outgoing_number_format',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        'OUT-{YEAR}-{SEQ}',

                    'rules' => [
                        'required',
                        'string',
                        'max:100',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        'OUT-{YEAR}-{SEQ}',

                    'column' =>
                        6,

                    'order' =>
                        20,
                ],

                'default_priority' => [

                    'label' =>
                        'emis.default_document_priority',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'normal',

                    'rules' => [
                        'required',
                        'string',
                        'in:low,normal,high,urgent',
                    ],

                    'public' =>
                        false,

                    'options' => [
                        'low' => 'Low',
                        'normal' => 'Normal',
                        'high' => 'High',
                        'urgent' => 'Urgent',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        30,
                ],

                'default_status' => [

                    'label' =>
                        'emis.default_document_status',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'draft',

                    'rules' => [
                        'required',
                        'string',
                        'in:draft,registered,pending',
                    ],

                    'public' =>
                        false,

                    'options' => [
                        'draft' => 'Draft',
                        'registered' => 'Registered',
                        'pending' => 'Pending',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        40,
                ],

                'maximum_attachment_size_mb' => [

                    'label' =>
                        'emis.maximum_attachment_size_mb',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        10,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:100',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        50,
                ],

                'allowed_attachment_types' => [

                    'label' =>
                        'emis.allowed_attachment_types',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        'pdf,jpg,jpeg,png',

                    'rules' => [
                        'required',
                        'string',
                        'max:150',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        'pdf,jpg,jpeg,png',

                    'column' =>
                        12,

                    'order' =>
                        60,
                ],

                'require_subject' => [

                    'label' =>
                        'emis.require_document_subject',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        70,
                ],

                'require_document_date' => [

                    'label' =>
                        'emis.require_document_date',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        80,
                ],

                'allow_multiple_attachments' => [

                    'label' =>
                        'emis.allow_multiple_attachments',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        90,
                ],

                'prevent_duplicate_numbers' => [

                    'label' =>
                        'emis.prevent_duplicate_document_numbers',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        100,
                ],

                'document_retention_years' => [

                    'label' =>
                        'emis.document_retention_years',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        10,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:50',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        110,
                ],
            ],
        ],
                /*
        |--------------------------------------------------------------------------
        | WORKFLOW & APPROVALS
        |--------------------------------------------------------------------------
        */

        'workflow' => [

            'group' =>
                'workflow',

            'title' =>
                'emis.workflow_settings',

            'description' =>
                'emis.workflow_settings_description',

            'icon' =>
                'fa-solid fa-diagram-project',

            'order' =>
                70,

            'permission' =>
                'settings.manage',

            'fields' => [

                'workflow_enabled' => [

                    'label' =>
                        'emis.workflow_enabled',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        10,
                ],

                'incoming_requires_review' => [

                    'label' =>
                        'emis.incoming_requires_review',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        20,
                ],

                'outgoing_requires_approval' => [

                    'label' =>
                        'emis.outgoing_requires_approval',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        30,
                ],

                'card_requires_approval' => [

                    'label' =>
                        'emis.card_requires_approval',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        40,
                ],

                'allow_self_approval' => [

                    'label' =>
                        'emis.allow_self_approval',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        false,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        50,
                ],

                'require_rejection_reason' => [

                    'label' =>
                        'emis.require_rejection_reason',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        60,
                ],

                'require_approval_comment' => [

                    'label' =>
                        'emis.require_approval_comment',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        false,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        70,
                ],

                'default_due_days' => [

                    'label' =>
                        'emis.default_workflow_due_days',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        3,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:90',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        80,
                ],

                'escalation_after_days' => [

                    'label' =>
                        'emis.escalation_after_days',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        2,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:90',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        90,
                ],

                'maximum_revisions' => [

                    'label' =>
                        'emis.maximum_workflow_revisions',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        3,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:20',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        100,
                ],

                'auto_close_completed_workflows' => [

                    'label' =>
                        'emis.auto_close_completed_workflows',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        110,
                ],
            ],
        ],
                /*
        |--------------------------------------------------------------------------
        | BUDGET COORDINATION
        |--------------------------------------------------------------------------
        */

        'budget_coordination' => [

            'group' =>
                'budget_coordination',

            'title' =>
                'emis.budget_coordination_settings',

            'description' =>
                'emis.budget_coordination_settings_description',

            'icon' =>
                'fa-solid fa-id-card',

            'order' =>
                80,

            'permission' =>
                'settings.manage',

            'fields' => [

                'focal_point_code_format' => [

                    'label' =>
                        'emis.focal_point_code_format',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        'FP-{YEAR}-{SEQ}',

                    'rules' => [
                        'required',
                        'string',
                        'max:100',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        'FP-{YEAR}-{SEQ}',

                    'column' =>
                        6,

                    'order' =>
                        10,
                ],

                'card_number_format' => [

                    'label' =>
                        'emis.card_number_format',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        'CARD-{YEAR}-{SEQ}',

                    'rules' => [
                        'required',
                        'string',
                        'max:100',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        'CARD-{YEAR}-{SEQ}',

                    'column' =>
                        6,

                    'order' =>
                        20,
                ],

                'card_validity_months' => [

                    'label' =>
                        'emis.card_validity_months',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        12,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:60',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        30,
                ],

                'maximum_focal_points_per_entity' => [

                    'label' =>
                        'emis.maximum_focal_points_per_entity',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        5,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:100',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        40,
                ],

                'card_expiry_reminder_days' => [

                    'label' =>
                        'emis.card_expiry_reminder_days',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        30,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:365',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        50,
                ],

                'card_issuing_organization' => [

                    'label' =>
                        'emis.card_issuing_organization',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        'Budget Directorate',

                    'rules' => [
                        'required',
                        'string',
                        'max:200',
                    ],

                    'public' =>
                        true,

                    'column' =>
                        8,

                    'order' =>
                        60,
                ],

                'card_print_language' => [

                    'label' =>
                        'emis.card_print_language',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'ps_en',

                    'rules' => [
                        'required',
                        'string',
                        'in:ps,fa,en,ps_en,fa_en',
                    ],

                    'public' =>
                        false,

                    'options' => [
                        'ps' => 'Pashto',
                        'fa' => 'Dari',
                        'en' => 'English',
                        'ps_en' => 'Pashto and English',
                        'fa_en' => 'Dari and English',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        70,
                ],

                'require_introduction_letter' => [

                    'label' =>
                        'emis.require_introduction_letter',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        80,
                ],

                'require_approval_before_card' => [

                    'label' =>
                        'emis.require_approval_before_card',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        90,
                ],

                'require_photograph' => [

                    'label' =>
                        'emis.require_focal_point_photograph',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        100,
                ],

                'require_signature' => [

                    'label' =>
                        'emis.require_focal_point_signature',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        false,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        110,
                ],

                'allow_card_renewal' => [

                    'label' =>
                        'emis.allow_card_renewal',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        120,
                ],

                'allow_card_replacement' => [

                    'label' =>
                        'emis.allow_card_replacement',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        130,
                ],

                'enable_qr_verification' => [

                    'label' =>
                        'emis.enable_qr_verification',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        140,
                ],
            ],
        ],
                /*
        |--------------------------------------------------------------------------
        | FILES & STORAGE
        |--------------------------------------------------------------------------
        */

        'storage' => [

            'group' =>
                'storage',

            'title' =>
                'emis.storage_settings',

            'description' =>
                'emis.storage_settings_description',

            'icon' =>
                'fa-solid fa-hard-drive',

            'order' =>
                90,

            'permission' =>
                'settings.manage',

            'fields' => [

                'default_upload_disk' => [

                    'label' =>
                        'emis.default_upload_disk',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'public',

                    'rules' => [
                        'required',
                        'string',
                        'in:public,local',
                    ],

                    'public' =>
                        false,

                    'options' => [
                        'public' =>
                            'Public Storage',

                        'local' =>
                            'Private Local Storage',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        10,
                ],

                'private_document_disk' => [

                    'label' =>
                        'emis.private_document_disk',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'local',

                    'rules' => [
                        'required',
                        'string',
                        'in:local,public',
                    ],

                    'public' =>
                        false,

                    'options' => [
                        'local' =>
                            'Private Local Storage',

                        'public' =>
                            'Public Storage',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        20,
                ],

                'maximum_upload_size_mb' => [

                    'label' =>
                        'emis.maximum_upload_size_mb',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        10,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:100',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        30,
                ],

                'allowed_document_formats' => [

                    'label' =>
                        'emis.allowed_document_formats',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        'pdf,doc,docx,xls,xlsx',

                    'rules' => [
                        'required',
                        'string',
                        'max:200',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        'pdf,doc,docx,xls,xlsx',

                    'column' =>
                        6,

                    'order' =>
                        40,
                ],

                'allowed_image_formats' => [

                    'label' =>
                        'emis.allowed_image_formats',

                    'input' =>
                        'text',

                    'type' =>
                        'string',

                    'default' =>
                        'jpg,jpeg,png,webp',

                    'rules' => [
                        'required',
                        'string',
                        'max:150',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        'jpg,jpeg,png,webp',

                    'column' =>
                        6,

                    'order' =>
                        50,
                ],

                'temporary_file_retention_days' => [

                    'label' =>
                        'emis.temporary_file_retention_days',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        7,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:90',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        60,
                ],

                'pdf_temporary_retention_days' => [

                    'label' =>
                        'emis.pdf_temporary_retention_days',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        3,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:30',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        70,
                ],

                'storage_warning_percentage' => [

                    'label' =>
                        'emis.storage_warning_percentage',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        85,

                    'rules' => [
                        'required',
                        'integer',
                        'min:50',
                        'max:99',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        80,
                ],

                'image_compression_enabled' => [

                    'label' =>
                        'emis.image_compression_enabled',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        90,
                ],

                'image_compression_quality' => [

                    'label' =>
                        'emis.image_compression_quality',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        85,

                    'rules' => [
                        'required',
                        'integer',
                        'min:40',
                        'max:100',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        100,
                ],

                'generate_unique_filenames' => [

                    'label' =>
                        'emis.generate_unique_filenames',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        110,
                ],
            ],
        ],
        // end of storage section

        /*
        |--------------------------------------------------------------------------
        | BACKUP CONFIGURATION
        |--------------------------------------------------------------------------
        */

        'backup' => [

            'group' =>
                'backup',

            'title' =>
                'emis.backup_settings',

            'description' =>
                'emis.backup_settings_description',

            'icon' =>
                'fa-solid fa-database',

            'order' =>
                100,

            'permission' =>
                'settings.manage',

            'fields' => [

                'automatic_backup_enabled' => [

                    'label' =>
                        'emis.automatic_backup_enabled',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        10,
                ],

                'backup_frequency' => [

                    'label' =>
                        'emis.backup_frequency',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'daily',

                    'rules' => [
                        'required',
                        'string',
                        'in:daily,weekly,monthly',
                    ],

                    'public' =>
                        false,

                    'options' => [
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'monthly' => 'Monthly',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        20,
                ],

                'backup_time' => [

                    'label' =>
                        'emis.backup_time',

                    'input' =>
                        'time',

                    'type' =>
                        'time',

                    'default' =>
                        '02:00',

                    'rules' => [
                        'required',
                        'date_format:H:i',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        30,
                ],

                'backup_disk' => [

                    'label' =>
                        'emis.backup_disk',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'local',

                    'rules' => [
                        'required',
                        'string',
                        'in:local,public',
                    ],

                    'public' =>
                        false,

                    'options' => [
                        'local' =>
                            'Private Local Storage',

                        'public' =>
                            'Public Storage',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        40,
                ],

                'retention_count' => [

                    'label' =>
                        'emis.backup_retention_count',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        14,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:365',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        50,
                ],

                'include_uploaded_files' => [

                    'label' =>
                        'emis.include_uploaded_files',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        60,
                ],

                'verify_backup_checksum' => [

                    'label' =>
                        'emis.verify_backup_checksum',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        70,
                ],

                'create_pre_restore_backup' => [

                    'label' =>
                        'emis.create_pre_restore_backup',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        80,
                ],

                'notify_backup_success' => [

                    'label' =>
                        'emis.notify_backup_success',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        false,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        90,
                ],

                'notify_backup_failure' => [

                    'label' =>
                        'emis.notify_backup_failure',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        100,
                ],
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | REPORTS & DATA RETENTION
        |--------------------------------------------------------------------------
        */

        'reports_retention' => [

            'group' =>
                'reports_retention',

            'title' =>
                'emis.reports_retention_settings',

            'description' =>
                'emis.reports_retention_settings_description',

            'icon' =>
                'fa-solid fa-chart-column',

            'order' =>
                110,

            'permission' =>
                'settings.manage',

            'fields' => [

                'default_export_format' => [

                    'label' =>
                        'emis.default_export_format',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'pdf',

                    'rules' => [
                        'required',
                        'string',
                        'in:pdf,xlsx,csv',
                    ],

                    'public' =>
                        false,

                    'options' => [
                        'pdf' => 'PDF',
                        'xlsx' => 'Microsoft Excel',
                        'csv' => 'CSV',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        10,
                ],

                'pdf_page_size' => [

                    'label' =>
                        'emis.pdf_page_size',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'A4',

                    'rules' => [
                        'required',
                        'string',
                        'in:A4,A3,letter',
                    ],

                    'public' =>
                        false,

                    'options' => [
                        'A4' => 'A4',
                        'A3' => 'A3',
                        'letter' => 'Letter',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        20,
                ],

                'pdf_orientation' => [

                    'label' =>
                        'emis.pdf_orientation',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'portrait',

                    'rules' => [
                        'required',
                        'string',
                        'in:portrait,landscape',
                    ],

                    'public' =>
                        false,

                    'options' => [
                        'portrait' => 'Portrait',
                        'landscape' => 'Landscape',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        30,
                ],

                'include_organization_logo' => [

                    'label' =>
                        'emis.include_organization_logo',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        40,
                ],

                'include_generated_by' => [

                    'label' =>
                        'emis.include_generated_by',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        50,
                ],

                'include_generation_date' => [

                    'label' =>
                        'emis.include_generation_date',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        60,
                ],

                'audit_log_retention_days' => [

                    'label' =>
                        'emis.audit_log_retention_days',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        730,

                    'rules' => [
                        'required',
                        'integer',
                        'min:30',
                        'max:3650',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        70,
                ],

                'generated_report_retention_days' => [

                    'label' =>
                        'emis.generated_report_retention_days',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        30,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:365',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        80,
                ],

                'export_file_retention_days' => [

                    'label' =>
                        'emis.export_file_retention_days',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        7,

                    'rules' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:90',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        90,
                ],

                'allow_sensitive_data_export' => [

                    'label' =>
                        'emis.allow_sensitive_data_export',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        false,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        100,
                ],

                'watermark_confidential_reports' => [

                    'label' =>
                        'emis.watermark_confidential_reports',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        110,
                ],
            ],
        ],
        /*
        |--------------------------------------------------------------------------
        | MAINTENANCE & DIAGNOSTICS
        |--------------------------------------------------------------------------
        */

        'maintenance' => [

            'group' =>
                'maintenance',

            'title' =>
                'emis.maintenance_settings',

            'description' =>
                'emis.maintenance_settings_description',

            'icon' =>
                'fa-solid fa-screwdriver-wrench',

            'order' =>
                120,

            'permission' =>
                'settings.manage',

            'fields' => [

                'maintenance_message' => [

                    'label' =>
                        'emis.maintenance_message',

                    'input' =>
                        'textarea',

                    'type' =>
                        'text',

                    'default' =>
                        'The system is temporarily unavailable for maintenance.',

                    'rules' => [
                        'nullable',
                        'string',
                        'max:1000',
                    ],

                    'public' =>
                        true,

                    'rows' =>
                        3,

                    'column' =>
                        12,

                    'order' =>
                        10,
                ],

                'maintenance_allowed_ips' => [

                    'label' =>
                        'emis.maintenance_allowed_ips',

                    'input' =>
                        'textarea',

                    'type' =>
                        'text',

                    'default' =>
                        '127.0.0.1',

                    'rules' => [
                        'nullable',
                        'string',
                        'max:2000',
                    ],

                    'public' =>
                        false,

                    'placeholder' =>
                        'One IP address per line',

                    'rows' =>
                        3,

                    'column' =>
                        12,

                    'order' =>
                        20,
                ],

                'log_level' => [

                    'label' =>
                        'emis.log_level',

                    'input' =>
                        'select',

                    'type' =>
                        'string',

                    'default' =>
                        'error',

                    'rules' => [
                        'required',
                        'string',
                        'in:debug,info,warning,error,critical',
                    ],

                    'public' =>
                        false,

                    'options' => [
                        'debug' => 'Debug',
                        'info' => 'Information',
                        'warning' => 'Warning',
                        'error' => 'Error',
                        'critical' => 'Critical',
                    ],

                    'column' =>
                        4,

                    'order' =>
                        30,
                ],

                'log_retention_days' => [

                    'label' =>
                        'emis.log_retention_days',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        30,

                    'rules' => [
                        'required',
                        'integer',
                        'min:7',
                        'max:365',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        40,
                ],

                'diagnostics_retention_days' => [

                    'label' =>
                        'emis.diagnostics_retention_days',

                    'input' =>
                        'number',

                    'type' =>
                        'integer',

                    'default' =>
                        30,

                    'rules' => [
                        'required',
                        'integer',
                        'min:7',
                        'max:365',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        50,
                ],

                'queue_monitoring_enabled' => [

                    'label' =>
                        'emis.queue_monitoring_enabled',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        60,
                ],

                'scheduler_monitoring_enabled' => [

                    'label' =>
                        'emis.scheduler_monitoring_enabled',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        70,
                ],

                'database_monitoring_enabled' => [

                    'label' =>
                        'emis.database_monitoring_enabled',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        80,
                ],

                'storage_monitoring_enabled' => [

                    'label' =>
                        'emis.storage_monitoring_enabled',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        true,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        90,
                ],

                'daily_diagnostics_enabled' => [

                    'label' =>
                        'emis.daily_diagnostics_enabled',

                    'input' =>
                        'switch',

                    'type' =>
                        'boolean',

                    'default' =>
                        false,

                    'rules' => [
                        'required',
                        'boolean',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        100,
                ],

                'daily_diagnostics_time' => [

                    'label' =>
                        'emis.daily_diagnostics_time',

                    'input' =>
                        'time',

                    'type' =>
                        'time',

                    'default' =>
                        '01:00',

                    'rules' => [
                        'required',
                        'date_format:H:i',
                    ],

                    'public' =>
                        false,

                    'column' =>
                        4,

                    'order' =>
                        110,
                ],
            ],
        ],
        // new
    ],

    /*
    |--------------------------------------------------------------------------
    | Future Settings Sections
    |--------------------------------------------------------------------------
    |
    | These are intentionally not enabled yet.
    |
    | We will add them one by one after General Settings works:
    |
    | organization
    | localization
    | security
    | notifications
    | correspondence
    | workflow
    | budget_coordination
    | storage
    | backup
    | reports_retention
    | maintenance
    |
    */

];