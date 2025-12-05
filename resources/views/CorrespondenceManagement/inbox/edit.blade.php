@extends('Welcome')
@section('content')
<div class="container">

<h3 class="mb-4">Edit Letter</h3>

<form action="{{ route('inbox.update', $inbox->id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

@include('correspondence.inbox.form', ['inbox' => $inbox])

<button class="btn btn-success mt-3">Update</button>

</form>

</div>
@endsection
