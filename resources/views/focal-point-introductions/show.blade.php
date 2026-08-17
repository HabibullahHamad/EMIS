@extends('new')

@section('title', __('emis.introduction_letter_details'))

@section('content')
<div class="container-fluid emis-page">
    <x-emis.page-header :title="__('emis.introduction_letter_details')" :description="$introduction->subject" icon="fa-solid fa-envelope-open-text">
        <x-slot:actions>
            <a href="{{ route('focal-point-introductions.edit', $introduction) }}" class="btn btn-primary"><i class="fa-solid fa-pen"></i>{{ __('emis.edit') }}</a>
            <a href="{{ route('focal-point-introductions.index') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i>{{ __('emis.back') }}</a>
        </x-slot:actions>
    </x-emis.page-header>

    <x-emis.card :title="__('emis.official_introduction')">
        <div class="row g-3">
            @foreach([
                __('emis.budget_entity') => $introduction->budgetEntity?->display_name,
                __('emis.letter_number') => $introduction->letter_number,
                __('emis.letter_date') => optional($introduction->letter_date)->format('Y-m-d'),
                __('emis.received_date') => optional($introduction->received_date)->format('Y-m-d'),
                __('emis.number_of_nominees') => $introduction->number_of_nominees,
                __('emis.status') => __('emis.' . $introduction->status),
                __('emis.created_by') => $introduction->creator?->name,
                __('emis.reviewed_by') => $introduction->reviewer?->name,
                __('emis.reviewed_at') => optional($introduction->reviewed_at)->format('Y-m-d H:i'),
            ] as $label => $value)
                <div class="col-md-6 col-xl-4"><div class="p-3 border rounded-3 h-100"><div class="small text-muted mb-1">{{ $label }}</div><strong>{{ filled($value) ? $value : '—' }}</strong></div></div>
            @endforeach
            <div class="col-12"><div class="p-3 border rounded-3"><div class="small text-muted mb-1">{{ __('emis.subject') }}</div>{{ $introduction->subject ?: '—' }}</div></div>
            <div class="col-12"><div class="p-3 border rounded-3"><div class="small text-muted mb-1">{{ __('emis.approval_notes') }}</div>{{ $introduction->approval_notes ?: '—' }}</div></div>
            @if($introduction->attachment)
                <div class="col-12"><a href="{{ route('focal-point-introductions.attachment', $introduction) }}" class="btn btn-info"><i class="fa-solid fa-download"></i>{{ __('emis.download') }}</a></div>
            @endif
        </div>
    </x-emis.card>
</div>
@endsection
