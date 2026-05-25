@extends('new')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa fa-inbox"></i>
                Incoming Document Details
            </h5>

            <a href="{{ route('inbox.index') }}" class="btn btn-sm btn-secondary">
                Back to Inbox
            </a>
        </div>

        <div class="card-body">

            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped align-middle">
                    <tbody>
                        <tr>
                            <th width="220">Letter No</th>
                            <td>{{ $inbox->letter_no }}</td>
                        </tr>

                        <tr>
                            <th>حکم نمبر / Order Number</th>
                            <td>{{ $inbox->order_number ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Subject</th>
                            <td>{{ $inbox->subject }}</td>
                        </tr>

                        <tr>
                            <th>Sender</th>
                            <td>{{ $inbox->sender }}</td>
                        </tr>

                        <tr>
                            <th>Receiver</th>
                            <td>{{ $inbox->receiver }}</td>
                        </tr>

                        <tr>
                            <th>Received Date</th>
                            <td>{{ $inbox->received_date }}</td>
                        </tr>

                        <tr>
                            <th>Priority</th>
                            <td>{{ $inbox->priority ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>{{ $inbox->status }}</td>
                        </tr>

                        <tr>
                            <th>Summary</th>
                            <td>{{ $inbox->summary ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @php
                $files = json_decode($inbox->attachment, true);

                if (!is_array($files)) {
                    $files = $inbox->attachment ? [$inbox->attachment] : [];
                }

                $names = $inbox->attachment_names ?? [];

                if (is_string($names)) {
                    $names = json_decode($names, true) ?: [];
                }
            @endphp

            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="mb-0 fw-bold">
                    <i class="fa fa-paperclip"></i>
                    Attachments
                </h5>

                @if(count($files))
                    <a href="{{ route('inbox.combinePdf', $inbox->id) }}"
                       target="_blank"
                       class="btn btn-sm btn-danger">
                        <i class="fa fa-file-pdf"></i>
                        Combine All Files
                    </a>
                @endif
            </div>

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
                                        Preview
                                    </a>
                                </td>

                                <td>
                                    <a href="{{ asset('storage/'.$file) }}"
                                       download
                                       class="btn btn-sm btn-primary">
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