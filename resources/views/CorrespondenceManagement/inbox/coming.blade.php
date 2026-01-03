@extends('new')

@section('title', 'Correspondence Tracking')

@section('content')
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Subject</th>
            <th>Type</th>
            <th>Status</th>
            <th>Assigned</th>
            <th>Deadline</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($documents as $doc)
        <tr>
            <td>{{ $doc->document_no }}</td>
            <td>{{ $doc->subject }}</td>
            <td>{{ $doc->type }}</td>
            <td>
                <span class="badge bg-{{ 
                    $doc->status=='Pending'?'warning':
                    ($doc->status=='In Progress'?'info':
                    ($doc->status=='Completed'?'success':'secondary')) }}">
                    {{ $doc->status }}
                </span>
            </td>
            <td>{{ $doc->assignedUser->name ?? '-' }}</td>
            <td>{{ $doc->deadline ?? '-' }}</td>
            <td>
                <a href="{{ route('documents.show',$doc) }}">👁</a>
                <a href="{{ route('documents.edit',$doc) }}">✏</a>

                @if($doc->status!='Archived')
                <form action="{{ route('documents.archive',$doc) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-danger">Archive</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $documents->links() }}
@endsection
