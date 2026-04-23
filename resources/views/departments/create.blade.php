@extends('new')

@section('page_title', __('emis.create_department') ?? 'Create Department')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <form method="POST" action="{{ route('departments.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.code') }}</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.pashto_name') }}</label>
                        <input type="text" name="name_ps" class="form-control" value="{{ old('name_ps') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.dari_name') }}</label>
                        <input type="text" name="name_fa" class="form-control" value="{{ old('name_fa') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.parent_department') }}</label>
                        <select name="parent_id" class="form-select">
                            <option value="">{{ __('emis.none') }}</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                            <label class="form-check-label" for="status">{{ __('emis.active') }}</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">{{ __('emis.description') }}</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">{{ __('emis.save') }}</button>
                    <a href="{{ route('departments.index') }}" class="btn btn-secondary">{{ __('emis.back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection