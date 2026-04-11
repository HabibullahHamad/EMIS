@extends('new')

@section('content')


<style>
    .monitor-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
        background: #fff;
    }

    .monitor-stat {
        text-align: center;
        padding: 16px 10px;
    }

    .monitor-stat h6 {
        font-size: 13px;
        margin-bottom: 8px;
        color: #555;
    }
    .monitor-stat h3 {
        margin: 0;
        font-weight: 700;
    }
    .section-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 12px;
    }
</style>
<div class="container-fluid">
    <div class="card monitor-card mb-3">
        <div class="card-body">
            <h4 class="mb-1">{{ $employee->full_name }}</h4>
            <div><strong>Code:</strong> {{ $employee->employee_code }}</div>
            <div><strong>Status:</strong> {{ ucfirst($employee->status) }}</div>
            <div><strong>Email:</strong> {{ $employee->email ?? '-' }}</div>
            <div><strong>Phone:</strong> {{ $employee->phone ?? '-' }}</div>
        </div>
    </div>
    
    </div>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection