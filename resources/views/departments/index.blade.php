@extends('new')

@section('page_title', __('emis.departments') ?? 'Departments')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
              

                <a href="{{ route('departments.create') }}" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i> {{ __('emis.adddepaerment') }}
                </a>
            </div>
<form method="GET" action="{{ route('departments.index') }}" class="row g-2 mb-3">

    <div class="col-md-3">
        <input type="text" name="search" value="{{ request('search') }}"
               class="form-control" placeholder="{{ __('emis.search_department') }}">
    </div>

    <div class="col-md-2">
        <select name="type" class="form-select">
            <option value="">All Types</option>
            <option value="general_directorate" {{ request('type') == 'general_directorate' ? 'selected' : '' }}>General Directorate</option>
            <option value="directorate" {{ request('type') == 'directorate' ? 'selected' : '' }}>Directorate</option>
            <option value="department" {{ request('type') == 'department' ? 'selected' : '' }}>Department</option>
        </select>
    </div>

    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">All Status</option>
            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <div class="col-md-3">
        <select name="parent_id" class="form-select">
            <option value="">All Parent Departments</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}" {{ request('parent_id') == $parent->id ? 'selected' : '' }}>
                    {{ $parent->name_ps ?? $parent->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2 d-flex gap-1">
        <button class="btn btn-primary">
            {{ __('emis.search') }}
        </button>

        <a href="{{ route('departments.index') }}" class="btn btn-secondary">
            {{ __('emis.Reset') }}
        </a>
    </div>
</form>

<div class="mb-3 d-flex gap-2">
    <a href="{{ route('departments.print', request()->query()) }}"
       target="_blank"
       class="btn btn-dark">
        Print Filtered
    </a>

    <button type="button" class="btn btn-success" onclick="printSelected()">
        Print Selected
    </button>
                       <a href="{{ route('department.reports.index') }}">
    <i class="fa fa-file-alt"></i> Custom Reports
</a>
</div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{{ __('emis.name') }}</th>
                            <th>{{ __('emis.pashto_name') }}</th>
                            <th>{{ __('emis.dari_name') }}</th>
                            <th>{{ __('emis.code') }}</th>
                            <th>{{ __('emis.parent_department') }}</th>
                            <th>{{ __('emis.status') }}</th>
                            <th width="220">{{ __('emis.actions') }}</th>
                            <th>
    <input type="checkbox" id="selectAll">
</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $department)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $department->name }}</td>
                                <td>{{ $department->name_ps ?? '-' }}</td>
                                <td>{{ $department->name_fa ?? '-' }}</td>
                                <td>{{ $department->code ?? '-' }}</td>
                                <td>{{ $department->parent->name ?? '-' }}</td>
                                <td>
                                    @if($department->status)
                                        <span class="badge bg-success">{{ __('emis.active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('emis.inactive') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('departments.show', $department) }}" class="btn btn-sm btn-info">{{ __('emis.view') }}</a>
                                    <a href="{{ route('departments.edit', $department) }}" class="btn btn-sm btn-warning">{{ __('emis.edit') }}</a>

                                    <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('{{ __('emis.delete_department_confirm') }}')">{{ __('emis.delete') }}</button>
                                    </form>
                                </td>
                                <td>
    <input type="checkbox" class="row-check" value="{{ $department->id }}">
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">{{ __('emis.no_departments_found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $departments->links() }}
        </div>
    </div>
</div>

<!-- for search and selection  -->
<script>
document.getElementById('selectAll')?.addEventListener('change', function () {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
});

function printSelected() {
    let ids = [];

    document.querySelectorAll('.row-check:checked').forEach(cb => {
        ids.push(cb.value);
    });

    if (ids.length === 0) {
        alert('Please select at least one record.');
        return;
    }

    let url = "{{ route('departments.print') }}" + "?ids=" + ids.join(',');
    window.open(url, '_blank');
}
</script>
@endsection