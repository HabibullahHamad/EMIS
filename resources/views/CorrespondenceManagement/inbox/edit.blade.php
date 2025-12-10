@extends('Welcome')
@section('content')



<div class="container mt-4">
    <h2>Edit Correspondence</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            Please fix the following errors:
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/CorrespondenceManagement/inbox/'.$letter->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="subject">Subject</label>
            <input id="subject" name="subject" type="text" class="form-control" value="{{ old('subject', $letter->subject) }}" required>
            @error('subject') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="sender">Sender</label>
                <input id="sender" name="sender" type="text" class="form-control" value="{{ old('sender', $letter->sender) }}">
                @error('sender') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="recipient">Recipient</label>
                <input id="recipient" name="recipient" type="text" class="form-control" value="{{ old('recipient', $letter->recipient) }}">
                @error('recipient') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="reference_no">Reference No.</label>
                <input id="reference_no" name="reference_no" type="text" class="form-control" value="{{ old('reference_no', $letter->reference_no) }}">
                @error('reference_no') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="date_sent">Date</label>
                <input id="date_sent" name="date_sent" type="date" class="form-control" value="{{ old('date_sent', optional($letter->date_sent)->format('Y-m-d')) }}">
                @error('date_sent') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="pending" {{ old('status', $letter->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('status', $letter->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="closed" {{ old('status', $letter->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="body">Message / Body</label>
            <textarea id="body" name="body" class="form-control" rows="6">{{ old('body', $letter->body) }}</textarea>
            @error('body') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="attachment">Attachment (optional)</label>
            @if($letter->attachment)
                <div class="mb-2">
                    Current file: <a href="{{ url($letter->attachment) }}" target="_blank">View</a>
                </div>
            @endif
            <input id="attachment" name="attachment" type="file" class="form-control-file">
            @error('attachment') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ url('/CorrespondenceManagement/inbox') }}" class="btn btn-secondary">Cancel</a>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </form>
</div>
@endsection
