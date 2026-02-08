@extends('new') 
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    bootstarp 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVeBo0mG1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> 

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crete Out Going </title>
</head>
<body>
    <h1>Create Outgoing Correspondence</h1>
  
    <form action="{{ route('outbox.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="recipient" class="form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient" name="recipient" required>
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">Subject:</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Body:</label>
            <textarea class="form-control" id="body" name="body" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
</body>
</html>
@endsection