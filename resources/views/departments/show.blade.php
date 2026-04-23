@extends('new')

@section('page_title', __('emis.department_details') ?? 'Department Details')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6"><strong>Name:</strong> {{ $department->name }}</div>
                <div class="col-md-6"><strong>Code:</strong> {{ $department->code ?? '-' }}</div>
                <div class="col-md-6"><strong>Pashto:</strong> {{ $department->name_ps ?? '-' }}</div>
                <div class="col-md-6"><strong>Dari:</strong> {{ $department->name_fa ?? '-' }}</div>
                <div class="col-md-6"><strong>Parent:</strong> {{ $department->parent->name ?? '-' }}</div>
                <div class="col-md-6">
                    <strong>Status:</strong>
                    @if($department->status)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </div>
                <div class="col-12"><strong>Description:</strong> {{ $department->description ?? '-' }}</div>
            </div>

            @if($department->children->count())
                <hr>
                <h6>Child Departments</h6>
                <ul>
                    @foreach($department->children as $child)
                        <li>{{ $child->name }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="mt-3">
                <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection