@extends('Welcome')

@section('content')
<div class="container">

<h3>Letter Details</h3>

<div class="card mt-3">
    <div class="card-body">

        <p><strong>Letter No:</strong> {{ $inbox->letter_no }}</p>
        <p><strong>Subject:</strong> {{ $inbox->subject }}</p>
        <p><strong>Sender:</strong> {{ $inbox->sender_name }}</p>
        <p><strong>Date Received:</strong> {{ $inbox->date_received }}</p>

        @if($inbox->attachment)
        <p><strong>Attachment:</strong>
            <a href="{{ asset('storage/' . $inbox->attachment) }}" target="_blank">View File</a>
        </p>
        @endif

    </div>
</div>

</div>
@endsection
