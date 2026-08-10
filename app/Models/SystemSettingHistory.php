<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemSettingHistory extends Model
{
    /**
     * Database table.
     */
    protected $table = 'system_setting_histories';

    /**
     * This table only has created_at.
     */
    public $timestamps = false;

    /**
     * Mass-assignable attributes.
     */
    protected $fillable = [
        'system_setting_id',
        'setting_group',
        'setting_key',
        'old_value',
        'new_value',
        'value_type',
        'action',
        'changed_by',
        'ip_address',
        'user_agent',
        'route_name',
        'request_method',
        'metadata',
        'created_at',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Original system setting.
     */
    public function setting(): BelongsTo
    {
        return $this->belongsTo(
            SystemSetting::class,
            'system_setting_id'
        );
    }

    /**
     * User who performed the change.
     */
    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'changed_by'
        );
    }

    /**
     * Filter history by Settings group.
     */
    public function scopeGroup(
        Builder $query,
        string $group
    ): Builder {
        return $query->where(
            'setting_group',
            $group
        );
    }

    /**
     * Filter history by setting key.
     */
    public function scopeKey(
        Builder $query,
        string $key
    ): Builder {
        return $query->where(
            'setting_key',
            $key
        );
    }

    /**
     * Filter history by action.
     */
    public function scopeAction(
        Builder $query,
        string $action
    ): Builder {
        return $query->where(
            'action',
            $action
        );
    }

    /**
     * Complete dot-notation setting key.
     *
     * Example:
     * general.system_name
     */
    public function getFullKeyAttribute(): string
    {
        return sprintf(
            '%s.%s',
            $this->setting_group,
            $this->setting_key
        );
    }
}