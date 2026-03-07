@extends('new')
@section('title', 'Outbox Documents Monitoring')
@section('content')
<style>
    body{
        margin-top: 1px;
        padding-top: 1px;
    }

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="d-flex align-items-center mb-1 mt-0 gap-3">
    <div class="btn-group">
        <a href="{{ route('CorrespondenceManagement.outbox.create') }}" class="btn btn-info btn-sm">
            <i class="fa fa-plus fa-sm"></i>
        </a>
         ---
        <a href="{{ route('CorrespondenceManagement.outbox.index') }}" class="btn btn-info btn-sm">
            <i class="fa fa-search fa-sm"></i>
        </a>
    </div>

    <div class="flex-grow-1 text-center">
        <h5 class="mb-0">Search Mode</h5>
    </div>
</div>


<hr style="size:30px">

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