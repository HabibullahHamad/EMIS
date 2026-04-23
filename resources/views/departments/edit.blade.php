@extends('new')

@section('page_title', __('emis.edit_department') ?? 'Edit Department')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <form method="POST" action="{{ route('departments.update', $department) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $department->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Code</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $department->code) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pashto Name</label>
                        <input type="text" name="name_ps" class="form-control" value="{{ old('name_ps', $department->name_ps) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Dari Name</label>
                        <input type="text" name="name_fa" class="form-control" value="{{ old('name_fa', $department->name_fa) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Parent Department</label>
                        <select name="parent_id" class="form-select">
                            <option value="">None</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $department->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="status" id="status"
                                {{ old('status', $department->status) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $department->description) }}</textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection