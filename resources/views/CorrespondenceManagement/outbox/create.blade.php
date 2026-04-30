@extends('new') 
@section('content')

<style>
.tb{
    background-color: #074582;
    padding: 1px 8px 1px 8px;
    border-radius: 6px;
    color: white;
    font-weight: 10px;
    margin-right: 3px;
    text-decoration: none;
}
</style>

<div class="d-flex justify-content-start mb-2">
    <a href="{{ route('CorrespondenceManagement.outbox.create') }}" class="tb" title="{{ __('emis.create') }}">
        <i class="fa fa-plus"></i>
    </a>

    <a href="{{ route('CorrespondenceManagement.outbox.index') }}" class="tb" title="{{ __('emis.search') }}">
        <i class="fa fa-search"></i>
    </a>
</div>

<hr>

<form action="{{ route('CorrespondenceManagement.outbox.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-2">

        <div class="col-md-4">
            <label>{{ __('emis.document_number') }}</label>
            <input type="text" name="doc_number" class="form-control" placeholder="{{ __('emis.document_number') }}">
        </div>

        <div class="col-md-4">
            <label>{{ __('emis.subject') }}</label>
            <input type="text" name="subject" class="form-control" placeholder="{{ __('emis.subject') }}">
        </div>

        <div class="col-md-4">
            <label>{{ __('emis.sender') }}</label>
            <input type="text" name="sender" class="form-control" placeholder="{{ __('emis.sender') }}">
        </div>

        <div class="col-md-4">
            <label>{{ __('emis.receiver') }}</label>
            <input type="text" name="receiver" class="form-control" placeholder="{{ __('emis.receiver') }}">
        </div>

        <div class="col-md-4">
            <label>{{ __('emis.document_date') }}</label>
            <input type="date" name="doc_date" class="form-control">
        </div>

        <div class="col-md-4">
            <label>{{ __('emis.priority') }}</label>
            <select name="priority" class="form-control">
                <option value="Low">{{ __('emis.low') }}</option>
                <option value="Normal">{{ __('emis.medium') }}</option>
                <option value="High">{{ __('emis.high') }}</option>
            </select>
        </div>

  <div class="col-md-4">
    <label>{{ __('emis.assigned_to') }}</label>
        <select name="assigned_to" class="form-control" required>
    <option value="">-- Select User --</option>
    @foreach($users as $user)
        <option value="{{ $user->id }}" {{ old('assigned_to', $document->assigned_to ?? '') == $user->id ? 'selected' : '' }}>
            {{ $user->name }} - {{ $user->email }}
        </option>
    @endforeach
</select>
</div>
        <div class="col-md-4">
            <label>{{ __('emis.department') }}</label>
            <input type="text" name="department" class="form-control" placeholder="{{ __('emis.department') }}">
        </div>

        <div class="col-md-4">
            <label>{{ __('emis.description') }}</label>
            <textarea name="description" class="form-control" placeholder="{{ __('emis.description') }}"></textarea>
        </div>

        <div class="col-md-4">
            <label>{{ __('emis.attachment') }}</label>
            <input type="file" name="attachment" class="form-control">
        </div>
    </div>

    <center class="mt-3">
        <button type="submit" class="btn btn-primary">
            {{ __('emis.save') }}
        </button>
    </center>
</form>
@endsection