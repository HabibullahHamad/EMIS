@extends('new')

@section('page_title', __('emis.audit_details') ?? 'Audit Details')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header fw-bold d-flex justify-content-between">
            <span>{{ __('emis.audit_details') ?? 'Audit Details' }}</span>

            <a href="{{ route('audit.index') }}" class="btn btn-sm btn-secondary">
                {{ __('emis.back') ?? 'Back' }}
            </a>
        </div>

        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <strong>{{ __('emis.user') ?? 'User' }}:</strong>
                    {{ optional($auditLog->user)->name ?? 'System' }}
                </div>

                <div class="col-md-6">
                    <strong>{{ __('emis.action') ?? 'Action' }}:</strong>
                    {{ ucfirst($auditLog->action) }}
                </div>

                <div class="col-md-6">
                    <strong>{{ __('emis.module') ?? 'Module' }}:</strong>
                    {{ $auditLog->model_type ? class_basename($auditLog->model_type) : '-' }}
                </div>

                <div class="col-md-6">
                    <strong>{{ __('emis.record_id') ?? 'Record ID' }}:</strong>
                    {{ $auditLog->model_id ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>{{ __('emis.ip_address') ?? 'IP Address' }}:</strong>
                    {{ $auditLog->ip_address ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>{{ __('emis.date') ?? 'Date' }}:</strong>
                    {{ $auditLog->created_at?->format('Y-m-d H:i') }}
                </div>

                <div class="col-12">
                    <strong>{{ __('emis.user_agent') ?? 'User Agent' }}:</strong>
                    <div class="text-muted small">{{ $auditLog->user_agent ?? '-' }}</div>
                </div>
            </div>

            <h6>{{ __('emis.old_values') ?? 'Old Values' }}</h6>
            <pre class="bg-light p-3 rounded border">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>

            <h6>{{ __('emis.new_values') ?? 'New Values' }}</h6>
            <pre class="bg-light p-3 rounded border">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    </div>
</div>
@endsection