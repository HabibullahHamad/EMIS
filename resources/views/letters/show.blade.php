@extends('new')
@section('content')
<div class="container">
    <h2 class="mb-4">د لیک تفصیل: {{ $letter->letter_no }}</h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>لیږونکی:</strong> {{ $letter->sender }}</p>
            <p><strong>موضوع:</strong> {{ $letter->subject }}</p>
            <p><strong>د رسیدو نیټه:</strong> {{ $letter->received_date }}</p>
            <p><strong>تفصیل:</strong><br>{{ $letter->description }}</p>
        </div>
    </div>

    <h4>د دې لیک لپاره دنده ټاکل</h4>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('letters.assignTask', $letter->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>د دندې عنوان</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>د څانګې نوم</label>
            <select name="assigned_to" class="form-control" required>
                @foreach($departments as $dep)
                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>د دندې ختمیدو نیټه</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">دنده ټاکل</button>
    </form>

    <h4 class="mt-5">د دې لیک اړوند ټولې دندې</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-secondary">
            <tr>
                <th>د دندې عنوان</th>
                <th>څانګې ته ټاکل شوې</th>
                <th>حالت</th>
                <th>د ختمیدو نیټه</th>
            </tr>
        </thead>
        <tbody>
            @foreach($letter->tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->assignedToUser->name ?? 'N/A' }}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->due_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
