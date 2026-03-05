@extends('new')

@section('content')
<!DOCTYPE html>
<html lang="ar"dir="RTL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفصیل</title>

    <styele>
       
</style>
</head>
<body>

<div class="container mt-3;direction:rtl">

<h3>بشپړ معلومات</h3>
<hr>

<div class="card shadow-sm" dir="rtl">
    <div class="card-header">
        <h5 class="mb-0 bg-green">د سند معلومات</h5>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-sm mb-0">
           
            <tbody>

                <tr>
                    <th style="width:30%">شمېره</th>
                    <td>{{ $document->doc_number }}</td>
                </tr>

                <tr>
                    <th>نېټه</th>
                    <td>{{ $document->doc_date }}</td>
                </tr>

                <tr>
                    <th>ترلاسه کوونکی</th>
                    <td>{{ $document->receiver }}</td>
                </tr>

                <tr>
                    <th>موضوع</th>
                    <td>{{ $document->subject }}</td>
                </tr>

                <tr>
                    <th>تشریح</th>
                    <td>{{ $document->description }}</td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

@if($document->attachment)

<a href="{{ asset('storage/'.$document->attachment) }}" target="_blank">
Download Attachment
</a>

@endif

</div>
    
</body>
</html>
@endsection
