@extends('new')

@section('content')

<div class="container-fluid">

    <h5 class="mb-3">Notifications</h5>

    <div class="mb-3">
        <a href="{{ route('notifications.readAll') }}" 
           onclick="event.preventDefault(); document.getElementById('readAllForm').submit();"
           class="btn btn-sm btn-success">
           Mark All as Read
        </a>

        <form id="readAllForm" method="POST" action="{{ route('notifications.readAll') }}">
            @csrf
            @method('PATCH')
        </form>
    </div>

    <div class="card shadow-sm">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($notifications as $n)
                <tr class="{{ !$n->is_read ? 'table-warning' : '' }}">
                    <td>{{ $n->title }}</td>
                    <td>{{ $n->message }}</td>
                    <td>{{ ucfirst($n->type) }}</td>
                    <td>
                        @if($n->is_read)
                            <span class="badge bg-success">Read</span>
                        @else
                            <span class="badge bg-danger">Unread</span>
                        @endif
                    </td>
                    <td>{{ $n->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        @if(!$n->is_read)
                        <form method="POST" action="{{ route('notifications.read', $n->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-primary">Read</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $notifications->links() }}
    </div>

</div>

@endsection