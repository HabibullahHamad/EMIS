@extends('new')

@section('content')

<div class="container-fluid">

   <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

    {{-- LEFT SIDE --}}
    <div class="d-flex align-items-center gap-2">

        <a href="{{ route('documents.report') }}" 
           class="btn btn-success btn-sm d-flex align-items-center gap-1">
           <i class="fa fa-file-pdf"></i>
           export
        </a>

        <a href="{{ route('documents.create') }}" 
           class="btn btn-primary btn-sm d-flex align-items-center gap-1">
            ➕ <span>Register</span>
        </a>

    </div>

    {{-- RIGHT SIDE --}}
    <h5 class="mb-0 fw-semibold text-muted">
        📄 Documents Management
    </h5>

</div>

    {{-- SEARCH --}}
    <div class="card p-3 mb-3"> 
        
        <form method="GET" class="row g-2">

            <div class="col-md-2">
                <lable class="form-label">Number</lable>
                <input type="text" name="number" value="{{ request('number') }}" class="form-control" placeholder="Number">
            </div>

            <div class="col-md-2">
                <lable class="form-label">Title</label>
                <input type="text" name="title" value="{{ request('title') }}" class="form-control" placeholder="Title">
            </div>

            <div class="col-md-2">
                <lable class="form-label">Organization</lable>
                <input type="text" name="organization" value="{{ request('organization') }}" class="form-control" placeholder="Organization">
            </div>

            <div class="col-md-2">
                <lable class="form-lable">from</lable>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
            </div>

            <div class="col-md-2">
                <lable class="form-label">To</lable>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
            </div>

            <div>
                <button class="btn btn-dark">Search</button>
            </div>
            <div>
                <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('documents.index') }}'">
                    Reset
                </button>
            </div>

        </form>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Number</th>
                        <th>Title</th>
                        <th>Organization</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($documents as $doc)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $doc->document_number }}</td>

                        <td>{{ $doc->title }}</td>

                        <td>{{ $doc->organization }}</td>

                        <td>
                            <span class="badge 
                                @if($doc->status=='completed') bg-success
                                @elseif($doc->status=='responded') bg-warning
                                @elseif($doc->status=='assigned') bg-primary
                                @else bg-secondary
                                @endif
                            ">
                                {{ $doc->status }}
                            </span>
                        </td>

                        <td>{{ $doc->received_date }}</td>

                        <td>
                            <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm btn-primary">
                                View
                            </a>

                            <a href="{{ route('documents.view', $doc->id) }}" class="btn btn-sm btn-danger">
                                PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No documents found</td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-2">
            {{ $documents->withQueryString()->links() }}
        </div>

    </div>

</div>

@endsection