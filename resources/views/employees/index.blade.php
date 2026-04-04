@extends('new')

@section('content')


<style>
   
    .custom-pagination .page-link {
        color: #0d6efd;
        font-weight: 100;
        border-radius: 6px;
        padding: 1px 10px;
        margin-top:6px;

    }
    .custom-pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white !important;
        font-weight: normal;
    }
    .custom-pagination .page-item.disabled .page-link {
        color: #6c757d;
    }
    .custom-pagination .page-link:hover {
        background-color: #e9f0ff;
    }
</style>

<div class="container">
    <h2>Employees</h2>

    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3 align-left">Add Employee</a>

    <form method="GET" action="{{ route('employees.index') }}" class="form">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search employee">
        <button type="submit">Search</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th width="220">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->employee_code }}</td>
                    <td>{{ $employee->full_name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->status }}</td>
                    <td>
                        <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-info">کتل</a>
                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this employee?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No employees found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

 @if ($employees->hasPages())
    <nav>
        <ul class="pagination justify-content-center custom-pagination">
            {{-- Previous Page --}}
            @if ($employees->onFirstPage())
                <li class="page-item disabled"><span class="page-link">«</span></li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $employees->previousPageUrl() }}">«</a>
                </li>
            @endif
            {{-- Page Numbers --}}
            @foreach ($employees->links()->elements[0] as $page => $url)
                @if ($page == $employees->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
            {{-- Next Page --}}
            @if ($employees->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $employees->nextPageUrl() }}">»</a>
                </li>
            @else

                <li class="page-item disabled"><span class="page-link">»</span></li>
            @endif
        </ul>
    </nav>
@endif
</div>
@endsection