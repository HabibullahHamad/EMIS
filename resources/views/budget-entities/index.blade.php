@extends('new')

@section('title', __('emis.budget_entities'))

@section('content')
@php
    $budgetEntities = $budgetEntities ?? collect();
    $parents = $parents ?? collect();

    $stats = array_merge([
        'total' => 0,
        'active' => 0,
        'inactive' => 0,
        'ministries' => 0,
    ], $stats ?? []);

    /*
    |--------------------------------------------------------------------------
    | Stable database values
    |--------------------------------------------------------------------------
    |
    | These values remain in English in the database. Only their visible
    | labels are translated through lang/{locale}/emis.php.
    |
    */

    $entityTypes = [
        'ministry',
        'independent_directorate',
        'general_directorate',
        'state_owned_enterprise',
        'provincial_entity',
        'budget_unit',
        'other',
    ];

    /*
    |--------------------------------------------------------------------------
    | Localized entity display name
    |--------------------------------------------------------------------------
    */

    $displayName = static function ($entity): string {
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

    $statCards = [
        [
            'key' => 'total',
            'label' => __('emis.total_entities'),
            'border' => 'primary',
            'icon' => 'fa-building-columns',
        ],
        [
            'key' => 'active',
            'label' => __('emis.active'),
            'border' => 'success',
            'icon' => 'fa-circle-check',
        ],
        [
            'key' => 'inactive',
            'label' => __('emis.inactive'),
            'border' => 'secondary',
            'icon' => 'fa-circle-pause',
        ],
        [
            'key' => 'ministries',
            'label' => __('emis.ministries'),
            'border' => 'info',
            'icon' => 'fa-landmark-dome',
        ],
    ];
@endphp

<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="mb-1 fw-bold text-primary">
                <i class="fa-solid fa-landmark me-2"></i>
                {{ __('emis.budget_entities') }}
            </h3>

            <p class="text-muted mb-0">
                {{ __('emis.manage_budget_entities_description') }}
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            @if(Route::has('focal-point-introductions.index'))
                <a href="{{ route('focal-point-introductions.index') }}"
                   class="btn btn-outline-success">
                    <i class="fa-solid fa-envelope-open-text me-1"></i>
                    {{ __('emis.introduction_letters') }}
                </a>
            @endif

            @if(Route::has('focal-points.index'))
                <a href="{{ route('focal-points.index') }}"
                   class="btn btn-outline-primary">
                    <i class="fa-solid fa-users me-1"></i>
                    {{ __('emis.focal_points') }}
                </a>
            @endif

            @if(Route::has('budget-entities.create'))
                <a href="{{ route('budget-entities.create') }}"
                   class="btn btn-primary">
                    <i class="fa-solid fa-plus me-1"></i>
                    {{ __('emis.register_budget_entity') }}
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
            <div class="col-6 col-md-3">
                <div class="stat-card border-start border-4 border-{{ $item['border'] }}">
                    <div>
                        <div class="stat-label">
                            {{ $item['label'] }}
                        </div>

                        <div class="stat-value">
                            {{ number_format($stats[$item['key']] ?? 0) }}
                        </div>
                    </div>

                    <div class="stat-icon bg-{{ $item['border'] }}-subtle text-{{ $item['border'] }}">
                        <i class="fa-solid {{ $item['icon'] }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card border-0 shadow-sm mb-4 filter-card">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-2">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="fa-solid fa-filter me-2 text-primary"></i>
                    {{ __('emis.search_and_filters') }}
                </h5>

                @if(request()->hasAny([
                    'search',
                    'entity_type',
                    'status',
                    'parent_id',
                ]))
                    <a href="{{ route('budget-entities.index') }}"
                       class="btn btn-sm btn-light border">
                        <i class="fa-solid fa-rotate-left me-1"></i>
                        {{ __('emis.clear_filters') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body px-4 pb-4">
            <form method="GET"
                  action="{{ route('budget-entities.index') }}"
                  class="row g-3 align-items-end">

                <div class="col-md-6 col-xl-4">
                    <label for="search"
                           class="form-label fw-semibold">
                        {{ __('emis.search') }}
                    </label>

                    <input type="search"
                           name="search"
                           id="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="{{ __('emis.budget_entities_search_placeholder') }}">
                </div>

                <div class="col-md-6 col-xl-3">
                    <label for="entity_type"
                           class="form-label fw-semibold">
                        {{ __('emis.entity_type') }}
                    </label>

                    <select name="entity_type"
                            id="entity_type"
                            class="form-select">
                        <option value="">
                            {{ __('emis.all_entity_types') }}
                        </option>

                        @foreach($entityTypes as $value)
                            <option value="{{ $value }}"
                                    @selected(request('entity_type') === $value)>
                                {{ __("emis.{$value}") }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 col-xl-2">
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

                        <option value="1"
                                @selected(request('status') === '1')>
                            {{ __('emis.active') }}
                        </option>

                        <option value="0"
                                @selected(request('status') === '0')>
                            {{ __('emis.inactive') }}
                        </option>
                    </select>
                </div>

                <div class="col-md-6 col-xl-3">
                    <label for="parent_id"
                           class="form-label fw-semibold">
                        {{ __('emis.parent_entity') }}
                    </label>

                    <select name="parent_id"
                            id="parent_id"
                            class="form-select">
                        <option value="">
                            {{ __('emis.all_parent_entities') }}
                        </option>

                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}"
                                    @selected(
                                        (string) request('parent_id')
                                        === (string) $parent->id
                                    )>
                                {{ $parent->entity_code }}
                                —
                                {{ $displayName($parent) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 d-flex justify-content-end">
                    <button type="submit"
                            class="btn btn-primary px-4">
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
                        {{ __('emis.registered_budget_entities') }}
                    </h5>

                    <small class="text-muted">
                        @if(method_exists($budgetEntities, 'total'))
                            {{ __('emis.showing_records', [
                                'from' => $budgetEntities->firstItem() ?? 0,
                                'to' => $budgetEntities->lastItem() ?? 0,
                                'total' => $budgetEntities->total(),
                            ]) }}
                        @else
                            {{ __('emis.records_count', [
                                'count' => $budgetEntities->count(),
                            ]) }}
                        @endif
                    </small>
                </div>

                @if(Route::has('budget-entities.create'))
                    <a href="{{ route('budget-entities.create') }}"
                       class="btn btn-sm btn-primary">
                        <i class="fa-solid fa-plus me-1"></i>
                        {{ __('emis.new_entity') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 entity-table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>{{ __('emis.entity') }}</th>
                            <th>{{ __('emis.type') }}</th>
                            <th>{{ __('emis.parent') }}</th>
                            <th>{{ __('emis.contact') }}</th>
                            <th class="text-center">
                                {{ __('emis.children') }}
                            </th>
                            <th class="text-center">
                                {{ __('emis.letters') }}
                            </th>
                            <th class="text-center">
                                {{ __('emis.focal_points') }}
                            </th>
                            <th>{{ __('emis.status') }}</th>
                            <th class="text-center">
                                {{ __('emis.actions') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($budgetEntities as $entity)
                            @php
                                $rowNumber = method_exists(
                                    $budgetEntities,
                                    'firstItem'
                                )
                                    ? (
                                        ($budgetEntities->firstItem() ?? 1)
                                        + $loop->index
                                    )
                                    : $loop->iteration;

                                $childrenCount =
                                    $entity->children_count ?? 0;

                                $introductionsCount =
                                    $entity->introductions_count ?? 0;

                                $focalPointsCount =
                                    $entity->focal_points_count ?? 0;

                                $entityType =
                                    $entity->entity_type ?: 'other';
                            @endphp

                            <tr>
                                <td class="text-center text-muted fw-semibold">
                                    {{ $rowNumber }}
                                </td>

                                <td>
                                    <div class="entity-cell">
                                        <span class="entity-icon">
                                            <i class="fa-solid fa-landmark"></i>
                                        </span>

                                        <div>
                                            <div class="fw-bold text-dark">
                                                {{ $displayName($entity) }}
                                            </div>

                                            <small class="text-muted">
                                                {{ $entity->entity_code }}

                                                @if($entity->short_name)
                                                    · {{ $entity->short_name }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border entity-type-badge">
                                        {{ __("emis.{$entityType}") }}
                                    </span>
                                </td>

                                <td>
                                    @if($entity->parent)
                                        <div class="fw-semibold">
                                            {{ $displayName($entity->parent) }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $entity->parent->entity_code }}
                                        </small>
                                    @else
                                        <span class="text-muted">
                                            {{ __('emis.no_parent') }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($entity->phone)
                                        <div class="contact-line">
                                            <i class="fa-solid fa-phone"></i>
                                            {{ $entity->phone }}
                                        </div>
                                    @endif

                                    @if($entity->email)
                                        <div class="contact-line">
                                            <i class="fa-solid fa-envelope"></i>
                                            {{ $entity->email }}
                                        </div>
                                    @endif

                                    @if(!$entity->phone && !$entity->email)
                                        <span class="text-muted">
                                            {{ __('emis.not_provided') }}
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <span class="count-badge bg-primary-subtle text-primary">
                                        {{ number_format($childrenCount) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="count-badge bg-info-subtle text-info">
                                        {{ number_format($introductionsCount) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="count-badge bg-success-subtle text-success">
                                        {{ number_format($focalPointsCount) }}
                                    </span>
                                </td>

                                <td>
                                    @if($entity->status)
                                        <span class="badge rounded-pill bg-success status-badge">
                                            <i class="fa-solid fa-circle-check me-1"></i>
                                            {{ __('emis.active') }}
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary status-badge">
                                            <i class="fa-solid fa-circle-pause me-1"></i>
                                            {{ __('emis.inactive') }}
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-inline-flex flex-wrap justify-content-center gap-1">
                                        @if(Route::has('budget-entities.show'))
                                            <a href="{{ route('budget-entities.show', $entity) }}"
                                               class="btn btn-sm btn-outline-info action-button"
                                               title="{{ __('emis.view') }}"
                                               aria-label="{{ __('emis.view') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        @endif

                                        @if(Route::has('budget-entities.edit'))
                                            <a href="{{ route('budget-entities.edit', $entity) }}"
                                               class="btn btn-sm btn-outline-warning action-button"
                                               title="{{ __('emis.edit') }}"
                                               aria-label="{{ __('emis.edit') }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endif

                                        @if(Route::has('focal-point-introductions.create'))
                                            <a href="{{ route(
                                                    'focal-point-introductions.create',
                                                    [
                                                        'budget_entity_id'
                                                            => $entity->id,
                                                    ]
                                                ) }}"
                                               class="btn btn-sm btn-outline-success action-button"
                                               title="{{ __('emis.register_introduction_letter') }}"
                                               aria-label="{{ __('emis.register_introduction_letter') }}">
                                                <i class="fa-solid fa-envelope-circle-check"></i>
                                            </a>
                                        @endif

                                        @if(Route::has('budget-entities.destroy'))
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger action-button"
                                                    data-delete-form="deleteEntity{{ $entity->id }}"
                                                    data-entity-name="{{ $displayName($entity) }}"
                                                    @disabled(
                                                        $childrenCount > 0
                                                        || $introductionsCount > 0
                                                        || $focalPointsCount > 0
                                                    )
                                                    title="{{ __('emis.delete') }}"
                                                    aria-label="{{ __('emis.delete') }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                            <form id="deleteEntity{{ $entity->id }}"
                                                  method="POST"
                                                  action="{{ route('budget-entities.destroy', $entity) }}"
                                                  class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10"
                                    class="p-0">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fa-solid fa-landmark"></i>
                                        </div>

                                        <h5 class="fw-bold mb-2">
                                            {{ __('emis.no_budget_entities_found') }}
                                        </h5>

                                        <p class="text-muted mb-3">
                                            {{ __('emis.register_entity_before_introduction') }}
                                        </p>

                                        @if(Route::has('budget-entities.create'))
                                            <a href="{{ route('budget-entities.create') }}"
                                               class="btn btn-primary">
                                                <i class="fa-solid fa-plus me-1"></i>
                                                {{ __('emis.register_first_entity') }}
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
            method_exists($budgetEntities, 'hasPages')
            && $budgetEntities->hasPages()
        )
            <div class="card-footer bg-white border-0 px-4 py-3">
                {{ $budgetEntities->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .stat-card {
        min-height: 104px;
        height: 100%;
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
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-size: 18px;
    }

    .filter-card,
    .table-card {
        border-radius: 16px;
        overflow: hidden;
    }

    .form-control,
    .form-select {
        min-height: 44px;
        border-radius: 10px;
    }

    .entity-table {
        min-width: 1250px;
    }

    .entity-table thead th {
        padding: 14px 12px;
        color: #526579;
        background: #f5f8fb;
        border-bottom: 1px solid #e4ebf2;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .entity-table tbody td {
        padding: 14px 12px;
        border-color: #edf1f5;
        font-size: 13px;
        vertical-align: middle;
    }

    .entity-cell {
        min-width: 220px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .entity-icon {
        width: 36px;
        height: 36px;
        min-width: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        color: #0d6efd;
        background: #eaf3ff;
    }

    .entity-type-badge {
        padding: 7px 9px;
        white-space: nowrap;
    }

    .contact-line {
        color: #536779;
        font-size: 12px;
        line-height: 1.7;
        white-space: nowrap;
    }

    .contact-line i {
        width: 16px;
        color: #7690a7;
    }

    .count-badge {
        min-width: 34px;
        height: 30px;
        padding: 0 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
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
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 22px;
        color: #0d6efd;
        background: #eaf3ff;
        font-size: 30px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteTitle = @json(__('emis.delete_budget_entity_title'));
    const deleteMessage = @json(__('emis.delete_budget_entity_message'));
    const yesDelete = @json(__('emis.yes_delete_it'));
    const cancelText = @json(__('emis.cancel'));
    const fallbackMessage = @json(__('emis.delete_entity_confirmation'));

    document.querySelectorAll('[data-delete-form]').forEach(function (button) {
        button.addEventListener('click', function () {
            if (this.disabled) {
                return;
            }

            const formId = this.dataset.deleteForm;
            const entityName = this.dataset.entityName || '';
            const form = document.getElementById(formId);

            if (!form) {
                return;
            }

            const localizedMessage = deleteMessage.replace(
                ':name',
                entityName
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
                    fallbackMessage.replace(':name', entityName)
                )
            ) {
                form.submit();
            }
        });
    });
});
</script>
@endpush