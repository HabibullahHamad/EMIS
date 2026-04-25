@extends('new')

@section('page_title', __('emis.departments') ?? 'Departments')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <form method="GET" action="{{ route('departments.index') }}" class="d-flex gap-2 flex-wrap">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="{{ __('emis.search_department') }}">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">{{ __('emis.all_status') }}</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>{{ __('emis.active') }}</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>{{ __('emis.inactive') }}</option>
                    </select>
                    <button class="btn btn-sm btn-primary">{{ __('emis.search') }}</button>
                    <a href="{{ route('departments.index') }}" class="btn btn-sm btn-secondary">{{ __('emis.reset') }}</a>
                </form>

                <a href="{{ route('departments.create') }}" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i> {{ __('emis.adddepaerment') }}
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
@endsection