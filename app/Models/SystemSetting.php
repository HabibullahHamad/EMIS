<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SystemSetting extends Model
{
    /**
     * Database table.
     */
    protected $table = 'system_settings';

    /**
     * Fields allowed for mass assignment.
     */
    protected $fillable = [
        'setting_group',
        'setting_key',
        'setting_value',
        'value_type',
        'is_public',
        'description',
        'updated_by',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    /**
     * User who last changed the setting.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'updated_by'
        );
    }

    /**
     * Complete change history for this setting.
     */
    public function histories(): HasMany
    {
        return $this->hasMany(
            SystemSettingHistory::class,
            'system_setting_id'
        )->latest('created_at');
    }

    /**
     * Filter settings by group.
     *
     * Example:
     * SystemSetting::group('general')->get();
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
     * Filter by setting key.
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
     * Return only public settings.
     */
    public function scopePublic(
        Builder $query
    ): Builder {
        return $query->where(
            'is_public',
            true
        );
    }

    /**
     * Create the standard dot notation identifier.
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

    /**
     * Return the stored value cast to its configured type.
     */
    public function getTypedValueAttribute(): mixed
    {
        return match ($this->value_type) {
            'integer' => $this->setting_value !== null
                ? (int) $this->setting_value
                : null,

            'decimal' => $this->setting_value !== null
                ? (float) $this->setting_value
                : null,

            'boolean' => $this->castBoolean(
                $this->setting_value
            ),

            'json' => $this->decodeJson(
                $this->setting_value
            ),

            default => $this->setting_value,
        };
    }

    /**
     * Safely convert a stored value to boolean.
     */
    private function castBoolean(
        mixed $value
    ): bool {
        if (is_bool($value)) {
            return $value;
        }

        return in_array(
            strtolower((string) $value),
            [
                '1',
                'true',
                'yes',
                'on',
                'enabled',
            ],
            true
        );
    }

    /**
     * Safely decode JSON.
     */
    private function decodeJson(
        ?string $value
    ): mixed {
        if ($value === null || $value === '') {
            return null;
        }

        $decoded = json_decode(
            $value,
            true
        );

        return json_last_error() === JSON_ERROR_NONE
            ? $decoded
            : null;
    }
}