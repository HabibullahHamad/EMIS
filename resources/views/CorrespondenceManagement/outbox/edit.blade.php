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
                <label>{{ __('emis.subject') }}</label>
                <input type="text" name="subject" class="form-control" value="{{ $document->subject }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>{{ __('emis.sender') }}</label>
                <input type="text" name="sender" class="form-control" value="{{ $document->sender }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>{{ __('emis.receiver') }}</label>
                <input type="text" name="receiver" class="form-control" value="{{ $document->receiver }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Document Date</label>
                <input type="date" name="doc_date" class="form-control" value="{{ $document->doc_date }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>{{ __('emis.priority') }}</label>
                <select name="priority" class="form-control">
                    <option value="Low" {{ $document->priority == 'Low' ? 'selected' : '' }}>{{ __('emis.low') }}</option>
                    <option value="Medium" {{ $document->priority == 'Medium' ? 'selected' : '' }}>{{ __('emis.medium') }}</option>
                    <option value="High" {{ $document->priority == 'High' ? 'selected' : '' }}>{{ __('emis.high') }}</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>{{ __('emis.assigned_to') }}</label>
                <input type="text" name="assigned_to" class="form-control" value="{{ $document->assigned_to }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>{{ __('emis.department') }}</label>
                <input type="text" name="department" class="form-control" value="{{ $document->department }}">
            </div>

            <div class="col-md-12 mb-3">
                <label>{{ __('emis.description') }}</label>
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
            {{ __('emis.back') }}
        </a>

    </form>
</div>

@endsection