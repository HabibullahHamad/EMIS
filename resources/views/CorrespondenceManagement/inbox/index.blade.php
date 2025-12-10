
@extends('Welcome')
@section('content')

<h2>Inbox Letters</h2>

<a href="{{ route('inbox.create') }}" class="btn btn-primary">+ New Letter</a>
<style>
/* table font & color */
.border-radiused-table,
.border-radiused-table th,
.border-radiused-table td {
    font-family: "B Nazanin", "BNazanin", Tahoma, Arial, sans-serif;
    font-size: 12px;
    color: #0d6efd;
}

/* table head: blue background, white text */
.border-radiused-table thead th {
    background-color: #0a48a5ff !important;
    color: #ffffff !important;
    font-weight: bold;
    text-align: center;
}

/* body cells styling */
.border-radiused-table tbody td {
    text-align: center;
    color:  #0a48a5ff;
    vertical-align: middle;
}

/* rounded corners */
.border-radiused-table {
    border-radius: 6px;
    overflow: hidden;
}
</style>
<table class="table table-bordered mt-3 border-radiused-table">
    <thead class="bg-primary text-white">

        <tr style="text-align:center; font-weight:bold; color: #0d6efd; background-color:#e3f2fd;"> 
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
         <tbody style="color:#0d6efd; text-align:center; font-weight:bold; color: #3b86f6ff;">
            <td>{{ $letter->letter_no }}</td>
            <td>{{ $letter->subject }}</td>
            <td>{{ $letter->sender }}</td>
            <td>{{ $letter->received_date }}</td>
            <td>{{ $letter->status }}</td>
            <td>
                <a href="{{ route('inbox.show',$letter->id) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('inbox.edit',$letter->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('inbox.destroy', $letter->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this)">Delete</button>

                    <!-- SweetAlert2 CDN (add once in the page) -->
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                    function confirmDelete(btn){
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This action cannot be undone.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // submit the surrounding form
                                btn.closest('form').submit();
                            }
                        });
                        return false;
                    }
                    </script>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection


