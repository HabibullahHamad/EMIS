<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    
   <style>
    body {
        font-family: dejavusans;
        direction: rtl;
        text-align: right;
        unicode-bidi: embed;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        direction: rtl;
    }

    th, td {
        border: 1px solid #333;
        padding: 6px;
        text-align: center;
        font-size: 11px;
    }

    th {
        background: #eee;
        font-weight: bold;
    }

    h3, p {
        text-align: center;
    }
</style>

</head>
<body>

<h3>{{ $title }}</h3>
<p>{{ $report_date }}</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            @foreach($fields as $field)
                <th>{{ $fieldLabels[$field] }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach($departments as $department)
            <tr>
                <td>{{ $loop->iteration }}</td>

                @foreach($fields as $field)
                    <td>
                        @if($field === 'parent')
                            {{ optional($department->parent)->name_ps ?? optional($department->parent)->name ?? '-' }}
                        @elseif($field === 'status')
                            {{ $department->status ? 'Active' : 'Inactive' }}
                        @else
                            {{ $department->$field ?? '-' }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>