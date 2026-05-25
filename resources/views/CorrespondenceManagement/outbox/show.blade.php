@extends('new')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa fa-paper-plane"></i>
                Outgoing Document Details
            </h5>

            {{-- ONLY ONE BACK BUTTON --}}
            <a href="{{ route('outbox.index') }}" class="btn btn-sm btn-secondary">
                <i class="fa fa-arrow-left"></i>
                Back to Outbox
            </a>
        </div>

        <div class="card-body">

            {{-- DOCUMENT INFO TABLE --}}
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped align-middle">
                    <tbody>
                        <tr>
                            <th width="220">Number</th>
                            <td>{{ $document->doc_number }}</td>
                        </tr>

                        <tr>
                            <th>Date</th>
                            <td>{{ $document->doc_date }}</td>
                        </tr>

                        <tr>
                            <th>Receiver</th>
                            <td>{{ $document->receiver }}</td>
                        </tr>

                        <tr>
                            <th>Subject</th>
                            <td>{{ $document->subject }}</td>
                        </tr>

                        <tr>
                            <th>Description</th>
                            <td>{{ $document->description ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @php
                $files = json_decode($document->attachment, true);

                if (!is_array($files)) {
                    $files = $document->attachment ? [$document->attachment] : [];
                }

                $names = $document->attachment_names ?? [];

                if (is_string($names)) {
                    $names = json_decode($names, true) ?: [];
                }
            @endphp

            {{-- ATTACHMENTS HEADER + COMBINE BUTTON --}}
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="mb-0 fw-bold">
                    <i class="fa fa-paperclip"></i>
                    Attachments
                </h5>

                @if(count($files))
                    <a href="{{ route('outbox.combinePdf', $document->id) }}"
                       target="_blank"
                       class="btn btn-sm btn-danger">
                        <i class="fa fa-file-pdf"></i>
                        Combine All Files
                    </a>
                @endif
            </div>

            {{-- FILE TABLE LIKE INBOX --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th class="text-start">File Name</th>
                            <th width="140">Preview</th>
                            <th width="140">Download</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($files as $file)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="text-start">
                                    <i class="fa fa-file me-1 text-secondary"></i>
                                    {{ $names[$loop->index] ?? basename($file) }}
                                </td>

                                <td>
                                    <a href="{{ asset('storage/'.$file) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                        Preview
                                    </a>
                                </td>

                                <td>
                                    <a href="{{ asset('storage/'.$file) }}"
                                       download
                                       class="btn btn-sm btn-primary">
                                        <i class="fa fa-download"></i>
                                        Download
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted py-4">
                                    No attachments
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>

@endsection