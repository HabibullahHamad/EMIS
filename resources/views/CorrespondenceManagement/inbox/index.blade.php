@extends('new')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
<a href="{{ route('inbox.create') }}" style="color: #fefefeff; text-decoration: none; font-size: 11px; background-color: #274993ff; border-radius: 4px;padding: top 2px;">+ New Letter</a>
<h4 style="">inbox Letters</h4>
</div>
<style>
    .custom-pagination .page-link {
        color: #0d6efd;
        font-weight: 600;
        border-radius: 6px;
        padding: 6px 12px;
    }
    .custom-pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white !important;
        font-weight: bold;
    }
    .custom-pagination .page-item.disabled .page-link {
        color: #6c757d;
    }
    .custom-pagination .page-link:hover {
        background-color: #e9f0ff;
    }
</style>
<style>
    .table1 {
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        border-radius: 10px;
        width: 100%;
        margin-top: 2px;

    }
    .table1 thead tr th:first-child {
        border-top-left-radius: 12px;
    }
    .table1 thead tr th:last-child {
        border-top-right-radius: 12px;
    }
    .table1 tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }
    .table1 tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }
  
    .table1 {
        border: 2px solid #064e96ff;
        border-radius: 12px;
        margin-top: 2px;
        padding: auto;
        width: 100%;
        background: white;
    }
    .table1 thead tr {
        background: #064e96ff;
        color:white;
        font-weight: bold;
    }
    .table1 tbody tr {
        transition: background 0.2s, color 0.2s, border-radius 0.2s;
    }
    .table1 tbody tr:hover {
        background: #04419dff !important;
        color: #fcfcfcff !important;
        border-radius: 12px;
    }
    .table1 th, .table1 td {
        vertical-align: middle;
        text-align: center;
    }
</style>
<table class="table1">
<thead>
        <tr> 
           <th>Letter No</th>
            <th>Subject</th>
            <th>Sender</th>
            <th>Received</th>
            <th>Status</th>
            <th width="180">Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($inbox as $letter)
        <tr>
            <td>{{ $letter->letter_no }}</td>
            <td>{{ $letter->subject }}</td>
            <td>{{ $letter->sender }}</td>
            <td>{{ $letter->received_date }}</td>
            <td>{{ $letter->status }}</td>
         <td class="text-center">
    <!-- View -->
    <a href="{{ route('inbox.show', $letter->id) }}"
       title="View"
       class="text-info me-2">
        <i class="fa-solid fa-eye"></i>
    </a>|
    <!-- Edit -->
    <a href="{{ route('inbox.edit', $letter->id) }}"
       title="Edit"
       class="text-warning me-2">
        <i class="fa-solid fa-pen"></i>
    </a>|
    <!-- Delete -->
    <form action="{{ route('inbox.destroy', $letter->id) }}"
          method="POST"
          class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <a href="javascript:void(0)"
           title="Delete"
           class="text-danger delete-btn">
            <i class="fa-solid fa-trash"></i>
        </a>
    </form>
</td>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.delete-btn');
    if (!btn) return;

    const form = btn.closest('form');
    const row  = btn.closest('tr');

    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
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
                if (!res.ok) throw 'Delete failed';
                row.remove();
                Swal.fire('Deleted!', 'Record has been deleted.', 'success');
            })
            .catch(() => {
                Swal.fire('Error', 'Something went wrong.', 'error');
            });
        }
    });
});
</script>

    @endforeach
    </tbody>
</table>
<!-- Peganation -->
 @if ($inbox->hasPages())
    <nav>
        <ul class="pagination justify-content-center custom-pagination">
            {{-- Previous Page --}}
            @if ($inbox->onFirstPage())
                <li class="page-item disabled"><span class="page-link">«</span></li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $inbox->previousPageUrl() }}">«</a>
                </li>
            @endif
            {{-- Page Numbers --}}
            @foreach ($inbox->links()->elements[0] as $page => $url)
                @if ($page == $inbox->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
            {{-- Next Page --}}
            @if ($inbox->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $inbox->nextPageUrl() }}">»</a>
                </li>
            @else

                <li class="page-item disabled"><span class="page-link">»</span></li>
            @endif
        </ul>
    </nav>
@endif
<!-- End Peganation -->

@endsection
