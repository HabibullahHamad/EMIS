@extends('new')

@section('page_title', 'Workflow Details')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm border-0 rounded-4 mb-3">
        <div class="card-header fw-bold">
            Workflow Details
        </div>

        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6"><strong>Title:</strong> {{ $workflow->title }}</div>
                <div class="col-md-6"><strong>Status:</strong> {{ ucfirst($workflow->status) }}</div>

                <div class="col-md-6"><strong>From:</strong> {{ optional($workflow->fromUser)->name ?? '-' }}</div>
                <div class="col-md-6"><strong>To:</strong> {{ optional($workflow->toUser)->name ?? '-' }}</div>

                <div class="col-md-6"><strong>From Department:</strong> {{ optional($workflow->fromDepartment)->name ?? '-' }}</div>
                <div class="col-md-6"><strong>To Department:</strong> {{ optional($workflow->toDepartment)->name ?? '-' }}</div>

                <div class="col-md-6"><strong>Priority:</strong> {{ ucfirst($workflow->priority) }}</div>
                <div class="col-md-6"><strong>Date:</strong> {{ $workflow->created_at?->format('Y-m-d H:i') }}</div>

                <div class="col-12"><strong>Description:</strong><br>{{ $workflow->description ?? '-' }}</div>
                <div class="col-12"><strong>Remarks:</strong><br>{{ $workflow->remarks ?? '-' }}</div>
            </div>
        </div>
    </div>

    @if($workflow->status === 'pending' && $workflow->to_user_id == auth()->id())
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header fw-bold">
                Workflow Actions
            </div>

            <div class="card-body d-flex flex-wrap gap-2">
                <form action="{{ route('workflows.approve', $workflow) }}" method="POST">
                    @csrf
                    <button class="btn btn-success">Approve</button>
                </form>

                <form action="{{ route('workflows.complete', $workflow) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary">Complete</button>
                </form>

                <form action="{{ route('workflows.return', $workflow) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="remarks" class="form-control" placeholder="Return remarks" required>
                    <button class="btn btn-info">Return</button>
                </form>

                <form action="{{ route('workflows.reject', $workflow) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="remarks" class="form-control" placeholder="Reject reason" required>
                    <button class="btn btn-danger">Reject</button>
                </form>
            </div>
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('workflows.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection