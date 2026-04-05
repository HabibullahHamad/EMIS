@extends('new')

@section('content')


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>

    .{
        direction:rtl;
    }
    .page-header {
        background: #fff;
        border-radius: 10px;
        padding: 8px 80px;
        margin-bottom: 8px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
    }

    .page-title {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
        text-align: center;
    }

    .search-box {
        max-width: 280px;
    }

    .table-card {
        background: #fff;
        border-radius: 10px;
        padding: 12px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
        direction:rtl;
    }

    .table thead th {
        font-size: 13px;
        white-space: nowrap;
        vertical-align: middle;
        text-align: center;
    }

    .table tbody td {
        font-size: 12px;
        vertical-align: middle;
        text-align: center;
        height: 30px;
    }

    .employee-photo {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #ddd;
    }

    .action-btns .btn {
        margin: 1px;
         font-size: 10px;
        
    }

    .custom-pagination .page-link {
        color: #0d6efd;
        border-radius: 6px;
        padding: 3px 10px;
        margin-top: 6px;
        font-size: 13px;
    }

    .custom-pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff !important;
    }

    .custom-pagination .page-item.disabled .page-link {
        color: #6c757d;
    }

    .table-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .rtl-page {
        direction: ltr;
        text-align: right;
    }

    .ltr-table {
        direction: ltr;
    }

    @media (max-width: 768px) {
        .page-title {
            width: 100%;
            text-align: center;
            order: -1;
        }

        .table-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            max-width: 100%;
        }
    }
</style>

<div class="container-fluid rtl-page">

    {{-- Header --}}
    <div class="page-header">
        <div class="table-toolbar">
            <div class="search-box">
                <div class="input-group input-group-sm">
                    <span class="input-group-text">🔍</span>
                    <input type="text" id="liveSearch" class="form-control" placeholder="د کارکوونکي لټون..." value="{{ request('search') }}">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="resetSearch">Reset</button>
                </div>
            </div>

            <h4 class="page-title flex-grow-0">د کارکوونکو مدیریت</h4>

            <a href="{{ route('employees.create') }}" class="btn btn-sm btn-primary">
                 Add Employee
            </a>
        </div>
    </div>

   
    <div class="table-card">
        <div class="table-responsive rtl-table">
            <div class="row mb-3">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center">
            <div class="card-body py-3">
                <h6 class="mb-1">Total Employees</h6>
                <h3 class="mb-0">{{ $stats['total'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center">
            <div class="card-body py-3">
                <h6 class="mb-1 text-success">Active</h6>
                <h3 class="mb-0 text-success">{{ $stats['active'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center">
            <div class="card-body py-3">
                <h6 class="mb-1 text-danger">Inactive</h6>
                <h3 class="mb-0 text-danger">{{ $stats['inactive'] }}</h3>
            </div>
        </div>
    </div>
</div>
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                         <th>Photo</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody id="employeeTableBody">
                    @include('employees.partials.rows', ['employees' => $employees])
                </tbody>
            </table>
        </div>

        <div class="mt-3" id="paginationWrapper">
            @if ($employees->hasPages())
                <nav>
                    <ul class="pagination justify-content-center custom-pagination">
                        @if ($employees->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">«</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $employees->previousPageUrl() }}">«</a>
                            </li>
                        @endif

                        @foreach ($employees->getUrlRange(1, $employees->lastPage()) as $page => $url)
                            @if ($page == $employees->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

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
    </div>
</div>

<script>
    let searchTimer;

    const liveSearch = document.getElementById('liveSearch');
    const statusFilter = document.getElementById('statusFilter');
    const resetSearch = document.getElementById('resetSearch');

    liveSearch.addEventListener('keyup', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(fetchEmployees, 400);
    });

    statusFilter.addEventListener('change', function () {
        fetchEmployees();
    });

    resetSearch.addEventListener('click', function () {
        liveSearch.value = '';
        statusFilter.value = '';
        fetchEmployees();
    });

    function fetchEmployees() {
        const search = liveSearch.value;
        const status = statusFilter.value;

        fetch(`{{ route('employees.index') }}?search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('employeeTableBody').innerHTML = html;
            document.getElementById('paginationWrapper').innerHTML = '';
        })
        .catch(error => console.error('Search error:', error));
    }
</script>

@endsection