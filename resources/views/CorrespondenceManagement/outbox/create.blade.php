@extends('new') 
@section('content')

<div class="d-flex align-items-center mb-1 mt-0">
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
        <h5 class="mb-0">Insert Mode</h5>
    </div>
</div>
<hr>
<form action="{{ route('CorrespondenceManagement.outbox.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
<div class="row g-2">

<div class="col-md-4">
    <label>Document Number</label>
    <input type="text" name="doc_number" class="form-control">
</div>

<div class="col-md-4">
    <label>Subject</label>
    <input type="text" name="subject" class="form-control">
</div>

<div class="col-md-4">
    <label>Sender</label>
    <input type="text" name="sender" class="form-control">
</div>

<div class="col-md-4">
    <label>Receiver</label>
    <input type="text" name="receiver" class="form-control">
</div>

<div class="col-md-4">
    <label>Document Date</label>
    <input type="date" name="doc_date" class="form-control">
</div>

<div class="col-md-4">
    <label>Priority</label>
    <select name="priority" class="form-control">
        <option value="Low">Low</option>
        <option value="Normal">Normal</option>
        <option value="High">High</option>
    </select>
</div>

<div class="col-md-4">
    <label>Assigned To</label>
    <input type="text" name="assigned_to" class="form-control">
</div>

<div class="col-md-4">
    <label>Department</label>
    <input type="text" name="department" class="form-control">
</div>

<div class="col-md-4">
    <label>Description</label>
    <textarea name="description" class="form-control"></textarea>
</div>

<div class="col-md-4">
    <label>Attachment</label>
    <input type="file" name="attachment" class="form-control">
</div>
</div>
<center>
<button type="submit" class="btn btn-primary">
Save
</button>
</center>
</form>
@endsection