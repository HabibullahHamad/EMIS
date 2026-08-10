@extends('new')

@section('title', __('emis.introduction_letters'))

@section('content')
@php
    $introductions = $introductions ?? collect();
    $budgetEntities = $budgetEntities ?? collect();

    $stats = array_merge([
        'total' => 0,
        'received' => 0,
        'under_review' => 0,
        'approved' => 0,
        'completed' => 0,
    ], $stats ?? []);

    $statusOptions = [
        'received' => [
            'class' => 'bg-info text-dark',
            'icon' => 'fa-inbox',
        ],
        'under_review' => [
            'class' => 'bg-warning text-dark',
            'icon' => 'fa-magnifying-glass',
        ],
        'returned' => [
            'class' => 'bg-secondary',
            'icon' => 'fa-rotate-left',
        ],
        'approved' => [
            'class' => 'bg-success',
            'icon' => 'fa-circle-check',
        ],
        'rejected' => [
            'class' => 'bg-danger',
            'icon' => 'fa-circle-xmark',
        ],
        'completed' => [
            'class' => 'bg-primary',
            'icon' => 'fa-flag-checkered',
        ],
    ];

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

    $formatDate = static function ($value): string {
        if (!$value) {
            return '-';
        }

        try {
            return \Illuminate\Support\Carbon::parse(
                $value
            )->format('d-m-Y');
        } catch (\Throwable $exception) {
            return (string) $value;
        }
    };

    $statCards = [
        [
            'key' => 'total',
            'label' => __('emis.total_letters'),
            'border' => 'primary',
            'icon' => 'fa-envelopes-bulk',
        ],
        [
            'key' => 'received',
            'label' => __('emis.received'),
            'border' => 'info',
            'icon' => 'fa-inbox',
        ],
        [
            'key' => 'under_review',
            'label' => __('emis.under_review'),
            'border' => 'warning',
            'icon' => 'fa-magnifying-glass',
        ],
        [
            'key' => 'approved',
            'label' => __('emis.approved'),
            'border' => 'success',
            'icon' => 'fa-circle-check',
        ],
        [
            'key' => 'completed',
            'label' => __('emis.completed'),
            'border' => 'secondary',
            'icon' => 'fa-flag-checkered',
        ],
    ];
@endphp

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h5 class="mb-1 fw-bold text-block">
                <i class="fa-solid fa-envelope-open-text me-2"></i>
                {{ __('emis.introduction_letters') }}
            </h5>

            <p class="text-muted mb-0">
                {{ __('emis.manage_introduction_letters_description') }}
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            @if(Route::has('budget-entities.create'))
                <a href="{{ route('budget-entities.create') }}"
                   class="btn btn-outline-primary">
                    <i class="fa-solid fa-building-circle-check me-1"></i>
                    {{ __('emis.register_budget_entity') }}
                </a>
            @endif

            @if(Route::has('focal-point-introductions.create'))
                <a href="{{ route('focal-point-introductions.create') }}"
                   class="btn btn-success">
                    <i class="fa-solid fa-plus me-1"></i>
                    {{ __('emis.register_introduction_letter') }}
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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm"
             role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="{{ __('emis.close') }}">
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm"
             role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="{{ __('emis.close') }}">
            </button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        @foreach($statCards as $item)
            <div class="col-6 col-md-4 col-xl">
                <div class="stat-card border-start border-4 border-{{ $item['border'] }}">
                    <div>
                        <div class="stat-label">
                            {{ $item['label'] }}
                        </div>

                        <div class="stat-value">
                            {{ number_format(
                                $stats[$item['key']] ?? 0
                            ) }}
                        </div>
                    </div>

                    <div class="stat-icon text-{{ $item['border'] }} bg-{{ $item['border'] }}-subtle">
                        <i class="fa-solid {{ $item['icon'] }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card border-0 shadow-sm mb-4 filter-card">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-2">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">
                    <i class="fa-solid fa-filter me-2 text-success"></i>
                    {{ __('emis.search_and_filters') }}
                </h5>

                @if(request()->hasAny([
                    'search',
                    'budget_entity_id',
                    'status',
                    'from_date',
                    'to_date',
                ]))
                    <a href="{{ route('focal-point-introductions.index') }}"
                       class="btn btn-sm btn-light border">
                        <i class="fa-solid fa-rotate-left me-1"></i>
                        {{ __('emis.clear_filters') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body px-4 pb-4">
            <form method="GET"
                  action="{{ route('focal-point-introductions.index') }}"
                  class="row g-3 align-items-end">

                <div class="col-md-6 col-xl-3">
                    <label for="search"
                           class="form-label fw-semibold">
                        {{ __('emis.search') }}
                    </label>

                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>

                        <input type="search"
                               name="search"
                               id="search"
                               value="{{ request('search') }}"
                               class="form-control"
                               placeholder="{{ __('emis.introduction_search_placeholder') }}">
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <label for="budget_entity_id"
                           class="form-label fw-semibold">
                        {{ __('emis.budget_entity') }}
                    </label>

                    <select name="budget_entity_id"
                            id="budget_entity_id"
                            class="form-select">
                        <option value="">
                            {{ __('emis.all_budget_entities') }}
                        </option>

                        @foreach($budgetEntities as $entity)
                            <option value="{{ $entity->id }}"
                                    @selected(
                                        (string) request('budget_entity_id')
                                        === (string) $entity->id
                                    )>
                                {{ $entity->entity_code }}
                                —
                                {{ $entityDisplayName($entity) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 col-xl-2">
                    <label for="status"
                           class="form-label fw-semibold">
                        {{ __('emis.status') }}
                    </label>

                    <select name="status"
                            id="status"
                            class="form-select">
                        <option value="">
                            {{ __('emis.all_statuses') }}
                        </option>

                        @foreach($statusOptions as $value => $status)
                            <option value="{{ $value }}"
                                    @selected(request('status') === $value)>
                                {{ __("emis.{$value}") }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 col-xl-2">
                    <label for="from_date"
                           class="form-label fw-semibold">
                        {{ __('emis.received_from') }}
                    </label>

                    <input type="date"
                           name="from_date"
                           id="from_date"
                           value="{{ request('from_date') }}"
                           class="form-control">
                </div>

                <div class="col-md-4 col-xl-2">
                    <label for="to_date"
                           class="form-label fw-semibold">
                        {{ __('emis.received_to') }}
                    </label>

                    <input type="date"
                           name="to_date"
                           id="to_date"
                           value="{{ request('to_date') }}"
                           class="form-control">
                </div>

                <div class="col-12 d-flex justify-content-end">
                    <button type="submit"
                            class="btn btn-success px-4">
                        <i class="fa-solid fa-filter me-1"></i>
                        {{ __('emis.apply_filters') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm table-card">
        <div class="card-header bg-white border-0 px-4 py-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h5 class="mb-1 fw-bold">
                        {{ __('emis.registered_introduction_letters') }}
                    </h5>

                    <small class="text-muted">
                        @if(method_exists($introductions, 'total'))
                            {{ __('emis.showing_records', [
                                'from' => $introductions->firstItem() ?? 0,
                                'to' => $introductions->lastItem() ?? 0,
                                'total' => $introductions->total(),
                            ]) }}
                        @else
                            {{ __('emis.records_count', [
                                'count' => $introductions->count(),
                            ]) }}
                        @endif
                    </small>
                </div>

                @if(Route::has('focal-point-introductions.create'))
                    <a href="{{ route('focal-point-introductions.create') }}"
                       class="btn btn-sm btn-success">
                        <i class="fa-solid fa-plus me-1"></i>
                        {{ __('emis.new_letter') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 introduction-table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>{{ __('emis.letter') }}</th>
                            <th>{{ __('emis.budget_entity') }}</th>
                            <th>{{ __('emis.subject') }}</th>
                            <th>{{ __('emis.dates') }}</th>
                            <th class="text-center">
                                {{ __('emis.nominees') }}
                            </th>
                            <th class="text-center">
                                {{ __('emis.focal_points') }}
                            </th>
                            <th>{{ __('emis.status') }}</th>
                            <th class="text-center">
                                {{ __('emis.attachment') }}
                            </th>
                            <th class="text-center">
                                {{ __('emis.actions') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($introductions as $introduction)
                            @php
                                $statusKey = $introduction->status
                                    ?: 'unknown';

                                $status = $statusOptions[$statusKey] ?? [
                                    'class' => 'bg-light text-dark border',
                                    'icon' => 'fa-circle-question',
                                ];

                                $focalPointCount =
                                    $introduction->focal_points_count
                                    ?? (
                                        $introduction->relationLoaded(
                                            'focalPoints'
                                        )
                                            ? $introduction
                                                ->focalPoints
                                                ->count()
                                            : 0
                                    );

                                $rowNumber = method_exists(
                                    $introductions,
                                    'firstItem'
                                )
                                    ? (
                                        ($introductions->firstItem() ?? 1)
                                        + $loop->index
                                    )
                                    : $loop->iteration;
                            @endphp

                            <tr>
                                <td class="text-center text-muted fw-semibold">
                                    {{ $rowNumber }}
                                </td>

                                <td>
                                    <div class="fw-bold text-dark">
                                        {{ $introduction->letter_number }}
                                    </div>

                                    <small class="text-muted">
                                        @if($introduction->inbox_id)
                                            <i class="fa-solid fa-link me-1"></i>
                                            {{ __('emis.inbox_reference', [
                                                'id' => $introduction->inbox_id,
                                            ]) }}
                                        @else
                                            {{ __('emis.no_inbox_reference') }}
                                        @endif
                                    </small>
                                </td>

                                <td>
                                    <div class="entity-cell">
                                        <span class="entity-icon">
                                            <i class="fa-solid fa-landmark"></i>
                                        </span>

                                        <div>
                                            <div class="fw-semibold">
                                                {{ $entityDisplayName(
                                                    $introduction->budgetEntity
                                                ) }}
                                            </div>

                                            <small class="text-muted">
                                                {{
                                                    $introduction
                                                        ->budgetEntity
                                                        ?->entity_code
                                                    ?: '-'
                                                }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td class="subject-column">
                                    <div class="fw-semibold text-dark"
                                         title="{{ $introduction->subject }}">
                                        {{ \Illuminate\Support\Str::limit(
                                            $introduction->subject,
                                            85
                                        ) }}
                                    </div>

                                    @if($introduction->approval_notes)
                                        <small class="text-muted d-block mt-1"
                                               title="{{ $introduction->approval_notes }}">
                                            <i class="fa-solid fa-note-sticky me-1"></i>
                                            {{ \Illuminate\Support\Str::limit(
                                                $introduction->approval_notes,
                                                55
                                            ) }}
                                        </small>
                                    @endif
                                </td>

                                <td>
                                    <div class="date-line">
                                        <span>{{ __('emis.letter') }}:</span>
                                        <strong>
                                            {{ $formatDate(
                                                $introduction->letter_date
                                            ) }}
                                        </strong>
                                    </div>

                                    <div class="date-line mt-1">
                                        <span>{{ __('emis.received') }}:</span>
                                        <strong>
                                            {{ $formatDate(
                                                $introduction->received_date
                                            ) }}
                                        </strong>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <span class="count-badge bg-primary-subtle text-primary">
                                        {{ number_format(
                                            $introduction
                                                ->number_of_nominees
                                            ?? 0
                                        ) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="count-badge {{
                                        $focalPointCount > 0
                                            ? 'bg-success-subtle text-success'
                                            : 'bg-light text-muted'
                                    }}">
                                        {{ number_format($focalPointCount) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge rounded-pill {{ $status['class'] }} status-badge">
                                        <i class="fa-solid {{ $status['icon'] }} me-1"></i>
                                        {{ __("emis.{$statusKey}") }}
                                    </span>

                                    @if($introduction->reviewed_at)
                                        <small class="text-muted d-block mt-1">
                                            {{ __('emis.reviewed_on', [
                                                'date' => $formatDate(
                                                    $introduction->reviewed_at
                                                ),
                                            ]) }}
                                        </small>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if(
                                        $introduction->attachment
                                        && Route::has(
                                            'focal-point-introductions.attachment'
                                        )
                                    )
                                        <a href="{{ route(
                                                'focal-point-introductions.attachment',
                                                $introduction
                                            ) }}"
                                           class="btn btn-sm btn-outline-primary action-button"
                                           title="{{ __('emis.download_attachment') }}"
                                           aria-label="{{ __('emis.download_attachment') }}">
                                            <i class="fa-solid fa-paperclip"></i>
                                        </a>
                                    @elseif($introduction->attachment)
                                        <a href="{{ asset(
                                                'storage/' .
                                                ltrim(
                                                    $introduction->attachment,
                                                    '/'
                                                )
                                            ) }}"
                                           target="_blank"
                                           rel="noopener"
                                           class="btn btn-sm btn-outline-primary action-button"
                                           title="{{ __('emis.open_attachment') }}"
                                           aria-label="{{ __('emis.open_attachment') }}">
                                            <i class="fa-solid fa-paperclip"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">
                                            <i class="fa-solid fa-minus"></i>
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-inline-flex flex-wrap justify-content-center gap-1">
                                        @if(Route::has('focal-point-introductions.show'))
                                            <a href="{{ route(
                                                    'focal-point-introductions.show',
                                                    $introduction
                                                ) }}"
                                               class="btn btn-sm btn-outline-info action-button"
                                               title="{{ __('emis.view_letter') }}"
                                               aria-label="{{ __('emis.view_letter') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        @endif

                                        @if(Route::has('focal-point-introductions.edit'))
                                            <a href="{{ route(
                                                    'focal-point-introductions.edit',
                                                    $introduction
                                                ) }}"
                                               class="btn btn-sm btn-outline-warning action-button"
                                               title="{{ __('emis.edit_letter') }}"
                                               aria-label="{{ __('emis.edit_letter') }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endif

                                        @if(Route::has('focal-point-introductions.status'))
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-secondary action-button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#statusModal{{ $introduction->id }}"
                                                    title="{{ __('emis.update_status') }}"
                                                    aria-label="{{ __('emis.update_status') }}">
                                                <i class="fa-solid fa-arrows-rotate"></i>
                                            </button>
                                        @endif

                                        @if(Route::has('focal-points.registration'))
                                            <a href="{{ route(
                                                    'focal-points.registration',
                                                    [
                                                        'budget_entity_id'
                                                            => $introduction
                                                                ->budget_entity_id,

                                                        'introduction_id'
                                                            => $introduction->id,
                                                    ]
                                                ) }}"
                                               class="btn btn-sm btn-outline-success action-button"
                                               title="{{ __('emis.register_focal_point_from_letter') }}"
                                               aria-label="{{ __('emis.register_focal_point_from_letter') }}">
                                                <i class="fa-solid fa-user-plus"></i>
                                            </a>
                                        @endif

                                        @if(Route::has('focal-point-introductions.destroy'))
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger action-button"
                                                    data-delete-form="deleteIntroduction{{ $introduction->id }}"
                                                    data-letter-number="{{ $introduction->letter_number }}"
                                                    title="{{ __('emis.delete_letter') }}"
                                                    aria-label="{{ __('emis.delete_letter') }}"
                                                    @disabled($focalPointCount > 0)>
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                            <form id="deleteIntroduction{{ $introduction->id }}"
                                                  action="{{ route(
                                                      'focal-point-introductions.destroy',
                                                      $introduction
                                                  ) }}"
                                                  method="POST"
                                                  class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @if(Route::has('focal-point-introductions.status'))
                                <div class="modal fade"
                                     id="statusModal{{ $introduction->id }}"
                                     tabindex="-1"
                                     aria-labelledby="statusModalLabel{{ $introduction->id }}"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <form action="{{ route(
                                                    'focal-point-introductions.status',
                                                    $introduction
                                                ) }}"
                                                  method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <div class="modal-header">
                                                    <div>
                                                        <h5 class="modal-title fw-bold"
                                                            id="statusModalLabel{{ $introduction->id }}">
                                                            {{ __('emis.update_letter_status') }}
                                                        </h5>

                                                        <small class="text-muted">
                                                            {{ $introduction->letter_number }}
                                                        </small>
                                                    </div>

                                                    <button type="button"
                                                            class="btn-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="{{ __('emis.close') }}">
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="modalStatus{{ $introduction->id }}"
                                                               class="form-label fw-semibold">
                                                            {{ __('emis.status') }}
                                                        </label>

                                                        <select name="status"
                                                                id="modalStatus{{ $introduction->id }}"
                                                                class="form-select"
                                                                required>
                                                            @foreach($statusOptions as $value => $option)
                                                                <option value="{{ $value }}"
                                                                        @selected(
                                                                            $introduction->status
                                                                            === $value
                                                                        )>
                                                                    {{ __("emis.{$value}") }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label for="modalNotes{{ $introduction->id }}"
                                                               class="form-label fw-semibold">
                                                            {{ __('emis.review_approval_notes') }}
                                                        </label>

                                                        <textarea name="approval_notes"
                                                                  id="modalNotes{{ $introduction->id }}"
                                                                  rows="4"
                                                                  class="form-control"
                                                                  placeholder="{{ __('emis.review_notes_placeholder') }}">{{ $introduction->approval_notes }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="btn btn-light border"
                                                            data-bs-dismiss="modal">
                                                        {{ __('emis.cancel') }}
                                                    </button>

                                                    <button type="submit"
                                                            class="btn btn-success">
                                                        <i class="fa-solid fa-floppy-disk me-1"></i>
                                                        {{ __('emis.save_status') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="10"
                                    class="p-0">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fa-solid fa-envelope-open-text"></i>
                                        </div>

                                        <h5 class="fw-bold mb-2">
                                            {{ __('emis.no_introduction_letters_found') }}
                                        </h5>

                                        <p class="text-muted mb-3">
                                            {{ __('emis.register_letter_before_focal_point') }}
                                        </p>

                                        @if(Route::has('focal-point-introductions.create'))
                                            <a href="{{ route(
                                                    'focal-point-introductions.create'
                                                ) }}"
                                               class="btn btn-success">
                                                <i class="fa-solid fa-plus me-1"></i>
                                                {{ __('emis.register_first_letter') }}
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(
            method_exists($introductions, 'hasPages')
            && $introductions->hasPages()
        )
            <div class="card-footer bg-white border-0 px-4 py-3">
                {{ $introductions->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .stat-card {
        height: 100%;
        min-height: 106px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 18px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 18px rgba(15, 45, 75, .07);
    }

    .stat-label {
        color: #718096;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .stat-value {
        color: #20354b;
        font-size: 26px;
        font-weight: 800;
        line-height: 1;
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        min-width: 46px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .filter-card,
    .table-card {
        border-radius: 16px;
        overflow: hidden;
    }

    .form-control,
    .form-select,
    .input-group-text {
        min-height: 44px;
        border-radius: 10px;
    }

    .input-group .input-group-text {
        border-start-end-radius: 0;
        border-end-end-radius: 0;
    }

    .input-group .form-control {
        border-start-start-radius: 0;
        border-end-start-radius: 0;
    }

    .introduction-table {
        min-width: 1280px;
    }

    .introduction-table thead th {
        padding: 14px 12px;
        color: #526579;
        background: #f5f8fb;
        border-bottom: 1px solid #e4ebf2;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .introduction-table tbody td {
        padding: 14px 12px;
        border-color: #edf1f5;
        font-size: 13px;
        vertical-align: middle;
    }

    .entity-cell {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 190px;
    }

    .entity-icon {
        width: 34px;
        height: 34px;
        min-width: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        color: #0d6efd;
        background: #eaf3ff;
    }

    .subject-column {
        min-width: 260px;
        max-width: 340px;
    }

    .date-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        min-width: 150px;
        font-size: 12px;
    }

    .date-line span {
        color: #7a8998;
    }

    .count-badge {
        min-width: 34px;
        height: 30px;
        padding: 0 9px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }

    .status-badge {
        padding: 7px 10px;
        font-size: 11px;
        white-space: nowrap;
    }

    .action-button {
        width: 33px;
        height: 33px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
    }

    .action-button:disabled {
        opacity: .35;
        cursor: not-allowed;
    }

    .empty-state {
        padding: 65px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 74px;
        height: 74px;
        margin: 0 auto 18px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #198754;
        background: #e8f7ef;
        font-size: 30px;
    }

    .modal-content {
        border-radius: 16px;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteTitle = @json(
        __('emis.delete_introduction_letter_title')
    );
    const deleteMessage = @json(
        __('emis.delete_introduction_letter_message')
    );
    const yesDelete = @json(__('emis.yes_delete_it'));
    const cancelText = @json(__('emis.cancel'));
    const fallbackMessage = @json(
        __('emis.delete_introduction_letter_confirmation')
    );

    document.querySelectorAll('[data-delete-form]').forEach(function (button) {
        button.addEventListener('click', function () {
            if (this.disabled) {
                return;
            }

            const formId = this.dataset.deleteForm;
            const letterNumber = this.dataset.letterNumber || '';
            const form = document.getElementById(formId);

            if (!form) {
                return;
            }

            const localizedMessage = deleteMessage.replace(
                ':number',
                letterNumber
            );

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: deleteTitle,
                    text: localizedMessage,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: yesDelete,
                    cancelButtonText: cancelText
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });

                return;
            }

            if (
                window.confirm(
                    fallbackMessage.replace(
                        ':number',
                        letterNumber
                    )
                )
            ) {
                form.submit();
            }
        });
    });
});
</script>
@endpush