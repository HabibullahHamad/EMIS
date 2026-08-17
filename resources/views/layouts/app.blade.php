@extends('new')

@section('content')
<div class="container-fluid emis-page">
    @isset($header)
        <div class="emis-page-header mb-3">
            <div>{{ $header }}</div>
        </div>
    @endisset

    {{ $slot }}
</div>
@endsection
