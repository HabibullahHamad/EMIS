


@extends('new')
@section('content')
<style>
    thead.custom-blue {
        background-color: #0d6efd;
        color: white;
    }
    tbody.custom-blue-text tr {
        color: #0d6efd;
        font-weight: bold;
    }
</style>
<div class="container mt-4">
    <h2>Inbox</h2>
 <table class="table table-bordered">

    <thead style="background-color: #04AA6D; color: #fbfcfcff;">
               <tr style="color:#0d6efd; font-weight:bold;">

                <th>Sender</th> 
                <th>Subject</th>
                <th>Date Received</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
                <tr>
                    <td>{{ $message->sender }}</td>
                    <td>{{ $message->subject }}</td>
                    <td>{{ $message->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        <a href="{{ route('correspondence.show', $message->id) }}" class="btn btn-primary btn-sm">View</a>
                        <form action="{{ route('correspondence.delete', $message->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this message?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No messages found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>



@endsection