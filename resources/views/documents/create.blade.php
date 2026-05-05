@extends('new')

@section('content')

<div class="container">

<h4 class="mb-3">  {{ __('emis.register') }}</h4>

<div class="card p-4">

<form method="POST" enctype="multipart/form-data" action="{{ route('documents.store') }}">
@csrf

<div class="row">

    {{-- TITLE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('emis.doc_title') }} *</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    {{-- TYPE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('emis.type') }}</label>
        <select name="type" class="form-control">
            <option value="incoming">{{ __('emis.incoming') }}</option>
            <option value="outgoing">{{ __('emis.outgoing') }}</option>
            <option value="other">{{ __('emis.Other') }}</option>
        </select>
    </div>

    {{-- ORGANIZATION --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('emis.organization') }}</label>
        <input type="text" name="organization" class="form-control">
    </div>

    {{-- RECEIVED DATE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('emis.received_date') }}</label>
        <input type="date" name="received_date" class="form-control" value="{{ date('Y-m-d') }}">
    </div>

    {{-- SUBJECT --}}
    <div class="col-md-12 mb-3">
        <label class="form-label">{{ __('emis.subject') }}</label>
        <textarea name="subject" class="form-control"></textarea>
    </div>

    {{-- DUE DATE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('emis.due_date') }}</label>
        <input type="date" name="due_date" class="form-control">
    </div>

    {{-- PRIORITY --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('emis.priority') }}</label>
        <select name="priority" class="form-control">
            <option value="normal">{{ __('emis.normal') }}</option>
            <option value="urgent">{{ __('emis.urgent') }}</option>
        </select>
    </div>

    {{-- FILE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('emis.file') }} *</label>
        <input type="file" name="file" class="form-control" required>
    </div>

    {{-- REMARKS --}}
    <div class="col-md-12 mb-3">
        <label class="form-label">{{ __('emis.remarks') }}</label>
        <textarea name="remarks" class="form-control"></textarea>
    </div>

</div>

<div class="d-flex gap-2">
    <button class="btn btn-success">{{ __('emis.save') }}</button>
    <a href="{{ route('documents.index') }}" class="btn btn-secondary">{{ __('emis.cancel') }}</a>
</div>

</form>

</div>

</div>

@endsection