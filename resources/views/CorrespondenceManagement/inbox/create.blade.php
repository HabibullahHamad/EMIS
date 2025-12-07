@extends('Welcome')

@section('content')
<div class="container">

<h3 class="mb-4">Add New Letter</h3>

<form action="{{ route('inbox.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    @include('CorrespondenceManagement.inbox.form')

    <button class="btn btn-primary mt-3">Save</button>
</form>


</div>
@endsection
