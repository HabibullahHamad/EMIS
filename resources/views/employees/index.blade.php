@extends('new')

@section('content')


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>

    .{
        direction:rtl;
    }
  .page-header {
    background: #fff;
    border-radius: 8px;
    padding: 6px 12px;   /* 🔥 small height */
    min-height: 45px;
    box-shadow: 0 1px 5px rgba(0,0,0,0.05);
}

/* Align all controls perfectly */
.page-header .form-control,
.page-header .form-select,
.page-header .btn,
.page-header .input-group-text {
    height: 30px !important;
    font-size: 12px;
}

/* Remove extra padding inside input group */
.input-group-sm > .form-control,
.input-group-sm > .input-group-text {
    padding: 2px 6px;
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
        background: #f8f5f5;
        border-radius: 10px;
        padding: 5px;
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

    {{-- Header --}}
    <div class="page-header">

{{-- Header --}}
<div class="page-header d-flex align-items-center justify-content-between flex-wrap">

    {{-- LEFT: Search + Filter --}}
    <div class="d-flex align-items-center gap-2">

        <div class="input-group input-group-sm" style="width:220px;">
            <span class="input-group-text py-1 px-2">🔍</span>
            <input type="text"
                   id="liveSearch"
                   class="form-control form-control-sm"
                   placeholder="Search..."
                   value="{{ request('search') }}">
        </div>

        <select id="statusFilter"
                class="form-select form-select-sm py-1"
                style="width:120px;">
            <option value="">All</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>

        <button type="button"class="btn btn-outline-secondary btn-sm py-1 px-2" id="resetSearch"id="resetSearch">
          
    <i class="bi bi-arrow-clockwise"></i>
</button>

    </div>

    {{-- CENTER: Title --}}
    <div class="text-center flex-grow-1">
        <h6 class="mb-0 fw-semibold">Employees</h6>
    </div>

    {{-- RIGHT: Add Button --}}
    <div>
        <a  class="btn btn-sm btn-primary" href="{{ route('employees.create') }}">
            Add New Employee 
        </a>

    </div>

</div>
   <!-- Cards -->
    <div class="table-card">
        <div class="table-responsive rtl-table">
            <div class="row mb-1">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center">
            <div class="card-body py-1 bg-info">
                <h6 class="mb-1">Total Employees</h6>
                <h3 class="mb-0">{{ $stats['total'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center">
            <div class="card-body py-1 bg-success">
                <h6 class="mb-1 text-whit">Active</h6>
                <h3 class="mb-0 text-whit">{{ $stats['active'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center">
            <div class="card-body py-1 bg-danger">
                <h6 class="mb-1 text-gold">Inactive</h6>
                <h3 class="mb-0 text-whit">{{ $stats['inactive'] }}</h3>
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
                      
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody id="employeeTableBody">
                    @include('employees.partials.rows', ['employees' => $employees])
                </tbody>
            </table>
        </div>

        <div class="mt-1" id="paginationWrapper">
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


<!-- Live Filter -->
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