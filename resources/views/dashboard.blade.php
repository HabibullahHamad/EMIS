@extends('new')

@section('page_title', __('emis.dashboard'))

@section('content')
@php
    /*
    |--------------------------------------------------------------------------
    | Safe localized dashboard labels
    |--------------------------------------------------------------------------
    |
    | The normal Laravel translation is used first. When a key is missing,
    | the page uses a built-in English/Pashto/Dari fallback instead of
    | displaying a raw value such as "emis.total_users".
    |
    */

    $locale = app()->getLocale();

    $fallbacks = [
        'dashboard' => [
            'en' => 'Dashboard',
            'ps' => 'ډشبورډ',
            'fa' => 'داشبورد',
        ],
        'welcome_back' => [
            'en' => 'Welcome back',
            'ps' => 'بېرته ښه راغلاست',
            'fa' => 'خوش آمدید',
        ],
        'dashboard_summary' => [
            'en' => 'A concise overview of users, correspondence, employees, and tasks.',
            'ps' => 'د کاروونکو، اسنادو، کارکوونکو او دندو لنډ او مهم عمومي وضعیت.',
            'fa' => 'نمای کلی کاربران، مکاتیب، کارمندان و وظایف.',
        ],
        'total_users' => [
            'en' => 'Total Users',
            'ps' => 'ټول کاروونکي',
            'fa' => 'مجموع کاربران',
        ],
        'total_employees' => [
            'en' => 'Total Employees',
            'ps' => 'ټول کارکوونکي',
            'fa' => 'مجموع کارمندان',
        ],
        'incoming_documents' => [
            'en' => 'Incoming Documents',
            'ps' => 'وارده اسناد',
            'fa' => 'اسناد وارده',
        ],
        'outgoing_documents' => [
            'en' => 'Outgoing Documents',
            'ps' => 'صادره اسناد',
            'fa' => 'اسناد صادره',
        ],
        'pending_tasks' => [
            'en' => 'Pending Tasks',
            'ps' => 'د انتظار دندې',
            'fa' => 'وظایف در انتظار',
        ],
        'completed_tasks' => [
            'en' => 'Completed Tasks',
            'ps' => 'بشپړې شوې دندې',
            'fa' => 'وظایف تکمیل‌شده',
        ],
        'overdue_tasks' => [
            'en' => 'Overdue Tasks',
            'ps' => 'ځنډېدلې دندې',
            'fa' => 'وظایف تأخیرشده',
        ],
        'task_performance' => [
            'en' => 'Task Performance',
            'ps' => 'د دندو فعالیت',
            'fa' => 'عملکرد وظایف',
        ],
        'completed_rate' => [
            'en' => 'Completion rate',
            'ps' => 'د بشپړېدو کچه',
            'fa' => 'نرخ تکمیل',
        ],
        'inbox_status_overview' => [
            'en' => 'Incoming Document Status',
            'ps' => 'د وارده اسنادو وضعیت',
            'fa' => 'وضعیت اسناد وارده',
        ],
        'outbox_status_overview' => [
            'en' => 'Outgoing Document Status',
            'ps' => 'د صادره اسنادو وضعیت',
            'fa' => 'وضعیت اسناد صادره',
        ],
        'recent_tasks' => [
            'en' => 'Recent Tasks',
            'ps' => 'وروستۍ دندې',
            'fa' => 'وظایف اخیر',
        ],
        'view_all' => [
            'en' => 'View all',
            'ps' => 'ټول وګورئ',
            'fa' => 'مشاهده همه',
        ],
        'task_code' => [
            'en' => 'Task Code',
            'ps' => 'د دندې کوډ',
            'fa' => 'کُد وظیفه',
        ],
        'title' => [
            'en' => 'Title',
            'ps' => 'سرلیک',
            'fa' => 'عنوان',
        ],
        'status' => [
            'en' => 'Status',
            'ps' => 'حالت',
            'fa' => 'وضعیت',
        ],
        'deadline' => [
            'en' => 'Deadline',
            'ps' => 'وروستۍ نېټه',
            'fa' => 'مهلت',
        ],
        'action' => [
            'en' => 'Action',
            'ps' => 'عمل',
            'fa' => 'عمل',
        ],
        'open' => [
            'en' => 'Open',
            'ps' => 'خلاص کړئ',
            'fa' => 'باز کردن',
        ],
        'no_data' => [
            'en' => 'No records were found.',
            'ps' => 'هیڅ معلومات ونه موندل شول.',
            'fa' => 'هیچ معلوماتی یافت نشد.',
        ],
        'quick_actions' => [
            'en' => 'Quick Actions',
            'ps' => 'چټک عملیات',
            'fa' => 'عملیات سریع',
        ],
        'new_incoming_document' => [
            'en' => 'New Incoming Document',
            'ps' => 'نوی وارده سند',
            'fa' => 'سند وارده جدید',
        ],
        'new_outgoing_document' => [
            'en' => 'New Outgoing Document',
            'ps' => 'نوی صادره سند',
            'fa' => 'سند صادره جدید',
        ],
        'new_task' => [
            'en' => 'New Task',
            'ps' => 'نوې دنده',
            'fa' => 'وظیفه جدید',
        ],
        'pending' => [
            'en' => 'Pending',
            'ps' => 'د انتظار',
            'fa' => 'در انتظار',
        ],
        'in_progress' => [
            'en' => 'In Progress',
            'ps' => 'د اجرا په حال کې',
            'fa' => 'در حال اجرا',
        ],
        'completed' => [
            'en' => 'Completed',
            'ps' => 'بشپړ شوی',
            'fa' => 'تکمیل‌شده',
        ],
        'overdue' => [
            'en' => 'Overdue',
            'ps' => 'ځنډېدلی',
            'fa' => 'تأخیرشده',
        ],
        'unknown' => [
            'en' => 'Unknown',
            'ps' => 'نامعلوم',
            'fa' => 'نامعلوم',
        ],
        'documents' => [
            'en' => 'Documents',
            'ps' => 'اسناد',
            'fa' => 'اسناد',
        ],
        'tasks' => [
            'en' => 'Tasks',
            'ps' => 'دندې',
            'fa' => 'وظایف',
        ],
        'today' => [
            'en' => 'Today',
            'ps' => 'نن',
            'fa' => 'امروز',
        ],
    ];

    $t = static function (string $key) use ($fallbacks, $locale): string {
        $translationKey = "emis.{$key}";
        $translated = __($translationKey);

        if ($translated !== $translationKey) {
            return $translated;
        }

        return $fallbacks[$key][$locale]
            ?? $fallbacks[$key]['en']
            ?? ucfirst(str_replace('_', ' ', $key));
    };

    /*
    |--------------------------------------------------------------------------
    | Safe collections and dashboard calculations
    |--------------------------------------------------------------------------
    */

    $recentTasksCollection = collect($recentTasks ?? []);

    $inboxStatusCollection = collect($inboxStatus ?? []);
    $outboxStatusCollection = collect($outboxStatus ?? []);

    $taskTotal = (int) ($pendingTasks ?? 0)
        + (int) ($completedTasks ?? 0)
        + (int) ($overdueTasks ?? 0);

    $completionRate = $taskTotal > 0
        ? round(((int) ($completedTasks ?? 0) / $taskTotal) * 100)
        : 0;

    $statusLabel = static function (?string $status) use ($t): string {
        $normalized = strtolower(trim((string) $status));
        $normalized = str_replace([' ', '-'], '_', $normalized);

        return match ($normalized) {
            'pending' => $t('pending'),
            'in_progress', 'processing', 'under_review' => $t('in_progress'),
            'completed', 'done', 'approved' => $t('completed'),
            'overdue', 'late', 'expired' => $t('overdue'),
            default => $status
                ? ucfirst(str_replace('_', ' ', $status))
                : $t('unknown'),
        };
    };

    $statusClass = static function (?string $status): string {
        $normalized = strtolower(trim((string) $status));
        $normalized = str_replace([' ', '-'], '_', $normalized);

        return match ($normalized) {
            'pending' => 'status-pending',
            'in_progress', 'processing', 'under_review' => 'status-progress',
            'completed', 'done', 'approved' => 'status-completed',
            'overdue', 'late', 'expired', 'rejected' => 'status-overdue',
            default => 'status-neutral',
        };
    };

    $translateChartLabels = static function ($collection) use ($statusLabel): array {
        return collect($collection)
            ->keys()
            ->map(fn ($label) => $statusLabel((string) $label))
            ->values()
            ->all();
    };

    /*
    |--------------------------------------------------------------------------
    | Route-safe quick actions
    |--------------------------------------------------------------------------
    */

    $quickActions = collect([
        [
            'route' => 'CorrespondenceManagement.inbox.create',
            'label' => $t('new_incoming_document'),
            'icon' => 'fa-solid fa-file-circle-plus',
            'class' => 'quick-action-primary',
        ],
        [
            'route' => 'CorrespondenceManagement.outbox.create',
            'label' => $t('new_outgoing_document'),
            'icon' => 'fa-solid fa-paper-plane',
            'class' => 'quick-action-info',
        ],
        [
            'route' => 'tasks.create',
            'label' => $t('new_task'),
            'icon' => 'fa-solid fa-list-check',
            'class' => 'quick-action-success',
        ],
    ])->filter(
        fn (array $action): bool => Route::has($action['route'])
    );
@endphp

<div class="dashboard-shell">

    {{-- ================================================================
         HERO HEADER
         ================================================================ --}}
    

    {{-- ================================================================
         PRIMARY KPI CARDS
         ================================================================ --}}
    <section class="dashboard-kpi-grid dashboard-kpi-grid-primary">

        <article class="dashboard-kpi-card kpi-blue">
            <div class="kpi-text">
                <div class="kpi-label">{{ $t('total_users') }}</div>
                <div class="kpi-value">{{ number_format((int) ($totalUsers ?? 0)) }}</div>
            </div>

            <div class="kpi-icon" aria-hidden="true">
                <i class="fa-solid fa-users"></i>
            </div>

            @if(Route::has('users.index'))
                <a href="{{ route('users.index') }}"
                   class="kpi-card-overlay"
                   aria-label="{{ $t('total_users') }}">
                    <span class="visually-hidden">{{ $t('total_users') }}</span>
                </a>
            @endif
        </article>

        <article class="dashboard-kpi-card kpi-green">
            <div class="kpi-text">
                <div class="kpi-label">{{ $t('total_employees') }}</div>
                <div class="kpi-value">{{ number_format((int) ($totalEmployees ?? 0)) }}</div>
            </div>

            <div class="kpi-icon" aria-hidden="true">
                <i class="fa-solid fa-id-badge"></i>
            </div>

            @if(Route::has('employees.index'))
                <a href="{{ route('employees.index') }}"
                   class="kpi-card-overlay"
                   aria-label="{{ $t('total_employees') }}">
                    <span class="visually-hidden">{{ $t('total_employees') }}</span>
                </a>
            @endif
        </article>

        <article class="dashboard-kpi-card kpi-gray">
            <div class="kpi-text">
                <div class="kpi-label">{{ $t('incoming_documents') }}</div>
                <div class="kpi-value">{{ number_format((int) ($incomingDocuments ?? 0)) }}</div>
            </div>

            <div class="kpi-icon" aria-hidden="true">
                <i class="fa-solid fa-inbox"></i>
            </div>

            @if(Route::has('inbox.index'))
                <a href="{{ route('inbox.index') }}"
                   class="kpi-card-overlay"
                   aria-label="{{ $t('incoming_documents') }}">
                    <span class="visually-hidden">{{ $t('incoming_documents') }}</span>
                </a>
            @elseif(Route::has('main'))
                <a href="{{ route('main') }}"
                   class="kpi-card-overlay"
                   aria-label="{{ $t('incoming_documents') }}">
                    <span class="visually-hidden">{{ $t('incoming_documents') }}</span>
                </a>
            @endif
        </article>

        <article class="dashboard-kpi-card kpi-cyan">
            <div class="kpi-text">
                <div class="kpi-label">{{ $t('outgoing_documents') }}</div>
                <div class="kpi-value">{{ number_format((int) ($outgoingDocuments ?? 0)) }}</div>
            </div>

            <div class="kpi-icon" aria-hidden="true">
                <i class="fa-solid fa-file-export"></i>
            </div>

            @if(Route::has('CorrespondenceManagement.outbox.index'))
                <a href="{{ route('CorrespondenceManagement.outbox.index') }}"
                   class="kpi-card-overlay"
                   aria-label="{{ $t('outgoing_documents') }}">
                    <span class="visually-hidden">{{ $t('outgoing_documents') }}</span>
                </a>
            @endif
        </article>

    </section>

    {{-- ================================================================
         TASK KPI CARDS + COMPLETION RATE
         ================================================================ --}}
    <section class="dashboard-task-grid">

        <div class="task-status-cards">
            <article class="task-mini-card task-pending">
                <div class="task-mini-icon">
                    <i class="fa-regular fa-clock"></i>
                </div>

                <div class="task-mini-content">
                    <span>{{ $t('pending_tasks') }}</span>
                    <strong>{{ number_format((int) ($pendingTasks ?? 0)) }}</strong>
                </div>
            </article>

            <article class="task-mini-card task-completed">
                <div class="task-mini-icon">
                    <i class="fa-solid fa-check"></i>
                </div>

                <div class="task-mini-content">
                    <span>{{ $t('completed_tasks') }}</span>
                    <strong>{{ number_format((int) ($completedTasks ?? 0)) }}</strong>
                </div>
            </article>

            <article class="task-mini-card task-overdue">
                <div class="task-mini-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>

                <div class="task-mini-content">
                    <span>{{ $t('overdue_tasks') }}</span>
                    <strong>{{ number_format((int) ($overdueTasks ?? 0)) }}</strong>
                </div>
            </article>
        </div>

        <article class="completion-card">
            <div class="completion-copy">
                <span>{{ $t('task_performance') }}</span>
                <strong>{{ $completionRate }}%</strong>
                <small>{{ $t('completed_rate') }}</small>
            </div>

            <div class="completion-ring"
                 style="--completion: {{ $completionRate }};">
                <div class="completion-ring-center">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
            </div>
        </article>

    </section>

    {{-- ================================================================
         CHARTS
         ================================================================ --}}
    <section class="dashboard-chart-grid">

        <article class="dashboard-panel chart-panel chart-panel-large">
            <header class="panel-header">
                <div>
                    <span class="panel-kicker">{{ $t('documents') }}</span>
                    <h2>{{ $t('inbox_status_overview') }}</h2>
                </div>

                <div class="panel-icon panel-icon-blue">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
            </header>

            <div class="chart-stage doughnut-stage">
                <canvas id="inboxStatusChart"></canvas>

                <div class="doughnut-center">
                    <span>{{ $t('incoming_documents') }}</span>
                    <strong>{{ number_format((int) ($incomingDocuments ?? 0)) }}</strong>
                </div>
            </div>
        </article>

        <article class="dashboard-panel chart-panel">
            <header class="panel-header">
                <div>
                    <span class="panel-kicker">{{ $t('documents') }}</span>
                    <h2>{{ $t('outbox_status_overview') }}</h2>
                </div>

                <div class="panel-icon panel-icon-orange">
                    <i class="fa-solid fa-chart-column"></i>
                </div>
            </header>

            <div class="chart-stage">
                <canvas id="outboxStatusChart"></canvas>
            </div>
        </article>

    </section>

    {{-- ================================================================
         RECENT TASKS
         ================================================================ --}}
    <section class="dashboard-panel recent-tasks-panel">

        <header class="panel-header recent-tasks-header">
            <div>
                <span class="panel-kicker">{{ $t('tasks') }}</span>
                <h2>{{ $t('recent_tasks') }}</h2>
            </div>

            @if(Route::has('tasks.index'))
                <a href="{{ route('tasks.index') }}"
                   class="view-all-link">
                    <span>{{ $t('view_all') }}</span>
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            @endif
        </header>

        <div class="dashboard-table-wrap">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th class="number-column">#</th>
                        <th>{{ $t('task_code') }}</th>
                        <th>{{ $t('title') }}</th>
                        <th>{{ $t('status') }}</th>
                        <th>{{ $t('deadline') }}</th>
                        <th class="action-column">{{ $t('action') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentTasksCollection as $task)
                        @php
                            $taskShowRoute = null;

                            if (
                                isset($task->id)
                                && Route::has('tasks.show')
                            ) {
                                $taskShowRoute = route(
                                    'tasks.show',
                                    $task->id
                                );
                            }
                        @endphp

                        <tr @class(['clickable-row' => $taskShowRoute])
                            @if($taskShowRoute)
                                data-href="{{ $taskShowRoute }}"
                                tabindex="0"
                                role="link"
                            @endif>
                            <td class="number-column">
                                <span class="row-number">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            <td>
                                <span class="task-code">
                                    {{ $task->task_code ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <div class="task-title-cell">
                                    <span class="task-title-text">
                                        {{ $task->title ?? '-' }}
                                    </span>

                                    @if(!empty($task->description))
                                        <small>
                                            {{ \Illuminate\Support\Str::limit(
                                                strip_tags($task->description),
                                                72
                                            ) }}
                                        </small>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <span class="dashboard-status-badge
                                    {{ $statusClass($task->status ?? null) }}">
                                    <span class="status-indicator"></span>
                                    {{ $statusLabel($task->status ?? null) }}
                                </span>
                            </td>

                            <td>
                                <div class="deadline-cell">
                                    <i class="fa-regular fa-calendar"></i>

                                    <span>
                                        @if(!empty($task->deadline))
                                            {{ \Illuminate\Support\Carbon::parse(
                                                $task->deadline
                                            )->format('Y-m-d') }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </td>

                            <td class="action-column">
                                @if($taskShowRoute)
                                    <a href="{{ $taskShowRoute }}"
                                       class="table-action-btn"
                                       title="{{ $t('open') }}">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                @else
                                    <span class="table-action-btn disabled">
                                        <i class="fa-solid fa-minus"></i>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="dashboard-empty-state">
                                    <div class="empty-icon">
                                        <i class="fa-solid fa-clipboard-check"></i>
                                    </div>

                                    <strong>{{ $t('no_data') }}</strong>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </section>

</div>
@endsection

@push('styles')
<style>
    /* ================================================================
       PROFESSIONAL EMIS DASHBOARD
       ================================================================ */

    .dashboard-shell {
        width: 100%;
        max-width: 1500px;
        margin-inline: auto;
        padding: 2px 0 24px;
    }

    /* Hero */

    .dashboard-hero {
        position: relative;
        overflow: hidden;
        min-height: 148px;
        margin-bottom: 18px;
        padding: 25px 27px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;

        color: #ffffff;
        background:
            radial-gradient(
                circle at 12% 18%,
                rgba(255, 255, 255, 0.17),
                transparent 26%
            ),
            radial-gradient(
                circle at 92% 90%,
                rgba(64, 181, 246, 0.28),
                transparent 31%
            ),
            linear-gradient(
                135deg,
                #0b3563 0%,
                #114a80 52%,
                #0b3563 100%
            );

        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 19px;
        box-shadow:
            0 18px 38px rgba(11, 53, 99, 0.16),
            0 5px 14px rgba(11, 53, 99, 0.08);
    }

    .dashboard-hero::after {
        content: "";
        position: absolute;
        inset-inline-end: -42px;
        inset-block-start: -66px;

        width: 190px;
        height: 190px;

        border: 30px solid rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        min-width: 0;

        display: flex;
        align-items: center;
        gap: 18px;
    }

    .hero-icon {
        width: 62px;
        height: 62px;
        flex: 0 0 62px;

        display: grid;
        place-items: center;

        color: #ffffff;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 17px;

        font-size: 24px;
        backdrop-filter: blur(8px);
    }

    .hero-eyebrow {
        margin-bottom: 4px;
        color: rgba(255, 255, 255, 0.72);
        font-size: 0.74rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .dashboard-hero h1 {
        margin: 0;
        color: #ffffff;
        font-size: clamp(1.35rem, 2vw, 1.85rem);
        font-weight: 800;
        line-height: 1.3;
    }

    .dashboard-hero h1 span {
        color: #bde8ff;
    }

    .dashboard-hero p {
        max-width: 720px;
        margin: 7px 0 0;
        color: rgba(255, 255, 255, 0.76);
        font-size: 0.87rem;
        line-height: 1.65;
    }

    .hero-meta {
        position: relative;
        z-index: 1;
        flex: 0 0 auto;

        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
    }

    html[dir="rtl"] .hero-meta {
        align-items: flex-start;
    }

    .hero-date {
        min-width: 185px;
        padding: 10px 13px;

        display: flex;
        align-items: center;
        gap: 10px;

        background: rgba(255, 255, 255, 0.10);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        backdrop-filter: blur(8px);
    }

    .hero-date > i {
        font-size: 19px;
    }

    .hero-date div {
        display: flex;
        flex-direction: column;
    }

    .hero-date small {
        color: rgba(255, 255, 255, 0.65);
        font-size: 0.68rem;
    }

    .hero-date strong {
        color: #ffffff;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .quick-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 7px;
    }

    html[dir="rtl"] .quick-actions {
        justify-content: flex-start;
    }

    .quick-action {
        min-height: 35px;
        padding: 7px 10px;

        display: inline-flex;
        align-items: center;
        gap: 7px;

        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.17);
        border-radius: 9px;

        font-size: 0.72rem;
        font-weight: 700;
        transition:
            transform 0.18s ease,
            background-color 0.18s ease,
            border-color 0.18s ease;
    }

    .quick-action:hover {
        color: #ffffff;
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.16);
        border-color: rgba(255, 255, 255, 0.28);
    }

    .quick-action-primary {
        background: rgba(30, 123, 255, 0.22);
    }

    .quick-action-info {
        background: rgba(14, 165, 233, 0.22);
    }

    .quick-action-success {
        background: rgba(34, 197, 94, 0.22);
    }

    /* KPI cards — clean horizontal dashboard cards */

    .dashboard-kpi-grid {
        display: grid;
        gap: 16px;
    }

    .dashboard-kpi-grid-primary {
        grid-template-columns: repeat(4, minmax(0, 1fr));
        margin-bottom: 10px;
    }

    .dashboard-kpi-card {
        --kpi-accent: #1768ff;
        --kpi-icon-bg: #d8e7ff;
        --kpi-icon-color: #1768ef;

        position: relative;
        isolation: isolate;
        overflow: hidden;

        min-height: 120px;
        padding: 22px 27px 22px 30px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 22px;

        background: #ffffff;
        border: 1px solid #edf1f5;
        border-radius: 21px;

        box-shadow:
            0 13px 30px rgba(42, 64, 92, 0.08),
            0 3px 9px rgba(42, 64, 92, 0.035);

        transition:
            transform 0.20s ease,
            box-shadow 0.20s ease,
            border-color 0.20s ease;
    }
     
    .dashboard-kpi-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        z-index: 1;
        


        

        width: 6px;
        background: var(--kpi-accent);
        border-radius: 21px 0 0 21px;
    }

    .dashboard-kpi-card:hover {
        transform: translateY(-3px);
        border-color: color-mix(
            in srgb,
            var(--kpi-accent) 18%,
            #edf1f5
        );
        box-shadow:
            0 18px 38px rgba(42, 64, 92, 0.11),
            0 5px 13px rgba(42, 64, 92, 0.045);
    }

    .kpi-blue {
        --kpi-accent: #1768ff;
        --kpi-icon-bg: #d8e7ff;
        --kpi-icon-color: #1768ef;
    }

    .kpi-green {
        --kpi-accent: #15925a;
        --kpi-icon-bg: #dcefe7;
        --kpi-icon-color: #168a55;
    }

    .kpi-gray {
        --kpi-accent: #6f7780;
        --kpi-icon-bg: #e4e7eb;
        --kpi-icon-color: #6e7781;
    }

    .kpi-cyan {
        --kpi-accent: #08b9de;
        --kpi-icon-bg: #d8f4fb;
        --kpi-icon-color: #08a9cc;
    }

    .kpi-text {
        position: relative;
        z-index: 2;
        min-width: 0;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .kpi-label {
        margin: 0;
        overflow: hidden;
        color: #748197;
        font-size: 1rem;
        font-weight: 750;
        line-height: 1.45;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .kpi-value {
        margin-top: 1px;
        color: #12233c;
        font-size: clamp(2rem, 2.9vw, 2.55rem);
        font-weight: 500;
        line-height: 1.08;
        letter-spacing: -0.04em;
    }

    .kpi-icon {
        position: relative;
        z-index: 2;
        width: 69px;
        height: 69px;
        flex: 0 0 69px;
        display: grid;
        place-items: center;
        color: var(--kpi-icon-color);
        background: var(--kpi-icon-bg);
        border-radius: 18px;
        font-size: 24px;
        box-shadow:
            inset 0 0 0 1px rgba(255, 255, 255, 0.45);
    }

    .kpi-card-overlay {
        position: absolute;
        inset: 0;
        z-index: 4;
        border-radius: inherit;
    }

    html[dir="rtl"] .dashboard-kpi-card {
        flex-direction: row;
        text-align: right;
    }

    html[dir="ltr"] .dashboard-kpi-card {
        text-align: left;
    }

    @media (max-width: 1390px) {
        .dashboard-kpi-card {
            padding-inline: 22px;
        }

        .kpi-icon {
            width: 61px;
            height: 61px;
            flex-basis: 61px;
            border-radius: 16px;
            font-size: 21px;
        }

        .kpi-label {
            font-size: 0.9rem;
        }

        .kpi-value {
            font-size: 2.1rem;
        }
    }

    /* Task cards */

    .dashboard-task-grid {
        display: grid;
        grid-template-columns: minmax(0, 2.2fr) minmax(245px, 0.8fr);
        gap: 14px;
        margin-bottom: 14px;
    }

    .task-status-cards {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .task-mini-card {
        min-height: 96px;
        padding: 15px 16px;

        display: flex;
        align-items: center;
        gap: 13px;

        background: #ffffff;
        border: 1px solid #e3eaf2;
        border-radius: 15px;
        box-shadow: 0 7px 18px rgba(15, 23, 42, 0.045);
    }

    .task-mini-icon {
        width: 43px;
        height: 43px;
        flex: 0 0 43px;

        display: grid;
        place-items: center;

        border-radius: 11px;
        font-size: 17px;
    }

    .task-pending .task-mini-icon {
        color: #d65d0e;
        background: #fff1e6;
    }

    .task-completed .task-mini-icon {
        color: #12814a;
        background: #e7f7ef;
    }

    .task-overdue .task-mini-icon {
        color: #d72831;
        background: #fdebed;
    }

    .task-mini-content {
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .task-mini-content span {
        overflow: hidden;
        color: #718095;
        font-size: 0.75rem;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .task-mini-content strong {
        margin-top: 3px;
        color: #172234;
        font-size: 1.35rem;
        font-weight: 850;
        line-height: 1.2;
    }

    .completion-card {
        min-height: 96px;
        padding: 14px 17px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;

        color: #ffffff;
        background:
            radial-gradient(
                circle at 85% 5%,
                rgba(255, 255, 255, 0.15),
                transparent 35%
            ),
            linear-gradient(135deg, #0b3563, #1263a0);

        border-radius: 15px;
        box-shadow: 0 10px 22px rgba(11, 53, 99, 0.15);
    }

    .completion-copy {
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .completion-copy span {
        color: rgba(255, 255, 255, 0.72);
        font-size: 0.72rem;
        font-weight: 700;
    }

    .completion-copy strong {
        margin-top: 1px;
        font-size: 1.55rem;
        font-weight: 850;
        line-height: 1.2;
    }

    .completion-copy small {
        margin-top: 2px;
        color: rgba(255, 255, 255, 0.62);
        font-size: 0.64rem;
    }

    .completion-ring {
        --ring-size: 55px;

        width: var(--ring-size);
        height: var(--ring-size);
        flex: 0 0 var(--ring-size);

        display: grid;
        place-items: center;

        background:
            conic-gradient(
                #58d9ff calc(var(--completion) * 1%),
                rgba(255, 255, 255, 0.16) 0
            );

        border-radius: 50%;
    }

    .completion-ring-center {
        width: 42px;
        height: 42px;

        display: grid;
        place-items: center;

        color: #bceeff;
        background: #0b3563;
        border-radius: 50%;
        font-size: 14px;
    }

    /* Shared panels */

    .dashboard-panel {
        background: #ffffff;
        border: 1px solid #e3eaf2;
        border-radius: 16px;
        box-shadow:
            0 8px 22px rgba(15, 23, 42, 0.05),
            0 2px 6px rgba(15, 23, 42, 0.025);
    }

    .dashboard-chart-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(0, 1.45fr);
        gap: 14px;
        margin-bottom: 14px;
    }

    .chart-panel {
        min-width: 0;
        padding: 18px 19px 15px;
    }

    .panel-header {
        min-height: 45px;
        margin-bottom: 13px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .panel-kicker {
        display: block;
        margin-bottom: 2px;
        color: #8794a5;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.07em;
        text-transform: uppercase;
    }

    .panel-header h2 {
        margin: 0;
        color: #182438;
        font-size: 0.98rem;
        font-weight: 800;
        line-height: 1.35;
    }

    .panel-icon {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;

        display: grid;
        place-items: center;

        border-radius: 10px;
        font-size: 15px;
    }

    .panel-icon-blue {
        color: #0b5a99;
        background: #e8f3fc;
    }

    .panel-icon-orange {
        color: #d85a0a;
        background: #fff0e5;
    }

    .chart-stage {
        position: relative;
        height: 286px;
        min-height: 286px;
    }

    .doughnut-stage {
        display: grid;
        place-items: center;
    }

    .doughnut-stage canvas {
        position: relative;
        z-index: 1;
    }

    .doughnut-center {
        position: absolute;
        inset: 50% auto auto 50%;
        z-index: 2;

        width: 115px;
        transform: translate(-50%, -49%);

        display: flex;
        flex-direction: column;
        align-items: center;

        pointer-events: none;
        text-align: center;
    }

    .doughnut-center span {
        color: #8390a2;
        font-size: 0.63rem;
        font-weight: 700;
    }

    .doughnut-center strong {
        margin-top: 2px;
        color: #172234;
        font-size: 1.28rem;
        font-weight: 850;
    }

    /* Recent tasks */

    .recent-tasks-panel {
        overflow: hidden;
    }

    .recent-tasks-header {
        margin: 0;
        padding: 17px 19px 14px;
        border-bottom: 1px solid #edf1f5;
    }

    .view-all-link {
        min-height: 34px;
        padding: 7px 10px;

        display: inline-flex;
        align-items: center;
        gap: 7px;

        color: #0b4f8c;
        background: #edf6fd;
        border: 1px solid #dcecf9;
        border-radius: 9px;

        font-size: 0.72rem;
        font-weight: 750;
        transition: all 0.18s ease;
    }

    .view-all-link:hover {
        color: #ffffff;
        background: #0b4f8c;
        border-color: #0b4f8c;
    }

    .dashboard-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .dashboard-table {
        width: 100%;
        min-width: 760px;
        margin: 0;

        border-collapse: separate;
        border-spacing: 0;
    }

    .dashboard-table th,
    .dashboard-table td {
        padding: 11px 13px;
        text-align: start;
        vertical-align: middle;
        border-bottom: 1px solid #edf1f5;
    }

    .dashboard-table thead th {
        color: #657286;
        background: #f8fafc;
        font-size: 0.69rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .dashboard-table tbody td {
        color: #2f3c50;
        font-size: 0.76rem;
    }

    .dashboard-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .dashboard-table tbody tr {
        transition: background-color 0.15s ease;
    }

    .dashboard-table tbody tr:hover {
        background: #fbfdff;
    }

    .dashboard-table tbody tr.clickable-row {
        cursor: pointer;
    }

    .number-column {
        width: 58px;
        text-align: center !important;
    }

    .action-column {
        width: 74px;
        text-align: center !important;
    }

    .row-number {
        width: 26px;
        height: 26px;

        display: inline-grid;
        place-items: center;

        color: #5d6c7e;
        background: #f0f4f8;
        border-radius: 8px;

        font-size: 0.7rem;
        font-weight: 750;
    }

    .task-code {
        color: #0b4f8c;
        font-weight: 800;
        white-space: nowrap;
    }

    .task-title-cell {
        min-width: 210px;
        display: flex;
        flex-direction: column;
    }

    .task-title-text {
        color: #1d293b;
        font-weight: 700;
    }

    .task-title-cell small {
        max-width: 410px;
        margin-top: 2px;
        overflow: hidden;

        color: #8a96a5;
        font-size: 0.65rem;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dashboard-status-badge {
        width: max-content;
        padding: 5px 9px;

        display: inline-flex;
        align-items: center;
        gap: 6px;

        border-radius: 999px;
        font-size: 0.67rem;
        font-weight: 750;
        white-space: nowrap;
    }

    .status-indicator {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-pending {
        color: #a94d08;
        background: #fff0e3;
    }

    .status-progress {
        color: #145da0;
        background: #e8f3fc;
    }

    .status-completed {
        color: #107946;
        background: #e7f7ef;
    }

    .status-overdue {
        color: #c5252e;
        background: #fdebed;
    }

    .status-neutral {
        color: #657286;
        background: #eff3f7;
    }

    .deadline-cell {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #5d6b7e;
        white-space: nowrap;
    }

    .deadline-cell i {
        color: #8a96a5;
        font-size: 0.72rem;
    }

    .table-action-btn {
        width: 29px;
        height: 29px;

        display: inline-grid;
        place-items: center;

        color: #0b4f8c;
        background: #edf6fd;
        border: 1px solid #dcecf9;
        border-radius: 8px;

        font-size: 0.69rem;
        transition: all 0.18s ease;
    }

    .table-action-btn:hover {
        color: #ffffff;
        background: #0b4f8c;
        border-color: #0b4f8c;
    }

    .table-action-btn.disabled {
        color: #a3adb9;
        background: #f3f5f7;
        border-color: #edf0f3;
        pointer-events: none;
    }

    .dashboard-empty-state {
        min-height: 150px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        color: #8995a5;
        text-align: center;
    }

    .empty-icon {
        width: 46px;
        height: 46px;
        margin-bottom: 9px;

        display: grid;
        place-items: center;

        color: #7f91a5;
        background: #eef3f7;
        border-radius: 13px;

        font-size: 18px;
    }

    .dashboard-empty-state strong {
        font-size: 0.78rem;
        font-weight: 700;
    }

    /* RTL refinements */

    html[dir="rtl"] .doughnut-center {
        transform: translate(-50%, -49%);
    }

    html[dir="rtl"] .dashboard-table th,
    html[dir="rtl"] .dashboard-table td {
        text-align: right;
    }

    html[dir="ltr"] .dashboard-table th,
    html[dir="ltr"] .dashboard-table td {
        text-align: left;
    }

    /* Responsive */

    @media (max-width: 1260px) {
        .dashboard-kpi-grid-primary {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-task-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 1050px) {
        .dashboard-hero {
            align-items: flex-start;
            flex-direction: column;
        }

        .hero-meta {
            width: 100%;
            align-items: flex-start;
        }

        .quick-actions {
            justify-content: flex-start;
        }

        .dashboard-chart-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 760px) {
        .dashboard-hero {
            padding: 21px 18px;
            border-radius: 16px;
        }

        .hero-content {
            align-items: flex-start;
        }

        .hero-icon {
            width: 50px;
            height: 50px;
            flex-basis: 50px;
            border-radius: 13px;
            font-size: 20px;
        }

        .hero-date {
            width: 100%;
        }

        .quick-actions,
        .quick-action {
            width: 100%;
        }

        .quick-action {
            justify-content: center;
        }

        .task-status-cards {
            grid-template-columns: 1fr;
        }

        .chart-stage {
            height: 250px;
            min-height: 250px;
        }
    }

    @media (max-width: 560px) {
        .dashboard-kpi-grid-primary {
            grid-template-columns: 1fr;
        }

        .dashboard-kpi-card {
            min-height: 132px;
        }

        .hero-content {
            gap: 12px;
        }

        .hero-icon {
            display: none;
        }

        .dashboard-hero h1 {
            font-size: 1.25rem;
        }

        .dashboard-hero p {
            font-size: 0.8rem;
        }

        .chart-panel {
            padding: 16px 14px 13px;
        }

        .recent-tasks-header {
            align-items: flex-start;
            padding: 15px 14px 13px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    /*
    |--------------------------------------------------------------------------
    | Clickable task rows
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.dashboard-table tr[data-href]')
        .forEach(function (row) {
            function openRow(event) {
                const interactive = event.target.closest(
                    'a, button, input, select, textarea, form'
                );

                if (interactive) {
                    return;
                }

                window.location.href = row.dataset.href;
            }

            row.addEventListener('click', openRow);

            row.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    window.location.href = row.dataset.href;
                }
            });
        });

    /*
    |--------------------------------------------------------------------------
    | Chart.js
    |--------------------------------------------------------------------------
    */

    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded.');
        return;
    }

    const rootStyles = getComputedStyle(document.documentElement);

    const textColor =
        rootStyles.getPropertyValue('--text-main').trim()
        || '#1e293b';

    const softTextColor =
        rootStyles.getPropertyValue('--text-soft').trim()
        || '#64748b';

    const borderColor =
        rootStyles.getPropertyValue('--border').trim()
        || '#e2e8f0';

    const inboxLabels = @json(
        $translateChartLabels($inboxStatusCollection)
    );

    const inboxData = @json(
        $inboxStatusCollection->values()->map(
            fn ($value) => (int) $value
        )->all()
    );

    const outboxLabels = @json(
        $translateChartLabels($outboxStatusCollection)
    );

    const outboxData = @json(
        $outboxStatusCollection->values()->map(
            fn ($value) => (int) $value
        )->all()
    );

    const isRtl =
        document.documentElement.getAttribute('dir') === 'rtl';

    Chart.defaults.font.family =
        getComputedStyle(document.body).fontFamily;

    Chart.defaults.color = softTextColor;

    /*
    |--------------------------------------------------------------------------
    | Inbox doughnut chart
    |--------------------------------------------------------------------------
    */

    const inboxCanvas =
        document.getElementById('inboxStatusChart');

    if (inboxCanvas) {
        const hasInboxData =
            inboxData.some(function (value) {
                return Number(value) > 0;
            });

        new Chart(inboxCanvas, {
            type: 'doughnut',

            data: {
                labels: hasInboxData
                    ? inboxLabels
                    : [@json($t('no_data'))],

                datasets: [{
                    data: hasInboxData
                        ? inboxData
                        : [1],

                    backgroundColor: hasInboxData
                        ? [
                            '#0b5a99',
                            '#0ea5e9',
                            '#f59e0b',
                            '#16a05d',
                            '#df2f36',
                            '#7c5ce0',
                        ]
                        : ['#dce5ee'],

                    borderColor: '#ffffff',
                    borderWidth: 4,
                    hoverOffset: hasInboxData ? 5 : 0,
                }],
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',

                interaction: {
                    intersect: false,
                    mode: 'nearest',
                },

                plugins: {
                    legend: {
                        display: hasInboxData,
                        position: 'bottom',
                        rtl: isRtl,

                        labels: {
                            color: softTextColor,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 7,
                            boxHeight: 7,
                            padding: 16,
                            font: {
                                size: 11,
                                weight: '600',
                            },
                        },
                    },

                    tooltip: {
                        enabled: hasInboxData,
                        rtl: isRtl,
                    },
                },
            },
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Outbox bar chart
    |--------------------------------------------------------------------------
    */

    const outboxCanvas =
        document.getElementById('outboxStatusChart');

    if (outboxCanvas) {
        const hasOutboxData =
            outboxData.some(function (value) {
                return Number(value) > 0;
            });

        new Chart(outboxCanvas, {
            type: 'bar',

            data: {
                labels: hasOutboxData
                    ? outboxLabels
                    : [@json($t('no_data'))],

                datasets: [{
                    label: @json($t('outgoing_documents')),

                    data: hasOutboxData
                        ? outboxData
                        : [0],

                    backgroundColor: [
                        'rgba(11, 79, 140, 0.88)',
                        'rgba(14, 165, 233, 0.82)',
                        'rgba(245, 158, 11, 0.82)',
                        'rgba(22, 160, 93, 0.82)',
                        'rgba(223, 47, 54, 0.82)',
                        'rgba(124, 92, 224, 0.82)',
                    ],

                    borderColor: [
                        '#0b4f8c',
                        '#0ea5e9',
                        '#f59e0b',
                        '#16a05d',
                        '#df2f36',
                        '#7c5ce0',
                    ],

                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false,
                    maxBarThickness: 58,
                }],
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                interaction: {
                    intersect: false,
                    mode: 'index',
                },

                scales: {
                    x: {
                        grid: {
                            display: false,
                        },

                        ticks: {
                            color: softTextColor,
                            maxRotation: 0,
                            autoSkip: true,
                            font: {
                                size: 10,
                                weight: '600',
                            },
                        },

                        border: {
                            display: false,
                        },
                    },

                    y: {
                        beginAtZero: true,

                        grid: {
                            color: borderColor,
                            drawTicks: false,
                        },

                        ticks: {
                            color: softTextColor,
                            precision: 0,
                            padding: 8,
                            font: {
                                size: 10,
                            },
                        },

                        border: {
                            display: false,
                        },
                    },
                },

                plugins: {
                    legend: {
                        display: false,
                    },

                    tooltip: {
                        rtl: isRtl,
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        backgroundColor: textColor,
                        padding: 10,
                        cornerRadius: 8,
                    },
                },
            },
        });
    }
});
</script>
@endpush