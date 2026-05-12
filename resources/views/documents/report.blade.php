<!DOCTYPE html>
<html lang="ps" dir="rtl">
<head>
<meta charset="UTF-8">

<style>
    * {
        font-family: notonaskh !important;
    }

    body {
        direction: rtl;
        text-align: right;
        font-size: 12px;
        color: #000;
    }

    .rtl {
        direction: rtl;
        text-align: right;
        unicode-bidi: plaintext;
    }

    .ltr {
        direction: ltr;
        text-align: left;
        unicode-bidi: plaintext;
    }

    .center {
        text-align: center;
    }

    h2 {
        text-align: center;
        margin-bottom: 18px;
        font-size: 18px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 12px;
    }

    th, td {
        border: 1px solid #222;
        padding: 7px;
        vertical-align: middle;
        font-size: 12px;
    }

    th {
        background: #eee;
        font-weight: bold;
        text-align: center;
    }

    .label {
        background: #eee;
        font-weight: bold;
        text-align: center;
        width: 18%;
    }

    .value {
        text-align: right;
        width: 32%;
    }

    .section-title {
        background: #ddd;
        padding: 7px;
        font-weight: bold;
        margin-top: 8px;
        border: 1px solid #ccc;
    }

    .history th,
    .history td {
        text-align: center;
    }

    hr {
        margin: 16px 0;
        border: 0;
        border-top: 1px solid #333;
    }
</style>
</head>

<body>

<h2>{{ __('emis.emis_documents_report') }}</h2>

@foreach($documents as $document)

<table>
    <tr>                

        <td class="label">{{ __('emis.document_no') }}</td>
        <td class="value ltr">{{ $document->document_number }}</td>

        <td class="label">{{ __('emis.status') }}</td>
        <td class="value ltr">{{ $document->status }}</td>
    </tr>

    <tr>
        <td class="label">{{ __('emis.title')}}</td>
        <td colspan="3" class="value rtl">{{ $document->title }}</td>
    </tr>

    <tr>
        <td class="label">{{ __('emis.organization') }}/td>
        <td class="value rtl">{{ $document->organization }}</td>

        <td class="label">{{ __('emis.date') }}</td>
        <td class="value ltr">{{ $document->received_date }}</td>
    </tr>

    <tr>
        <td class="label">{{ __('emis.registered_by') }}</td>
        <td class="value ltr">{{ optional($document->creator)->name ?? '-' }}</td>

        <td class="label">{{ __('emis.assigned_to') }}</td>
        <td class="value ltr">{{ optional($document->assignedUser)->name ?? '-' }}</td>
    </tr>
</table>

<div class="section-title">{{ __('emis.tracking_history') }}</div>

<table class="history">
    <thead>
        <tr>
            <th>{{ __('emis.action') }}</th>
            <th>{{ __('emis.from') }}</th>
            <th>To</th>
            <th>{{ __('emis.to') }}</th>
            <th>{{ __('emis.comment') }}</th>
        </tr>
    </thead>

    <tbody>
        @forelse($document->histories as $history)
            <tr>
                <td class="ltr">{{ $history->action }}</td>
                <td class="ltr">{{ optional($history->fromUser)->name ?? '-' }}</td>
                <td class="ltr">{{ optional($history->toUser)->name ?? '-' }}</td>
                <td class="rtl">{{ $history->comments ?? '-' }}</td>
                <td class="ltr">{{ $history->created_at?->format('Y-m-d H:i:s') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">{{ __('emis.no_history_found') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>

<hr>

@endforeach

</body>
</html>