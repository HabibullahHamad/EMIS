@extends('new')

@section('page_title', __('emis.print_department') ?? 'print Department')

@section('content')
<!DOCTYPE html>
<html lang="ps" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Departments Print</title>

    <style>
        body {
            font-family: Tahoma, Arial, sans-serif;
            padding: 20px;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th, td {
            border: 1px solid #333;
            padding: 7px;
            text-align: center;
        }

        th {
            background: #f1f1f1;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<button onclick="window.print()" class="no-print">{{ __('emis.print') }}</button>

<h3>Departments Report</h3>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>نوم</th>
            <th>پښتو نوم</th>
            <th>دری نوم</th>
            <th>کوډ</th>
            <th>ډول</th>
            <th>مربوطه ریاست</th>
            <th>حالت</th>
        </tr>
    </thead>

    <tbody>
        @foreach($departments as $department)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $department->name }}</td>
                <td>{{ $department->name_ps }}</td>
                <td>{{ $department->name_fa }}</td>
                <td>{{ $department->code }}</td>
                <td>{{ $department->type }}</td>
                <td>{{ optional($department->parent)->name_ps ?? '-' }}</td>
                <td>{{ $department->status ? 'فعال' : 'غیرفعال' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
window.onload = function () {
    window.print();
};
</script>

</body>
</html>
@endsection 