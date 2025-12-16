@extends('new')
@section('content')

<div class="container" style="margin-top: 20px; background-color: #cfe0f1ff; padding: 20px; border-radius: 11px;">
    
<button class="btn btn-primary mb-1" onclick="window.history.back();">Back to Inbox</button>
<div class="card mt-3 border-radiused-table">
    <thead class="bg-primary text-white">
        <div class="card-header" style="background-color: #cb9d04ff; color: #0472f0ff; font-weight:bold; text-align:center;">
            Letter Information
        </div>
    </thead>
    
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
