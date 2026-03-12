@extends('new')
@section('content')
<div class="container">
    <h2 class="mb-4">د عاید لیکونه</h2>
    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>د لیک نمبر</th>
                <th>لیږونکی</th>
                <th>موضوع</th>
                <th>د رسیدو نیټه</th>
            </tr>
        </thead>
        <tbody>
            @foreach($letters as $letter)
            <tr onclick="window.location='{{ route('letters.show', $letter->id) }}'" style="cursor:pointer;">
                <td>{{ $letter->letter_no }}</td>
                <td>{{ $letter->sender }}</td>
                <td>{{ $letter->subject }}</td>
                <td>{{ $letter->received_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
