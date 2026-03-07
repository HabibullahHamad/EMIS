
@extends('new')
@section('content')

<link rel="stylesheet" href="{{ asset('css/show.css') }}">

<table class="table table-bordered">

<tr>
<th>Number</th>
<td>{{ $document->doc_number }}</td>
</tr>

<tr>
<th>Date</th>
<td>{{ $document->doc_date }}</td>
</tr>

<tr>
<th>Receiver</th>
<td>{{ $document->receiver }}</td>
</tr>

<tr>
<th>Subject</th>
<td>{{ $document->subject }}</td>
</tr>

<tr>
<th>Description</th>
<td>{{ $document->description }}</td>
</tr>

</table>
@endsection