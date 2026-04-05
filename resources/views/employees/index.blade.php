@extends('new')

@section('content')

<style>
    .page-header {
        background: #fff;
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 16px;
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
    }

    .table thead th {
        font-size: 13px;
        white-space: nowrap;
        vertical-align: middle;
        text-align: center;
    }

    .table tbody td {
        font-size: 13px;
        vertical-align: middle;
        text-align: center;
    }

    .employee-photo {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #ddd;
    }

    .action-btns .btn {
        margin: 2px;
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
        direction: rtl;
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

            <h4 class="page-title flex-grow-1">د کارکوونکو مدیریت</h4>

            <a href="{{ route('employees.create') }}" class="btn btn-sm btn-primary">
                ➕ Add Employee
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif

    <div class="table-card">
        <div class="table-responsive ltr-table">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th width="240">Actions</th>
                    </tr>
                </thead>
                <tbody id="employeeTableBody">
                    <!-- @include('employees.partials.rows', ['employees' => $employees]) -->
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

    document.getElementById('liveSearch').addEventListener('keyup', function () {
        clearTimeout(searchTimer);
        const value = this.value;

        searchTimer = setTimeout(() => {
            fetchEmployees(value);
        }, 400);
    });

    document.getElementById('resetSearch').addEventListener('click', function () {
        document.getElementById('liveSearch').value = '';
        fetchEmployees('');
    });

    function fetchEmployees(search = '') {
        fetch(`{{ route('employees.index') }}?search=${encodeURIComponent(search)}`, {
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