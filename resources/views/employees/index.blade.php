@extends('new')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
   .page-header {
    background: #fff;
    border-radius: 8px;
    padding: 6px 12px;
    min-height: 45px;
    box-shadow: 0 1px 5px rgba(0,0,0,0.05);
    margin-bottom: 12px;
}

.page-header .form-control,
.page-header .form-select,
.page-header .btn,
.page-header .input-group-text {
    height: 30px !important;
    font-size: 12px;
}

.input-group-sm > .form-control,
.input-group-sm > .input-group-text {
    padding: 2px 6px;
}

   .table-card {
    background: #f8f5f5;
    border-radius: 8px;
    padding: 4px 6px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    direction: rtl;
    margin-bottom: 8px;
}
.table-card .table {
    margin-bottom: 0;
}

.table-card .table thead th {
    padding: 6px 8px;
    font-size: 12px;
}

.table-card .table tbody td {
    padding: 5px 6px;
    font-size: 12px;
}

.table-card {
    padding: 2px 4px;
}

.table-card .table thead th,
.table-card .table tbody td {
    padding: 4px 6px;
    font-size: 11.5px;
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
        margin-bottom: 5px;
        flex-wrap: wrap;
    }

    .rtl-page {
        direction: ltr;
        text-align: right;
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
    }
</style>

<div class="container-fluid rtl-page">

  <div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">

    <div class="d-flex align-items-center gap-2 flex-wrap">

        <div class="input-group input-group-sm" style="width:220px;">
            <span class="input-group-text py-1 px-2">&#128269;</span>
            <input type="text"
                   id="liveSearch"
                   class="form-control form-control-sm"
                   placeholder="{{ __('emis.search') }}..."
                   value="{{ request('search') }}">
        </div>

        <select id="statusFilter"
                class="form-select form-select-sm py-1"
                style="width:120px;">
            <option value="">{{ __('emis.all') }}</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('emis.active') }}</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('emis.inactive') }}</option>
        </select>

        <button type="button"
                class="btn btn-outline-secondary btn-sm py-1 px-2"
                id="resetSearch">
            {{ __('emis.reset') }}
        </button>
    </div>

    <div class="text-center flex-grow-1">
        <h6 class="mb-0 fw-semibold">{{ __('emis.employees') }}</h6>
    </div>

    <div class="d-flex align-items-center gap-2 flex-wrap">
        <a href="{{ route('employees.export.excel', request()->query()) }}"
           class="btn btn-sm btn-success py-1 px-3">
            {{ __('emis.export_excel') }}
        </a>

        <a href="{{ route('employees.export.pdf', request()->query()) }}"
           class="btn btn-sm btn-danger py-1 px-3">
            {{ __('emis.export_pdf') }}
        </a>

        <a href="{{ route('employees.create') }}"
           class="btn btn-sm btn-primary py-1 px-3">
            + {{ __('emis.add_employee') }}
        </a>
    </div>

</div>

    <div class="table-card">
        <div class="table-responsive rtl-table">
            <div class="row mb-1">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 text-center">
                        <div class="card-body py-1 bg-info">
                            <h6 class="mb-1">{{ __('emis.total_employees') }}</h6>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 text-center">
                        <div class="card-body py-1 bg-success">
                            <h6 class="mb-1 text-whit">{{ __('emis.active') }}</h6>
                            <h3 class="mb-0 text-whit">{{ $stats['active'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 text-center">
                        <div class="card-body py-1 bg-danger">
                            <h6 class="mb-1 text-gold">{{ __('emis.inactive') }}</h6>
                            <h3 class="mb-0 text-whit">{{ $stats['inactive'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>{{ __('emis.code') }}</th>
                        <th>{{ __('emis.name') }}</th>
                        <th>{{ __('emis.email') }}</th>
                        <th>{{ __('emis.phone') }}</th>
                        <th>{{ __('emis.status') }}</th>
                        <th width="150">{{ __('emis.actions') }}</th>
                    </tr>
                </thead>
                <tbody id="employeeTableBody">
                    @include('employees.partials.rows', ['employees' => $employees])
                </tbody>
            </table>
        </div>

        <div class="mt-0" id="paginationWrapper">
            @if ($employees->hasPages())
                <nav>
                    <ul class="pagination justify-content-center custom-pagination">
                        @if ($employees->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $employees->previousPageUrl() }}">&laquo;</a>
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
                                <a class="page-link" href="{{ $employees->nextPageUrl() }}">&raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
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
