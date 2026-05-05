<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>EMIS Report</title>

    <style>
        body { font-family: DejaVu Sans; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background: #eee; }
        .title { text-align: center; font-size: 16px; margin-bottom: 10px; }
        .section { background: #ddd; padding: 5px; margin-top: 10px; }
    </style>
</head>
<body>

<div class="title">
    📄 EMIS DOCUMENTS REPORT
</div>

@foreach($documents as $doc)

<table>
    <tr>
        <th>Document No</th>
        <td>{{ $doc->document_number }}</td>

        <th>Status</th>
        <td>{{ $doc->status }}</td>
    </tr>

    <tr>
        <th>Title</th>
        <td colspan="3">{{ $doc->title }}</td>
    </tr>

    <tr>
        <th>Organization</th>
        <td>{{ $doc->organization }}</td>

        <th>Date</th>
        <td>{{ $doc->received_date }}</td>
    </tr>

    <tr>
        <th>Registered By</th>
        <td>{{ $doc->creator->name ?? '' }}</td>

        <th>Assigned To</th>
        <td>{{ $doc->assignedUser->name ?? '' }}</td>
    </tr>
</table>

{{-- TIMELINE --}}
<div class="section">Tracking History</div>

<table>
    <tr>
        <th>Action</th>
        <th>From</th>
        <th>To</th>
        <th>Comment</th>
        <th>Date</th>
    </tr>

    @foreach($doc->histories as $h)
    <tr>
        <td>{{ $h->action }}</td>
        <td>{{ $h->fromUser->name ?? '' }}</td>
        <td>{{ $h->toUser->name ?? '' }}</td>
        <td>{{ $h->comments }}</td>
        <td>{{ $h->created_at }}</td>
    </tr>
    @endforeach

</table>

<hr>

@endforeach

</body>
</html>