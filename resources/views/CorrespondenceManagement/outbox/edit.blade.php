@extends('new')
@section('title', 'Outbox Documents Monitoring')
@section('content')
<div class="container">
    <h3>Edit Outgoing Document</h3>

    <form action="{{ route('CorrespondenceManagement.outbox.update', $document->id) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-4 mb-3">
                <label>Document Number</label>
                <input type="text" name="doc_number" class="form-control" value="{{ $document->doc_number }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control" value="{{ $document->subject }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Sender</label>
                <input type="text" name="sender" class="form-control" value="{{ $document->sender }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Receiver</label>
                <input type="text" name="receiver" class="form-control" value="{{ $document->receiver }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Document Date</label>
                <input type="date" name="doc_date" class="form-control" value="{{ $document->doc_date }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Priority</label>
                <select name="priority" class="form-control">
                    <option value="Low" {{ $document->priority == 'Low' ? 'selected' : '' }}>Low</option>
                    <option value="Medium" {{ $document->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="High" {{ $document->priority == 'High' ? 'selected' : '' }}>High</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Assigned To</label>
                <input type="text" name="assigned_to" class="form-control" value="{{ $document->assigned_to }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Department</label>
                <input type="text" name="department" class="form-control" value="{{ $document->department }}">
            </div>

            <div class="col-md-12 mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ $document->description }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label>Attachment</label>
                <input type="file" name="attachment" class="form-control">
            </div>

            @if($document->attachment)
            <div class="col-md-6 mb-3">
                <label>Current File</label><br>
                <a href="{{ asset('storage/'.$document->attachment) }}" target="_blank" class="btn btn-info">
                    View Attachment
                </a>
            </div>
            @endif

        </div>

        <button type="submit" class="btn btn-success">
            Update Document
        </button>

        <a href="{{ route('CorrespondenceManagement.outbox.index') }}" class="btn btn-secondary">
            Back
        </a>

    </form>
</div>

@endsection