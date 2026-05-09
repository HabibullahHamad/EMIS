<?php

use App\Models\AuditLog;
use App\Models\Notification;

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
  if (!function_exists('notify_user')) {
    function notify_user($userId, $title, $message, $type = 'general', $priority = 'normal', $related = null)
    {
        if (!$userId) {
            return;
        }

        \App\Models\Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'priority' => $priority,
            'related_type' => $related ? get_class($related) : null,
            'related_id' => $related?->id,
        ]);
    }
}
if (!function_exists('afghan_date')) {

    function afghan_date($date)
    {
        if (!$date) {
            return '-';
        }

        try {

            $jalali = \Morilog\Jalali\Jalalian::fromCarbon(
                \Carbon\Carbon::parse($date)
            );

            $months = [

                'فروردین' => 'حمل',
                'اردیبهشت' => 'ثور',
                'خرداد' => 'جوزا',
                'تیر' => 'سرطان',
                'مرداد' => 'اسد',
                'شهریور' => 'سنبله',
                'مهر' => 'میزان',
                'آبان' => 'عقرب',
                'آذر' => 'قوس',
                'دی' => 'جدی',
                'بهمن' => 'دلو',
                'اسفند' => 'حوت',

            ];

            // IMPORTANT
            $formatted = $jalali->format('Y F d');

            foreach ($months as $fa => $af) {

                $formatted = str_replace($fa, $af, $formatted);

            }

            return $formatted;

        } catch (\Exception $e) {

            return '-';

        }
    }

}
}