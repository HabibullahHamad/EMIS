@extends('new')

@section('content')

<div class="container mt-4">

<h4 class="mb-3">📤 صادره اسناد</h4>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<form action="#" method="POST" enctype="multipart/form-data">
@csrf

<div class="row">

<div class="col-md-3">
<label>نمبر</label>
<input type="text" name="doc_number" class="form-control" required>
</div>

<div class="col-md-3">
<label>موضوع</label>
<input type="text" name="subject" class="form-control" required>
</div>

<div class="col-md-3">
<label>مرسل الیه</label>
<input type="text" name="receiver" class="form-control" required>
</div>

<div class="col-md-3">
<label>تاریخ</label>
<input type="text" name="doc_date" id="doc_date" class="form-control" required>
</div>

<div class="col-md-6 mt-2">
<label>ضمیمه</label>
<input type="file" name="attachment" class="form-control">
</div>

<div class="col-md-3 mt-4">
<button class="btn btn-primary">💾 ذخیره</button>
</div>

</div>

</form>

<hr>

<table class="table table-bordered table-striped">

<thead>

<tr>
<th>#</th>
<th>شماره</th>
<th>تاریخ</th>
<th>مرسل الیه</th>
<th>موضوع</th>
<th>مشاهده</th>
</tr>

</thead>

<tbody>


<tr>
<td>#</td>

<td>#</td>

<td>#</td>

<td>#</td>

<td>#</td>

<td>

<a href="#" class="btn btn-info btn-sm">

View

</a>

</td>

</tr>



</tbody>

</table>



</div>

@endsection
