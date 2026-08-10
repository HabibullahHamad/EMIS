<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingsSectionRequest extends FormRequest
{
    /**
     * Determine whether the current user may submit
     * a Settings form.
     *
     * Fine-grained permissions will be added later.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Return the current Settings section.
     *
     * Example:
     *
     * /admin/settings/general
     *
     * returns:
     *
     * general
     */
    public function section(): string
    {
        $section = $this->route('section');

        if (
            !is_string($section) ||
            trim($section) === ''
        ) {
            return 'general';
        }

        return strtolower(
            trim($section)
        );
    }

    /**
     * Return the configuration for the current section.
     */
    public function sectionConfig(): array
    {
        return config(
            'emis-settings.sections.'
            . $this->section(),
            []
        );
    }

    /**
     * Return the configured fields for the current section.
     */
    public function fields(): array
    {
        return $this->sectionConfig()['fields']
            ?? [];
    }

    /**
     * Dynamically build Laravel validation rules from
     * config/emis-settings.php.
     */
    public function rules(): array
    {
        $rules = [];

        foreach (
            $this->fields()
            as $key => $field
        ) {
            /*
             * Ignore incorrectly configured fields.
             */
            if (!is_array($field)) {
                continue;
            }

            $fieldRules = $field['rules']
                ?? [];

            if (is_string($fieldRules)) {
                $fieldRules = explode(
                    '|',
                    $fieldRules
                );
            }

            if (!is_array($fieldRules)) {
                $fieldRules = [];
            }

            /*
             * Add the configured validation rules.
             */
            $rules[$key] = $fieldRules;
        }

        return $rules;
    }

    /**
     * User-friendly validation field names.
     *
     * If the configured label is a Laravel translation key,
     * translate it automatically.
     */
    public function attributes(): array
    {
        $attributes = [];

        foreach (
            $this->fields()
            as $key => $field
        ) {
            if (!is_array($field)) {
                continue;
            }

            $label = $field['label']
                ?? $key;

            if (
                is_string($label) &&
                str_contains($label, '.')
            ) {
                $translated = __($label);

                /*
                 * When a translation key is missing,
                 * Laravel returns the original key.
                 */
                $attributes[$key] =
                    $translated !== $label
                        ? $translated
                        : $this->humanize($key);

                continue;
            }

            $attributes[$key] =
                is_string($label)
                    ? $label
                    : $this->humanize($key);
        }

        return $attributes;
    }

    /**
     * Normalize incoming Settings values before validation.
     */
    protected function prepareForValidation(): void
    {
        $prepared = [];

        foreach (
            $this->fields()
            as $key => $field
        ) {
            if (!is_array($field)) {
                continue;
            }

            $inputType = strtolower(
                (string) (
                    $field['input']
                    ?? 'text'
                )
            );

            $valueType = strtolower(
                (string) (
                    $field['type']
                    ?? 'string'
                )
            );

            /*
             * Boolean/checkbox values:
             *
             * HTML does not submit unchecked checkboxes,
             * therefore convert missing checkbox values to 0.
             */
            if (
                in_array(
                    $inputType,
                    [
                        'checkbox',
                        'switch',
                        'toggle',
                    ],
                    true
                ) ||
                $valueType === 'boolean'
            ) {
                $prepared[$key] =
                    $this->booleanInput(
                        $key
                    );

                continue;
            }

            /*
             * Do not modify uploaded files.
             */
            if (
                in_array(
                    $inputType,
                    [
                        'file',
                        'image',
                    ],
                    true
                )
            ) {
                continue;
            }

            /*
             * Trim normal string inputs.
             */
            if (
                $this->exists($key) &&
                is_string(
                    $this->input($key)
                )
            ) {
                $prepared[$key] =
                    trim(
                        $this->input($key)
                    );
            }
        }

        if ($prepared !== []) {
            $this->merge(
                $prepared
            );
        }
    }

    /**
     * Return only values that belong to the current
     * Settings section.
     *
     * This prevents unexpected request fields from
     * being written to system_settings.
     */
    public function settingsData(): array
    {
        $validated = $this->validated();

        $result = [];

        foreach (
            $this->fields()
            as $key => $field
        ) {
            if (!is_array($field)) {
                continue;
            }

            $inputType = strtolower(
                (string) (
                    $field['input']
                    ?? 'text'
                )
            );

            /*
             * Uploaded files are handled separately
             * by the controller/service.
             */
            if (
                in_array(
                    $inputType,
                    [
                        'file',
                        'image',
                    ],
                    true
                )
            ) {
                continue;
            }

            if (
                array_key_exists(
                    $key,
                    $validated
                )
            ) {
                $result[$key] =
                    $validated[$key];
            }
        }

        return $result;
    }

    /**
     * Return validated uploaded files belonging to
     * this Settings section.
     */
    public function settingsFiles(): array
    {
        $files = [];

        foreach (
            $this->fields()
            as $key => $field
        ) {
            if (!is_array($field)) {
                continue;
            }

            $inputType = strtolower(
                (string) (
                    $field['input']
                    ?? 'text'
                )
            );

            if (
                !in_array(
                    $inputType,
                    [
                        'file',
                        'image',
                    ],
                    true
                )
            ) {
                continue;
            }

            if ($this->hasFile($key)) {
                $files[$key] =
                    $this->file($key);
            }
        }

        return $files;
    }

    /**
     * Determine whether the configured section exists.
     */
    public function sectionExists(): bool
    {
        return $this->sectionConfig()
            !== [];
    }

    /**
     * Safely normalize HTML boolean input.
     */
    private function booleanInput(
        string $key
    ): bool {
        if (!$this->exists($key)) {
            return false;
        }

        $value = $this->input($key);

        if (is_bool($value)) {
            return $value;
        }

        return filter_var(
            $value,
            FILTER_VALIDATE_BOOLEAN
        );
    }

    /**
     * Convert:
     *
     * support_email
     *
     * into:
     *
     * Support Email
     */
    private function humanize(
        string $value
    ): string {
        return ucwords(
            str_replace(
                [
                    '_',
                    '-',
                ],
                ' ',
                $value
            )
        );
    }
}