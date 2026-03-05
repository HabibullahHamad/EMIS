@extends('new')

@section('content')




<div class="container">

<h3>Create Document</h3>

<form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" style="margine:33px;">
@csrf

<div class="row g-2">

    <div class="col-md-6">
        <label class="form-label">Document Number</label>
        <input type="text" name="doc_number" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Document Date</label>
        <input type="date" name="doc_date" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Receiver</label>
        <input type="text" name="receiver" class="form-control form-control-sm">
    </div>

    <div class="col-md-6">
        <label class="form-label">Subject</label>
        <input type="text" name="subject" class="form-control form-control-sm">
    </div>

    <div class="col-md-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="2" class="form-control form-control-sm"></textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Attachment</label>
        <input type="file" name="attachment" class="form-control form-control-sm">
    </div>

    <div class="col-md-6 d-flex align-items-end">
        <button class="btn btn-primary btn-sm w-100">Save</button>
    </div>

</div>

</form>

<hr>

<h3>Documents List</h3>

<table class="table table-bordered">

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

<a href="{{ route('documents.show',$doc->id) }}" class="btn btn-info btn-sm">
View
</a>

<form action="{{ route('documents.destroy',$doc->id) }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</table>

</div>

@endsection