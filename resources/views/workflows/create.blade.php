@extends('new')

@section('page_title', 'Create Workflow')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header fw-bold">
{{ __('emis.create_workflow') }}        </div>

        <div class="card-body">
            <form action="{{ route('workflows.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.title') }}</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.forward_to_user') }}</label>
                        <select name="to_user_id" class="form-select" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('to_user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} - {{ optional($user->role)->display_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.to_department') }}</label>
                        <select name="to_department_id" class="form-select">
                            <option value="">None</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('to_department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>




                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.priority') }}</label>
                        <select name="priority" class="form-select" required>
                            <option value="low">{{ __('emis.low') }}</option>
                            <option value="normal" selected>{{ __('emis.normal') }}</option>
                            <option value="high">{{ __('emis.high') }}</option>
                            <option value="urgent">{{ __('emis.urgent') }}</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">{{ __('emis.description') }}</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">{{ __('emis.remarks') }}</label>
                        <textarea name="remarks" class="form-control" rows="3">{{ old('remarks') }}</textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">{{ __('emis.save') }}</button>
                    <a href="{{ route('workflows.index') }}" class="btn btn-secondary">{{ __('emis.back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection