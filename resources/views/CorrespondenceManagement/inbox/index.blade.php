
@extends('Welcome')
@section('content')
   <head>
<style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

 
</style>
</head>
<h2>Inbox Letters</h2>

<a href="{{ route('inbox.create') }}" class="btn btn-primary">+ New Letter</a>

<table class="table mt-3">
   <thead class="custom-thead">
        <tr>
            <th>Letter No</th>
            <th>Subject</th>
            <th>Sender</th>
            <th>Received</th>
            <th>Status</th>
            <th width="180">Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($inbox as $letter)
        <tr>
            <td>{{ $letter->letter_no }}</td>
            <td>{{ $letter->subject }}</td>
            <td>{{ $letter->sender }}</td>
            <td>{{ $letter->received_date }}</td>
            <td>{{ $letter->status }}</td>
            <td>
                <a href="{{ route('inbox.show',$letter->id) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('inbox.edit',$letter->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('inbox.destroy', $letter->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection


