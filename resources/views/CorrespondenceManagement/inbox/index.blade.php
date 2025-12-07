
@extends('Welcome')
@section('content')

<h2>Inbox Letters</h2>

<a href="{{ route('inbox.create') }}" class="btn btn-primary">+ New Letter</a>

<table class="table table-bordered mt-3 border-radiused-table">
    <thead style="background-color:#e3f2fd;">
          <tr style="background-color:#0d6efd; color:white; text-align:center;">  
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
         <tbody style="color:#0d6efd; text-align:center; font-weight:bold; color: #3b86f6ff;">
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


