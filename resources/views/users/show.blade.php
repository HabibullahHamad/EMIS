@extends('new')

@section('content')

<style>
    .detail-card {
        background: #fff;
        border-radius: 10px;
        padding: 16px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
    }

    .detail-label {
        font-size: 13px;
        font-weight: 700;
        color: #555;
        margin-bottom: 3px;
    }

    .detail-value {
        font-size: 14px;
        margin-bottom: 12px;
    }

    .badge-role {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        background: #e9f2ff;
        color: #0d6efd;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">User Details</h5>

        <div class="d-flex gap-2">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>

    <div class="detail-card">
        <div class="row">
            <div class="col-md-4">
                <div class="detail-label">ID</div>
                <div class="detail-value">{{ $user->id }}</div>
            </div>

            <div class="col-md-4">
                <div class="detail-label">Name</div>
                <div class="detail-value">{{ $user->name }}</div>
            </div>

            <div class="col-md-4">
                <div class="detail-label">Email</div>
                <div class="detail-value">{{ $user->email }}</div>
            </div>

            <div class="col-md-4">
                <div class="detail-label">Role</div>
                <div class="detail-value">
                    @if(optional($user->role)->display_name)
                        <span class="badge-role">{{ $user->role->display_name }}</span>
                    @else
                        -
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="detail-label">Created At</div>
                <div class="detail-value">{{ optional($user->created_at)->format('Y-m-d H:i') }}</div>
            </div>

            <div class="col-md-4">
                <div class="detail-label">Updated At</div>
                <div class="detail-value">{{ optional($user->updated_at)->format('Y-m-d H:i') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection