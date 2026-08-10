<?php

namespace App\Services\Settings;

use App\Models\SystemSetting;
use App\Models\SystemSettingHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class SystemSettingService
{
    /**
     * One central cache entry for all EMIS settings.
     */
    private const CACHE_KEY = 'emis.system_settings.all';

    /**
     * Supported database value types.
     */
    private const SUPPORTED_TYPES = [
        'string',
        'text',
        'integer',
        'decimal',
        'boolean',
        'json',
        'email',
        'url',
        'color',
        'date',
        'time',
        'file',
        'image',
    ];

    /**
     * Environment / server values that must never be managed
     * through the web Settings Center.
     */
    private const PROTECTED_KEYS = [
        'app_key',
        'db_host',
        'db_database',
        'db_username',
        'db_password',
        'mail_password',
        'server_credentials',
    ];

    /**
     * Get one setting using dot notation.
     *
     * Example:
     *
     * $settings->get('general.system_name', 'EMIS');
     */
    public function get(
        string $fullKey,
        mixed $default = null
    ): mixed {
        [$group, $key] = $this->parseKey($fullKey);

        $settings = $this->all();

        if (
            isset($settings[$group]) &&
            array_key_exists($key, $settings[$group])
        ) {
            return $settings[$group][$key];
        }

        return $default;
    }

    /**
     * Determine whether a setting exists.
     */
    public function has(string $fullKey): bool
    {
        [$group, $key] = $this->parseKey($fullKey);

        $settings = $this->all();

        return isset($settings[$group])
            && array_key_exists(
                $key,
                $settings[$group]
            );
    }

    /**
     * Return one complete group.
     *
     * Example:
     *
     * $settings->group('general');
     */
    public function group(string $group): array
    {
        $group = $this->normalizeSegment($group);

        return $this->all()[$group] ?? [];
    }

    /**
     * Return every stored setting grouped by section.
     *
     * Example:
     *
     * [
     *     'general' => [
     *         'system_name' => 'EMIS',
     *     ],
     * ]
     */
    public function all(): array
    {
        return Cache::rememberForever(
            self::CACHE_KEY,
            function (): array {
                $result = [];

                SystemSetting::query()
                    ->orderBy('setting_group')
                    ->orderBy('setting_key')
                    ->get()
                    ->each(
                        function (
                            SystemSetting $setting
                        ) use (&$result): void {
                            $result[
                                $setting->setting_group
                            ][
                                $setting->setting_key
                            ] = $setting->typed_value;
                        }
                    );

                return $result;
            }
        );
    }

    /**
     * Return only settings marked public.
     */
    public function publicSettings(): array
    {
        $result = [];

        SystemSetting::query()
            ->public()
            ->orderBy('setting_group')
            ->orderBy('setting_key')
            ->get()
            ->each(
                function (
                    SystemSetting $setting
                ) use (&$result): void {
                    $result[
                        $setting->setting_group
                    ][
                        $setting->setting_key
                    ] = $setting->typed_value;
                }
            );

        return $result;
    }

    /**
     * Create or update a setting.
     */
    public function set(
        string $fullKey,
        mixed $value,
        string $type = 'string',
        bool $isPublic = false,
        ?string $description = null
    ): SystemSetting {
        [$group, $key] = $this->parseKey(
            $fullKey
        );

        $this->ensureKeyIsAllowed($key);

        $type = $this->normalizeType($type);

        $serializedValue = $this->serializeValue(
            $value,
            $type
        );

        $setting = DB::transaction(
            function () use (
                $group,
                $key,
                $serializedValue,
                $type,
                $isPublic,
                $description
            ): SystemSetting {
                $setting = SystemSetting::query()
                    ->where(
                        'setting_group',
                        $group
                    )
                    ->where(
                        'setting_key',
                        $key
                    )
                    ->first();

                $action = $setting
                    ? 'updated'
                    : 'created';

                $oldValue = $setting?->setting_value;

                $oldType = $setting?->value_type;
                $oldPublic = $setting?->is_public;
                $oldDescription = $setting?->description;

                /*
                 * Avoid unnecessary writes and history rows.
                 */
                if (
                    $setting &&
                    $oldValue === $serializedValue &&
                    $oldType === $type &&
                    (bool) $oldPublic === $isPublic &&
                    $oldDescription === $description
                ) {
                    return $setting;
                }

                if (!$setting) {
                    $setting = new SystemSetting();

                    $setting->setting_group = $group;
                    $setting->setting_key = $key;
                }

                $setting->setting_value =
                    $serializedValue;

                $setting->value_type = $type;

                $setting->is_public = $isPublic;

                $setting->description =
                    $description;

                $setting->updated_by =
                    Auth::id();

                $setting->save();

                $this->writeHistory(
                    setting: $setting,
                    oldValue: $oldValue,
                    newValue: $serializedValue,
                    action: $action,
                    metadata: [
                        'old_type' => $oldType,
                        'new_type' => $type,

                        'old_is_public' =>
                            $oldPublic,

                        'new_is_public' =>
                            $isPublic,

                        'old_description' =>
                            $oldDescription,

                        'new_description' =>
                            $description,
                    ]
                );

                return $setting;
            }
        );

        $this->clearCache();

        return $setting->refresh();
    }

    /**
     * Save several settings in one operation.
     *
     * Example:
     *
     * $settings->setMany([
     *     'general.system_name' => [
     *         'value' => 'EMIS',
     *         'type' => 'string',
     *     ],
     * ]);
     */
    public function setMany(
        array $settings
    ): array {
        $saved = [];

        foreach ($settings as $fullKey => $definition) {
            if (
                is_array($definition) &&
                array_key_exists(
                    'value',
                    $definition
                )
            ) {
                $saved[$fullKey] = $this->set(
                    fullKey: $fullKey,
                    value: $definition['value'],
                    type: $definition['type']
                        ?? 'string',
                    isPublic:
                        $definition['public']
                        ?? false,
                    description:
                        $definition['description']
                        ?? null
                );

                continue;
            }

            $saved[$fullKey] = $this->set(
                $fullKey,
                $definition
            );
        }

        return $saved;
    }

    /**
     * Remove one setting while keeping its history.
     */
    public function forget(
        string $fullKey
    ): bool {
        [$group, $key] = $this->parseKey(
            $fullKey
        );

        $setting = SystemSetting::query()
            ->where(
                'setting_group',
                $group
            )
            ->where(
                'setting_key',
                $key
            )
            ->first();

        if (!$setting) {
            return false;
        }

        DB::transaction(
            function () use ($setting): void {
                $this->writeHistory(
                    setting: $setting,
                    oldValue:
                        $setting->setting_value,
                    newValue: null,
                    action: 'deleted'
                );

                $setting->delete();
            }
        );

        $this->clearCache();

        return true;
    }

    /**
     * Clear Settings cache.
     */
    public function clearCache(): void
    {
        Cache::forget(
            self::CACHE_KEY
        );
    }

    /**
     * Parse:
     *
     * general.system_name
     *
     * into:
     *
     * general
     * system_name
     */
    private function parseKey(
        string $fullKey
    ): array {
        $fullKey = trim($fullKey);

        $parts = explode(
            '.',
            $fullKey,
            2
        );

        if (
            count($parts) !== 2 ||
            trim($parts[0]) === '' ||
            trim($parts[1]) === ''
        ) {
            throw new InvalidArgumentException(
                'Setting key must use group.key format.'
            );
        }

        return [
            $this->normalizeSegment(
                $parts[0]
            ),

            $this->normalizeSegment(
                $parts[1]
            ),
        ];
    }

    /**
     * Normalize group/key naming.
     */
    private function normalizeSegment(
        string $value
    ): string {
        return strtolower(
            trim($value)
        );
    }

    /**
     * Validate supported value type.
     */
    private function normalizeType(
        string $type
    ): string {
        $type = strtolower(
            trim($type)
        );

        if (
            !in_array(
                $type,
                self::SUPPORTED_TYPES,
                true
            )
        ) {
            throw new InvalidArgumentException(
                sprintf(
                    'Unsupported setting type: %s',
                    $type
                )
            );
        }

        return $type;
    }

    /**
     * Convert application values into database strings.
     */
    private function serializeValue(
        mixed $value,
        string $type
    ): ?string {
        if ($value === null) {
            return null;
        }

        return match ($type) {
            'boolean' =>
                $this->serializeBoolean(
                    $value
                ),

            'json' =>
                $this->serializeJson(
                    $value
                ),

            'integer' =>
                (string) (int) $value,

            'decimal' =>
                (string) (float) $value,

            default =>
                (string) $value,
        };
    }

    /**
     * Convert boolean-like values to 1 or 0.
     */
    private function serializeBoolean(
        mixed $value
    ): string {
        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        $boolean = filter_var(
            $value,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );

        return $boolean === true
            ? '1'
            : '0';
    }

    /**
     * Encode JSON safely.
     */
    private function serializeJson(
        mixed $value
    ): string {
        if (is_string($value)) {
            json_decode(
                $value,
                true
            );

            if (
                json_last_error()
                === JSON_ERROR_NONE
            ) {
                return $value;
            }
        }

        return json_encode(
            $value,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
            | JSON_THROW_ON_ERROR
        );
    }

    /**
     * Protect environment/server credentials.
     */
    private function ensureKeyIsAllowed(
        string $key
    ): void {
        if (
            in_array(
                strtolower($key),
                self::PROTECTED_KEYS,
                true
            )
        ) {
            throw new InvalidArgumentException(
                'This setting cannot be managed through the EMIS Settings Center.'
            );
        }
    }

    /**
     * Write append-only history.
     */
    private function writeHistory(
        SystemSetting $setting,
        ?string $oldValue,
        ?string $newValue,
        string $action,
        array $metadata = []
    ): void {
        $request = app()->bound('request')
            ? request()
            : null;

        SystemSettingHistory::create([
            'system_setting_id' =>
                $setting->id,

            'setting_group' =>
                $setting->setting_group,

            'setting_key' =>
                $setting->setting_key,

            'old_value' =>
                $oldValue,

            'new_value' =>
                $newValue,

            'value_type' =>
                $setting->value_type,

            'action' =>
                $action,

            'changed_by' =>
                Auth::id(),

            'ip_address' =>
                $request?->ip(),

            'user_agent' =>
                $request?->userAgent(),

            'route_name' =>
                $request?->route()?->getName(),

            'request_method' =>
                $request?->method(),

            'metadata' =>
                $metadata !== []
                    ? $metadata
                    : null,

            'created_at' =>
                now(),
        ]);
    }
}