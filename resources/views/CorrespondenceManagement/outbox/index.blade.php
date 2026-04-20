@extends('new')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .custom-pagination .page-link {
        color: #0d6efd;
        font-weight: 100;
        border-radius: 6px;
        padding: 1px 10px;
        margin-top: 6px;
    }

    .custom-pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white !important;
        font-weight: normal;
    }

    .custom-pagination .page-item.disabled .page-link {
        color: #6c757d;
    }

    .custom-pagination .page-link:hover {
        background-color: #e9f0ff;
    }

    .table-emis {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
        box-shadow: 0 0 5px 5px lightblue;
    }

    .table-emis thead {
        background-color: #074582;
        color: #ffffff;
        font-size: 15px;
        text-align: right;
    }

    .table-emis thead th {
        font-weight: bold;
        padding: 6px 8px;
        text-align: right;
        border-bottom: 2px solid #dee2e6;
    }

    .table-emis tbody td {
        padding: 6px 8px;
        border-bottom: 0 solid #08519a;
        vertical-align: middle;
        text-align: right;
    }

    .table-emis tbody tr:nth-child(even) {
        background-color: #ffffff;
    }

    .table-emis tbody tr:hover {
        background-color: #f4f5f7;
    }

    .table-emis tr {
        height: 32px;
    }

    .tb {
        background-color: #074582;
        padding: 4px 10px;
        border-radius: 6px;
        color: white;
        margin-right: 3px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .tb:hover {
        color: #fff;
        background-color: #0b5aa5;
    }
</style>

<div class="d-flex justify-content-start mb-2">
    <a href="{{ route('CorrespondenceManagement.outbox.create') }}" class="tb" title="{{ __('emis.create') }}">
        <i class="fa fa-plus"></i>
    </a>

    <a href="{{ route('CorrespondenceManagement.outbox.index') }}" class="tb" title="{{ __('emis.search') }}">
        <i class="fa fa-search"></i>
    </a>
    <lable class="tb" title="{{ __('emis.refresh') }}" onclick="location.reload()">
        <i class="fa-solid fa-arrows-rotate"></i>
    </lable>
     <h3 class="ms-3 mb-0" style="color:#074582; font-weight:600;">
        {{ __('emis.outbox') }} 
    </h3>  

</div>

<div class="table-responsive">
    <table class="table-emis">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>{{ __('emis.number') }}</th>
                <th>{{ __('emis.date') }}</th>
                <th>{{ __('emis.receiver') }}</th>
                <th>{{ __('emis.subject') }}</th>
                <th>{{ __('emis.actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @forelse($documents as $doc)
                <tr>
                    <td>{{ $loop->iteration + (($documents->currentPage() - 1) * $documents->perPage()) }}</td>
                    <td>{{ $doc->doc_number }}</td>
                    <td>{{ $doc->doc_date }}</td>
                    <td>{{ $doc->receiver }}</td>
                    <td>{{ $doc->subject }}</td>
                    <td>
                        <a href="{{ route('CorrespondenceManagement.outbox.show', $doc->id) }}"
                           title="{{ __('emis.view') }}"
                           class="text-info me-2">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        |

                        <a href="{{ route('CorrespondenceManagement.outbox.edit', $doc->id) }}"
                           title="{{ __('emis.edit') }}"
                           class="text-warning me-2">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        |

                        <form action="{{ route('CorrespondenceManagement.outbox.destroy', $doc->id) }}"
                              method="POST"
                              class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <a href="javascript:void(0)"
                               title="{{ __('emis.delete') }}"
                               class="text-danger delete-btn">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        {{ __('emis.no_data_found') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($documents instanceof \Illuminate\Contracts\Pagination\Paginator || $documents instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
    @if($documents->hasPages())
        <nav>
            <ul class="pagination justify-content-center custom-pagination">
                @if($documents->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">«</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $documents->previousPageUrl() }}">«</a>
                    </li>
                @endif

                @foreach ($documents->getUrlRange(1, $documents->lastPage()) as $page => $url)
                    @if ($page == $documents->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                @if($documents->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $documents->nextPageUrl() }}">»</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">»</span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.delete-btn');
    if (!btn) return;

    const form = btn.closest('form');
    const row = btn.closest('tr');

    Swal.fire({
        title: "{{ __('emis.are_you_sure') }}",
        text: "{{ __('emis.cannot_undo') }}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: "{{ __('emis.yes_delete') }}",
        cancelButtonText: "{{ __('emis.cancel') }}"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            })
            .then(res => {
                if (!res.ok) throw new Error('Delete failed');
                row.remove();

                Swal.fire(
                    "{{ __('emis.success') }}",
                    "{{ __('emis.record_deleted') }}",
                    'success'
                );
            })
            .catch(() => {
                Swal.fire(
                    "{{ __('emis.error') }}",
                    "{{ __('emis.something_went_wrong') }}",
                    'error'
                );
            });
        }
    });
});
</script>
@endsection