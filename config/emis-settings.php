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