@extends('new')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                <i class="fa fa-edit"></i>
                Edit Incoming Document
            </h5>

            <a href="{{ route('inbox.index') }}"
               class="btn btn-sm btn-secondary">

                <i class="fa fa-arrow-left"></i>

                {{ __('emis.back') }}

            </a>

        </div>

        <div class="card-body">

            <form action="{{ route('inbox.update',$letter->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- LETTER NUMBER --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Letter No

                        </label>

                        <input type="text"
                               name="letter_no"
                               class="form-control"

                               value="{{ old(
                               'letter_no',
                               $letter->letter_no
                               ) }}"

                               required>

                    </div>

                    {{-- ORDER NUMBER --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            حکم نمبر / Order Number

                        </label>

                        <input type="text"
                               name="order_number"
                               class="form-control"

                               value="{{ old(
                               'order_number',
                               $letter->order_number
                               ) }}">

                    </div>

                    {{-- DATE --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Received Date

                        </label>

                        <input type="date"

                               name="received_date"

                               class="form-control"

                               value="{{ old(
                               'received_date',
                               $letter->received_date
                               ) }}"

                               required>

                    </div>

                    {{-- SENDER --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            {{ __('emis.sender') }}

                        </label>

                        <input type="text"

                               name="sender"

                               class="form-control"

                               value="{{ old(
                               'sender',
                               $letter->sender
                               ) }}"

                               required>

                    </div>

                    {{-- RECEIVER --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            {{ __('emis.receiver') }}

                        </label>

                        <input type="text"

                               name="receiver"

                               class="form-control"

                               value="{{ old(
                               'receiver',
                               $letter->receiver
                               ) }}"

                               required>

                    </div>

                    {{-- SUBJECT --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            {{ __('emis.subject') }}

                        </label>

                        <input type="text"

                               name="subject"

                               class="form-control"

                               value="{{ old(
                               'subject',
                               $letter->subject
                               ) }}"

                               required>

                    </div>

                  <div class="col-md-4 mb-3">
    <label class="form-label">{{ __('emis.priority') }}</label>

    <select name="priority" class="form-select" required>

        <option value="High"
            {{ old('priority')=='High' ? 'selected' : '' }}>
            {{ __('emis.high') }}
        </option>

        <option value="Medium"
            {{ old('priority','Medium')=='Medium' ? 'selected' : '' }}>
            {{ __('emis.medium') }}
        </option>

        <option value="Low"
            {{ old('priority')=='Low' ? 'selected' : '' }}>
            {{ __('emis.low') }}
        </option>

    </select>
</div>
                    {{-- STATUS --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            {{ __('emis.status') }}

                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="Unread"

                            {{ $letter->status=='Unread'
                            ?'selected':'' }}>

                                Unread

                            </option>

                            <option value="Read"

                            {{ $letter->status=='Read'
                            ?'selected':'' }}>

                                Read

                            </option>

                            <option value="Assigned"

                            {{ $letter->status=='Assigned'
                            ?'selected':'' }}>

                                Assigned

                            </option>

                            <option value="Completed"

                            {{ $letter->status=='Completed'
                            ?'selected':'' }}>

                                {{ __('emis.completed') }}

                            </option>

                        </select>

                    </div>

                    {{-- ASSIGNED --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            {{ __('emis.assigned_to') }}

                        </label>

                        <input type="text"

                               name="assigned_to"

                               class="form-control"

                               value="{{ old(
                               'assigned_to',
                               $letter->assigned_to
                               ) }}">

                    </div>

                    {{-- SUMMARY --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Summary

                        </label>

                        <textarea name="summary"

                                  class="form-control"

                                  rows="4">{{ old(
                                  'summary',
                                  $letter->summary
                                  ) }}</textarea>

                    </div>

                    {{-- NEW ATTACHMENTS --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            New Attachments

                        </label>

                        <input type="file"

                               name="attachments[]"

                               class="form-control"

                               multiple>

                    </div>

                </div>

                <button class="btn btn-primary">

                    <i class="fa fa-save"></i>

                    {{ __('emis.update') }}

                </button>

            </form>

        </div>

    </div>

</div>

@endsection