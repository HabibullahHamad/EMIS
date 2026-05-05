@extends('new')

@section('content')


<style>
    .btn-sm {
    padding: 4px 10px;
    font-size: 13px;
}
    .timeline {
    position: relative;
    padding-left: 40px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 18px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: #ddd;
}

.timeline-item {
    position: relative;
    margin-bottom: 25px;
}

.timeline-icon {
    position: absolute;
    left: -2px;
    top: 0;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    text-align: center;
    line-height: 35px;
    color: white;
    font-size: 16px;
}

.timeline-content {
    background: #f8f9fa;
    padding: 12px;
    border-radius: 8px;
}
    </style>

<div class="container">

<h4 class="mb-3">📄 Document Details</h4>

{{-- DETAILS --}}
<div class="card p-3 mb-3">

    <p><strong>Number:</strong> {{ $document->document_number }}</p>
    <p><strong>Title:</strong> {{ $document->title }}</p>
    <p><strong>Organization:</strong> {{ $document->organization }}</p>
    <p><strong>Status:</strong> {{ $document->status }}</p>

</div>

{{-- ACTIONS --}}
<div class="row">

    {{-- ASSIGN --}}
    <div class="col-md-4">
        <div class="card p-3 mb-3">
            <h6>Assign to Department</h6>

            <form method="POST" action="{{ route('documents.assign', $document->id) }}">
            @csrf

            <select name="user_id" class="form-control">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

            <button class="btn btn-primary mt-2 w-100">Assign</button>

            </form>
        </div>
    </div>

    {{-- RESPONSE --}}
    <div class="col-md-4">
        <div class="card p-3 mb-3">
            <h6>Department Response</h6>

            <form method="POST" action="{{ route('documents.respond', $document->id) }}">
            @csrf

            <textarea name="response" class="form-control" placeholder="Write response..."></textarea>

            <button class="btn btn-warning mt-2 w-100">Submit Response</button>

            </form>
        </div>
    </div>

    {{-- COMPLETE --}}
    <div class="col-md-4">
        <div class="card p-3 mb-3 text-center">
            <h6>Finalize</h6>

            <form method="POST" action="{{ route('documents.complete', $document->id) }}">
            @csrf

            <button class="btn btn-success w-100">Mark Completed</button>

            </form>
        </div>
    </div>

</div>
<div>
{{-- PDF --}}
<a href="{{ route('documents.view', $document->id) }}" class="btn btn-sm btn-info mb-3" target="_blank">
    <i class="fa-solid fa-file-pdf"></i> View Attachment
</a>
<a href="{{ route('documents.pdf', $document->id) }}" class="btn btn-sm btn-danger">
    <i class="fa-solid fa-download"></i> Export As PDF
</a>
</div>
{{-- TIMELINE --}}
<div class="card p-3">
@php
$steps = ['registered', 'assigned', 'responded', 'completed'];
$currentIndex = array_search($document->status, $steps);
@endphp

<div class="card p-3 mb-3">
    <div class="d-flex justify-content-between">
        @foreach($steps as $index => $step)
            <div class="text-center flex-fill">
                <div class="rounded-circle mx-auto mb-1 
                    {{ $index <= $currentIndex ? 'bg-success text-white' : 'bg-light' }}"
                    style="width:35px;height:35px;line-height:35px;">
                    {{ $index+1 }}
                </div>
                <small>{{ ucfirst($step) }}</small>
            </div>
        @endforeach
    </div>
</div>
<h5>📊 Tracking Timeline</h5>
<div class="card p-4">
    <h5 class="mb-4">📊 Tracking Timeline</h5>

    <div class="timeline">

        @foreach($document->histories as $history)

        @php
            $user = $history->fromUser;
            $avatar = $user && $user->photo 
                ? asset('storage/'.$user->photo) 
                : 'https://ui-avatars.com/api/?name='.urlencode($user->name ?? 'User');
        @endphp

        <div class="timeline-item">

            {{-- ICON --}}
            <div class="timeline-icon
                @if($history->action=='registered') bg-secondary
                @elseif($history->action=='assigned') bg-primary
                @elseif($history->action=='responded') bg-warning
                @elseif($history->action=='completed') bg-success
                @endif
            ">
                @if($history->action=='registered') 📥
                @elseif($history->action=='assigned') 🔁
                @elseif($history->action=='responded') 💬
                @elseif($history->action=='completed') ✔
                @endif
            </div>

            {{-- CONTENT --}}
            <div class="timeline-content">

                <div class="d-flex justify-content-between">
                    <strong>{{ ucfirst($history->action) }}</strong>
                    <small class="text-muted">
                        {{ $history->created_at->diffForHumans() }}
                    </small>
                </div>

                <div class="d-flex align-items-center mt-2">

                    {{-- AVATAR --}}
                    <img src="{{ $avatar }}" 
                         class="rounded-circle me-2"
                         width="40" height="40">

                    <div>

                        {{-- REGISTERED --}}
                        @if($history->action == 'registered')
                            Registered by: <strong>{{ $user->name ?? 'System' }}</strong>

                        {{-- ASSIGNED --}}
                        @elseif($history->action == 'assigned')
                            Assigned by: <strong>{{ $user->name ?? 'System' }}</strong><br>
                            To: <strong>{{ $history->toUser->name ?? 'N/A' }}</strong>

                        {{-- RESPONDED --}}
                        @elseif($history->action == 'responded')
                            Responded by: <strong>{{ $user->name ?? 'System' }}</strong>

                            @if($history->toUser)
                                <br>To: <strong>{{ $history->toUser->name }}</strong>
                            @endif

                            <br><small class="text-muted">{{ $history->comments }}</small>

                        {{-- COMPLETED --}}
                        @elseif($history->action == 'completed')
                            Completed by: <strong>{{ $user->name ?? 'System' }}</strong>
                        @endif

                    </div>

                </div>

            </div>

        </div>

        @endforeach

    </div>
</div>

</div>

</div>

@endsection<