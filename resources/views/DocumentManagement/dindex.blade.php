@extends('new')

@section('content')
<div class="container">

    <h3 class="mb-4">Documents Exportation (صادره)</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ================== FORM ================== --}}
    <div class="card mb-4">
        <div class="card-header">Add New Document</div>
        <div class="card-body">
            <form method="POST" action="#" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-3">
                        <label>Document No</label>
                        <input type="text" name="doc_number" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label>Date (Shamsi)</label>
                        <input type="text" name="doc_date" id="doc_date" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label>Receiver</label>
                        <input type="text" name="receiver" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label>Attachment</label>
                        <input type="file" name="attachment" class="form-control">
                    </div>
                </div>

                <div class="mt-3">
                    <label>Subject</label>
                    <textarea name="subject" class="form-control" rows="2" required></textarea>
                </div>

                <button class="btn btn-primary mt-3">Save</button>
            </form>
        </div>
    </div>

    {{-- ================== GRID VIEW ================== --}}
    <div class="card">
        <div class="card-header">Documents List</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Doc No</th>
                        <th>Date</th>
                        <th>Receiver</th>
                        <th>Subject</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $doc)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $doc->doc_number }}</td>
                        <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($doc->doc_date)->format('Y/m/d') }}</td>
                        <td>{{ $doc->receiver }}</td>
                        <td>{{ Str::limit($doc->subject, 40) }}</td>
                        <td>
                            <a href="{{ route('export-documents.show', $doc->id) }}" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $documents->links() }}
        </div>
    </div>

</div>
@endsection