@extends('new')

@section('title', __('emis.register_budget_entity'))

@section('content')
@php
    $parentEntities = $parents ?? $budgetEntities ?? collect();

    $entityTypes = [
        'ministry',
        'independent_directorate',
        'general_directorate',
        'state_owned_enterprise',
        'provincial_entity',
        'budget_unit',
        'other',
    ];

    $parentDisplayName = static function ($parent): string {
        if (isset($parent->display_name) && $parent->display_name) {
            return $parent->display_name;
        }

        return match (app()->getLocale()) {
            'ps' => $parent->name_ps
                ?: $parent->name_fa
                ?: $parent->name_en
                ?: $parent->entity_code,

            'fa' => $parent->name_fa
                ?: $parent->name_ps
                ?: $parent->name_en
                ?: $parent->entity_code,

            default => $parent->name_en
                ?: $parent->name_fa
                ?: $parent->name_ps
                ?: $parent->entity_code,
        };
    };
@endphp
<div class="container-fluid budget-entity-page py-3">
    <div class="row justify-content-center">
        <div class="col-12 budget-form-container">

            <div class="budget-page-header d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                <div>
                    <h3 class="budget-page-title mb-1 text-primary fw-bold">
                        <i class="fa-solid fa-landmark me-2"></i>
                        {{ __('emis.register_budget_entity') }}
                    </h3>

                    <p class="budget-page-subtitle text-muted mb-0">
                        {{ __('emis.budget_entity_registration_description') }}
                    </p>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    @if(Route::has('budget-entities.index'))
                        <a href="{{ route('budget-entities.index') }}"
                           class="btn btn-outline-secondary smart-nav-btn">
                            <i class="fa-solid fa-list me-1"></i>
                            {{ __('emis.budget_entities') }}
                        </a>
                    @endif

                    @if(Route::has('focal-points.index'))
                        <a href="{{ route('focal-points.index') }}"
                           class="btn btn-outline-primary smart-nav-btn">
                            <i class="fa-solid fa-users me-1"></i>
                            {{ __('emis.focal_points') }}
                        </a>
                    @endif
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger smart-alert" role="alert">
                    <strong>
                        {{ __('emis.please_correct_following_errors') }}
                    </strong>

                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('budget-entities.store') }}"
                  method="POST"
                  id="budgetEntityForm"
                  class="budget-entity-form"
                  novalidate>
                @csrf

                <div class="card border-0 shadow-sm budget-form-card">
                   

                    <div class="card-body budget-card-body">
                        <div class="row g-3 form-grid">

                            <div class="col-lg-4 col-md-6">
                                <label for="entity_code"
                                       class="form-label fw-semibold">
                                    {{ __('emis.entity_code') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="entity_code"
                                       id="entity_code"
                                       value="{{ old('entity_code') }}"
                                       class="form-control @error('entity_code') is-invalid @enderror"
                                       maxlength="50"
                                       placeholder="{{ __('emis.example_mof') }}"
                                       autocomplete="off"
                                       required>

                                @error('entity_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="short_name"
                                       class="form-label fw-semibold">
                                    {{ __('emis.short_name') }}
                                </label>

                                <input type="text"
                                       name="short_name"
                                       id="short_name"
                                       value="{{ old('short_name') }}"
                                       class="form-control @error('short_name') is-invalid @enderror"
                                       maxlength="100"
                                       placeholder="{{ __('emis.example_mof_short') }}">

                                @error('short_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="entity_type"
                                       class="form-label fw-semibold">
                                    {{ __('emis.entity_type') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="entity_type"
                                        id="entity_type"
                                        class="form-select @error('entity_type') is-invalid @enderror"
                                        required>
                                    <option value="">
                                        {{ __('emis.select_entity_type') }}
                                    </option>

                                    @foreach($entityTypes as $value)
                                        <option value="{{ $value }}"
                                                @selected(
                                                    old(
                                                        'entity_type',
                                                        'budget_unit'
                                                    ) === $value
                                                )>
                                            {{ __("emis.{$value}") }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('entity_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="name_en"
                                       class="form-label fw-semibold">
                                    {{ __('emis.name_english') }}
                                </label>

                                <input type="text"
                                       name="name_en"
                                       id="name_en"
                                       value="{{ old('name_en') }}"
                                       dir="ltr"
                                       class="form-control @error('name_en') is-invalid @enderror"
                                       placeholder="{{ __('emis.name_english_placeholder') }}">

                                @error('name_en')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="name_ps"
                                       class="form-label fw-semibold">
                                    {{ __('emis.name_pashto') }}
                                </label>

                                <input type="text"
                                       name="name_ps"
                                       id="name_ps"
                                       value="{{ old('name_ps') }}"
                                       dir="rtl"
                                       class="form-control text-end @error('name_ps') is-invalid @enderror"
                                       placeholder="{{ __('emis.name_pashto_placeholder') }}">

                                @error('name_ps')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="name_fa"
                                       class="form-label fw-semibold">
                                    {{ __('emis.name_dari') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="name_fa"
                                       id="name_fa"
                                       value="{{ old('name_fa') }}"
                                       dir="rtl"
                                       class="form-control text-end @error('name_fa') is-invalid @enderror"
                                       placeholder="{{ __('emis.name_dari_placeholder') }}"
                                       required>

                                @error('name_fa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <label for="parent_id"
                                       class="form-label fw-semibold">
                                    {{ __('emis.parent_budget_entity') }}
                                </label>

                                <select name="parent_id"
                                        id="parent_id"
                                        class="form-select @error('parent_id') is-invalid @enderror">
                                    <option value="">
                                        {{ __('emis.no_parent_entity') }}
                                    </option>

                                    @foreach($parentEntities as $parent)
                                        <option value="{{ $parent->id }}"
                                                @selected(
                                                    (string) old('parent_id')
                                                    === (string) $parent->id
                                                )>
                                            {{ $parent->entity_code }}
                                            —
                                            {{ $parentDisplayName($parent) }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('parent_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <label for="phone"
                                       class="form-label fw-semibold">
                                    {{ __('emis.phone') }}
                                </label>

                                <input type="text"
                                       name="phone"
                                       id="phone"
                                       value="{{ old('phone') }}"
                                       dir="ltr"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       maxlength="50"
                                       placeholder="{{ __('emis.phone_placeholder') }}">

                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <label for="email"
                                       class="form-label fw-semibold">
                                    {{ __('emis.email') }}
                                </label>

                                <input type="email"
                                       name="email"
                                       id="email"
                                       value="{{ old('email') }}"
                                       dir="ltr"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="{{ __('emis.email_placeholder') }}">

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="address"
                                       class="form-label fw-semibold">
                                    {{ __('emis.address') }}
                                </label>

                                <textarea name="address"
                                          id="address"
                                          rows="2"
                                          class="form-control @error('address') is-invalid @enderror"
                                          placeholder="{{ __('emis.official_address') }}">{{ old('address') }}</textarea>

                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-8 col-md-12">
                                <label for="description"
                                       class="form-label fw-semibold">
                                    {{ __('emis.description') }}
                                </label>

                                <textarea name="description"
                                          id="description"
                                          rows="3"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="{{ __('emis.additional_information') }}">{{ old('description') }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="status"
                                       class="form-label fw-semibold">
                                    {{ __('emis.status') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="status"
                                        id="status"
                                        class="form-select @error('status') is-invalid @enderror"
                                        required>
                                    <option value="1"
                                            @selected(
                                                (string) old(
                                                    'status',
                                                    '1'
                                                ) === '1'
                                            )>
                                        {{ __('emis.active') }}
                                    </option>

                                    <option value="0"
                                            @selected(
                                                (string) old('status')
                                                === '0'
                                            )>
                                        {{ __('emis.inactive') }}
                                    </option>
                                </select>

                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card-footer bg-light border-0 budget-card-footer">
                        <div class="d-flex flex-wrap justify-content-end gap-2 form-actions">
                            @if(Route::has('focal-points.index'))
                                <a href="{{ route('focal-points.index') }}"
                                   class="btn btn-light border form-action-btn">
                                    {{ __('emis.cancel') }}
                                </a>
                            @elseif(Route::has('budget-entities.index'))
                                <a href="{{ route('budget-entities.index') }}"
                                   class="btn btn-light border form-action-btn">
                                    {{ __('emis.cancel') }}
                                </a>
                            @endif

                            <button type="submit"
                                    class="btn btn-primary px-4 form-action-btn save-action-btn"
                                    id="saveBudgetEntityButton">
                                <i class="fa-solid fa-floppy-disk me-1"></i>
                                {{ __('emis.save_budget_entity') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* =========================================================
       SMART BUDGET ENTITY FORM
       ========================================================= */

    .budget-entity-page {
        --form-primary: #1677ff;
        --form-primary-dark: #0f62d6;
        --form-text: #1f2937;
        --form-muted: #6b7280;
        --form-border: #d7e0ea;
        --form-danger: #dc3545;
    }

    .budget-form-container {
        width: 100%;
        max-width: 1160px;
        margin-inline: auto;
    }

    .budget-page-header {
        padding: 2px 2px 6px;
    }

    .budget-page-title {
        font-size: clamp(1.5rem, 2vw, 2rem);
        line-height: 1.25;
        letter-spacing: -0.02em;
    }

    .budget-page-title i {
        font-size: 0.92em;
    }

    .budget-page-subtitle {
        max-width: 680px;
        font-size: 0.92rem;
        line-height: 1.55;
    }

    .smart-nav-btn {
        min-height: 40px;
        padding: 7px 13px;
        border-radius: 9px;
        font-size: 0.86rem;
        font-weight: 650;
    }

    .smart-alert {
        padding: 13px 16px;
        border: 1px solid rgba(220, 53, 69, 0.20);
        border-radius: 11px;
        font-size: 0.88rem;
        box-shadow: 0 5px 16px rgba(110, 20, 30, 0.05);
    }

    .budget-form-card {
        overflow: hidden;
        border: 1px solid #e3eaf2 !important;
        border-radius: 16px;
        background: #ffffff;
        box-shadow:
            0 14px 34px rgba(32, 63, 99, 0.08),
            0 3px 10px rgba(32, 63, 99, 0.04) !important;
    }

    .budget-card-header {
        min-height: 62px;
        padding: 15px 22px;
        display: flex;
        align-items: center;
        border: 0;
        background:
            linear-gradient(
                135deg,
                var(--form-primary) 0%,
                #2563eb 100%
            ) !important;
    }

    .budget-card-header,
    .budget-card-header * {
        color: #ffffff !important;
    }

    .budget-card-title {
        font-size: 1.12rem;
        font-weight: 750;
        line-height: 1.3;
    }

    .budget-card-body {
        padding: 24px 26px 22px;
        background:
            linear-gradient(
                180deg,
                #ffffff 0%,
                #fbfdff 100%
            );
    }

    .form-grid {
        --bs-gutter-x: 1.15rem;
        --bs-gutter-y: 1.05rem;
    }

    #budgetEntityForm .form-label {
        display: flex;
        align-items: center;
        gap: 4px;
        min-height: 20px;
        margin-bottom: 7px;
        color: var(--form-text);
        font-size: 0.88rem;
        font-weight: 700 !important;
        line-height: 1.35;
    }

    #budgetEntityForm .text-danger {
        font-size: 0.88rem;
        line-height: 1;
    }

    #budgetEntityForm .form-control,
    #budgetEntityForm .form-select {
        width: 100%;
        min-height: 46px;
        padding: 9px 13px;
        color: var(--form-text);
        background-color: #ffffff;
        border: 1px solid var(--form-border);
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 500;
        line-height: 1.35;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.02);
        transition:
            border-color 0.18s ease,
            box-shadow 0.18s ease,
            background-color 0.18s ease;
    }

    #budgetEntityForm .form-select {
        cursor: pointer;
        padding-inline-end: 38px;
    }

    #budgetEntityForm .form-select option {
        font-size: 0.86rem;
    }

    #budgetEntityForm textarea.form-control {
        min-height: 82px;
        padding-top: 11px;
        padding-bottom: 11px;
        resize: vertical;
    }

    #budgetEntityForm #description {
        min-height: 96px;
    }

    #budgetEntityForm .form-control::placeholder,
    #budgetEntityForm textarea.form-control::placeholder {
        color: #929dab;
        font-size: 0.78rem;
        font-weight: 400;
        opacity: 1;
    }

    #budgetEntityForm .form-control:hover,
    #budgetEntityForm .form-select:hover {
        border-color: #b8c8da;
    }

    #budgetEntityForm .form-control:focus,
    #budgetEntityForm .form-select:focus {
        color: #111827;
        background-color: #ffffff;
        border-color: var(--form-primary);
        box-shadow:
            0 0 0 3px rgba(22, 119, 255, 0.13),
            0 4px 12px rgba(22, 119, 255, 0.05);
        outline: 0;
    }

    #budgetEntityForm .form-control.is-invalid,
    #budgetEntityForm .form-select.is-invalid {
        border-color: var(--form-danger);
        background-image: none;
    }

    #budgetEntityForm .form-control.is-invalid:focus,
    #budgetEntityForm .form-select.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.12);
    }

    #budgetEntityForm .invalid-feedback {
        margin-top: 5px;
        font-size: 0.74rem;
        line-height: 1.35;
    }

    html[dir="rtl"] #budgetEntityForm input[dir="ltr"] {
        text-align: left;
    }

    html[dir="ltr"] #budgetEntityForm input[dir="rtl"] {
        text-align: right;
    }

    .budget-card-footer {
        padding: 15px 26px;
        background: #f8fafc !important;
        border-top: 1px solid #e7edf4 !important;
    }

    .form-action-btn {
        min-width: 118px;
        min-height: 42px;
        padding: 8px 17px;
        border-radius: 9px;
        font-size: 0.86rem;
        font-weight: 700;
    }

    .save-action-btn {
        border-color: var(--form-primary);
        background: var(--form-primary);
        box-shadow: 0 7px 16px rgba(22, 119, 255, 0.18);
    }

    .save-action-btn:hover,
    .save-action-btn:focus {
        border-color: var(--form-primary-dark);
        background: var(--form-primary-dark);
    }

    .save-action-btn:disabled {
        cursor: wait;
        opacity: 0.78;
    }

    @media (max-width: 991.98px) {
        .budget-form-container {
            max-width: 860px;
        }

        .budget-card-body {
            padding: 22px;
        }
    }

    @media (max-width: 767.98px) {
        .budget-entity-page {
            padding-inline: 8px;
        }

        .budget-page-header {
            align-items: flex-start !important;
        }

        .budget-card-header {
            min-height: 56px;
            padding: 13px 17px;
        }

        .budget-card-title {
            font-size: 1rem;
        }

        .budget-card-body {
            padding: 18px 16px;
        }

        #budgetEntityForm .form-control,
        #budgetEntityForm .form-select {
            min-height: 44px;
            font-size: 0.86rem;
        }

        .budget-card-footer {
            padding: 14px 16px;
        }
    }

    @media (max-width: 575.98px) {
        .budget-page-header > div:last-child,
        .budget-page-header .smart-nav-btn {
            width: 100%;
        }

        .budget-page-header > div:last-child {
            display: grid !important;
            grid-template-columns: 1fr;
        }

        .form-actions {
            width: 100%;
            flex-direction: column-reverse;
        }

        .form-action-btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const code = document.getElementById('entity_code');
    const form = document.getElementById('budgetEntityForm');
    const button = document.getElementById(
        'saveBudgetEntityButton'
    );

    const savingText = @json(__('emis.saving'));

    code?.addEventListener('input', function () {
        this.value = this.value
            .toUpperCase()
            .replace(/[^A-Z0-9_-]/g, '');
    });

    form?.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        if (!button || button.disabled) {
            return;
        }

        button.disabled = true;
        button.setAttribute('aria-busy', 'true');
        button.innerHTML =
            '<i class="fa-solid fa-spinner fa-spin me-1"></i> ' +
            savingText;
    });
});
</script>
@endpush