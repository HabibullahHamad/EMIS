@extends('new')

@section('content')



<style>

.small-table{
    font-size:13px;
    color:blue;
    text:blue;

    
}

.small-table th,
.small-table td{
    padding:1px 1px;   /* row height small */
    vertical-align:middle;
}

.small-table th{
    background:#f4f6f9;
    font-weight:600;
}

.small-table tr:hover{
    background:#f1f7ff;
}
</style>
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

<table class="table table-bordered table-sm small-table">

<thead>

<tr>
<th width="40">#</th>
<th width="120">Number</th>
<th width="110">Date</th>
<th width="160">Receiver</th>
<th>Subject</th>
<th width="150">Action</th>
</tr>

</thead>

<tbody>

@foreach($documents as $doc)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $doc->doc_number }}</td>

<td>{{ $doc->doc_date }}</td>

<td>{{ $doc->receiver }}</td>

<td>{{ Str::limit($doc->subject,40) }}</td>

<td>

<a href="{{ route('documents.show',$doc->id) }}" 
class="btn btn-info btn-sm px-2 py-1">
View
</a>

<form action="{{ route('documents.destroy',$doc->id) }}" 
method="POST" style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm px-2 py-1">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>
<div class="d-flex justify-content-center">
{{ $documents->links() }}
</div>
</div>

@endsection