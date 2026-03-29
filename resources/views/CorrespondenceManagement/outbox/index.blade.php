@extends('new')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1px;">

</div>
<style>
   
    .custom-pagination .page-link {
        color: #0d6efd;
        font-weight: 100;
        border-radius: 6px;
        padding: 1px 1px;
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
</style>
<style>
  
.table-emis {
    width: 100%;
    border-collapse: collapse;
    border-buttom:2px solid #0c0c0c;
    font-size: 15px;
      box-shadow: 0px 0px 5px 5px lightblue;   
}

/* Header */
.table-emis thead {
    background-color: #074582;
    color: #ffffff;
    font-size:15px;
    text-align: right;
    
}

.table-emis thead th {
    font-weight: bold;
    padding: 2px 2px;
    text-align: right;
    border-bottom: 2px solid #dee2e6;
}

/* Body Rows */
.table-emis tbody td {
    padding: 1px 1px;   /* SMALL HEIGHT */
    border-bottom: 0px solid #08519a;
    vertical-align: middle;
    text-align: right;
}

/* Zebra Style */
.table-emis tbody tr:nth-child(even) {
    background-color: #ffffff;
}

/* Hover Effect */
.table-emis tbody tr:hover {
    background-color: #f4f5f7;
}

/* Compact row height */
.table-emis tr {
    height: 25px;
}

.tb{
 background-color: #074582;
 padding: 1px 8px 1px 8px;
 border-radius:6px;
 color:white;
 weight:10px;
 margin-right:3px;
 }

</style>
<div class="d-flex justify-content-start mb-2">

    <a href="{{ route('CorrespondenceManagement.outbox.create') }}" class="tb">
        <i class="fa fa-plus"></i>
    </a>

    <a href="{{ route('CorrespondenceManagement.outbox.index') }}" class="tb">
        <i class="fa fa-search"></i>
    </a>
</div>
<div class="table-responsive shadow:2px">
    <table class="table-emis">
    <thead class="table-light">
        <tr> 
<th>#</th>
<th>Number</th>
<th>Date</th>
<th>Receiver</th>
<th>Subject</th>
<th>Action</th>

</tr>
</thead>
@foreach($documents as $doc)

<tr>

<td>{{ $loop->iteration }}</td>
<td>{{ $doc->doc_number }}</td>
<td>{{ $doc->doc_date }}</td>
<td>{{ $doc->receiver }}</td>
<td>{{ $doc->subject }}</td>


<td>
<a href="{{ route('CorrespondenceManagement.outbox.show', $doc->id) }}"
       title="View"
       class="text-info me-2">
        <i class="fa-solid fa-eye"></i>
    </a>|
    <!-- Edit -->
    <a href="{{ route('CorrespondenceManagement.outbox.edit', $doc->id) }}"
       title="Edit"
       class="text-warning me-2">
        <i class="fa-solid fa-pen"></i>
    </a>|
    <!-- Delete -->
    <form action="{{ route('CorrespondenceManagement.outbox.destroy', $doc->id) }}"
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
<div class="d-flex justify-content-center mt-0 padding-0">
    {{ $documents->links('pagination::bootstrap-5') }}
</div>

<!-- End Peganation -->

@endsection
