@extends('Welcome')

@section('content')
<div class="container">
<button class="btn btn-primary mb-3" onclick="window.history.back();">Back to Inbox</button>
<h3>Letter Details</h3>

<div class="card mt-3">
    <div class="card-body" >
        <p><strong>Letter No:</strong> {{ $letter->letter_no }}</p>
        <p><strong>Subject:</strong> {{ $letter->subject }}</p>
        <p><strong>Sender:</strong> {{ $letter->sender }}</p>
        <p><strong>Date Received:</strong> {{ $letter->received_date }}</p>
         <p><strong>Date Received:</strong>{{ $letter->status }}</p>
        @if($letter->attachment)
        <p><strong>Attachment:</strong>
            <a href="{{ asset('storage/' . $letter->attachment) }}" target="_blank">View File</a>
        </p>
        @endif

    </div>
</div>

</div>
@endsection
