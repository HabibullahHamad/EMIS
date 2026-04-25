@extends('new')

@section('page_title', __('emis.workflow') ?? 'Workflow')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <strong>{{ __('emis.workflow') }}</strong>

<a href="{{ route('workflows.create') }}" class="btn btn-sm btn-primary">
    <i class="fa fa-plus"></i> {{ __('emis.create_workflow') }}
</a>

            
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                        <th>#</th>
          <th>{{ __('emis.title') }}</th>
          <th>{{ __('emis.from') }}</th>
          <th>{{ __('emis.to') }}</th>
          <th>{{ __('emis.department') }}</th>
         <th>{{ __('emis.priority') }}</th>
         <th>{{ __('emis.status') }}</th>
         <th>{{ __('emis.date') }}</th>
          <th>{{ __('emis.action') }}</th>
          
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse($workflows as $workflow)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $workflow->title }}</td>
                                <td>{{ optional($workflow->fromUser)->name ?? '-' }}</td>
                                <td>{{ optional($workflow->toUser)->name ?? '-' }}</td>
                                <td>{{ optional($workflow->toDepartment)->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        {{ ucfirst($workflow->priority) }}
                                    </span>
                                </td>
                                <td>
                                    @if($workflow->status == 'pending')
                                        <span class="badge bg-secondary">Pending</span>
                                    @elseif($workflow->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($workflow->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @elseif($workflow->status == 'returned')
                                        <span class="badge bg-info">Returned</span>
                                    @elseif($workflow->status == 'completed')
                                        <span class="badge bg-primary">Completed</span>
                                    @else
                                        <span class="badge bg-dark">{{ ucfirst($workflow->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $workflow->created_at?->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('workflows.show', $workflow) }}" class="btn btn-sm btn-info">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-muted">No workflows found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $workflows->links() }}
            </div>
        </div>
    </div>
</div>
@endsection