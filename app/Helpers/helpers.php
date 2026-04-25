<?php
use App\Models\AuditLog;
use App\Models\Setting;

if (! function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        $settings = Setting::current();

        return $settings->{$key} ?? $default;
    }
    

    // auditlogs



if (! function_exists('audit_log')) {
    function audit_log($action, $model = null, $oldValues = null, $newValues = null)
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
}