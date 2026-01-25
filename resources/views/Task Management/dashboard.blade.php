@extends('new')
@section('content')
<!-- start -->


@section('title', 'EMIS | د اجرائیوي مدیریت KPI ډشبورډ')

<div class="container-fluid py-4" dir="rtl" style="font-family: Tahoma, Arial;">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">د اجرائیوي مدیریت د فعالیتونو KPI ډشبورډ</h4>
            <p class="text-muted mb-0">
                د ملي بودیجې لوی ریاست – EMIS
            </p>
        </div>
        <span class="badge bg-primary px-3 py-2">
            مالي کال {{ $fiscalYear ?? '۱۴۰۳' }}
        </span>
    </div>

    {{-- SECTION 1: CORE KPI SUMMARY --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">ټول ثبت شوي اسناد</small>
                    <h4 class="fw-bold">{{ $totalDocuments ?? 1248 }}</h4>
                    <small class="text-muted">وارد + صادر</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">فعال کاري بهیرونه</small>
                    <h4 class="fw-bold text-info">{{ $activeWorkflows ?? 187 }}</h4>
                    <small class="text-muted">تر اجرا لاندې</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">سپارل شوې دندې</small>
                    <h4 class="fw-bold text-success">{{ $totalTasks ?? 392 }}</h4>
                    <small class="text-success">اداري فعالیتونه</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">ځنډېدلي موارد</small>
                    <h4 class="fw-bold text-danger">{{ $overdueItems ?? 27 }}</h4>
                    <small class="text-danger">تعقیب ته اړتیا لري</small>
                </div>
            </div>
        </div>

    </div>

    {{-- SECTION 2: DOCUMENT MANAGEMENT KPI --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white fw-bold">
                    د اسنادو مدیریت (Document Management)
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered align-middle">
                        <tr>
                            <td>وارد شوي مکتوبونه</td>
                            <td>{{ $incomingDocs ?? 612 }}</td>
                            <td><span class="badge bg-info">ثبت</span></td>
                        </tr>
                        <tr>
                            <td>صادر شوي مکتوبونه</td>
                            <td>{{ $outgoingDocs ?? 498 }}</td>
                            <td><span class="badge bg-success">لېږل</span></td>
                        </tr>
                        <tr>
                            <td>آرشیف شوي اسناد</td>
                            <td>{{ $archivedDocs ?? 138 }}</td>
                            <td><span class="badge bg-secondary">آرشیف</span></td>
                        </tr>
                        <tr>
                            <td>ضمیمې (PDF / Word)</td>
                            <td>{{ $attachments ?? 1893 }}</td>
                            <td><span class="badge bg-primary">خوندي</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- SECTION 3: WORKFLOW ENGINE KPI --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white fw-bold">
                    د کاري بهیر او Routing وضعیت
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>تایید ته استول شوي</span>
                            <span class="badge bg-warning">{{ $pendingApprovals ?? 74 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>تایید شوي</span>
                            <span class="badge bg-success">{{ $approved ?? 529 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>رد / بېرته ستانه شوي</span>
                            <span class="badge bg-danger">{{ $rejected ?? 36 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Escalated موارد</span>
                            <span class="badge bg-dark">{{ $escalated ?? 11 }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    {{-- SECTION 4: TASK & ADMIN ACTIVITIES --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white fw-bold">
            اداري دندې، ناستې او فعالیتونه
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ریاست</th>
                        <th>سپارل شوې دندې</th>
                        <th>بشپړې شوې</th>
                        <th>ځنډېدلې</th>
                        <th>فعالیت</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>د اجرااتو ریاست</td>
                        <td>112</td>
                        <td>94</td>
                        <td>6</td>
                        <td><span class="badge bg-success">ښه</span></td>
                    </tr>
                    <tr>
                        <td>د اسنادو ریاست</td>
                        <td>86</td>
                        <td>61</td>
                        <td>11</td>
                        <td><span class="badge bg-warning">منځنی</span></td>
                    </tr>
                    <tr>
                        <td>د څارنې ریاست</td>
                        <td>54</td>
                        <td>51</td>
                        <td>1</td>
                        <td><span class="badge bg-primary">عالي</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white fw-bold">
            ټولې دندې (Tasks)
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>شمېره</th>
                        <th>عنوان</th>
                        <th>مسئول</th>
                        <th>د پای نېټه</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-info" style="cursor:pointer;" onclick="window.location='/tasks/101'">
                        <td>101</td>
                        <td>د بودیجې مسوده تایید</td>
                        <td>احمد خان</td>
                        <td>2026-02-10</td>
                        <td>په جریان کې</td>
                        <td>
                            <a href="/tasks/101" class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation();">تفصیلات</a>
                        </td>
                    </tr>

                    <tr class="table-warning" style="cursor:pointer;" onclick="window.location='/tasks/102'">
                        <td>102</td>
                        <td>د راپور چمتو کول</td>
                        <td>فاطمه</td>
                        <td>2026-01-27</td>
                        <td>نږدې دمه</td>
                        <td>
                            <a href="/tasks/102" class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation();">تفصیلات</a>
                        </td>
                    </tr>

                    <tr class="table-danger" style="cursor:pointer;" onclick="window.location='/tasks/103'">
                        <td>103</td>
                        <td>د اسنادو ترتیب</td>
                        <td>ملا صیب</td>
                        <td>2025-12-30</td>
                        <td>ځنډېدلی</td>
                        <td>
                            <a href="/tasks/103" class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation();">تفصیلات</a>
                        </td>
                    </tr>
                    @php
                        $hasTasks = !empty($tasks) && count($tasks) > 0;
                    @endphp

                    @if($hasTasks)
                        @foreach($tasks as $task)
                            @php
                                $now = \Carbon\Carbon::now();
                                $due = isset($task->due_date) && $task->due_date ? \Carbon\Carbon::parse($task->due_date) : null;

                                // Determine row color and status label:
                                if(!empty($task->completed_at)) {
                                    $rowClass = 'table-success'; // green
                                    $statusText = 'بشپړ شوی';
                                } elseif($due && $due->lt($now)) {
                                    $rowClass = 'table-danger'; // red (overdue)
                                    $statusText = 'ځنډېدلی';
                                } elseif($due && $due->diffInDays($now) <= 2) {
                                    $rowClass = 'table-warning'; // yellow (due soon)
                                    $statusText = 'نږدې دمه';
                                } else {
                                    $rowClass = 'table-info'; // blue (in progress / normal)
                                    $statusText = 'په جریان کې';
                                }

                                // target url for detail view (adjust route if needed)
                                $detailUrl = url('/tasks/'.$task->id);
                            @endphp

                            <tr class="{{ $rowClass }}" style="cursor:pointer;" onclick="window.location='{{ $detailUrl }}'">
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->assigned_to_name ?? $task->assigned_to ?? '-' }}</td>
                                <td>{{ $due ? $due->format('Y-m-d') : '-' }}</td>
                                <td>{{ $statusText }}</td>
                                <td>
                                    <a href="{{ $detailUrl }}" class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation();">تفصیلات</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center text-muted">هیڅ دنده ونه موندل شوه</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- SECTION 5: AUDIT & COMPLIANCE --}}
    <div class="row g-4">

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold">Audit Log</h6>
                    <p class="mb-1">ټول ثبت شوي فعالیتونه: <strong>{{ $auditLogs ?? 18421 }}</strong></p>
                    <p class="mb-0">ننني فعالیتونه: <strong>{{ $todayLogs ?? 327 }}</strong></p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold">د مقرراتو تطبیق</h6>
                    <h4 class="fw-bold text-success">95%</h4>
                    <small class="text-muted">RBAC + SOP Compliance</small>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold">امنیت او شفافیت</h6>
                    <p class="mb-1">غیر مجاز هڅې: <strong class="text-success">0</strong></p>
                    <p class="mb-0">Backup حالت: <span class="badge bg-success">فعال</span></p>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- end -->

@endsection
