@extends('new')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa fa-inbox"></i>
                Create Incoming Document
            </h5>

            <a href="{{ route('inbox.index') }}" class="btn btn-sm btn-secondary">
                Back
            </a>
        </div>

        <div class="card-body">

            <form action="{{ route('inbox.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Letter No</label>
                        <input type="text" name="letter_no" class="form-control" value="{{ old('letter_no') }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">حکم نمبر / Order Number</label>
                        <input type="text" name="order_number" class="form-control" value="{{ old('order_number') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Received Date</label>
                        <input type="date" name="received_date" class="form-control" value="{{ old('received_date') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sender</label>
                        <input type="text" name="sender" class="form-control" value="{{ old('sender') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Receiver</label>
                        <input type="text" name="receiver" class="form-control" value="{{ old('receiver') }}" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="">Select</option>
                            <option value="H">High</option>
                            <option value="M">Medium</option>
                            <option value="L">Low</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="Unread">Unread</option>
                            <option value="Read">Read</option>
                            <option value="Assigned">Assigned</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Assigned To</label>
                        <input type="text" name="assigned_to" class="form-control" value="{{ old('assigned_to') }}">
                    </div>
                         </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Summary</label>
                        <textarea name="summary" class="form-control" rows="4">{{ old('summary') }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Attachments</label>
                        <input type="file" name="attachments[]" class="form-control" multiple>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    Save
                </button>

            </form>

        </div>

    </div>

</div>

@endsection