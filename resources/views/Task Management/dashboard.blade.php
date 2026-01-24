@extends('new')

@section('content')
<div class="container-fluid">

    {{-- PAGE TITLE --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>د اجرائیه دندو د سپارلو او څارنې ډشبورډ</h4>
    </div>

    {{-- KPI CARDS --}}
    <div class="row mb-4">
        <x-kpi-card title="ټولې دندې" :value="$stats['total']" color="primary" />
        <x-kpi-card title="بشپړې شوې" :value="$stats['completed']" color="success" />
        <x-kpi-card title="روانې" :value="$stats['in_progress']" color="warning" />
        <x-kpi-card title="ځنډېدلې" :value="$stats['delayed']" color="danger" />
    </div>

    {{-- TASK LIST --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">
            د دندو لېست او حالت
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>دنده</th>
                        <th>څانګه</th>
                        <th>مسؤل</th>
                        <th>حالت</th>
                        <th>Deadline</th>
                        <th>اقدام</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->department }}</td>
                        <td>{{ $task->assigned_to }}</td>
                        <td>
                            <x-status-badge :status="$task->status" />
                        </td>
                        <td>{{ $task->deadline }}</td>
                        <td>
                            <x-action-button
                                label="تفصیل"
                                type="info"
                                url="{{ route('Task Management.show', $task->id) }}" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            هیڅ ریکارډ ونه موندل شو
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- AUDIT LOG --}}
    <div class="card">
        <div class="card-header fw-bold">
            وروستي Audit فعالیتونه
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>وخت</th>
                        <th>کاروونکی</th>
                        <th>دنده</th>
                        <th>اقدام</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($auditLogs as $log)
                    <tr>
                        <td>{{ $log->created_at }}</td>
                        <td>{{ $log->user_name }}</td>
                        <td>{{ $log->task_title }}</td>
                        <td>{{ $log->action }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
