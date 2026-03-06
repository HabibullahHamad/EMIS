@extends('new')

@section('content')

<script>
(function setAfghanLocale(){
    function apply(){
        if (typeof persianDate === 'undefined' || typeof persianDate.toLocale !== 'function') {
            return setTimeout(apply, 100);
        }
        persianDate.toLocale('fa', {
            name: 'fa',
            months: {
                long: ['حمل','ثور','جوزا','سرطان','اسد','سنبله','میزان','عقرب','قوس','جدی','دلو','حوت'],
                short: ['حمل','ثور','جوزا','سرطان','اسد','سنبله','میزان','عقرب','قوس','جدی','دلو','حوت']
            },
            weekdays: {
                longhand: ['یکشنبه','دوشنبه','سه‌شنبه','چهارشنبه','پنج‌شنبه','جمعه','شنبه'],
                shorthand: ['ی','د','س','چ','پ','ج','ش']
            }
        });
    }
    apply();
})();
</script>
@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<script>
window.addEventListener('load', function () {
    function ready() {
        if (typeof persianDate === 'undefined' || typeof jQuery === 'undefined' || typeof jQuery.fn.persianDatepicker === 'undefined') {
            return setTimeout(ready, 100);
        }

        if (persianDate && typeof persianDate.toLocale === 'function') {
            persianDate.toLocale('fa');
        }

        $.fn.persianDatepicker.defaults = Object.assign($.fn.persianDatepicker.defaults || {}, {
            format: 'YYYY/MM/DD',
            altField: '#doc_date_hidden',
            altFormat: 'YYYY/MM/DD',
            observer: true,
            autoClose: true,
            persianDigits: true
        });

        if (!jQuery('#doc_date').data('datepicker-initialized')) {
            jQuery('#doc_date').persianDatepicker($.fn.persianDatepicker.defaults);
            jQuery('#doc_date').data('datepicker-initialized', true);
        }
    }
    ready();
});
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">

<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-date/dist/persian-date.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-datepicker/dist/js/persian-datepicker.min.js"></script>
<style>

.small-table{
    font-size:13px;
    color:blue;
    text:blue;

    
}

.small-table th,
.small-table td{
    padding:1px 1px;   /* row height small */
    vertical-align:middle;
}

.small-table th{
    background:#f4f6f9;
    font-weight:600;
}

.small-table tr:hover{
    background:#f1f7ff;
}
</style>
<div class="container">

<h3>نوی سند خوندي کړئ</h3>

<form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" style="margine:33px;">
@csrf

<div class="row g-2">

    <div class="col-md-4">
        <label class="form-label">سند ګڼه</label>
        <input type="text" name="doc_number" class="form-control form-control-sm">
    </div>


<!-- shamsi date -->
<div class="col-md-3">

<label>نېټه</label>

<input type="text" id="doc_date" class="form-control">

<input type="hidden" name="doc_date" id="doc_date_hidden">

</div>
<!-- end -->
    <div class="col-md-4">
        <label class="form-label">ترلاسه کوونکی</label>
        <input type="text" name="receiver" class="form-control form-control-sm">
    </div>

    <div class="col-md-4">
        <label class="form-label">موضوع</label>
        <input type="text" name="subject" class="form-control form-control-sm">
    </div>

    <div class="col-md-4">
        <label class="form-label">تفصیل</label>
        <textarea name="description" rows="2" class="form-control form-control-sm"></textarea>
    </div>

    <div class="col-md-4">
        <label class="form-label">مل / ضمایم</label>
        <input type="file" name="attachment" class="form-control form-control-sm">
    </div>

    <div>
        <button class="btn btn-primary btn-sm w-100">خوندي کړئ</button>
    </div>

</div>

</form>

<hr>

<h3>دسندونو لیست</h3>

<table class="table table-bordered table-sm small-table">

<thead>

<tr>
<th width="40">اي ډي</th>
<th width="120">سند نمبر</th>
<th width="110">نېټه</th>
<th width="160">ترلاسه کوونکی</th>
<th>Subject</th>
<th width="150">عمل</th>
</tr>

</thead>

<tbody>

@foreach($documents as $doc)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $doc->doc_number }}</td>

<td>{{ $doc->doc_date }}</td>
<td>{{ $doc->receiver }}</td>

<td>{{ Str::limit($doc->subject,40) }}</td>

<td>
   <!-- View -->
    <a href="{{ route('documents.show', $doc->id) }}"
       title="View"
       class="text-info me-2">
        <i class="fa-solid fa-eye"></i>
    </a>|
    <!-- Edit -->
   
    </a>|
    <!-- Delete -->
    <form action="{{ route('documents.destroy', $doc->id) }}"
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

</tr>
<!-- SWEET ALERT -->
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
        confirmButtonText: 'هو,حذف یې کړه',
        cancelButtonText:'نه ، بیرته لاړ شه '
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
                Swal.fire('حذف شو!', 'Record has been deleted.', 'success');
            })
            .catch(() => {
                Swal.fire('مشکل دي', 'Something went wrong.', 'error');
            });
        }
    });
});
</script>
<script>

$(document).ready(function(){

$("#doc_date").persianDatepicker({

format: 'YYYY/MM/DD',
altField: '#doc_date_hidden',
altFormat: 'YYYY/MM/DD',
observer: true,
autoClose: true

});

});

</script>
@endforeach

</tbody>

</table>
<div class="d-flex justify-content-center">
{{ $documents->links() }}
</div>
</div>
<script>

$(document).ready(function(){

$("#doc_date").persianDatepicker({

format: 'YYYY/MM/DD',
initialValue: true,
autoClose: true,

});

});

</script>
@endsection