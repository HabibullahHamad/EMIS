<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>د کارکوونکو راپور</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 1px;
            color: #222;
            direction: rtl;
            text-align: right;
        }

        .header-image {
            width: 90%;
            display: block;
            margin: 0 auto 12px auto;

           


        }

        .generated-row {
            width: 100%;
            text-align: right;
            margin: 8px 0 12px 0;
            font-size: 12px;
            font-style: italic;
            color: #555;
        }

        .summary-box {
            width: 100%;
            margin-bottom: 12px;
            border-collapse: collapse;
        }

        .summary-box td {
            border: 1px solid #cfcfcf;
            padding: 2px 2px;
            text-align: center;
            font-weight: bold;
        }

        .summary-total {
            background: #eef5fb;
        }

        .summary-active {
            background: #dff3e4;
            color: #1f7a3e;
        }

        .summary-inactive {
            background: #f9dede;
            color: #b02a37;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #999;
            padding: 1px 5px;
        }

        .report-table th {
            background: #1f4e78;
            color: white;
            text-align: center;
            height:33px;
        }

        .report-table td {
            vertical-align: middle;
            text-align: right;
            
        }

        .text-center {
            text-align: center;
        }

        .status-active {
            background: #b8dbc0;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .status-inactive {
            background: #da9ba2;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .status-other {
            background: #6c757d;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body style="direction: rtl; text-align: right; font-family: dejavusans;">

    @php
        $total = $employees->count();
        $active = $employees->filter(fn($e) => strtolower(trim($e->status ?? '')) === 'active')->count();
        $inactive = $employees->filter(fn($e) => strtolower(trim($e->status ?? '')) === 'inactive')->count();
    @endphp

    @if(file_exists(public_path('images/1.png')))
        <img src="{{ public_path('images/1.png') }}" class="header-image" alt="Report Header">
    @endif

    <div class="generated-row">
    اخیستل شوی په: {{ now()->format('Y-m-d H:i') }}
</div>

    <table class="summary-box">
    <tr>
        <td class="summary-total">ټول کارکوونکي: {{ $total }}</td>
        <td class="summary-active">فعال: {{ $active }}</td>
        <td class="summary-inactive">غیرفعال: {{ $inactive }}</td>
    </tr>
</table>

    <table class="report-table">
        <thead>
            <tr>
                
                <th style="width: 6%;">شمېره</th>
                <th style="width: 12%;">کوډ</th>
                 <th style="width: 24%;">بشپړ نوم</th>
                   <th style="width: 23%;">برېښنالیک</th>
                      <th style="width: 14%;">تلیفون</th>
                       <th style="width: 10%;">حالت</th>
                       <th style="width: 16%;">د جوړېدو نېټه</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $index => $employee)
                @php
                    $status = strtolower(trim($employee->status ?? ''));
                    $statusText = $status === 'active' ? 'فعال' : ($status === 'inactive' ? 'غیرفعال' : ($employee->status ?? 'نامعلوم'));
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $employee->employee_code }}</td>
                     <td>{{ $employee->full_name }}</td>
                      <td>{{ $employee->email ?? '-' }}</td>
                         <td>{{ $employee->phone ?? '-' }}</td>
                           <td class="{{ $status === 'active' ? 'status-active' : ($status === 'inactive' ? 'status-inactive' : 'status-other') }}">
                        {{ $statusText }}
                    </td>


                    <td class="text-center">{{ optional($employee->created_at)->format('Y-m-d H:i') }}</td>
                  
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">هیڅ کارکوونکی ونه موندل شو</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>