@extends('new')

@section(
    'page_title',
    isset($focalPoint) && $focalPoint->exists
        ? __('emis.focal_point_registration_card_management')
        : __('emis.register_focal_point')
)

@php
    $isEdit = isset($focalPoint) && $focalPoint->exists;

    $currentCard = $isEdit
        ? ($focalPoint->cards?->sortByDesc('id')->first())
        : null;

    $registrationComplete = $isEdit;
    $isApproved = $isEdit && in_array($focalPoint->status, ['active', 'approved'], true);
    $cardGenerated = (bool) $currentCard;
    $cardPrinted = $cardGenerated && !empty($currentCard->printed_at);
    $cardIssued = $cardGenerated && !empty($currentCard->issued_at);

    $formAction = $isEdit
        ? route('focal-points.update', $focalPoint)
        : route('focal-points.store');

    $entityDisplayName = static function ($entity): string {
        if (!$entity) {
            return '-';
        }

        return match (app()->getLocale()) {
            'ps' => $entity->name_ps
                ?: $entity->name_fa
                ?: $entity->name_en
                ?: $entity->entity_code
                ?: '-',

            'fa' => $entity->name_fa
                ?: $entity->name_ps
                ?: $entity->name_en
                ?: $entity->entity_code
                ?: '-',

            default => $entity->name_en
                ?: $entity->name_fa
                ?: $entity->name_ps
                ?: $entity->entity_code
                ?: '-',
        };
    };

    $focalPointDisplayName = static function ($record): string {
        if (!$record) {
            return '-';
        }

        return match (app()->getLocale()) {
            'ps' => $record->full_name_ps
                ?: $record->full_name_fa
                ?: $record->full_name_en
                ?: '-',

            'fa' => $record->full_name_fa
                ?: $record->full_name_ps
                ?: $record->full_name_en
                ?: '-',

            default => $record->full_name_en
                ?: $record->full_name_fa
                ?: $record->full_name_ps
                ?: '-',
        };
    };

    $registrationStatuses = [
        'pending',
        'under_review',
        'active',
        'suspended',
        'replaced',
        'expired',
        'rejected',
        'inactive',
    ];
@endphp

@push('styles')
<style>
    .fp-page {
        --fp-primary: #0b3563;
        --fp-secondary: #154c82;
        --fp-soft: #eef5fb;
        --fp-border: #dbe4ee;
        --fp-success: #198754;
        --fp-warning: #f59e0b;
        --fp-danger: #dc3545;
    }

    .fp-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .fp-header h4 {
        margin: 0 0 4px;
        color: var(--fp-primary);
        font-weight: 800;
    }

    .fp-header p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
    }

    .workflow-strip {
        display: grid;
        grid-template-columns: repeat(4, minmax(150px, 1fr));
        gap: 10px;
        margin-bottom: 18px;
    }

    .workflow-step {
        position: relative;
        min-height: 76px;
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 12px;
        border: 1px solid var(--fp-border);
        border-radius: 14px;
        background: #fff;
    }

    .workflow-step .step-icon {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #64748b;
        background: #e9eef4;
    }

    .workflow-step.completed {
        border-color: rgba(25, 135, 84, .35);
        background: rgba(25, 135, 84, .06);
    }

    .workflow-step.completed .step-icon {
        color: #fff;
        background: var(--fp-success);
    }

    .workflow-step.current {
        border-color: rgba(11, 53, 99, .35);
        background: var(--fp-soft);
    }

    .workflow-step.current .step-icon {
        color: #fff;
        background: var(--fp-primary);
    }

    .workflow-step strong {
        display: block;
        color: #1e293b;
        font-size: 13px;
    }

    .workflow-step small {
        color: #64748b;
        font-size: 11px;
    }

    .fp-section {
        margin-bottom: 18px;
        padding: 16px;
        border: 1px solid var(--fp-border);
        border-radius: 15px;
        background: #fff;
    }

    .fp-section-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #edf1f5;
        color: var(--fp-primary);
        font-size: 15px;
        font-weight: 800;
    }

    .fp-section-title i {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        color: #fff;
        background: var(--fp-primary);
    }

    .required-mark {
        color: var(--fp-danger);
    }

    .photo-box {
        height: 210px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px dashed #94a3b8;
        border-radius: 14px;
        background: #f8fafc;
    }

    .photo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-placeholder {
        color: #94a3b8;
        text-align: center;
    }

    .photo-placeholder i {
        display: block;
        margin-bottom: 8px;
        font-size: 42px;
    }

    .action-panel {
        position: sticky;
        top: 78px;
    }

    .action-card {
        margin-bottom: 14px;
        padding: 15px;
        border: 1px solid var(--fp-border);
        border-radius: 15px;
        background: #fff;
    }

    .action-card h6 {
        margin: 0 0 12px;
        color: var(--fp-primary);
        font-weight: 800;
    }

    .action-list {
        display: grid;
        gap: 8px;
    }

    .action-list .btn {
        min-height: 40px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 8px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
    }

    .action-list .btn i {
        width: 19px;
        text-align: center;
    }

    .status-summary {
        display: grid;
        gap: 8px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #edf1f5;
        font-size: 12px;
    }

    .summary-row:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .summary-row span:first-child {
        color: #64748b;
    }

    .summary-row strong {
        color: #1e293b;
        text-align: end;
    }

    .locked-notice {
        padding: 12px;
        border: 1px solid rgba(245, 158, 11, .35);
        border-radius: 11px;
        color: #8a5700;
        background: rgba(245, 158, 11, .09);
        font-size: 12px;
    }

    .card-preview {
        overflow: hidden;
        border: 1px solid #223b57;
        border-radius: 13px;
        background: linear-gradient(135deg, #fff 0%, #eaf2f9 100%);
    }

    .card-preview-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px;
        color: #fff;
        background: var(--fp-primary);
    }

    .card-preview-header img {
        width: 42px;
        height: 42px;
        object-fit: contain;
    }

    .card-preview-header div {
        flex: 1;
        text-align: center;
        font-size: 11px;
        line-height: 1.5;
    }

    .card-preview-body {
        display: flex;
        gap: 12px;
        padding: 13px;
    }

    .card-preview-photo {
        width: 82px;
        height: 103px;
        flex: 0 0 82px;
        object-fit: cover;
        border: 1px solid #94a3b8;
        border-radius: 8px;
        background: #fff;
    }

    .card-preview-data {
        flex: 1;
        min-width: 0;
        font-size: 11px;
    }

    .card-preview-data div {
        display: flex;
        gap: 7px;
        padding: 4px 0;
        border-bottom: 1px solid #dbe4ee;
    }

    .card-preview-data span {
        width: 82px;
        flex: 0 0 82px;
        color: #475569;
        font-weight: 700;
    }

    .card-preview-data strong {
        min-width: 0;
        overflow: hidden;
        color: #0f172a;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .card-preview-footer {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        padding: 8px 12px;
        color: #fff;
        background: var(--fp-primary);
        font-size: 10px;
    }

    .table-card-history th,
    .table-card-history td {
        font-size: 12px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .save-bar {
        position: sticky;
        bottom: 0;
        z-index: 20;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 18px;
        padding: 12px 14px;
        border: 1px solid var(--fp-border);
        border-radius: 13px;
        background: rgba(255, 255, 255, .96);
        box-shadow: 0 -5px 20px rgba(15, 23, 42, .08);
        backdrop-filter: blur(10px);
    }

    @media (max-width: 1199px) {
        .workflow-strip {
            grid-template-columns: repeat(2, 1fr);
        }

        .action-panel {
            position: static;
        }
    }

    @media (max-width: 575px) {
        .workflow-strip {
            grid-template-columns: 1fr;
        }

        .save-bar {
            align-items: stretch;
            flex-direction: column;
        }

        .save-bar .d-flex {
            width: 100%;
        }

        .save-bar .btn {
            flex: 1;
        }
    }
</style>
@endpush

@section('content')
<div class="fp-page">

    <div class="fp-header">
        <div>
            <h4>
                <i class="fa-solid fa-address-card me-1"></i>
                {{
                    $isEdit
                        ? __('emis.focal_point_registration_card_management')
                        : __('emis.register_focal_point')
                }}
            </h4>

            <p>
                {{ __('emis.focal_point_registration_instructions') }}
            </p>
        </div>

        <a href="{{ route('focal-points.index') }}" class="emis-btn emis-btn-light">
            <i class="fa-solid fa-arrow-left me-1"></i>
            {{ __('emis.back_to_focal_points') }}
        </a>
    </div>

    {{-- Workflow progress --}}
    <div class="workflow-strip">
        <div class="workflow-step {{ $registrationComplete ? 'completed' : 'current' }}">
            <div class="step-icon">
                <i class="fa-solid {{ $registrationComplete ? 'fa-check' : 'fa-user-plus' }}"></i>
            </div>
            <div>
                <strong>{{ __('emis.step_registration') }}</strong>
                <small>
                    {{
                        $registrationComplete
                            ? __('emis.registration_saved')
                            : __('emis.enter_focal_point_details')
                    }}
                </small>
            </div>
        </div>

        <div class="workflow-step {{ $isApproved ? 'completed' : ($registrationComplete ? 'current' : '') }}">
            <div class="step-icon">
                <i class="fa-solid {{ $isApproved ? 'fa-check' : 'fa-user-shield' }}"></i>
            </div>
            <div>
                <strong>{{ __('emis.step_approval') }}</strong>
                <small>
                    {{
                        $isApproved
                            ? __('emis.focal_point_approved')
                            : __('emis.review_and_approve_record')
                    }}
                </small>
            </div>
        </div>

        <div class="workflow-step {{ $cardGenerated ? 'completed' : ($isApproved ? 'current' : '') }}">
            <div class="step-icon">
                <i class="fa-solid {{ $cardGenerated ? 'fa-check' : 'fa-id-card' }}"></i>
            </div>
            <div>
                <strong>{{ __('emis.step_card_generation') }}</strong>
                <small>
                    {{
                        $cardGenerated
                            ? $currentCard->card_number
                            : __('emis.generate_id_card')
                    }}
                </small>
            </div>
        </div>

        <div class="workflow-step {{ $cardIssued ? 'completed' : ($cardGenerated ? 'current' : '') }}">
            <div class="step-icon">
                <i class="fa-solid {{ $cardIssued ? 'fa-check' : 'fa-print' }}"></i>
            </div>
            <div>
                <strong>{{ __('emis.step_print_issue') }}</strong>
                <small>
                    @if($cardIssued)
                        {{ __('emis.card_issued') }}
                    @elseif($cardPrinted)
                        {{ __('emis.printed_waiting_issuance') }}
                    @else
                        {{ __('emis.print_and_hand_over_card') }}
                    @endif
                </small>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-9">
            <form id="focalPointForm"
                  method="POST"
                  action="{{ $formAction }}"
                  enctype="multipart/form-data">

                @csrf

                @if($isEdit)
                    @method('PUT')
                @endif

                {{-- Official introduction --}}
                <section class="fp-section">
                    <div class="fp-section-title">
                        <i class="fa-solid fa-envelope-open-text"></i>
                        {{ __('emis.official_introduction') }}
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="emis-form-label">
                                {{ __('emis.budget_entity') }}
                                <span class="required-mark">*</span>
                            </label>

                            <select name="budget_entity_id"
                                    id="budgetEntitySelect"
                                    class="form-select emis-form-control @error('budget_entity_id') is-invalid @enderror"
                                    required>
                                <option value="">
                                    {{ __('emis.select_budget_entity') }}
                                </option>

                                @foreach($budgetEntities ?? [] as $entity)
                                    <option value="{{ $entity->id }}"
                                        {{ (string) old('budget_entity_id', $focalPoint->budget_entity_id ?? request('budget_entity_id')) === (string) $entity->id ? 'selected' : '' }}>
                                        {{ $entity->entity_code }} —
                                        {{ $entityDisplayName($entity) }}
                                    </option>
                                @endforeach
                            </select>

                            @error('budget_entity_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="emis-form-label">
                                {{ __('emis.introduction_letter') }}
                                <span class="required-mark">*</span>
                            </label>

                            <select name="introduction_id"
                                    id="introductionSelect"
                                    class="form-select emis-form-control @error('introduction_id') is-invalid @enderror"
                                    required>
                                <option value="">
                                    {{ __('emis.select_introduction_letter') }}
                                </option>

                                @foreach($introductions ?? [] as $introduction)
                                    <option value="{{ $introduction->id }}"
                                            data-entity-id="{{ $introduction->budget_entity_id }}"
                                        {{ (string) old('introduction_id', $focalPoint->introduction_id ?? request('introduction_id')) === (string) $introduction->id ? 'selected' : '' }}>
                                        {{ $introduction->letter_number }}
                                        — {{ $introduction->subject }}
                                    </option>
                                @endforeach
                            </select>

                            @error('introduction_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="emis-form-label">
                                {{ __('emis.focal_point_code') }}
                            </label>

                            <input type="text"
                                   name="focal_point_code"
                                   class="form-control emis-form-control @error('focal_point_code') is-invalid @enderror"
                                   value="{{ old('focal_point_code', $focalPoint->focal_point_code ?? '') }}"
                                   placeholder="{{ __('emis.automatically_generated_if_empty') }}">

                            @error('focal_point_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </section>

                {{-- Personal information --}}
                <section class="fp-section">
                    <div class="fp-section-title">
                        <i class="fa-solid fa-user"></i>
                        {{ __('emis.personal_information') }}
                    </div>

                    <div class="row g-3">
                        <div class="col-lg-9">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="emis-form-label">
                                        {{ __('emis.full_name_en') }}
                                    </label>
                                    <input type="text"
                                           name="full_name_en"
                                           class="form-control emis-form-control @error('full_name_en') is-invalid @enderror"
                                           value="{{ old('full_name_en', $focalPoint->full_name_en ?? '') }}">
                                    @error('full_name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="emis-form-label">
                                        {{ __('emis.full_name_ps') }}
                                    </label>
                                    <input type="text"
                                           name="full_name_ps"
                                           class="form-control emis-form-control @error('full_name_ps') is-invalid @enderror"
                                           value="{{ old('full_name_ps', $focalPoint->full_name_ps ?? '') }}">
                                    @error('full_name_ps')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="emis-form-label">
                                        {{ __('emis.full_name_fa') }}
                                        <span class="required-mark">*</span>
                                    </label>
                                    <input type="text"
                                           name="full_name_fa"
                                           class="form-control emis-form-control @error('full_name_fa') is-invalid @enderror"
                                           value="{{ old('full_name_fa', $focalPoint->full_name_fa ?? '') }}"
                                           required>
                                    @error('full_name_fa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="emis-form-label">
                                        {{ __('emis.father_name') }}
                                        <span class="required-mark">*</span>
                                    </label>
                                    <input type="text"
                                           name="father_name"
                                           class="form-control emis-form-control @error('father_name') is-invalid @enderror"
                                           value="{{ old('father_name', $focalPoint->father_name ?? '') }}"
                                           required>
                                    @error('father_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="emis-form-label">
                                        {{ __('emis.grandfather_name') }}
                                    </label>
                                    <input type="text"
                                           name="grandfather_name"
                                           class="form-control emis-form-control"
                                           value="{{ old('grandfather_name', $focalPoint->grandfather_name ?? '') }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="emis-form-label">
                                        {{ __('emis.employee_number') }}
                                    </label>
                                    <input type="text"
                                           name="employee_number"
                                           class="form-control emis-form-control"
                                           value="{{ old('employee_number', $focalPoint->employee_number ?? '') }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="emis-form-label">
                                        {{ __('emis.national_id') }}
                                    </label>
                                    <input type="text"
                                           name="national_id"
                                           class="form-control emis-form-control @error('national_id') is-invalid @enderror"
                                           value="{{ old('national_id', $focalPoint->national_id ?? '') }}">
                                    @error('national_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="emis-form-label">
                                        {{ __('emis.signature') }}
                                    </label>
                                    <input type="file"
                                           name="signature"
                                           class="form-control emis-form-control @error('signature') is-invalid @enderror"
                                           accept=".jpg,.jpeg,.png">
                                    @error('signature')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    @if($isEdit && $focalPoint->signature_path)
                                        <label class="emis-form-label">
                                            {{ __('emis.current_signature') }}
                                        </label>
                                        <div class="border rounded-3 p-2 text-center">
                                            <img src="{{ asset('storage/' . $focalPoint->signature_path) }}"
                                                 alt="{{ __('emis.signature') }}"
                                                 style="max-width:100%;max-height:65px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <label class="emis-form-label">
                                {{ __('emis.photograph') }}
                                @unless($isEdit)
                                    <span class="required-mark">*</span>
                                @endunless
                            </label>

                            <div class="photo-box mb-2" id="photoPreviewBox">
                                @if($isEdit && $focalPoint->photo_path)
                                    <img id="photoPreview"
                                         src="{{ asset('storage/' . $focalPoint->photo_path) }}"
                                         alt="{{ __('emis.focal_point_photo') }}">
                                @else
                                    <div class="photo-placeholder" id="photoPlaceholder">
                                        <i class="fa-solid fa-user"></i>
                                        {{ __('emis.photo_preview') }}
                                    </div>

                                    <img id="photoPreview"
                                         src=""
                                         alt="{{ __('emis.photo_preview') }}"
                                         style="display:none;">
                                @endif
                            </div>

                            <input type="file"
                                   name="photo"
                                   id="photoInput"
                                   class="form-control emis-form-control @error('photo') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png"
                                   {{ $isEdit ? '' : 'required' }}>

                            <small class="text-muted">
                                {{ __('emis.photo_requirements') }}
                            </small>

                            @error('photo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </section>

                {{-- Employment --}}
                <section class="fp-section">
                    <div class="fp-section-title">
                        <i class="fa-solid fa-briefcase"></i>
                        {{ __('emis.employment_contact_information') }}
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="emis-form-label">
                                {{ __('emis.job_title') }}
                                <span class="required-mark">*</span>
                            </label>
                            <input type="text"
                                   name="job_title"
                                   class="form-control emis-form-control @error('job_title') is-invalid @enderror"
                                   value="{{ old('job_title', $focalPoint->job_title ?? '') }}"
                                   required>
                            @error('job_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="emis-form-label">
                                {{ __('emis.directorate') }}
                            </label>
                            <input type="text"
                                   name="directorate"
                                   class="form-control emis-form-control"
                                   value="{{ old('directorate', $focalPoint->directorate ?? '') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="emis-form-label">
                                {{ __('emis.department') }}
                            </label>
                            <input type="text"
                                   name="department"
                                   class="form-control emis-form-control"
                                   value="{{ old('department', $focalPoint->department ?? '') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="emis-form-label">
                                {{ __('emis.official_position') }}
                            </label>
                            <input type="text"
                                   name="official_position"
                                   class="form-control emis-form-control"
                                   value="{{ old('official_position', $focalPoint->official_position ?? '') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="emis-form-label">
                                {{ __('emis.phone') }}
                                <span class="required-mark">*</span>
                            </label>
                            <input type="text"
                                   name="phone"
                                   class="form-control emis-form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $focalPoint->phone ?? '') }}"
                                   required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="emis-form-label">
                                {{ __('emis.alternate_phone') }}
                            </label>
                            <input type="text"
                                   name="alternate_phone"
                                   class="form-control emis-form-control"
                                   value="{{ old('alternate_phone', $focalPoint->alternate_phone ?? '') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="emis-form-label">
                                {{ __('emis.email') }}
                            </label>
                            <input type="email"
                                   name="email"
                                   class="form-control emis-form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $focalPoint->email ?? '') }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </section>

                {{-- Authorization --}}
                <section class="fp-section">
                    <div class="fp-section-title">
                        <i class="fa-solid fa-calendar-check"></i>
                        {{ __('emis.authorization_validity') }}
                    </div>

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="emis-form-label">
                                {{ __('emis.appointment_date') }}
                            </label>
                            <input type="date"
                                   name="appointment_date"
                                   class="form-control emis-form-control"
                                   value="{{ old(
                                       'appointment_date',
                                       $isEdit && $focalPoint->appointment_date
                                           ? \Illuminate\Support\Carbon::parse($focalPoint->appointment_date)->format('Y-m-d')
                                           : ''
                                   ) }}">
                        </div>

                        <div class="col-md-3">
                            <label class="emis-form-label">
                                {{ __('emis.valid_from') }}
                                <span class="required-mark">*</span>
                            </label>
                            <input type="date"
                                   name="valid_from"
                                   class="form-control emis-form-control @error('valid_from') is-invalid @enderror"
                                   value="{{ old(
                                       'valid_from',
                                       $isEdit && $focalPoint->valid_from
                                           ? \Illuminate\Support\Carbon::parse($focalPoint->valid_from)->format('Y-m-d')
                                           : ''
                                   ) }}"
                                   required>
                            @error('valid_from')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="emis-form-label">
                                {{ __('emis.valid_until') }}
                                <span class="required-mark">*</span>
                            </label>
                            <input type="date"
                                   name="valid_until"
                                   class="form-control emis-form-control @error('valid_until') is-invalid @enderror"
                                   value="{{ old(
                                       'valid_until',
                                       $isEdit && $focalPoint->valid_until
                                           ? \Illuminate\Support\Carbon::parse($focalPoint->valid_until)->format('Y-m-d')
                                           : ''
                                   ) }}"
                                   required>
                            @error('valid_until')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="emis-form-label">
                                {{ __('emis.registration_status') }}
                                <span class="required-mark">*</span>
                            </label>
                            <select name="status"
                                    class="form-select emis-form-control @error('status') is-invalid @enderror"
                                    required>
                                @foreach($registrationStatuses as $value)
                                    <option value="{{ $value }}"
                                        {{ old(
                                            'status',
                                            $focalPoint->status ?? 'pending'
                                        ) === $value ? 'selected' : '' }}>
                                        {{
                                            $value === 'active'
                                                ? __('emis.active_approved')
                                                : __("emis.{$value}")
                                        }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="emis-form-label">
                                {{ __('emis.remarks') }}
                            </label>
                            <textarea name="remarks"
                                      rows="3"
                                      class="form-control emis-form-control">{{ old('remarks', $focalPoint->remarks ?? '') }}</textarea>
                        </div>
                    </div>
                </section>

                <div class="save-bar">
                    <div>
                        @if($isEdit)
                            <strong>{{ __('emis.registration_id') }}:</strong>
                            {{ $focalPoint->focal_point_code }}
                        @else
                            <span class="text-muted">
                                {{ __('emis.save_registration_to_activate_card_actions') }}
                            </span>
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('focal-points.index') }}" class="btn btn-light border">
                            {{ __('emis.cancel') }}
                        </a>

                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            {{
                                $isEdit
                                    ? __('emis.update_registration')
                                    : __('emis.save_continue')
                            }}
                        </button>
                    </div>
                </div>
            </form>

            {{-- Card history --}}
            @if($isEdit)
                <section class="fp-section mt-3">
                    <div class="fp-section-title">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        {{ __('emis.card_history') }}
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-card-history mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('emis.card_number') }}</th>
                                    <th>{{ __('emis.fiscal_year') }}</th>
                                    <th>{{ __('emis.issue_date') }}</th>
                                    <th>{{ __('emis.expiry_date') }}</th>
                                    <th>{{ __('emis.status') }}</th>
                                    <th>{{ __('emis.printed') }}</th>
                                    <th>{{ __('emis.issued') }}</th>
                                    <th>{{ __('emis.actions') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($focalPoint->cards?->sortByDesc('id') ?? [] as $card)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-semibold">{{ $card->card_number }}</td>
                                        <td>{{ $card->fiscal_year }}</td>
                                        <td>{{ $card->issue_date }}</td>
                                        <td>{{ $card->expiry_date }}</td>
                                        <td>
                                            <span class="badge bg-{{
                                                in_array($card->card_status, ['approved', 'printed', 'issued'], true)
                                                    ? 'success'
                                                    : (in_array($card->card_status, ['revoked', 'lost', 'damaged'], true)
                                                        ? 'danger'
                                                        : 'secondary')
                                            }}">
                                                {{ __("emis.{$card->card_status}") }}
                                            </span>
                                        </td>
                                        <td>
                                            {{
                                                $card->printed_at
                                                    ? __('emis.yes')
                                                    : __('emis.no')
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                $card->issued_at
                                                    ? __('emis.yes')
                                                    : __('emis.no')
                                            }}
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                @if(Route::has('focal-point-cards.show'))
                                                    <a href="{{ route('focal-point-cards.show', $card) }}"
                                                       class="btn btn-sm btn-info"
                                                       title="{{ __('emis.view') }}">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(Route::has('focal-point-cards.print'))
                                                    <a href="{{ route('focal-point-cards.print', $card) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-danger"
                                                       title="{{ __('emis.print') }}">
                                                        <i class="fa-solid fa-print"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            {{ __('emis.no_card_generated') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif
        </div>

        {{-- Right-side actions --}}
        <div class="col-xl-3">
            <div class="action-panel">

                <div class="action-card">
                    <h6>
                        <i class="fa-solid fa-bars-progress me-1"></i>
                        {{ __('emis.process_status') }}
                    </h6>

                    <div class="status-summary">
                        <div class="summary-row">
                            <span>{{ __('emis.registration') }}</span>
                            <strong class="{{ $registrationComplete ? 'text-success' : 'text-warning' }}">
                                {{
                                    $registrationComplete
                                        ? __('emis.saved')
                                        : __('emis.not_saved')
                                }}
                            </strong>
                        </div>

                        <div class="summary-row">
                            <span>{{ __('emis.approval') }}</span>
                            <strong class="{{ $isApproved ? 'text-success' : 'text-warning' }}">
                                {{
                                    $isApproved
                                        ? __('emis.approved')
                                        : __('emis.pending')
                                }}
                            </strong>
                        </div>

                        <div class="summary-row">
                            <span>{{ __('emis.card') }}</span>
                            <strong>
                                {{
                                    $currentCard->card_number
                                    ?? __('emis.not_generated')
                                }}
                            </strong>
                        </div>

                        <div class="summary-row">
                            <span>{{ __('emis.print') }}</span>
                            <strong class="{{ $cardPrinted ? 'text-success' : 'text-muted' }}">
                                {{
                                    $cardPrinted
                                        ? __('emis.printed')
                                        : __('emis.not_printed')
                                }}
                            </strong>
                        </div>

                        <div class="summary-row">
                            <span>{{ __('emis.issuance') }}</span>
                            <strong class="{{ $cardIssued ? 'text-success' : 'text-muted' }}">
                                {{
                                    $cardIssued
                                        ? __('emis.issued')
                                        : __('emis.not_issued')
                                }}
                            </strong>
                        </div>
                    </div>
                </div>

                @if($isEdit)
                    <div class="action-card">
                        <h6>
                            <i class="fa-solid fa-bolt me-1"></i>
                            {{ __('emis.available_actions') }}
                        </h6>

                        <div class="action-list">

                            @if(!$isApproved && Route::has('focal-points.approve'))
                                <form method="POST"
                                      action="{{ route('focal-points.approve', $focalPoint) }}">
                                    @csrf

                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fa-solid fa-user-check"></i>
                                        {{ __('emis.approve_focal_point') }}
                                    </button>
                                </form>
                            @endif

                            @if($isApproved && Route::has('focal-points.suspend'))
                                <form method="POST"
                                      action="{{ route('focal-points.suspend', $focalPoint) }}">
                                    @csrf

                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="fa-solid fa-user-slash"></i>
                                        {{ __('emis.suspend_focal_point') }}
                                    </button>
                                </form>
                            @endif

                            @if(!$currentCard)
                                @if($isApproved && Route::has('focal-points.cards.generate'))
                                    <button type="button"
                                            class="btn btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#generateCardModal">
                                        <i class="fa-solid fa-id-card"></i>
                                        {{ __('emis.generate_id_card') }}
                                    </button>
                                @else
                                    <div class="locked-notice">
                                        <i class="fa-solid fa-lock me-1"></i>
                                        {{ __('emis.approve_before_generating_card') }}
                                    </div>
                                @endif
                            @else
                                @if(Route::has('focal-point-cards.show'))
                                    <a href="{{ route('focal-point-cards.show', $currentCard) }}"
                                       class="btn btn-info">
                                        <i class="fa-solid fa-eye"></i>
                                        {{ __('emis.view_current_card') }}
                                    </a>
                                @endif

                                @if(Route::has('focal-point-cards.print'))
                                    <a href="{{ route('focal-point-cards.print', $currentCard) }}"
                                       target="_blank"
                                       class="btn btn-danger">
                                        <i class="fa-solid fa-print"></i>
                                        {{ __('emis.print_card') }}
                                    </a>
                                @endif

                                @if(!$cardPrinted && Route::has('focal-point-cards.mark-printed'))
                                    <form method="POST"
                                          action="{{ route('focal-point-cards.mark-printed', $currentCard) }}">
                                        @csrf

                                        <button type="submit" class="btn btn-outline-primary w-100">
                                            <i class="fa-solid fa-check-double"></i>
                                            {{ __('emis.mark_as_printed') }}
                                        </button>
                                    </form>
                                @endif

                                @if(!$cardIssued && Route::has('focal-point-cards.issue'))
                                    <button type="button"
                                            class="btn btn-success"
                                            data-bs-toggle="modal"
                                            data-bs-target="#issueCardModal">
                                        <i class="fa-solid fa-hand-holding"></i>
                                        {{ __('emis.issue_card') }}
                                    </button>
                                @endif

                                @if(Route::has('focal-points.cards.generate'))
                                    <button type="button"
                                            class="btn btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#generateCardModal">
                                        <i class="fa-solid fa-rotate"></i>
                                        {{ __('emis.renew_replace_card') }}
                                    </button>
                                @endif

                                @if(
                                    $currentCard->card_status !== 'revoked'
                                    && Route::has('focal-point-cards.revoke')
                                )
                                    <button type="button"
                                            class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#revokeCardModal">
                                        <i class="fa-solid fa-ban"></i>
                                        {{ __('emis.revoke_card') }}
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>

                    @if($currentCard)
                        <div class="action-card">
                            <h6>
                                <i class="fa-solid fa-address-card me-1"></i>
                                {{ __('emis.current_card_preview') }}
                            </h6>

                            <div class="card-preview">
                                <div class="card-preview-header">
                                    <img src="{{ asset('images/logo.png') }}"
                                         alt="{{ __('emis.logo') }}">

                                    <div>
                                        <strong>{{ __('emis.ministry_finance') }}</strong><br>
                                        {{ __('emis.general_directorate_budget') }}<br>
                                        {{ __('emis.focal_point_id_card') }}
                                    </div>
                                </div>

                                <div class="card-preview-body">
                                    @if($focalPoint->photo_path)
                                        <img src="{{ asset('storage/' . $focalPoint->photo_path) }}"
                                             class="card-preview-photo"
                                             alt="{{ __('emis.photo') }}">
                                    @else
                                        <div class="card-preview-photo d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-user fa-2x text-muted"></i>
                                        </div>
                                    @endif

                                    <div class="card-preview-data">
                                        <div>
                                            <span>{{ __('emis.card_no') }}</span>
                                            <strong>{{ $currentCard->card_number }}</strong>
                                        </div>

                                        <div>
                                            <span>{{ __('emis.name') }}</span>
                                            <strong>
                                                {{ $focalPointDisplayName($focalPoint) }}
                                            </strong>
                                        </div>

                                        <div>
                                            <span>{{ __('emis.entity') }}</span>
                                            <strong>
                                                {{ $entityDisplayName(
                                                    $focalPoint->budgetEntity
                                                ) }}
                                            </strong>
                                        </div>

                                        <div>
                                            <span>{{ __('emis.position') }}</span>
                                            <strong>{{ $focalPoint->job_title }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-preview-footer">
                                    <span>{{ $currentCard->issue_date }}</span>
                                    <span>{{ $currentCard->expiry_date }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="action-card">
                        <h6>
                            <i class="fa-solid fa-lock me-1"></i>
                            {{ __('emis.card_actions') }}
                        </h6>

                        <div class="locked-notice">
                            {{ __('emis.save_focal_point_before_card_actions') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Generate/Renew Card Modal --}}
@if($isEdit && Route::has('focal-points.cards.generate'))
<div class="modal fade" id="generateCardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST"
                  action="{{ route('focal-points.cards.generate', $focalPoint) }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{
                            $currentCard
                                ? __('emis.renew_replace_card')
                                : __('emis.generate_id_card')
                        }}
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="{{ __('emis.close') }}"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="emis-form-label">
                            {{ __('emis.fiscal_year') }}
                            <span class="required-mark">*</span>
                        </label>

                        <input type="text"
                               name="fiscal_year"
                               class="form-control"
                               value="{{ old('fiscal_year', $currentCard->fiscal_year ?? '') }}"
                               placeholder="1405"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="emis-form-label">
                            {{ __('emis.issue_date') }}
                            <span class="required-mark">*</span>
                        </label>

                        <input type="date"
                               name="issue_date"
                               class="form-control"
                               value="{{ old('issue_date', now()->format('Y-m-d')) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="emis-form-label">
                            {{ __('emis.expiry_date') }}
                            <span class="required-mark">*</span>
                        </label>

                        <input type="date"
                               name="expiry_date"
                               class="form-control"
                               value="{{ old(
                                   'expiry_date',
                                   $focalPoint->valid_until
                                       ? \Illuminate\Support\Carbon::parse($focalPoint->valid_until)->format('Y-m-d')
                                       : ''
                               ) }}"
                               required>
                    </div>

                    @if($currentCard)
                        <div class="mb-3">
                            <label class="emis-form-label">
                                {{ __('emis.action_type') }}
                                <span class="required-mark">*</span>
                            </label>

                            <select name="generation_type" class="form-select" required>
                                <option value="renewal">
                                    {{ __('emis.renewal') }}
                                </option>
                                <option value="replacement">
                                    {{ __('emis.replacement') }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="emis-form-label">
                                {{ __('emis.reason') }}
                            </label>
                            <textarea name="reason"
                                      rows="3"
                                      class="form-control"
                                      placeholder="{{ __('emis.renewal_replacement_reason') }}"></textarea>
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        {{ __('emis.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-id-card me-1"></i>
                        {{
                            $currentCard
                                ? __('emis.create_new_card')
                                : __('emis.generate_card')
                        }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- Issue Card Modal --}}
@if($isEdit && $currentCard && Route::has('focal-point-cards.issue'))
<div class="modal fade" id="issueCardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST"
                  action="{{ route('focal-point-cards.issue', $currentCard) }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('emis.issue_focal_point_card') }}
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="{{ __('emis.close') }}"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="emis-form-label">
                            {{ __('emis.received_by') }}
                            <span class="required-mark">*</span>
                        </label>

                        <input type="text"
                               name="received_by_name"
                               class="form-control"
                               value="{{ old(
                                   'received_by_name',
                                   $focalPoint->display_name
                                       ?? $focalPoint->full_name_en
                                       ?? $focalPoint->full_name_fa
                               ) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="emis-form-label">
                            {{ __('emis.issuance_date') }}
                            <span class="required-mark">*</span>
                        </label>

                        <input type="date"
                               name="received_at"
                               class="form-control"
                               value="{{ old('received_at', now()->format('Y-m-d')) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="emis-form-label">
                            {{ __('emis.handover_notes') }}
                        </label>

                        <textarea name="issuance_notes"
                                  rows="3"
                                  class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        {{ __('emis.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-hand-holding me-1"></i>
                        {{ __('emis.confirm_issuance') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- Revoke Card Modal --}}
@if($isEdit && $currentCard && Route::has('focal-point-cards.revoke'))
<div class="modal fade" id="revokeCardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST"
                  action="{{ route('focal-point-cards.revoke', $currentCard) }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        {{ __('emis.revoke_card') }}
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="{{ __('emis.close') }}"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning">
                        {{ __('emis.card_invalid_after_revocation') }}
                    </div>

                    <label class="emis-form-label">
                        {{ __('emis.revocation_reason') }}
                        <span class="required-mark">*</span>
                    </label>

                    <textarea name="revocation_reason"
                              rows="4"
                              class="form-control"
                              required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        {{ __('emis.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-ban me-1"></i>
                        {{ __('emis.revoke_card') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    const photoPlaceholder = document.getElementById('photoPlaceholder');

    photoInput?.addEventListener('change', function () {
        const file = this.files && this.files[0];

        if (!file || !file.type.startsWith('image/')) {
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            if (photoPreview) {
                photoPreview.src = event.target.result;
                photoPreview.style.display = 'block';
            }

            if (photoPlaceholder) {
                photoPlaceholder.style.display = 'none';
            }
        };

        reader.readAsDataURL(file);
    });

    /*
     * Filter introduction letters by the selected budget entity.
     * All options remain in the HTML, but irrelevant ones are hidden.
     */
    const entitySelect = document.getElementById('budgetEntitySelect');
    const introductionSelect = document.getElementById('introductionSelect');

    function filterIntroductionLetters() {
        if (!entitySelect || !introductionSelect) {
            return;
        }

        const entityId = entitySelect.value;
        const currentValue = introductionSelect.value;
        let currentOptionIsValid = false;

        Array.from(introductionSelect.options).forEach(function (option, index) {
            if (index === 0) {
                option.hidden = false;
                return;
            }

            const belongsToEntity = !entityId
                || option.dataset.entityId === entityId;

            option.hidden = !belongsToEntity;

            if (option.value === currentValue && belongsToEntity) {
                currentOptionIsValid = true;
            }
        });

        if (currentValue && !currentOptionIsValid) {
            introductionSelect.value = '';
        }
    }

    entitySelect?.addEventListener('change', filterIntroductionLetters);
    filterIntroductionLetters();
});
</script>
@endpush