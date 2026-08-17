@extends('settings.layout')

@section('settings-content')

@php
    $displayValue = function (
        mixed $value
    ): string {
        if ($value === null || $value === '') {
            return '—';
        }

        if (is_array($value)) {
            return json_encode(
                $value,
                JSON_UNESCAPED_UNICODE
                | JSON_UNESCAPED_SLASHES
            );
        }

        return (string) $value;
    };

    $displayUser = function (
        $user,
        mixed $changedBy
    ): string {
        if (!$user) {
            return $changedBy
                ? 'User #' . $changedBy
                : 'System';
        }

        $name = trim(
            (string) (
                $user->name
                ?? (
                    trim(
                        ($user->first_name ?? '')
                        . ' '
                        . ($user->last_name ?? '')
                    )
                )
            )
        );

        if ($name !== '') {
            return $name;
        }

        return $user->email
            ?? 'User #' . $changedBy;
    };
@endphp

@include('settings.partials.page-header', [
    'pageTitle' => 'Settings History',
    'pageDescription' =>
        'Review configuration changes, previous values, users, IP addresses, and timestamps.',
    'pageIcon' => 'fa-solid fa-clock-rotate-left',
])

<div class="settings-history-filter">
    <form
        method="GET"
        action="{{ route('settings.history') }}"
        class="settings-history-filter__form"
    >
        <div class="settings-history-filter__field settings-history-filter__field--search">
            <label for="history-search">
                Search
            </label>

            <input
                type="search"
                id="history-search"
                name="search"
                value="{{ $filters['search'] ?? '' }}"
                placeholder="Setting key, group, IP or route"
            >
        </div>

        <div class="settings-history-filter__field">
            <label for="history-group">
                Group
            </label>

            <select
                id="history-group"
                name="group"
            >
                <option value="">
                    All groups
                </option>

                @foreach($groups as $groupKey => $groupTitle)
                    <option
                        value="{{ $groupKey }}"
                        @selected(
                            ($filters['group'] ?? '')
                            === $groupKey
                        )
                    >
                        {{ $groupTitle }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="settings-history-filter__field">
            <label for="history-action">
                Action
            </label>

            <select
                id="history-action"
                name="action"
            >
                <option value="">
                    All actions
                </option>

                @foreach($actions as $actionKey => $actionTitle)
                    <option
                        value="{{ $actionKey }}"
                        @selected(
                            ($filters['action'] ?? '')
                            === $actionKey
                        )
                    >
                        {{ $actionTitle }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="settings-history-filter__field">
            <label for="history-date-from">
                From
            </label>

            <input
                type="date"
                id="history-date-from"
                name="date_from"
                value="{{ $filters['date_from'] ?? '' }}"
            >
        </div>

        <div class="settings-history-filter__field">
            <label for="history-date-to">
                To
            </label>

            <input
                type="date"
                id="history-date-to"
                name="date_to"
                value="{{ $filters['date_to'] ?? '' }}"
            >
        </div>

        <div class="settings-history-filter__actions">
            <button
                type="submit"
                class="settings-history-button settings-history-button--primary"
            >
                <i class="fa-solid fa-filter"></i>
                Apply
            </button>

            <a
                href="{{ route('settings.history') }}"
                class="settings-history-button settings-history-button--light"
            >
                <i class="fa-solid fa-rotate-left"></i>
                Reset
            </a>
        </div>
    </form>
</div>

<div class="settings-history-card">
    <div class="settings-history-card__header">
        <div>
            <h3>Configuration changes</h3>

            <p>
                Every successful Settings change is recorded automatically.
            </p>
        </div>

        <span class="settings-history-count">
            {{ number_format($histories->total()) }}
            records
        </span>
    </div>

    @if($histories->count() > 0)
        <div class="settings-history-table-wrap">
            <table class="settings-history-table">
                <thead>
                    <tr>
                        <th>Setting</th>
                        <th>Action</th>
                        <th>Previous value</th>
                        <th>New value</th>
                        <th>Changed by</th>
                        <th>Date and source</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($histories as $history)
                        @php
                            $oldValue =
                                $displayValue(
                                    $history->old_value
                                );

                            $newValue =
                                $displayValue(
                                    $history->new_value
                                );

                            $actionClass = in_array(
                                $history->action,
                                [
                                    'created',
                                    'updated',
                                    'deleted',
                                ],
                                true
                            )
                                ? $history->action
                                : 'updated';
                        @endphp

                        <tr>
                            <td>
                                <strong class="settings-history-key">
                                    {{ $history->full_key }}
                                </strong>

                                <span class="settings-history-type">
                                    {{ $history->value_type }}
                                </span>
                            </td>

                            <td>
                                <span
                                    class="settings-history-action settings-history-action--{{ $actionClass }}"
                                >
                                    {{ ucfirst($history->action) }}
                                </span>
                            </td>

                            <td>
                                <div
                                    class="settings-history-value"
                                    title="{{ $oldValue }}"
                                >
                                    {{ \Illuminate\Support\Str::limit(
                                        $oldValue,
                                        90
                                    ) }}
                                </div>
                            </td>

                            <td>
                                <div
                                    class="settings-history-value settings-history-value--new"
                                    title="{{ $newValue }}"
                                >
                                    {{ \Illuminate\Support\Str::limit(
                                        $newValue,
                                        90
                                    ) }}
                                </div>
                            </td>

                            <td>
                                <strong class="settings-history-user">
                                    {{ $displayUser(
                                        $history->changedBy,
                                        $history->changed_by
                                    ) }}
                                </strong>

                                <span>
                                    ID:
                                    {{ $history->changed_by ?? '—' }}
                                </span>
                            </td>

                            <td>
                                <strong>
                                    {{ optional($history->created_at)
                                        ->format('Y-m-d H:i:s') }}
                                </strong>

                                <span>
                                    {{ $history->ip_address ?? '—' }}
                                </span>

                                <span>
                                    {{ $history->request_method ?? '—' }}
                                    ·
                                    {{ $history->route_name ?? '—' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($histories->hasPages())
            <div class="settings-history-pagination">
                {{ $histories->links() }}
            </div>
        @endif
    @else
        <div class="settings-history-empty">
            <i class="fa-solid fa-clock-rotate-left"></i>

            <h3>No history records found</h3>

            <p>
                Try changing the filters or save a Settings section.
            </p>
        </div>
    @endif
</div>

@endsection

@push('styles')
<style>
    .settings-history-filter,
    .settings-history-card {
        background: #ffffff;

        border: 1px solid #e1e6ee;
        border-radius: 11px;

        box-shadow:
            0 4px 16px
            rgba(31, 41, 55, 0.04);
    }

    .settings-history-filter {
        margin-bottom: 16px;
        padding: 15px;
    }

    .settings-history-filter__form {
        display: grid;
        grid-template-columns:
            minmax(220px, 2fr)
            repeat(4, minmax(130px, 1fr))
            auto;

        align-items: end;
        gap: 11px;
    }

    .settings-history-filter__field {
        min-width: 0;
    }

    .settings-history-filter__field label {
        display: block;

        margin-bottom: 5px;

        color: #4d5b70;

        font-size: 11px;
        font-weight: 700;
    }

    .settings-history-filter__field input,
    .settings-history-filter__field select {
        width: 100%;
        min-height: 39px;

        padding: 8px 10px;

        color: #26344a;
        background: #ffffff;

        border: 1px solid #d9e0e9;
        border-radius: 7px;

        font-size: 11.5px;
        outline: none;
    }

    .settings-history-filter__field input:focus,
    .settings-history-filter__field select:focus {
        border-color: #316ab2;

        box-shadow:
            0 0 0 3px
            rgba(49, 106, 178, 0.1);
    }

    .settings-history-filter__actions {
        display: flex;
        gap: 7px;
    }

    .settings-history-button {
        min-height: 39px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 6px;

        padding: 8px 11px;

        border: 1px solid;
        border-radius: 7px;

        font-size: 11px;
        font-weight: 700;

        text-decoration: none;
        cursor: pointer;
    }

    .settings-history-button--primary {
        color: #ffffff;
        background: #173d7a;
        border-color: #173d7a;
    }

    .settings-history-button--light {
        color: #4d5b70;
        background: #ffffff;
        border-color: #d9e0e9;
    }

    .settings-history-card {
        overflow: hidden;
    }

    .settings-history-card__header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 15px;

        padding: 15px 17px;

        background: #fafbfd;

        border-bottom: 1px solid #e6eaf0;
    }

    .settings-history-card__header h3 {
        margin: 0;

        color: #1d293d;

        font-size: 14px;
    }

    .settings-history-card__header p {
        margin: 4px 0 0;

        color: #7a8698;

        font-size: 11px;
    }

    .settings-history-count {
        padding: 4px 9px;

        color: #4d5b70;
        background: #ffffff;

        border: 1px solid #dce3ec;
        border-radius: 20px;

        font-size: 10px;
        font-weight: 700;
    }

    .settings-history-table-wrap {
        overflow-x: auto;
    }

    .settings-history-table {
        width: 100%;
        min-width: 1050px;

        border-collapse: collapse;
    }

    .settings-history-table th {
        padding: 10px 12px;

        color: #5d6a7d;
        background: #f8fafc;

        border-bottom: 1px solid #e5e9ef;

        font-size: 10px;
        font-weight: 800;

        text-align: start;
        white-space: nowrap;
    }

    .settings-history-table td {
        padding: 11px 12px;

        color: #3d4b60;

        border-bottom: 1px solid #edf0f4;

        font-size: 10.5px;

        vertical-align: top;
    }

    .settings-history-table tbody tr:hover {
        background: #fbfcfe;
    }

    .settings-history-key,
    .settings-history-user {
        display: block;

        color: #1f2e45;

        font-size: 10.5px;
    }

    .settings-history-type,
    .settings-history-table td span {
        display: block;

        margin-top: 3px;

        color: #8490a1;

        font-size: 9.5px;
    }

    .settings-history-action {
        display: inline-flex !important;

        width: fit-content;

        margin: 0 !important;
        padding: 3px 7px;

        border-radius: 20px;

        font-size: 9px !important;
        font-weight: 800;
    }

    .settings-history-action--created {
        color: #166534 !important;
        background: #dcfce7;
    }

    .settings-history-action--updated {
        color: #1d4ed8 !important;
        background: #dbeafe;
    }

    .settings-history-action--deleted {
        color: #991b1b !important;
        background: #fee2e2;
    }

    .settings-history-value {
        max-width: 210px;

        color: #667386;

        word-break: break-word;
    }

    .settings-history-value--new {
        color: #24324a;
        font-weight: 650;
    }

    .settings-history-pagination {
        padding: 13px 16px;

        border-top: 1px solid #e7ebf1;
    }

    .settings-history-empty {
        display: flex;
        flex-direction: column;
        align-items: center;

        padding: 50px 20px;

        color: #7b8798;

        text-align: center;
    }

    .settings-history-empty i {
        margin-bottom: 12px;

        color: #9aa5b4;

        font-size: 25px;
    }

    .settings-history-empty h3 {
        margin: 0;

        color: #334155;

        font-size: 14px;
    }

    .settings-history-empty p {
        margin: 5px 0 0;

        font-size: 11px;
    }

    @media (max-width: 1100px) {
        .settings-history-filter__form {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .settings-history-filter__field--search,
        .settings-history-filter__actions {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 650px) {
        .settings-history-filter__form {
            grid-template-columns: 1fr;
        }

        .settings-history-filter__field--search,
        .settings-history-filter__actions {
            grid-column: auto;
        }

        .settings-history-filter__actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
    }
</style>
@endpush