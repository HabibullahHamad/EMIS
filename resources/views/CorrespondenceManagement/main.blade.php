@extends('newe')
@section('content')
<html lang="ar" dir="rtl">

    <div class="container">
        <h1>إدارة المراسلات</h1>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('inbox.index') }}" class="btn btn-primary btn-block">صندوق الوارد</a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('outbox.index') }}" class="btn btn-secondary btn-block">صندوق الصادر</a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('drafts.index') }}" class="btn btn-info btn-block">المسودات</a>
            </div>
        </div>
    </div>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
@endsection