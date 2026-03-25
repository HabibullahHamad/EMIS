@extends('new')
@section('content')
<html lang="ar" dir="rtl">




    <div class="container">
        <h3>مراسلات</h3>
        <div class="row">
            <div class="col-md-4">
                 
                <a href="{{ route('inbox.index') }}" class="btn btn-primary btn-block">وارده</a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('CorrespondenceManagement.outbox.index') }}" class="btn btn-secondary btn-block">صادر</a>
            </div>
            <div class="col-md-4">
                <a href="#" class="btn btn-info btn-block">المسودات</a>
            </div>
        </div>
    </div>
    <hr>



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  
<style>
    .table1 {
        width: 100%;
        border-collapse: collapse;
    }
    .table1 th, .table1 td {
        border: 1px solid #ddd;
        padding: 8px;
    }       
    .table1 thead {
        background-color: #f2f2f2;
    }   
    .table1 tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<div id="inbox-content">

  
    @include('CorrespondenceManagement.page1')
    

</div>


 

</body>
</html>
@endsection