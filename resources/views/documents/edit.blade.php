@extends('new')

@section('content')

<div class="container">

<h4 class="mb-3">✏️ {{ __('emis.edit') }}</h4>

<div class="card p-4">

<form method="POST" enctype="multipart/form-data" action="{{ route('documents.update', $document->id) }}">
@csrf
@method('PUT')

<div class="row">

    {{-- TITLE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('emis.doc_title') }}</label>
        <input type="text" name="title" class="form-control" value="{{ $document->title }}">
    </div>

    {{-- TYPE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('emis.type') }}</label>
        <select name="type" class="form-control">
            <option value="incoming" {{ $document->type == 'incoming' ? 'selected' : '' }}>
                {{ __('emis.incoming') }}
            </option>
            <option value="outgoing" {{ $document->type == 'outgoing' ? 'selected' : '' }}>
                {{ __('emis.outgoing') }}
            </option>
        </select>
    </div>

    {{-- ORGANIZATION --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('emis.organization') }}</label>
        <input type="text" name="organization" class="form-control" value="{{ $document->organization }}">
    </div>

    {{-- RECEIVED DATE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('emis.received_date') }}</label>
        <input type="date" name="received_date" class="form-control" value="{{ $document->received_date }}">
    </div>

    {{-- SUBJECT --}}
    <div class="col-md-12 mb-3">
        <label class="form-label">{{ __('emis.subject') }}</label>
        <textarea name="subject" class="form-control">{{ $document->subject }}</textarea>
    </div>

    {{-- DUE DATE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('emis.due_date') }}</label>
        <input type="date" name="due_date" class="form-control" value="{{ $document->due_date }}">
    </div>

    {{-- PRIORITY --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('emis.priority') }}</label>
        <select name="priority" class="form-control">
            <option value="normal" {{ $document->priority == 'normal' ? 'selected' : '' }}>
                {{ __('emis.normal') }}
            </option>
            <option value="urgent" {{ $document->priority == 'urgent' ? 'selected' : '' }}>
                {{ __('emis.urgent') }}
            </option>
        </select>
    </div>

    {{-- FILE --}}
    <div class="col-md-12 mb-3">
        <label class="form-label">{{ __('emis.file') }}</label>

        @if($document->file_path)
            <p>
                <a href="{{ asset('storage/'.$document->file_path) }}" target="_blank">
                    📄 {{ __('emis.view_pdf') }}
                </a>
            </p>
        @endif

        <input type="file" name="file" class="form-control">
        <small class="text-muted">{{ __('emis.replace_file_note') }}</small>
    </div>

    {{-- REMARKS --}}
    <div class="col-md-12 mb-3">
        <label class="form-label">{{ __('emis.remarks') }}</label>
        <textarea name="remarks" class="form-control">{{ $document->remarks }}</textarea>
    </div>

</div>

<div class="d-flex gap-2">
    <button class="btn btn-success">{{ __('emis.update') }}</button>
    <a href="{{ route('documents.show', $document->id) }}" class="btn btn-secondary">{{ __('documents.cancel') }}</a>
</div>

</form>

</div>

</div>

@endsection