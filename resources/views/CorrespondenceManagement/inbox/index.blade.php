@extends('new')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa fa-inbox"></i>
                Incoming Documents
            </h5>

            <a href="{{ route('inbox.create') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i>
                Add New
            </a>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Letter No</th>
                            <th>حکم نمبر</th>
                            <th>Subject</th>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Date</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($inbox as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->letter_no }}</td>
                                <td>{{ $item->order_number ?? '-' }}</td>
                                <td>{{ $item->subject }}</td>
                                <td>{{ $item->sender }}</td>
                                <td>{{ $item->receiver }}</td>
                                <td>{{ $item->received_date }}</td>
                                <td class="text-center">
    @php
        $priorityClass = match($item->priority) {
            'High' => 'bg-danger',
            'Medium' => 'bg-warning text-dark',
            'Low' => 'bg-success',
            default => 'bg-secondary',
        };
    @endphp

    <span class="badge {{ $priorityClass }}">
        {{ $item->priority }}
    </span>
</td>
                                <td class="text-center">
    @php
        $statusClass = match($item->status) {
            'Unread' => 'bg-secondary',
            'Read' => 'bg-info',
            'Assigned' => 'bg-warning text-dark',
            'Completed' => 'bg-success',
            default => 'bg-dark',
        };
    @endphp

    <span class="badge {{ $statusClass }}">
        {{ $item->status }}
    </span>
</td>

                               <td class="text-center">
    <a href="{{ route('inbox.show', $item->id) }}"
       class="btn btn-sm btn-info"
       title="View">
        <i class="fa fa-eye"></i>
    </a>

    <a href="{{ route('inbox.edit', $item->id) }}"
       class="btn btn-sm btn-warning"
       title="Edit">
        <i class="fa fa-edit"></i>
    </a>

    <form action="{{ route('inbox.destroy', $item->id) }}"
          method="POST"
          class="d-inline">
        @csrf
        @method('DELETE')

        <button class="btn btn-sm btn-danger"
                title="Delete"
                onclick="return confirm('Are you sure?')">
            <i class="fa fa-trash"></i>
        </button>
    </form>
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-muted py-4">
                                    No incoming documents found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="mt-3">
                {{ $inbox->links() }}
            </div>

        </div>

    </div>

</div>

@endsection