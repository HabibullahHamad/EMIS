@extends('new')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Correspondence Details</h1>
            <div class="card">
                <div class="card-header">
                    <h5>{{ $inbox->subject }}</h5>
                </div>
                <div class="card-body">
                        <td></td>
          <td></td>
          <td></td>
                    <p><strong>Sender:</strong> {{$inbox->letter_no}}</p>
                    <p><strong>Recipient:</strong> {{$inbox->subject}}</p>
                    <p><strong>Sender :</strong>{{$inbox->sender}}</p>
                    <p><strong>Date Sent:</strong> {{ $inbox->created_at->format('Y-m-d H:i:s') }}</p>
                    <p><strong>Content:</strong></p>
                    <div>{{ $inbox->body }}</div>
                    @if($inbox->attachment)
                                        
                        <p><strong>Attachment:</strong> <a href="{{ asset('storage/' . $inbox->attachment) }}" target="_blank">Download</a></p>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('inbox.index') }}" class="btn btn-secondary">Back to Inbox</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection