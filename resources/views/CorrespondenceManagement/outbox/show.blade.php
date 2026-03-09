
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
 <tr>
<th>Attachment</th>
<td>

    @if($document->attachment)
        <a href="{{ asset('storage/'. $document->attachment) }}" target="_blank">Download File</a>
    @else
        No attachment
    @endif
    <div class="card-footer">
                    <a href="{{ route('CorrespondenceManagement.outbox.index') }}" class="btn btn-secondary">Back to Inbox</a>
                </div>
</td>
</table>
@endsection