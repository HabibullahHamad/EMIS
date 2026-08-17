@extends('settings.layout')

@section('settings-content')

@php
    $translateSectionText = function (
        mixed $key,
        string $fallback
    ): string {
        if (!is_string($key) || trim($key) === '') {
            return $fallback;
        }

        $translated = __($key);

        return $translated === $key
            ? $fallback
            : $translated;
    };

    $sectionTitle = $translateSectionText(
        $sectionConfig['title'] ?? null,
        str($section)
            ->replace('-', ' ')
            ->replace('_', ' ')
            ->title()
            ->toString()
    );

    $sectionDescription = $translateSectionText(
        $sectionConfig['description'] ?? null,
        'Manage configuration values for this section.'
    );

    $sectionIcon = $sectionConfig['icon']
        ?? 'fa-solid fa-sliders';

    $formId = 'settings-section-form';

    $successMessage =
        session('success')
        ?? session('status')
        ?? session('message');
@endphp

@include('settings.partials.page-header', [
    'pageTitle' => $sectionTitle,
    'pageDescription' => $sectionDescription,
    'pageIcon' => $sectionIcon,
])

@if($successMessage)
    <div
        class="settings-section-alert settings-section-alert--success"
        role="alert"
    >
        <i class="fa-solid fa-circle-check"></i>

        <span>
            {{ $successMessage }}
        </span>
    </div>
@endif

@if($errors->any())
    <div
        class="settings-section-alert settings-section-alert--error"
        role="alert"
    >
        <i class="fa-solid fa-circle-exclamation"></i>

        <div>
            <strong>
                {{ __('Please correct the highlighted fields.') }}
            </strong>

            <span>
                {{ __('Your changes have not been saved.') }}
            </span>
        </div>
    </div>
@endif

<form
    id="{{ $formId }}"
    method="POST"
    action="{{ route('settings.section.update', [
        'section' => $section,
    ]) }}"
    enctype="multipart/form-data"
    data-settings-form
    class="settings-section-form"
>
    @csrf
    @method('PUT')

    <div class="settings-section-card">
        <div class="settings-section-card__header">
            <div>
                <h3 class="settings-section-card__title">
                    {{ $sectionTitle }}
                </h3>

                <p class="settings-section-card__description">
                    {{ $sectionDescription }}
                </p>
            </div>

            <span class="settings-section-card__count">
                {{ count($fields) }}
                {{ count($fields) === 1 ? 'field' : 'fields' }}
            </span>
        </div>

        <div class="settings-section-card__body">
            @if($fields !== [])
                <div class="settings-fields-grid">
                    @foreach($fields as $fieldKey => $field)
                        @continue(!is_array($field))

                        @include(
                            'settings.partials.dynamic-field',
                            [
                                'fieldKey' => $fieldKey,
                                'field' => $field,
                                'value' =>
                                    $values[$fieldKey]
                                    ?? $field['default']
                                    ?? null,
                                'storedValue' =>
                                    $storedValues[$fieldKey]
                                    ?? null,
                            ]
                        )
                    @endforeach
                </div>
            @else
                <div class="settings-section-empty">
                    <div class="settings-section-empty__icon">
                        <i class="fa-solid fa-sliders"></i>
                    </div>

                    <h3>
                        {{ __('No settings are registered') }}
                    </h3>

                    <p>
                        {{ __('No editable fields are currently configured for this section.') }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</form>

@if($fields !== [])
    @include('settings.partials.save-actions', [
        'formId' => $formId,
        'cancelUrl' => route('settings.overview'),
        'saveLabel' => 'emis.save_settings',
    ])
@endif

@endsection

@push('styles')
<style>
    .settings-section-alert {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        margin-bottom: 16px;
        padding: 12px 14px;

        border: 1px solid;
        border-radius: 9px;

        font-size: 12.5px;
        line-height: 1.6;
    }

    .settings-section-alert--success {
        color: #166534;
        background: #f0fdf4;
        border-color: #bbf7d0;
    }

    .settings-section-alert--error {
        color: #991b1b;
        background: #fef2f2;
        border-color: #fecaca;
    }

    .settings-section-alert div {
        display: grid;
        gap: 2px;
    }

    .settings-section-alert strong {
        font-size: 12.5px;
    }

    .settings-section-alert span {
        font-size: 11.5px;
    }

    .settings-section-form {
        margin: 0;
    }

    .settings-section-card {
        overflow: hidden;

        background: #ffffff;

        border: 1px solid #e1e6ee;
        border-radius: 11px;

        box-shadow:
            0 4px 16px
            rgba(31, 41, 55, 0.04);
    }

    .settings-section-card__header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 16px;

        padding: 17px 18px;

        background: #fafbfd;

        border-bottom: 1px solid #e8ecf2;
    }

    .settings-section-card__title {
        margin: 0;

        color: #1d293d;

        font-size: 15px;
        font-weight: 750;
        line-height: 1.4;
    }

    .settings-section-card__description {
        max-width: 700px;

        margin: 4px 0 0;

        color: #788598;

        font-size: 11.5px;
        line-height: 1.65;
    }

    .settings-section-card__count {
        flex: 0 0 auto;

        padding: 4px 9px;

        color: #4d5d73;
        background: #ffffff;

        border: 1px solid #dfe5ed;
        border-radius: 20px;

        font-size: 10.5px;
        font-weight: 700;
    }

    .settings-section-card__body {
        padding: 20px 18px;
    }

    .settings-fields-grid {
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));

        gap: 18px 16px;
    }

    .settings-section-empty {
        display: flex;
        flex-direction: column;
        align-items: center;

        padding: 42px 20px;

        text-align: center;
    }

    .settings-section-empty__icon {
        width: 52px;
        height: 52px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 12px;

        color: #65758c;
        background: #f1f5f9;

        border-radius: 50%;

        font-size: 19px;
    }

    .settings-section-empty h3 {
        margin: 0;

        color: #26344b;

        font-size: 14px;
    }

    .settings-section-empty p {
        max-width: 430px;

        margin: 6px 0 0;

        color: #7b8799;

        font-size: 12px;
        line-height: 1.6;
    }

    @media (max-width: 760px) {
        .settings-section-card__header {
            flex-direction: column;
        }

        .settings-section-card__body {
            padding: 16px 14px;
        }

        .settings-fields-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush