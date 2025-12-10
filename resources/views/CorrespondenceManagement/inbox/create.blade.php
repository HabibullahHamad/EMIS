@extends('Welcome')

@section('content')
<div class="container mt-4 mb-4">


<h3 class="mb-4">Add New Letter</h3>

<form action="{{ route('inbox.store') }}" method="POST" enctype="multipart/form-data" style="background-color: #cfe0f1ff; padding: 10px; border-radius: 11px;">
    @csrf

    @include('CorrespondenceManagement.inbox.form')

    <button class="btn btn-primary mt-3">Save</button>
</form>


</div>
@endsection
