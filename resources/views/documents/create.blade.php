@extends('new')

@section('content')

<div class="container">

<h4 class="mb-3">📥 Register New Document</h4>

<div class="card p-4">

<form method="POST" enctype="multipart/form-data" action="{{ route('documents.store') }}">
@csrf

<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Title *</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Organization</label>
        <input type="text" name="organization" class="form-control">
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Subject</label>
        <textarea name="subject" class="form-control"></textarea>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Upload PDF *</label>
        <input type="file" name="file" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Priority</label>
        <select name="priority" class="form-control">
            <option value="normal">Normal</option>
            <option value="urgent">Urgent</option>
        </select>
    </div>

</div>

<button class="btn btn-success">Save Document</button>
<a href="{{ route('documents.index') }}" class="btn btn-secondary">Cancel</a>

</form>

</div>

</div>

@endsection