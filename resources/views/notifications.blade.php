@extends('new')

@section('title', 'Notifications')

@section('styles')
<style>
    .notification-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .notification-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }

    .notification-header h1 i {
        color: #4361ee;
        margin-right: 10px;
    }

    .notification-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn-mark-all {
        background: #4361ee;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-mark-all:hover {
        background: #3651d4;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    .btn-clear-all {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-clear-all:hover {
        background: #c0392b;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }

    /* Stats Cards */
    .notification-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .stat-icon.total { background: #e8f4fd; color: #4361ee; }
    .stat-icon.unread { background: #fff3e0; color: #f59e0b; }
    .stat-icon.today { background: #e8f5e9; color: #10b981; }
    .stat-icon.urgent { background: #fce4ec; color: #e74c3c; }

    .stat-info h3 {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        color: #1a1a2e;
    }

    .stat-info p {
        font-size: 13px;
        color: #6b7280;
        margin: 0;
    }

    /* Filter Tabs */
    .notification-filters {
        display: flex;
        gap: 8px;
        margin-bottom: 25px;
        flex-wrap: wrap;
        background: white;
        padding: 8px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    }

    .filter-tab {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .filter-tab:hover {
        background: #f0f4ff;
        color: #4361ee;
    }

    .filter-tab.active {
        background: #4361ee;
        color: white;
    }

    .filter-tab .badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 600;
    }

    .filter-tab.active .badge {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }

    .filter-tab:not(.active) .badge {
        background: #e5e7eb;
        color: #6b7280;
    }

    /* Search Bar */
    .notification-search {
        margin-bottom: 25px;
        position: relative;
    }

    .notification-search input {
        width: 100%;
        padding: 14px 20px 14px 50px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 15px;
        background: white;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .notification-search input:focus {
        outline: none;
        border-color: #4361ee;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    .notification-search i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 18px;
    }

    /* Notification List */
    .notification-list {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .notification-item {
        display: flex;
        align-items: flex-start;
        padding: 20px 25px;
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item:hover {
        background: #f8faff;
    }

    .notification-item.unread {
        background: #f0f4ff;
        border-left: 4px solid #4361ee;
    }

    .notification-item.unread:hover {
        background: #e8eeff;
    }

    .notification-checkbox {
        margin-right: 15px;
        margin-top: 5px;
    }

    .notification-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #4361ee;
        cursor: pointer;
    }

    .notification-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
        font-size: 20px;
    }

    .icon-info { background: #e8f4fd; color: #3b82f6; }
    .icon-success { background: #e8f5e9; color: #10b981; }
    .icon-warning { background: #fff3e0; color: #f59e0b; }
    .icon-danger { background: #fce4ec; color: #e74c3c; }
    .icon-academic { background: #f3e8ff; color: #8b5cf6; }
    .icon-enrollment { background: #e0f2fe; color: #0ea5e9; }
    .icon-finance { background: #ecfdf5; color: #059669; }
    .icon-system { background: #f1f5f9; color: #64748b; }
    .icon-attendance { background: #fef3c7; color: #d97706; }
    .icon-exam { background: #ede9fe; color: #7c3aed; }

    .notification-content {
        flex: 1;
        min-width: 0;
    }

    .notification-title {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .notification-title .priority-badge {
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 4px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .priority-high { background: #fce4ec; color: #e74c3c; }
    .priority-medium { background: #fff3e0; color: #f59e0b; }
    .priority-low { background: #e8f5e9; color: #10b981; }
    .priority-urgent { background: #e74c3c; color: white; animation: pulse-urgent 2s infinite; }

    @keyframes pulse-urgent {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .notification-message {
        font-size: 13px;
        color: #6b7280;
        line-height: 1.5;
        margin-bottom: 8px;
    }

    .notification-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 12px;
        color: #9ca3af;
        flex-wrap: wrap;
    }

    .notification-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .notification-category-tag {
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
        background: #f3f4f6;
        color: #4b5563;
    }

    .notification-actions-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: 15px;
        flex-shrink: 0;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: #9ca3af;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 16px;
    }

    .action-btn:hover {
        background: #f3f4f6;
        color: #4361ee;
    }

    .action-btn.delete:hover {
        background: #fce4ec;
        color: #e74c3c;
    }

    /* Date Separator */
    .date-separator {
        padding: 12px 25px;
        background: #f9fafb;
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .date-separator::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e5e7eb;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 20px;
        color: #4b5563;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 14px;
    }

    /* Pagination */
    .notification-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        gap: 5px;
    }

    .pagination-btn {
        padding: 8px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: white;
        color: #4b5563;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .pagination-btn:hover {
        background: #f0f4ff;
        border-color: #4361ee;
        color: #4361ee;
    }

    .pagination-btn.active {
        background: #4361ee;
        color: white;
        border-color: #4361ee;
    }

    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Bulk Actions Bar */
    .bulk-actions-bar {
        background: #4361ee;
        color: white;
        padding: 12px 25px;
        display: none;
        align-items: center;
        justify-content: space-between;
        border-radius: 12px;
        margin-bottom: 15px;
        animation: slideDown 0.3s ease;
    }

    .bulk-actions-bar.show {
        display: flex;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .bulk-actions-bar .selected-count {
        font-weight: 600;
        font-size: 14px;
    }

    .bulk-actions-bar .bulk-btns {
        display: flex;
        gap: 10px;
    }

    .bulk-btn {
        padding: 6px 16px;
        border-radius: 6px;
        border: 1px solid rgba(255,255,255,0.3);
        background: rgba(255,255,255,0.1);
        color: white;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .bulk-btn:hover {
        background: rgba(255,255,255,0.2);
    }

    /* Notification Detail Modal */
    .notification-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .notification-modal-overlay.show {
        display: flex;
    }

    .notification-modal {
        background: white;
        border-radius: 16px;
        width: 90%;
        max-width: 600px;
        max-height: 80vh;
        overflow-y: auto;
        animation: modalSlideUp 0.3s ease;
    }

    @keyframes modalSlideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        padding: 25px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .modal-header h2 {
        font-size: 20px;
        color: #1a1a2e;
        margin: 0;
    }

    .modal-close {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        background: #f3f4f6;
        color: #6b7280;
        cursor: pointer;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-body {
        padding: 25px;
    }

    .modal-body .detail-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .modal-body .detail-meta span {
        font-size: 12px;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .modal-body .detail-content {
        font-size: 15px;
        line-height: 1.7;
        color: #374151;
    }

    .modal-footer {
        padding: 20px 25px;
        border-top: 1px solid #f3f4f6;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .notification-container {
            padding: 10px;
        }

        .notification-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .notification-item {
            padding: 15px;
            flex-wrap: wrap;
        }

        .notification-actions-item {
            margin-left: 0;
            margin-top: 10px;
            width: 100%;
            justify-content: flex-end;
        }

        .notification-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .notification-filters {
            overflow-x: auto;
            flex-wrap: nowrap;
        }
    }

    /* Loading Skeleton */
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 4px;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* Toast Notification */
    .toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #1a1a2e;
        color: white;
        padding: 14px 24px;
        border-radius: 10px;
        font-size: 14px;
        z-index: 2000;
        display: none;
        align-items: center;
        gap: 10px;
        animation: toastIn 0.3s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .toast.show { display: flex; }

    @keyframes toastIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="notification-container">

    {{-- Header --}}
    <div class="notification-header">
        <h1><i class="fas fa-bell"></i> Notifications</h1>
        <div class="notification-actions">
            <form action="#" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-mark-all">
                    <i class="fas fa-check-double"></i> Mark All as Read
                </button>
            </form>
            <form action="#" method="POST" style="display:inline;" 
                  onsubmit="return confirm('Are you sure you want to clear all notifications?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-clear-all">
                    <i class="fas fa-trash-alt"></i> Clear All
                </button>
            </form>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="notification-stats">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-bell"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $totalCount ?? 0 }}</h3>
                <p>Total Notifications</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon unread">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $unreadCount ?? 0 }}</h3>
                <p>Unread</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon today">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $todayCount ?? 0 }}</h3>
                <p>Today</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon urgent">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $urgentCount ?? 0 }}</h3>
                <p>Urgent</p>
            </div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="notification-filters">
        <button class="filter-tab {{ request('filter', 'all') == 'all' ? 'active' : '' }}" 
                onclick="filterNotifications('all')">
            <i class="fas fa-inbox"></i> All
            <span class="badge">{{ $totalCount ?? 0 }}</span>
        </button>
        <button class="filter-tab {{ request('filter') == 'unread' ? 'active' : '' }}" 
                onclick="filterNotifications('unread')">
            <i class="fas fa-envelope"></i> Unread
            <span class="badge">{{ $unreadCount ?? 0 }}</span>
        </button>
        <button class="filter-tab {{ request('filter') == 'academic' ? 'active' : '' }}" 
                onclick="filterNotifications('academic')">
            <i class="fas fa-graduation-cap"></i> Academic
        </button>
        <button class="filter-tab {{ request('filter') == 'enrollment' ? 'active' : '' }}" 
                onclick="filterNotifications('enrollment')">
            <i class="fas fa-user-plus"></i> Enrollment
        </button>
        <button class="filter-tab {{ request('filter') == 'attendance' ? 'active' : '' }}" 
                onclick="filterNotifications('attendance')">
            <i class="fas fa-clipboard-check"></i> Attendance
        </button>
        <button class="filter-tab {{ request('filter') == 'exam' ? 'active' : '' }}" 
                onclick="filterNotifications('exam')">
            <i class="fas fa-file-alt"></i> Exams
        </button>
        <button class="filter-tab {{ request('filter') == 'finance' ? 'active' : '' }}" 
                onclick="filterNotifications('finance')">
            <i class="fas fa-dollar-sign"></i> Finance
        </button>
        <button class="filter-tab {{ request('filter') == 'system' ? 'active' : '' }}" 
                onclick="filterNotifications('system')">
            <i class="fas fa-cog"></i> System
        </button>
    </div>

    {{-- Search --}}
    <div class="notification-search">
        <i class="fas fa-search"></i>
        <input type="text" id="searchNotifications" placeholder="Search notifications..." 
               value="{{ request('search') }}" onkeyup="debounceSearch(this.value)">
    </div>

    {{-- Bulk Actions Bar --}}
    <div class="bulk-actions-bar" id="bulkActionsBar">
        <span class="selected-count"><span id="selectedCount">0</span> selected</span>
        <div class="bulk-btns">
            <button class="bulk-btn" onclick="bulkMarkRead()">
                <i class="fas fa-check"></i> Mark Read
            </button>
            <button class="bulk-btn" onclick="bulkMarkUnread()">
                <i class="fas fa-envelope"></i> Mark Unread
            </button>
            <button class="bulk-btn" onclick="bulkDelete()">
                <i class="fas fa-trash"></i> Delete
            </button>
        </div>
    </div>

    {{-- Notification List --}}
    <div class="notification-list" id="notificationList">
        @forelse($notifications ?? [] as $date => $dateNotifications)
            {{-- Date Separator --}}
            <div class="date-separator">
                <i class="fas fa-calendar"></i>
                {{ \Carbon\Carbon::parse($date)->isToday() ? 'Today' : 
                   (\Carbon\Carbon::parse($date)->isYesterday() ? 'Yesterday' : 
                   \Carbon\Carbon::parse($date)->format('F j, Y')) }}
            </div>

            @foreach($dateNotifications as $notification)
                <div class="notification-item {{ is_null($notification->read_at) ? 'unread' : '' }}" 
                     id="notification-{{ $notification->id }}"
                     data-category="{{ $notification->data['category'] ?? 'system' }}"
                     data-id="{{ $notification->id }}">
                    
                    <div class="notification-checkbox">
                        <input type="checkbox" class="notification-check" 
                               value="{{ $notification->id }}" onchange="updateBulkBar()">
                    </div>

                    <div class="notification-icon-wrapper {{ getNotificationIconClass($notification) }}">
                        <i class="{{ getNotificationIcon($notification) }}"></i>
                    </div>

                    <div class="notification-content" onclick="showNotificationDetail('{{ $notification->id }}')">
                        <div class="notification-title">
                            {{ $notification->data['title'] ?? 'Notification' }}
                            @if(isset($notification->data['priority']))
                                <span class="priority-badge priority-{{ $notification->data['priority'] }}">
                                    {{ ucfirst($notification->data['priority']) }}
                                </span>
                            @endif
                        </div>
                        <div class="notification-message">
                            {{ Str::limit($notification->data['message'] ?? '', 120) }}
                        </div>
                        <div class="notification-meta">
                            <span>
                                <i class="fas fa-clock"></i>
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                            <span>
                                <i class="fas fa-user"></i>
                                {{ $notification->data['sender'] ?? 'System' }}
                            </span>
                            @if(isset($notification->data['category']))
                                <span class="notification-category-tag">
                                    {{ ucfirst($notification->data['category']) }}
                                </span>
                            @endif
                            @if(isset($notification->data['module']))
                                <span>
                                    <i class="fas fa-cube"></i>
                                    {{ $notification->data['module'] }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="notification-actions-item">
                        @if(is_null($notification->read_at))
                            <button class="action-btn" title="Mark as Read" 
                                    onclick="markAsRead('{{ $notification->id }}')">
                                <i class="fas fa-check"></i>
                            </button>
                        @else
                            <button class="action-btn" title="Mark as Unread" 
                                    onclick="markAsUnread('{{ $notification->id }}')">
                                <i class="fas fa-envelope"></i>
                            </button>
                        @endif

                        @if(isset($notification->data['action_url']))
                            <a href="{{ $notification->data['action_url'] }}" class="action-btn" title="View Details">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        @endif

                        <button class="action-btn delete" title="Delete" 
                                onclick="deleteNotification('{{ $notification->id }}')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            @endforeach

        @empty
            <div class="empty-state">
                <i class="fas fa-bell-slash"></i>
                <h3>No Notifications</h3>
                <p>You're all caught up! Check back later for new notifications.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(isset($notifications) && method_exists($notifications, 'links'))
        <div class="notification-pagination">
            {{ $notifications->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
    @endif
</div>

{{-- Notification Detail Modal --}}
<div class="notification-modal-overlay" id="notificationModal" onclick="closeModal(event)">
    <div class="notification-modal" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h2 id="modalTitle">Notification Details</h2>
            <button class="modal-close" onclick="closeNotificationModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="detail-meta">
                <span id="modalTime"><i class="fas fa-clock"></i> --</span>
                <span id="modalSender"><i class="fas fa-user"></i> --</span>
                <span id="modalCategory"><i class="fas fa-tag"></i> --</span>
            </div>
            <div class="detail-content" id="modalContent">
                Loading...
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-mark-all" id="modalActionBtn" style="display:none;" onclick="">
                <i class="fas fa-external-link-alt"></i> View Details
            </button>
            <button class="modal-close" onclick="closeNotificationModal()" 
                    style="padding: 10px 20px; border-radius: 8px; cursor: pointer;">
                Close
            </button>
        </div>
    </div>
</div>

{{-- Toast Notification --}}
<div class="toast" id="toast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMessage">Action completed successfully</span>
</div>
@endsection

@section('scripts')
<script>
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Filter Notifications
    function filterNotifications(filter) {
        const url = new URL(window.location.href);
        url.searchParams.set('filter', filter);
        window.location.href = url.toString();
    }

    // Search with Debounce
    let searchTimeout;
    function debounceSearch(value) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const url = new URL(window.location.href);
            if (value) {
                url.searchParams.set('search', value);
            } else {
                url.searchParams.delete('search');
            }
            window.location.href = url.toString();
        }, 500);
    }

    // Mark as Read
    function markAsRead(id) {
        fetch(`/notifications/${id}/mark-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.getElementById(`notification-${id}`);
                item.classList.remove('unread');
                showToast('Notification marked as read');
                updateCounters();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Mark as Unread
    function markAsUnread(id) {
        fetch(`/notifications/${id}/mark-unread`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.getElementById(`notification-${id}`);
                item.classList.add('unread');
                showToast('Notification marked as unread');
                updateCounters();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Delete Notification
    function deleteNotification(id) {
        if (!confirm('Are you sure you want to delete this notification?')) return;

        fetch(`/notifications/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.getElementById(`notification-${id}`);
                item.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    item.remove();
                    checkEmptyState();
                    updateCounters();
                }, 300);
                showToast('Notification deleted');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Show Notification Detail Modal
    function showNotificationDetail(id) {
        fetch(`/notifications/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').textContent = data.title || 'Notification';
            document.getElementById('modalTime').innerHTML = `<i class="fas fa-clock"></i> ${data.time}`;
            document.getElementById('modalSender').innerHTML = `<i class="fas fa-user"></i> ${data.sender || 'System'}`;
            document.getElementById('modalCategory').innerHTML = `<i class="fas fa-tag"></i> ${data.category || 'General'}`;
            document.getElementById('modalContent').innerHTML = data.message || 'No content available.';

            if (data.action_url) {
                const actionBtn = document.getElementById('modalActionBtn');
                actionBtn.style.display = 'flex';
                actionBtn.onclick = () => window.location.href = data.action_url;
            }

            document.getElementById('notificationModal').classList.add('show');

            // Mark as read
            markAsRead(id);
        })
        .catch(error => console.error('Error:', error));
    }

    // Close Modal
    function closeNotificationModal() {
        document.getElementById('notificationModal').classList.remove('show');
    }

    function closeModal(event) {
        if (event.target === event.currentTarget) {
            closeNotificationModal();
        }
    }

    // Bulk Actions
    function updateBulkBar() {
        const checkboxes = document.querySelectorAll('.notification-check:checked');
        const bar = document.getElementById('bulkActionsBar');
        const count = document.getElementById('selectedCount');

        if (checkboxes.length > 0) {
            bar.classList.add('show');
            count.textContent = checkboxes.length;
        } else {
            bar.classList.remove('show');
        }
    }

    function getSelectedIds() {
        return Array.from(document.querySelectorAll('.notification-check:checked')).map(cb => cb.value);
    }

    function bulkMarkRead() {
        const ids = getSelectedIds();
        fetch('/notifications/bulk-mark-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                ids.forEach(id => {
                    document.getElementById(`notification-${id}`)?.classList.remove('unread');
                    document.querySelector(`.notification-check[value="${id}"]`).checked = false;
                });
                updateBulkBar();
                updateCounters();
                showToast(`${ids.length} notifications marked as read`);
            }
        });
    }

    function bulkMarkUnread() {
        const ids = getSelectedIds();
        fetch('/notifications/bulk-mark-unread', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                ids.forEach(id => {
                    document.getElementById(`notification-${id}`)?.classList.add('unread');
                    document.querySelector(`.notification-check[value="${id}"]`).checked = false;
                });
                updateBulkBar();
                updateCounters();
                showToast(`${ids.length} notifications marked as unread`);
            }
        });
    }

    function bulkDelete() {
        const ids = getSelectedIds();
        if (!confirm(`Are you sure you want to delete ${ids.length} notifications?`)) return;

        fetch('/notifications/bulk-delete', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                ids.forEach(id => {
                    document.getElementById(`notification-${id}`)?.remove();
                });
                updateBulkBar();
                updateCounters();
                checkEmptyState();
                showToast(`${ids.length} notifications deleted`);
            }
        });
    }

    // Toast
    function showToast(message) {
        const toast = document.getElementById('toast');
        document.getElementById('toastMessage').textContent = message;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // Check Empty State
    function checkEmptyState() {
        const items = document.querySelectorAll('.notification-item');
        if (items.length === 0) {
            document.getElementById('notificationList').innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-bell-slash"></i>
                    <h3>No Notifications</h3>
                    <p>You're all caught up! Check back later for new notifications.</p>
                </div>
            `;
        }
    }

    // Update Counters (AJAX refresh)
    function updateCounters() {
        fetch('/notifications/counts', {
            headers: { 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            // Update header badge if exists
            const headerBadge = document.querySelector('.notification-badge');
            if (headerBadge) headerBadge.textContent = data.unread;
        })
        .catch(error => console.error('Error:', error));
    }

    // Keyboard shortcut: Escape to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeNotificationModal();
    });

    // Real-time notifications with Laravel Echo (if configured)
    if (typeof Echo !== 'undefined') {
        Echo.private(`App.Models.User.{{ auth()->id() }}`)
            .notification((notification) => {
                showToast('New notification: ' + (notification.title || 'You have a new notification'));
                // Optionally reload the page or prepend notification
                setTimeout(() => location.reload(), 2000);
            });
    }
</script>

<style>
    @keyframes slideOut {
        to { opacity: 0; transform: translateX(100px); height: 0; padding: 0; margin: 0; }
    }
</style>
@endsection