@extends('new')

@section('title', 'Outbox Documents Monitoring')

@section('content')
<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Outbox Documents Monitoring</h4>
        <a href="{{ route('outbox.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Document
        </a>
    </div>

    <!-- Card -->
    <div class="card shadow-sm">
        <div class="card-body">

            <!-- Search -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search document...">
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Document No</th>
                            <th>Subject</th>
                            <th>Recipient</th>
                            <th>Date Sent</th>
                            <th>Status</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $doc->document_number }}</td>
                                <td>{{ $doc->subject }}</td>
                                <td>{{ $doc->recipient }}</td>
                                <td>{{ $doc->sent_date }}</td>
                                <td>
                                    @if($doc->status == 'Pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($doc->status == 'Sent')
                                        <span class="badge bg-success">Sent</span>
                                    @elseif($doc->status == 'Returned')
                                        <span class="badge bg-danger">Returned</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('outbox.show',$doc->id) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('outbox.edit',$doc->id) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('outbox.destroy',$doc->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No documents found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $documents->links() }}
            </div>

        </div>
    </div>
</div>
@endsection