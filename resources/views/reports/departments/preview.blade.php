@extends('new')

@section('content')

<div class="report-actions no-print">
    <button onclick="window.print()" class="btn btn-dark">Print</button>

    <form method="POST" action="{{ route('department.reports.exportPdf') }}" class="d-inline">
        @csrf

        <input type="hidden" name="title" value="{{ $title }}">
        <input type="hidden" name="subtitle" value="{{ $subtitle }}">
        <input type="hidden" name="report_date" value="{{ $report_date }}">
        <input type="hidden" name="prepared_by" value="{{ $prepared_by }}">
        <input type="hidden" name="orientation" value="{{ $orientation }}">
        <input type="hidden" name="show_logo" value="{{ $show_logo }}">
        <input type="hidden" name="show_prepared_by" value="{{ $show_prepared_by }}">
        <input type="hidden" name="show_date" value="{{ $show_date }}">

        @foreach($fields as $field)
            <input type="hidden" name="fields[]" value="{{ $field }}">
        @endforeach

        <button class="btn btn-danger">Export PDF</button>
    </form>
</div>

<div class="report-page">

    <div class="report-header">
        @if($show_logo)
            <img src="{{ asset('images/45.png') }}" class="report-logo">
        @endif

        <h2>{{ $title }}</h2>

        @if($subtitle)
            <p>{{ $subtitle }}</p>
        @endif

        @if($show_date)
            <p><strong>Date:</strong> {{ $report_date }}</p>
        @endif

        @if($show_prepared_by)
            <p><strong>Prepared By:</strong> {{ $prepared_by }}</p>
        @endif
    </div>

    <table class="report-table">
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
                        @elseif($field === 'created_at')
                            {{ $department->created_at?->format('Y-m-d') }}
                        @else
                            {{ $department->$field ?? '-' }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

<style>
    .report-actions {
        margin-bottom: 15px;
    }

    .report-page {
        background: #fff;
        padding: 25px;
        direction: rtl;
    }

    .report-header {
        text-align: center;
        margin-bottom: 25px;
        border-bottom: 2px solid #222;
        padding-bottom: 12px;
    }

    .report-logo {
        width: 70px;
        height: 70px;
        object-fit: contain;
        margin-bottom: 8px;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        direction: rtl;
    }

    .report-table th,
    .report-table td {
        border: 1px solid #333;
        padding: 7px;
        text-align: center;
        vertical-align: middle;
    }

    .report-table th {
        background: #f1f1f1;
        font-weight: bold;
    }

    @media print {
        body * {
            visibility: hidden !important;
        }

        .report-page,
        .report-page * {
            visibility: visible !important;
        }

        .report-page {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            padding: 10mm;
        }

        .no-print {
            display: none !important;
        }

        @page {
            size: A4 landscape;
            margin: 10mm;
        }
    }
</style>

@endsection