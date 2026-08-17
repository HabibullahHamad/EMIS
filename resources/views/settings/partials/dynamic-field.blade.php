@php
    /*
    |--------------------------------------------------------------------------
    | Expected variables
    |--------------------------------------------------------------------------
    |
    | $fieldKey
    | $field
    | $value
    |
    */

    $fieldKey = (string) ($fieldKey ?? '');

    $field = is_array($field ?? null)
        ? $field
        : [];

    $inputType = strtolower(
        (string) ($field['input'] ?? 'text')
    );

    $column = (int) ($field['column'] ?? 12);

    $column = max(
        1,
        min(12, $column)
    );
$translateFieldText = function (
    mixed $text,
    string $fallback = ''
): string {
    if (!is_string($text) || trim($text) === '') {
        return $fallback;
    }

    $translated = __($text);

    if (!is_string($translated)) {
        return $fallback;
    }

    return $translated === $text
        ? $fallback
        : $translated;
};

    $humanizedKey = str($fieldKey)
        ->replace('_', ' ')
        ->title()
        ->toString();

    $label = $translateFieldText(
        $field['label'] ?? null,
        $humanizedKey
    );

    $help = $translateFieldText(
        $field['help'] ?? null,
        ''
    );

    $placeholderValue = $field['placeholder']
        ?? '';

    $placeholder = $translateFieldText(
        $placeholderValue,
        is_string($placeholderValue)
            ? $placeholderValue
            : ''
    );

    $resolvedValue = old(
        $fieldKey,
        $value ?? $field['default'] ?? null
    );

    $isRequired = in_array(
        'required',
        (array) ($field['rules'] ?? []),
        true
    );

    $fieldId = 'settings-field-'
        . str_replace('_', '-', $fieldKey);

    $hasError = $errors->has($fieldKey);
@endphp

<div
    class="settings-field {{ $hasError ? 'settings-field--invalid' : '' }}"
    style="--settings-field-column: {{ $column }};"
>
    @if($inputType !== 'image')
        <label
            for="{{ $fieldId }}"
            class="settings-field__label"
        >
            {{ $label }}

            @if($isRequired)
                <span
                    class="settings-field__required"
                    aria-hidden="true"
                >*</span>
            @endif
        </label>
    @endif

    @switch($inputType)

        @case('textarea')
            <textarea
                id="{{ $fieldId }}"
                name="{{ $fieldKey }}"
                rows="{{ max(2, (int) ($field['rows'] ?? 3)) }}"
                class="settings-field__control settings-field__textarea"
                placeholder="{{ $placeholder }}"
                @if($isRequired) required @endif
                @if($hasError) aria-invalid="true" @endif
            >{{ $resolvedValue }}</textarea>
            @break

        @case('select')
            <select
                id="{{ $fieldId }}"
                name="{{ $fieldKey }}"
                class="settings-field__control settings-field__select"
                @if($isRequired) required @endif
                @if($hasError) aria-invalid="true" @endif
            >
                @unless($isRequired)
                    <option value="">
                        {{ __('Select an option') }}
                    </option>
                @endunless

                @foreach(($field['options'] ?? []) as $optionValue => $optionLabel)
                    @php
                        $resolvedOptionLabel =
                            $translateFieldText(
                                $optionLabel,
                                is_string($optionLabel)
                                    ? $optionLabel
                                    : (string) $optionValue
                            );
                    @endphp

                    <option
                        value="{{ $optionValue }}"
                        @selected(
                            (string) $resolvedValue
                            === (string) $optionValue
                        )
                    >
                        {{ $resolvedOptionLabel }}
                    </option>
                @endforeach
            </select>
            @break

        @case('color')
            @php
                $colorValue = is_string($resolvedValue)
                    && preg_match(
                        '/^#[0-9a-fA-F]{6}$/',
                        $resolvedValue
                    )
                        ? $resolvedValue
                        : '#173d7a';
            @endphp

            <div class="settings-field__color-row">
                <input
                    type="color"
                    id="{{ $fieldId }}"
                    name="{{ $fieldKey }}"
                    value="{{ $colorValue }}"
                    class="settings-field__color"
                    @if($isRequired) required @endif
                >

                <span class="settings-field__color-value">
                    {{ $colorValue }}
                </span>
            </div>
            @break
        @case('checkbox')
        @case('switch')
        @case('toggle')
            @php
                $checkedValue = filter_var(
                    $resolvedValue,
                    FILTER_VALIDATE_BOOLEAN
                );
            @endphp

            <input
                type="hidden"
                name="{{ $fieldKey }}"
                value="0"
            >

            <label
                class="settings-field__switch"
                for="{{ $fieldId }}"
            >
                <input
                    type="checkbox"
                    id="{{ $fieldId }}"
                    name="{{ $fieldKey }}"
                    value="1"
                    class="settings-field__switch-input"
                    @checked($checkedValue)
                >

                <span class="settings-field__switch-control">
                    <span class="settings-field__switch-knob"></span>
                </span>

                <span class="settings-field__switch-text">
                    {{ $checkedValue ? __('Enabled') : __('Disabled') }}
                </span>
            </label>
            @break
        @case('image')
            @php
                $imageValue = is_string($value ?? null)
                    ? trim((string) $value)
                    : '';

                $imagePreview = '';

                if ($imageValue !== '') {
                    $imagePreview = str_starts_with(
                        $imageValue,
                        'http://'
                    ) || str_starts_with(
                        $imageValue,
                        'https://'
                    )
                        ? $imageValue
                        : asset(
                            str_starts_with(
                                $imageValue,
                                'storage/'
                            )
                                ? $imageValue
                                : 'storage/'
                                    . ltrim($imageValue, '/')
                        );
                }
            @endphp

            <div class="settings-field__image-box">
                <div class="settings-field__image-preview">
                    @if($imagePreview !== '')
                        <img
                            src="{{ $imagePreview }}"
                            alt="{{ $label }}"
                        >
                    @else
                        <i class="fa-regular fa-image"></i>
                    @endif
                </div>

                <div class="settings-field__image-content">
                    <label
                        for="{{ $fieldId }}"
                        class="settings-field__label"
                    >
                        {{ $label }}

                        @if($isRequired)
                            <span
                                class="settings-field__required"
                                aria-hidden="true"
                            >*</span>
                        @endif
                    </label>

                    <input
                        type="file"
                        id="{{ $fieldId }}"
                        name="{{ $fieldKey }}"
                        accept="image/png,image/jpeg,image/webp"
                        class="settings-field__file"
                        @if($isRequired && $imageValue === '')
                            required
                        @endif
                    >
                </div>
            </div>
            @break

        @default
            <input
                type="{{ in_array(
                    $inputType,
                    ['text', 'email', 'url', 'number', 'time'],
                    true
                ) ? $inputType : 'text' }}"
                id="{{ $fieldId }}"
                name="{{ $fieldKey }}"
                value="{{ $resolvedValue }}"
                class="settings-field__control"
                placeholder="{{ $placeholder }}"
                @if($isRequired) required @endif
                @if($hasError) aria-invalid="true" @endif
            >
    @endswitch

    @if($help !== '')
        <p class="settings-field__help">
            {{ $help }}
        </p>
    @endif

    @error($fieldKey)
        <p class="settings-field__error">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ $message }}
        </p>
    @enderror
</div>

@once
    @push('styles')
        <style>
            .settings-field {
                grid-column:
                    span var(--settings-field-column);

                min-width: 0;
            }

            .settings-field__label {
                display: block;

                margin-bottom: 7px;

                color: #25324a;

                font-size: 13px;
                font-weight: 700;
            }

            .settings-field__required {
                color: #dc2626;
            }

            .settings-field__control {
                width: 100%;
                min-height: 42px;

                padding: 9px 12px;

                color: #1f2937;
                background: #ffffff;

                border: 1px solid #d8dee8;
                border-radius: 8px;

                font-size: 13px;

                outline: none;

                transition:
                    border-color 0.2s ease,
                    box-shadow 0.2s ease;
            }

            .settings-field__control:focus {
                border-color: #316ab2;

                box-shadow:
                    0 0 0 3px
                    rgba(49, 106, 178, 0.12);
            }

            .settings-field--invalid
            .settings-field__control {
                border-color: #dc2626;
            }

            .settings-field__textarea {
                resize: vertical;
                line-height: 1.65;
            }

            .settings-field__select {
                cursor: pointer;
            }

            .settings-field__help {
                margin: 6px 0 0;

                color: #7a8598;

                font-size: 11.5px;
                line-height: 1.55;
            }

            .settings-field__error {
                display: flex;
                align-items: center;
                gap: 5px;

                margin: 6px 0 0;

                color: #dc2626;

                font-size: 11.5px;
                font-weight: 600;
            }

            .settings-field__color-row {
                display: flex;
                align-items: center;

                min-height: 42px;

                padding: 5px 8px;

                background: #ffffff;

                border: 1px solid #d8dee8;
                border-radius: 8px;
            }

            .settings-field__color {
                width: 46px;
                height: 30px;

                padding: 0;

                border: 0;
                background: transparent;

                cursor: pointer;
            }

            .settings-field__color-value {
                margin-inline-start: 10px;

                color: #536174;

                font-family: monospace;
                font-size: 12px;
            }

            .settings-field__image-box {
                display: flex;
                align-items: center;

                gap: 14px;

                min-height: 100px;

                padding: 12px;

                background: #fafbfd;

                border: 1px dashed #cbd5e1;
                border-radius: 10px;
            }

            .settings-field__image-preview {
                width: 76px;
                height: 76px;

                flex: 0 0 76px;

                display: flex;
                align-items: center;
                justify-content: center;

                overflow: hidden;

                color: #8692a6;
                background: #ffffff;

                border: 1px solid #e1e6ee;
                border-radius: 9px;

                font-size: 24px;
            }

            .settings-field__image-preview img {
                width: 100%;
                height: 100%;

                object-fit: contain;
            }

            .settings-field__image-content {
                min-width: 0;
                flex: 1;
            }

            .settings-field__file {
                display: block;

                width: 100%;

                color: #536174;

                font-size: 12px;
            }

            @media (max-width: 760px) {
                .settings-field {
                    grid-column: 1 / -1;
                }
            }
            .settings-field__switch {
    display: inline-flex;
    align-items: center;

    gap: 10px;

    min-height: 42px;

    cursor: pointer;
}

.settings-field__switch-input {
    position: absolute;

    width: 1px;
    height: 1px;

    opacity: 0;
    pointer-events: none;
}

.settings-field__switch-control {
    position: relative;

    width: 42px;
    height: 23px;

    flex: 0 0 42px;

    background: #cbd5e1;

    border-radius: 20px;

    transition: background-color 0.2s ease;
}

.settings-field__switch-knob {
    position: absolute;
    top: 3px;
    left: 3px;

    width: 17px;
    height: 17px;

    background: #ffffff;

    border-radius: 50%;

    box-shadow:
        0 1px 4px
        rgba(15, 23, 42, 0.25);

    transition: transform 0.2s ease;
}

.settings-field__switch-input:checked
+ .settings-field__switch-control {
    background: #173d7a;
}

.settings-field__switch-input:checked
+ .settings-field__switch-control
.settings-field__switch-knob {
    transform: translateX(19px);
}

.settings-field__switch-text {
    color: #536174;

    font-size: 12px;
    font-weight: 600;
}
        </style>
    @endpush
@endonce