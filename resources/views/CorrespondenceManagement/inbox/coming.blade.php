@extends('new')

@section('title', 'Correspondence Tracking')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Correspondence Tracking</h2>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('comming.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="sender" class="form-control" placeholder="Sender" value="{{ request('sender') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="subject" class="form-control" placeholder="Subject" value="{{ request('subject') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Sender</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Assigned To</th>
                    <th>Deadline</th>
                    <th>Comments</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($correspondences as $letter)
                <tr>
                    <td>{{ $letter->id }}</td>
                    <td>{{ $letter->sender }}</td>
                    <td>{{ $letter->subject }}</td>
                    <td>
                        @if($letter->status == 'Pending')
                            <span class="badge bg-warning">{{ $letter->status }}</span>
                        @elseif($letter->status == 'In Progress')
                            <span class="badge bg-info">{{ $letter->status }}</span>
                        @else
                            <span class="badge bg-success">{{ $letter->status }}</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('comming.assign', $letter->id) }}" method="POST">
                            @csrf
                            <select name="assigned_to" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Select Staff</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if($letter->assigned_to == $user->id) selected @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td>{{ $letter->deadline ? $letter->deadline->format('Y-m-d') : '-' }}</td>
                    <td>
                        <button class="btn btn-sm btn-secondary" data-bs-toggle="collapse" data-bs-target="#comments-{{ $letter->id }}">
                            View/Add
                        </button>
                        <div class="collapse mt-2" id="comments-{{ $letter->id }}">
                            <ul class="list-group mb-2">
                                @foreach($letter->comments as $comment)
                                    <li class="list-group-item">
                                        <strong>{{ $comment->user->name }}:</strong> {{ $comment->text }} <small class="text-muted">({{ $comment->created_at->diffForHumans() }})</small>
                                    </li>
                                @endforeach
                            </ul>
                            <form action="{{ route('comming.comment', $letter->id) }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="comment" class="form-control" placeholder="Add a comment">
                                    <button class="btn btn-primary" type="submit">Send</button>
                                </div>
                            </form>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('comming.show', $letter->id) }}" class="btn btn-sm btn-info"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('comming.edit', $letter->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('comming.destroy', $letter->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $correspondences->links() }}
    </div>
</div>
@endsection
