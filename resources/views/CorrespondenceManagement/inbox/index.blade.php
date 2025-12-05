use Illuminate\Support\Facades\DB;


@extends('Welcome')
@section('content')



<div class="container">
    <h2>Inbox Letters</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Subject</th>
                <th>Sender</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($letters as $letter)
                <tr>
                <td>{{ $letter->id }}</td>
                <td>{{ $letter->subject }}</td>
                <td>{{ $letter->sender_id }}</td>
                <td>{{ $letter->created_at }}</td>
                    <td>
                        @if($letter->attachment)
                            <a href="{{ asset('attachments/' . $letter->attachment) }}" target="_blank">View</a>
                        @else
                            No Attachment
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
