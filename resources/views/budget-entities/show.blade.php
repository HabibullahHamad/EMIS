@extends('new')

@section('title', __('emis.budget_entity_details'))

@section('content')
<div class="container-fluid emis-page">
    <x-emis.page-header
        :title="__('emis.budget_entity_details')"
        :description="$budgetEntity->display_name"
        icon="fa-solid fa-landmark"
    >
        <x-slot:actions>
            <a href="{{ route('budget-entities.edit', $budgetEntity) }}" class="btn btn-primary">
                <i class="fa-solid fa-pen"></i>{{ __('emis.edit') }}
            </a>
            <a href="{{ route('budget-entities.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>{{ __('emis.back') }}
            </a>
        </x-slot:actions>
    </x-emis.page-header>

    <div class="row g-3 mb-3">
        @foreach([
            ['label' => __('emis.children'), 'value' => $budgetEntity->children_count, 'icon' => 'fa-sitemap'],
            ['label' => __('emis.introduction_letters'), 'value' => $budgetEntity->introductions_count, 'icon' => 'fa-envelope-open-text'],
            ['label' => __('emis.focal_points'), 'value' => $budgetEntity->focal_points_count, 'icon' => 'fa-users'],
        ] as $stat)
            <div class="col-md-4">
                <div class="card h-100"><div class="card-body d-flex align-items-center gap-3">
                    <span class="emis-page-header__icon"><i class="fa-solid {{ $stat['icon'] }}"></i></span>
                    <div><div class="text-muted small">{{ $stat['label'] }}</div><strong class="fs-4">{{ $stat['value'] }}</strong></div>
                </div></div>
            </div>
        @endforeach
    </div>

    <x-emis.card :title="__('emis.basic_information')">
        <div class="row g-3">
            @foreach([
                __('emis.entity_code') => $budgetEntity->entity_code,
                __('emis.short_name') => $budgetEntity->short_name,
                __('emis.entity_type') => __('emis.' . $budgetEntity->entity_type),
                __('emis.name_english') => $budgetEntity->name_en,
                __('emis.name_pashto') => $budgetEntity->name_ps,
                __('emis.name_dari') => $budgetEntity->name_fa,
                __('emis.parent_budget_entity') => $budgetEntity->parent?->display_name,
                __('emis.phone') => $budgetEntity->phone,
                __('emis.email') => $budgetEntity->email,
                __('emis.status') => $budgetEntity->status ? __('emis.active') : __('emis.inactive'),
                __('emis.created_by') => $budgetEntity->creator?->name,
                __('emis.created_at') => optional($budgetEntity->created_at)->format('Y-m-d H:i'),
            ] as $label => $value)
                <div class="col-md-6 col-xl-4">
                    <div class="p-3 border rounded-3 h-100">
                        <div class="text-muted small mb-1">{{ $label }}</div>
                        <div class="fw-semibold">{{ filled($value) ? $value : '—' }}</div>
                    </div>
                </div>
            @endforeach
            <div class="col-12"><div class="p-3 border rounded-3">
                <div class="text-muted small mb-1">{{ __('emis.address') }}</div>
                <div>{{ $budgetEntity->address ?: '—' }}</div>
            </div></div>
            <div class="col-12"><div class="p-3 border rounded-3">
                <div class="text-muted small mb-1">{{ __('emis.description') }}</div>
                <div>{{ $budgetEntity->description ?: '—' }}</div>
            </div></div>
        </div>
    </x-emis.card>
</div>
@endsection
