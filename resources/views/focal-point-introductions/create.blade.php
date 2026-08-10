@extends('new')

@section('title', __('emis.register_introduction_letter'))

@section('content')
@php
    $entities = $budgetEntities ?? $entities ?? collect();
    $incomingDocuments = $inboxes ?? $incomingDocuments ?? collect();
    $selectedEntityId = old('budget_entity_id', request('budget_entity_id'));

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

    $statusValues = [
        'received',
        'under_review',
        'returned',
        'approved',
        'rejected',
        'completed',
    ];
@endphp

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                <div>
                    <h3 class="mb-1 text-success fw-bold">
                        <i class="fa-solid fa-envelope-open-text me-2"></i>
                        {{ __('emis.register_introduction_letter') }}
                    </h3>

                    <p class="text-muted mb-0">
                        {{ __('emis.introduction_registration_description') }}
                    </p>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    @if(Route::has('budget-entities.create'))
                        <a href="{{ route('budget-entities.create') }}"
                           class="btn btn-outline-primary">
                            <i class="fa-solid fa-plus me-1"></i>
                            {{ __('emis.new_budget_entity') }}
                        </a>
                    @endif

                    @if(Route::has('focal-point-introductions.index'))
                        <a href="{{ route('focal-point-introductions.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="fa-solid fa-list me-1"></i>
                            {{ __('emis.introduction_letters') }}
                        </a>
                    @endif

                    @if(Route::has('focal-points.index'))
                        <a href="{{ route('focal-points.index') }}"
                           class="btn btn-outline-success">
                            <i class="fa-solid fa-users me-1"></i>
                            {{ __('emis.focal_points') }}
                        </a>
                    @endif
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger" role="alert">
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

            <form action="{{ route('focal-point-introductions.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="introductionLetterForm">
                @csrf

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="mb-0">
                            <i class="fa-solid fa-file-signature me-2"></i>
                            {{ __('emis.official_introduction') }}
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <label for="budget_entity_id"
                                       class="form-label fw-semibold">
                                    {{ __('emis.budget_entity') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">
                                    <select name="budget_entity_id"
                                            id="budget_entity_id"
                                            class="form-select @error('budget_entity_id') is-invalid @enderror"
                                            required>
                                        <option value="">
                                            {{ __('emis.select_budget_entity') }}
                                        </option>

                                        @foreach($entities as $entity)
                                            <option value="{{ $entity->id }}"
                                                    @selected(
                                                        (string) $selectedEntityId
                                                        === (string) $entity->id
                                                    )>
                                                {{ $entity->entity_code }}
                                                —
                                                {{ $entityDisplayName($entity) }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if(Route::has('budget-entities.create'))
                                        <a href="{{ route('budget-entities.create') }}"
                                           class="btn btn-outline-primary"
                                           title="{{ __('emis.register_new_budget_entity') }}"
                                           aria-label="{{ __('emis.register_new_budget_entity') }}">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    @endif
                                </div>

                                @error('budget_entity_id')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="inbox_id"
                                       class="form-label fw-semibold">
                                    {{ __('emis.incoming_document_reference') }}
                                </label>

                                <select name="inbox_id"
                                        id="inbox_id"
                                        class="form-select @error('inbox_id') is-invalid @enderror">
                                    <option value="">
                                        {{ __('emis.no_linked_incoming_document') }}
                                    </option>

                                    @foreach($incomingDocuments as $inbox)
                                        @php
                                            $number = $inbox->document_number
                                                ?? $inbox->letter_number
                                                ?? $inbox->reference_number
                                                ?? ('#' . $inbox->id);

                                            $subject = $inbox->subject
                                                ?? $inbox->title
                                                ?? '';
                                        @endphp

                                        <option value="{{ $inbox->id }}"
                                                @selected(
                                                    (string) old('inbox_id')
                                                    === (string) $inbox->id
                                                )>
                                            {{ $number }}

                                            @if($subject)
                                                —
                                                {{ \Illuminate\Support\Str::limit(
                                                    $subject,
                                                    60
                                                ) }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>

                                @error('inbox_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="letter_number"
                                       class="form-label fw-semibold">
                                    {{ __('emis.letter_number') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="letter_number"
                                       id="letter_number"
                                       value="{{ old('letter_number') }}"
                                       class="form-control @error('letter_number') is-invalid @enderror"
                                       maxlength="100"
                                       placeholder="{{ __('emis.letter_number_placeholder') }}"
                                       required>

                                @error('letter_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="letter_date"
                                       class="form-label fw-semibold">
                                    {{ __('emis.letter_date') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="date"
                                       name="letter_date"
                                       id="letter_date"
                                       value="{{ old('letter_date') }}"
                                       class="form-control @error('letter_date') is-invalid @enderror"
                                       required>

                                @error('letter_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="received_date"
                                       class="form-label fw-semibold">
                                    {{ __('emis.received_date') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="date"
                                       name="received_date"
                                       id="received_date"
                                       value="{{ old(
                                           'received_date',
                                           now()->format('Y-m-d')
                                       ) }}"
                                       class="form-control @error('received_date') is-invalid @enderror"
                                       required>

                                @error('received_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label for="subject"
                                       class="form-label fw-semibold">
                                    {{ __('emis.subject') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="subject"
                                       id="subject"
                                       value="{{ old('subject') }}"
                                       class="form-control @error('subject') is-invalid @enderror"
                                       placeholder="{{ __('emis.introduction_subject_placeholder') }}"
                                       required>

                                @error('subject')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="number_of_nominees"
                                       class="form-label fw-semibold">
                                    {{ __('emis.number_of_nominees') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="number"
                                       name="number_of_nominees"
                                       id="number_of_nominees"
                                       value="{{ old('number_of_nominees', 1) }}"
                                       class="form-control @error('number_of_nominees') is-invalid @enderror"
                                       min="1"
                                       max="50"
                                       required>

                                @error('number_of_nominees')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status"
                                       class="form-label fw-semibold">
                                    {{ __('emis.letter_status') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="status"
                                        id="status"
                                        class="form-select @error('status') is-invalid @enderror"
                                        required>
                                    @foreach($statusValues as $value)
                                        <option value="{{ $value }}"
                                                @selected(
                                                    old('status', 'received')
                                                    === $value
                                                )>
                                            {{ __("emis.{$value}") }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="attachment"
                                       class="form-label fw-semibold">
                                    {{ __('emis.letter_attachment') }}
                                </label>

                                <input type="file"
                                       name="attachment"
                                       id="attachment"
                                       class="form-control @error('attachment') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">

                                @error('attachment')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="form-text"
                                     id="attachmentHelp">
                                    {{ __('emis.accepted_attachment_types') }}
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="approval_notes"
                                       class="form-label fw-semibold">
                                    {{ __('emis.review_approval_notes') }}
                                </label>

                                <textarea name="approval_notes"
                                          id="approval_notes"
                                          rows="4"
                                          class="form-control @error('approval_notes') is-invalid @enderror"
                                          placeholder="{{ __('emis.review_notes_placeholder') }}">{{ old('approval_notes') }}</textarea>

                                @error('approval_notes')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card-footer bg-light border-0 p-3">
                        <div class="d-flex justify-content-end gap-2">
                            @if(Route::has('focal-points.index'))
                                <a href="{{ route('focal-points.index') }}"
                                   class="btn btn-light border">
                                    {{ __('emis.cancel') }}
                                </a>
                            @elseif(Route::has('focal-point-introductions.index'))
                                <a href="{{ route('focal-point-introductions.index') }}"
                                   class="btn btn-light border">
                                    {{ __('emis.cancel') }}
                                </a>
                            @endif

                            <button type="submit"
                                    class="btn btn-success px-4"
                                    id="saveIntroductionButton">
                                <i class="fa-solid fa-floppy-disk me-1"></i>
                                {{ __('emis.save_introduction_letter') }}
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
    .card {
        border-radius: 16px;
        overflow: hidden;
    }

    .form-control,
    .form-select {
        min-height: 46px;
        border-radius: 10px;
    }

    textarea.form-control {
        min-height: auto;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('introductionLetterForm');
    const button = document.getElementById('saveIntroductionButton');
    const attachment = document.getElementById('attachment');
    const help = document.getElementById('attachmentHelp');

    const selectedFileText = @json(__('emis.selected_file'));
    const acceptedTypesText = @json(
        __('emis.accepted_attachment_types')
    );
    const savingText = @json(__('emis.saving'));

    attachment?.addEventListener('change', function () {
        help.textContent = this.files.length
            ? selectedFileText + ': ' + this.files[0].name
            : acceptedTypesText;
    });

    form?.addEventListener('submit', function () {
        if (!button) {
            return;
        }

        button.disabled = true;
        button.innerHTML =
            '<i class="fa-solid fa-spinner fa-spin me-1"></i> ' +
            savingText;
    });
});
</script>
@endpush