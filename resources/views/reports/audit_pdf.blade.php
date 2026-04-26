<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: dejavusans;
            font-size: 11px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f1f1f1;
            font-weight: bold;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Executive Management Information System</h2>
    <h3>Audit Logs Report</h3>
    <p>Generated At: {{ now()->format('Y-m-d H:i') }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Action</th>
            <th>Module</th>
            <th>Record ID</th>
            <th>IP Address</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
        @foreach($logs as $log)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ optional($log->user)->name ?? 'System' }}</td>
                <td>{{ ucfirst($log->action) }}</td>
                <td>{{ $log->model_type ? class_basename($log->model_type) : '-' }}</td>
                <td>{{ $log->model_id ?? '-' }}</td>
                <td>{{ $log->ip_address ?? '-' }}</td>
                <td>{{ $log->created_at?->format('Y-m-d H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>