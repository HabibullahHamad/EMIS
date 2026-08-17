@extends('new')

@section('title', __('emis.edit_budget_entity'))

@section('content')
@php
    $types = ['ministry','independent_directorate','general_directorate','state_owned_enterprise','provincial_entity','budget_unit','other'];
@endphp
<div class="container-fluid emis-page">
    <x-emis.page-header :title="__('emis.edit_budget_entity')" :description="$budgetEntity->display_name" icon="fa-solid fa-landmark">
        <x-slot:actions><a href="{{ route('budget-entities.show', $budgetEntity) }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i>{{ __('emis.back') }}</a></x-slot:actions>
    </x-emis.page-header>

    <x-emis.card :title="__('emis.basic_information')">
        <form method="POST" action="{{ route('budget-entities.update', $budgetEntity) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">{{ __('emis.entity_code') }} *</label><input name="entity_code" value="{{ old('entity_code', $budgetEntity->entity_code) }}" class="form-control @error('entity_code') is-invalid @enderror" required>@error('entity_code')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-4"><label class="form-label">{{ __('emis.short_name') }}</label><input name="short_name" value="{{ old('short_name', $budgetEntity->short_name) }}" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">{{ __('emis.entity_type') }} *</label><select name="entity_type" class="form-select" required>@foreach($types as $type)<option value="{{ $type }}" @selected(old('entity_type', $budgetEntity->entity_type)===$type)>{{ __('emis.' . $type) }}</option>@endforeach</select></div>
                <div class="col-md-4"><label class="form-label">{{ __('emis.name_english') }}</label><input name="name_en" dir="ltr" value="{{ old('name_en', $budgetEntity->name_en) }}" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">{{ __('emis.name_pashto') }}</label><input name="name_ps" dir="rtl" value="{{ old('name_ps', $budgetEntity->name_ps) }}" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">{{ __('emis.name_dari') }} *</label><input name="name_fa" dir="rtl" value="{{ old('name_fa', $budgetEntity->name_fa) }}" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">{{ __('emis.parent_budget_entity') }}</label><select name="parent_id" class="form-select"><option value="">{{ __('emis.no_parent_entity') }}</option>@foreach($parents as $parent)<option value="{{ $parent->id }}" @selected((string)old('parent_id',$budgetEntity->parent_id)===(string)$parent->id)>{{ $parent->entity_code }} — {{ $parent->display_name }}</option>@endforeach</select></div>
                <div class="col-md-3"><label class="form-label">{{ __('emis.phone') }}</label><input name="phone" value="{{ old('phone', $budgetEntity->phone) }}" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">{{ __('emis.email') }}</label><input type="email" name="email" value="{{ old('email', $budgetEntity->email) }}" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">{{ __('emis.address') }}</label><textarea name="address" class="form-control">{{ old('address', $budgetEntity->address) }}</textarea></div>
                <div class="col-md-6"><label class="form-label">{{ __('emis.description') }}</label><textarea name="description" class="form-control">{{ old('description', $budgetEntity->description) }}</textarea></div>
                <div class="col-md-4"><label class="form-label">{{ __('emis.status') }} *</label><select name="status" class="form-select" required><option value="1" @selected((string)old('status',(int)$budgetEntity->status)==='1')>{{ __('emis.active') }}</option><option value="0" @selected((string)old('status',(int)$budgetEntity->status)==='0')>{{ __('emis.inactive') }}</option></select></div>
            </div>
            <div class="emis-action-bar"><a href="{{ route('budget-entities.show', $budgetEntity) }}" class="btn btn-secondary">{{ __('emis.cancel') }}</a><button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>{{ __('emis.update') }}</button></div>
        </form>
    </x-emis.card>
</div>
@endsection
