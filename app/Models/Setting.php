<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'system_name',
        'system_short_name',
        'default_language',
        'timezone',
        'date_format',
        'system_description',
        'organization_name',
        'department_name',
        'contact_email',
        'contact_phone',
        'enable_user_registration',
        'enable_task_notifications',
        'enable_document_tracking',
        'email_notifications',
        'browser_notifications',
        'password_min_length',
        'session_timeout',
        'maintenance_mode',
        'debug_mode',
        'logo_path',
    ];

    protected $casts = [
        'enable_user_registration' => 'boolean',
        'enable_task_notifications' => 'boolean',
        'enable_document_tracking' => 'boolean',
        'email_notifications' => 'boolean',
        'browser_notifications' => 'boolean',
        'maintenance_mode' => 'boolean',
        'debug_mode' => 'boolean',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'system_name' => 'Executive Management Information System',
            'system_short_name' => 'EMIS',
            'default_language' => 'en',
            'timezone' => 'Asia/Kabul',
            'date_format' => 'Y-m-d',
        ]);
    }
}