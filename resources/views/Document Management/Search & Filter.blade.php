@extends('new')
@section('content')
{{-- resources/views/documents/index.blade.php --}}
<div class="container">

    <h4 class="mb-3">Search & Filter Documents</h4>

    {{-- Search Panel --}}
    <form method="GET" action="#" class="card card-body mb-4">

        <div class="row g-3">

            <div class="col-md-3">
                <input type="text" name="title" class="form-control"
                       placeholder="Document Title"
                       value="{{ request('title') }}">
            </div>

            <div class="col-md-2">
                <select name="document_type" class="form-select">
                    <option value="">Document Type</option>
                    <option value="Form">Form</option>
                    <option value="Report">Report</option>
                    <option value="Letter">Letter</option>
                </select>
            </div>

            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">Status</option>
                    <option value="Draft">Draft</option>
                    <option value="Submitted">Submitted</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>

            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control"
                       value="{{ request('date_from') }}">
            </div>

            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control"
                       value="{{ request('date_to') }}">
            </div>

            <div class="col-md-1 d-grid">
                <button class="btn btn-primary">Search</button>
            </div>

        </div>
    </form>

    {{-- Results Table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Directorate</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                @forelse($table as $doc)
                    <tr>
                        <td>{{ $doc->id }}</td>
                        <td>{{ $doc->title }}</td>
                        <td>{{ $doc->document_type }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $doc->status }}</span>
                        </td>
                        <td>{{ $doc->directorate }}</td>
                        <td>{{ $doc->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-info">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No records found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $documents->links() }}
    </div>

</div>
@endsection

