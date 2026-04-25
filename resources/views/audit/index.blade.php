@extends('new')

@section('page_title', __('emis.audit_trail') ?? 'Audit Trail')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <strong>{{ __('emis.audit_trail') ?? 'Audit Trail' }}</strong>

            <form method="GET" action="{{ route('audit.index') }}" class="d-flex gap-2 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="{{ __('emis.search') ?? 'Search' }}">

                <select name="action" class="form-select form-select-sm">
                    <option value="">{{ __('emis.all_actions') ?? 'All Actions' }}</option>
                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                    <option value="approved" {{ request('action') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                </select>

                <button class="btn btn-sm btn-primary">
                    <i class="fa fa-search"></i>
                </button>

                <a href="{{ route('audit.index') }}" class="btn btn-sm btn-secondary">
                    {{ __('emis.reset') ?? 'Reset' }}
                </a>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{{ __('emis.user') ?? 'User' }}</th>
                            <th>{{ __('emis.action') ?? 'Action' }}</th>
                            <th>{{ __('emis.module') ?? 'Module' }}</th>
                            <th>{{ __('emis.ip_address') ?? 'IP Address' }}</th>
                            <th>{{ __('emis.date') ?? 'Date' }}</th>
                            <th>{{ __('emis.actions') ?? 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auditLogs as $log)
                            <tr>
                                <td>{{ $loop->iteration + (($auditLogs->currentPage() - 1) * $auditLogs->perPage()) }}</td>
                                <td>{{ optional($log->user)->name ?? 'System' }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ ucfirst($log->action) }}</span>
                                </td>
                                <td>{{ class_basename($log->model_type) ?? '-' }}</td>
                                <td>{{ $log->ip_address ?? '-' }}</td>
                                <td>{{ $log->created_at?->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('audit.show', $log) }}" class="btn btn-sm btn-info">
                                        {{ __('emis.view') ?? 'View' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">
                                    {{ __('emis.no_data_found') ?? 'No data found' }}
                                </td>
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
@endsection