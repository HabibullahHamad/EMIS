@extends('new')

@section('page_title', __('emis.focal_points'))

@section('content')

<div class="emis-card">

    <div class="emis-card-header">
        <div>
            <h5 class="mb-1">
                <i class="fa-solid fa-user-check me-1"></i>
                {{ __('emis.focal_points') }}
            </h5>

            <small class="text-muted">
                {{ __('emis.focal_points_description') }}
            </small>
        </div>

        @if(Route::has('focal-points.registration'))
            <a href="{{ route('focal-points.registration') }}"
               class="emis-btn emis-btn-primary">
                <i class="fa-solid fa-user-plus me-1"></i>
                {{ __('emis.register_focal_point') }}
            </a>
        @elseif(Route::has('focal-points.create'))
            <a href="{{ route('focal-points.create') }}"
               class="emis-btn emis-btn-primary">
                <i class="fa-solid fa-user-plus me-1"></i>
                {{ __('emis.register_focal_point') }}
            </a>
        @endif

        @if(Route::has('budget-entities.create'))
            <a href="{{ route('budget-entities.create') }}"
               class="emis-btn emis-btn-secondary ms-2">
                <i class="fa-solid fa-building me-1"></i>
                {{ __('emis.add_budget_entity') }}
            </a>
        @endif

        @if(Route::has('introduction-form.create'))
            <a href="{{ route('introduction-form.create') }}"
               class="emis-btn emis-btn-secondary ms-2">
                <i class="fa-solid fa-file-lines me-1"></i>
                {{ __('emis.introduction_form') }}
            </a>
        @endif
    </div>

    {{-- Search and filters --}}
    <form method="GET"
          action="{{ route('focal-points.index') }}"
          class="emis-filter">

        <input type="search"
               name="search"
               class="form-control"
               value="{{ request('search') }}"
               placeholder="{{ __('emis.focal_points_search_placeholder') }}">

        <select name="budget_entity_id"
                class="form-select"
                aria-label="{{ __('emis.budget_entity') }}">
            <option value="">{{ __('emis.all_budget_entities') }}</option>

            @foreach($budgetEntities ?? [] as $entity)
                <option value="{{ $entity->id }}"
                    {{ (string) request('budget_entity_id') === (string) $entity->id ? 'selected' : '' }}>
                    {{ $entity->entity_code }}
                    —
                    {{ $entity->display_name
                        ?? $entity->name_en
                        ?? $entity->name_fa
                        ?? $entity->name_ps }}
                </option>
            @endforeach
        </select>

        <select name="status"
                class="form-select"
                aria-label="{{ __('emis.status') }}">
            <option value="">{{ __('emis.all_statuses') }}</option>

            @foreach([
                'pending',
                'under_review',
                'active',
                'suspended',
                'replaced',
                'expired',
                'rejected',
                'inactive',
            ] as $value)
                <option value="{{ $value }}"
                    {{ request('status') === $value ? 'selected' : '' }}>
                    {{ __('emis.' . $value) }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="emis-btn emis-btn-primary">
            <i class="fa-solid fa-magnifying-glass me-1"></i>
            {{ __('emis.search') }}
        </button>

        <a href="{{ route('focal-points.index') }}"
           class="emis-btn emis-btn-light">
            {{ __('emis.reset') }}
        </a>
    </form>

    {{-- Results table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover emis-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('emis.photo') }}</th>
                    <th>{{ __('emis.focal_point_code') }}</th>
                    <th>{{ __('emis.name') }}</th>
                    <th>{{ __('emis.budget_entity') }}</th>
                    <th>{{ __('emis.job_title') }}</th>
                    <th>{{ __('emis.phone') }}</th>
                    <th>{{ __('emis.valid_until') }}</th>
                    <th>{{ __('emis.status') }}</th>
                    <th class="actions-cell">{{ __('emis.actions') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse($focalPoints as $focalPoint)
                    @php
                        $statusClass = match($focalPoint->status) {
                            'active' => 'bg-success',
                            'pending', 'under_review' => 'bg-warning text-dark',
                            'suspended', 'rejected' => 'bg-danger',
                            'expired', 'replaced', 'inactive' => 'bg-secondary',
                            default => 'bg-secondary',
                        };

                        $registrationUrl = Route::has('focal-points.registration')
                            ? route('focal-points.registration', $focalPoint)
                            : route('focal-points.show', $focalPoint);
                    @endphp

                    <tr>
                        <td>
                            {{ $loop->iteration
                                + (($focalPoints->currentPage() - 1)
                                * $focalPoints->perPage()) }}
                        </td>

                        <td>
                            @if($focalPoint->photo_path)
                                <img src="{{ asset('storage/' . $focalPoint->photo_path) }}"
                                     alt="{{ __('emis.focal_point_photo') }}"
                                     width="44"
                                     height="52"
                                     class="rounded border"
                                     style="object-fit: cover;">
                            @else
                                <span class="d-inline-flex align-items-center justify-content-center
                                             rounded border bg-light text-muted"
                                      style="width:44px;height:52px;"
                                      title="{{ __('emis.no_photo') }}">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                            @endif
                        </td>

                        <td class="fw-semibold">
                            {{ $focalPoint->focal_point_code }}
                        </td>

                        <td>
                            <a href="{{ $registrationUrl }}"
                               class="fw-semibold text-decoration-none">
                                {{ $focalPoint->display_name
                                    ?? $focalPoint->full_name_en
                                    ?? $focalPoint->full_name_fa
                                    ?? $focalPoint->full_name_ps
                                    ?? '-' }}
                            </a>

                            @if($focalPoint->father_name)
                                <div class="small text-muted">
                                    {{ __('emis.father_name') }}: {{ $focalPoint->father_name }}
                                </div>
                            @endif
                        </td>

                        <td>
                            {{ optional($focalPoint->budgetEntity)->display_name
                                ?? optional($focalPoint->budgetEntity)->name_en
                                ?? optional($focalPoint->budgetEntity)->name_fa
                                ?? optional($focalPoint->budgetEntity)->name_ps
                                ?? '-' }}
                        </td>

                        <td>
                            {{ $focalPoint->job_title ?: '-' }}
                        </td>

                        <td>
                            {{ $focalPoint->phone ?: '-' }}
                        </td>

                        <td>
                            {{ $focalPoint->valid_until
                                ? \Illuminate\Support\Carbon::parse($focalPoint->valid_until)->format('Y-m-d')
                                : '-' }}
                        </td>

                        <td>
                            <span class="badge {{ $statusClass }}">
                                {{ __('emis.' . $focalPoint->status) }}
                            </span>
                        </td>

                        <td>
                            <div class="action-buttons">

                                <a href="{{ $registrationUrl }}"
                                   class="btn btn-sm btn-info"
                                   title="{{ __('emis.view_and_manage') }}"
                                   aria-label="{{ __('emis.view_and_manage') }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                @if(Route::has('focal-points.registration'))
                                    <a href="{{ route('focal-points.registration', $focalPoint) }}"
                                       class="btn btn-sm btn-warning"
                                       title="{{ __('emis.edit') }}"
                                       aria-label="{{ __('emis.edit') }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                @elseif(Route::has('focal-points.edit'))
                                    <a href="{{ route('focal-points.edit', $focalPoint) }}"
                                       class="btn btn-sm btn-warning"
                                       title="{{ __('emis.edit') }}"
                                       aria-label="{{ __('emis.edit') }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                @endif

                                @if(
                                    Route::has('focal-point-cards.create')
                                    && $focalPoint->status === 'active'
                                )
                                    <a href="{{ route(
                                            'focal-point-cards.create',
                                            ['focal_point_id' => $focalPoint->id]
                                        ) }}"
                                       class="btn btn-sm btn-primary"
                                       title="{{ __('emis.generate_card') }}"
                                       aria-label="{{ __('emis.generate_card') }}">
                                        <i class="fa-solid fa-id-card"></i>
                                    </a>
                                @endif

                                @if(Route::has('focal-points.destroy'))
                                    <form method="POST"
                                          action="{{ route('focal-points.destroy', $focalPoint) }}"
                                          onsubmit="return confirm(@js(__('emis.confirm_delete_focal_point')));">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="{{ __('emis.delete') }}"
                                                aria-label="{{ __('emis.delete') }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10"
                            class="text-center text-muted py-5">
                            <i class="fa-solid fa-users-slash fa-2x mb-2 d-block"></i>
                            {{ __('emis.no_focal_points_registered') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($focalPoints, 'links'))
        <div class="mt-3">
            {{ $focalPoints->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection