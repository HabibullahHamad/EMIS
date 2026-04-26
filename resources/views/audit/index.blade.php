@extends('new')

@section('page_title', __('emis.audit_trail') ?? 'Audit Trail')

@section('content')
<div class="container-fluid">

    {{-- Header + Export Buttons --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="fw-bold mb-0">
            <i class="fa-solid fa-shield-halved"></i>
            {{ __('emis.audit_trail') ?? 'Audit Trail' }}
        </h5>

        <div class="d-flex gap-2">
            <a href="{{ route('audit.export.pdf', request()->query()) }}" class="btn btn-sm btn-danger">
                <i class="fa fa-file-pdf"></i> PDF
            </a>

            <a href="{{ route('audit.export.excel', request()->query()) }}" class="btn btn-sm btn-success">
                <i class="fa fa-file-excel"></i> Excel
            </a>

            <a href="{{ route('audit.export.csv', request()->query()) }}" class="btn btn-sm btn-primary">
                <i class="fa fa-file-csv"></i> CSV
            </a>
        </div>
    </div>

    {{-- Activity Cards --}}
    <div class="row g-3 mb-4">

        <div class="col-md-2">
            <div class="card audit-card bg-primary text-white">
                <div class="card-body">
                    <small>Total Logs</small>
                    <h3>{{ $stats['total'] ?? 0 }}</h3>
                    <i class="fa fa-list audit-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card audit-card bg-success text-white">
                <div class="card-body">
                    <small>Created</small>
                    <h3>{{ $stats['created'] ?? 0 }}</h3>
                    <i class="fa fa-plus-circle audit-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card audit-card bg-warning text-dark">
                <div class="card-body">
                    <small>Updated</small>
                    <h3>{{ $stats['updated'] ?? 0 }}</h3>
                    <i class="fa fa-pen-to-square audit-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card audit-card bg-danger text-white">
                <div class="card-body">
                    <small>Deleted</small>
                    <h3>{{ $stats['deleted'] ?? 0 }}</h3>
                    <i class="fa fa-trash audit-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card audit-card bg-dark text-white">
                <div class="card-body">
                    <small>Today</small>
                    <h3>{{ $stats['today'] ?? 0 }}</h3>
                    <i class="fa fa-calendar-day audit-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card audit-card bg-info text-white">
                <div class="card-body">
                    <small>Login</small>
                    <h3>{{ $stats['login'] ?? 0 }}</h3>
                    <i class="fa fa-right-to-bracket audit-icon"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <strong>Audit Log Records</strong>

            <form method="GET" action="{{ route('audit.index') }}" class="d-flex gap-2 flex-wrap">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control form-control-sm"
                       placeholder="Search user, action, module, IP">

                <select name="action" class="form-select form-select-sm">
                    <option value="">All Actions</option>
                    @foreach(['created','updated','deleted','viewed','login','logout','approved','rejected','returned','completed'] as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ ucfirst($action) }}
                        </option>
                    @endforeach
                </select>

                <button class="btn btn-sm btn-primary">
                    <i class="fa fa-search"></i>
                </button>

                <a href="{{ route('audit.index') }}" class="btn btn-sm btn-secondary">
                    Reset
                </a>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Module</th>
                            <th>Record ID</th>
                            <th>IP Address</th>
                            <th>Date</th>
                            <th width="90">View</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($auditLogs as $log)
                            <tr>
                                <td>{{ $loop->iteration + (($auditLogs->currentPage() - 1) * $auditLogs->perPage()) }}</td>
                                <td>{{ optional($log->user)->name ?? 'System' }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td>{{ $log->model_type ? class_basename($log->model_type) : '-' }}</td>
                                <td>{{ $log->model_id ?? '-' }}</td>
                                <td>{{ $log->ip_address ?? '-' }}</td>
                                <td>{{ $log->created_at?->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('audit.show', $log) }}" class="btn btn-sm btn-info">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted">No audit logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $auditLogs->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .audit-card {
        border: 0;
        border-radius: 16px;
        min-height: 110px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 5px 16px rgba(0,0,0,0.15);
        transition: .3s ease;
    }

    .audit-card:hover {
        transform: translateY(-4px);
    }

    .audit-card small {
        font-size: 13px;
        font-weight: 700;
    }

    .audit-card h3 {
        font-weight: 800;
        margin-top: 8px;
    }

    .audit-icon {
        position: absolute;
        right: 16px;
        bottom: 14px;
        font-size: 34px;
        opacity: .25;
    }
</style>
@endsection