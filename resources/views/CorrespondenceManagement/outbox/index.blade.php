@extends('new')
@section('title', 'Outbox Documents Monitoring')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="d-flex justify-content-stsrt mb-3 mt-0">

<a href="{{ route('CorrespondenceManagement.outbox.create') }}" class="btn btn-gold">
<i class="fa fa-plus"></i> 
</a>
<a href="{{ route('CorrespondenceManagement.outbox.index') }}" class="btn">
<i class="fa fa-search"></i> 
</a>
</div>
<hr style="size:30px">
<form method="GET" action="{{ route('CorrespondenceManagement.outbox.index') }}" class="mb-3">
    <div class="input-group input-group-sm">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Filter records">
        <button class="btn btn-outline-secondary" type="submit">Go</button>
    </div>
</form>
<table class="table table-bordered table-sm mt-3">

<tr>
<th>#</th>
<th>Number</th>
<th>Date</th>
<th>Receiver</th>
<th>Subject</th>
<th>Action</th>
</tr>

@foreach($documents as $doc)

<tr>

<td>{{ $loop->iteration }}</td>
<td>{{ $doc->doc_number }}</td>
<td>{{ $doc->doc_date }}</td>
<td>{{ $doc->receiver }}</td>
<td>{{ $doc->subject }}</td>

<td>

<a href="{{ route('CorrespondenceManagement.outbox.show',$doc->id) }}" class="btn btn-info btn-sm">View</a>

<a href="{{ route('CorrespondenceManagement.outbox.edit',$doc->id) }}" class="btn btn-warning btn-sm">Edit</a>

<form action="{{ route('CorrespondenceManagement.outbox.destroy',$doc->id) }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">Delete</button>

</form>

</td>

</tr>

@endforeach

</table>

{{ $documents->links() }}
@endsection