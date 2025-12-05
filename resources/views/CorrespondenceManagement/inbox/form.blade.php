
@extends('Welcome')
@section('content')
<div class="row">

<div class="col-md-6 mb-3">
    <label>Letter No</label>
    <input type="text" name="letter_no" class="form-control"
        value="{{ $inbox->letter_no ?? old('letter_no') }}">
</div>

<div class="col-md-6 mb-3">
    <label>Subject</label>
    <input type="text" name="subject" class="form-control"
        value="{{ $inbox->subject ?? old('subject') }}">
</div>

<div class="col-md-6 mb-3">
    <label>Sender Name</label>
    <input type="text" name="sender_name" class="form-control"
        value="{{ $inbox->sender_name ?? old('sender_name') }}">
</div>

<div class="col-md-6 mb-3">
    <label>Date Received</label>
    <input type="date" name="date_received" class="form-control"
        value="{{ $inbox->date_received ?? old('date_received') }}">
</div>

<div class="col-md-6 mb-3">
    <label>Priority</label>
    <select name="priority" class="form-control">
        <option value="high">High</option>
        <option value="medium">Medium</option>
        <option value="low">Low</option>
    </select>
</div>

<div class="col-md-6 mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="new">New</option>
        <option value="in_review">In Review</option>
        <option value="completed">Completed</option>
    </select>
</div>

<div class="col-md-12 mb-3">
    <label>Attachment</label>
    <input type="file" name="attachment" class="form-control">
</div>

</div>
@endsection
