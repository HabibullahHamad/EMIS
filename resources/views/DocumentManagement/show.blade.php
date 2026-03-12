@extends('new')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-header">
            Document Details
        </div>
        <div class="card-body">

            <p><strong>Document No:</strong> {{ $export_document->doc_number }}</p>

            <p><strong>Date:</strong>
                {{ \Morilog\Jalali\Jalalian::fromCarbon($export_document->doc_date)->format('Y/m/d') }}
            </p>

            <p><strong>Receiver:</strong> {{ $export_document->receiver }}</p>

            <p><strong>Subject:</strong> {{ $export_document->subject }}</p>

            @if($export_document->attachment)
                <p>
                    <strong>Attachment:</strong>
                    <a href="{{ asset('storage/'.$export_document->attachment) }}" target="_blank">
                        View Attachment
                    </a>
                </p>
            @endif

            <a href="{{ route('export-documents.index') }}" class="btn btn-secondary mt-3">Back</a>
        </div>
    </div>

</div>
@endsection