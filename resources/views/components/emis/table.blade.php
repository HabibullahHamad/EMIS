@props([
    'striped' => false,
    'hover' => true,
    'responsive' => true,
])

<div @class(['emis-table-responsive' => $responsive])>
    <table {{ $attributes->class([
        'table',
        'emis-table',
        'table-striped' => $striped,
        'table-hover' => $hover,
    ]) }}>
        @isset($head)
            <thead>
                <tr>{{ $head }}</tr>
            </thead>
        @endisset

        <tbody>{{ $slot }}</tbody>
    </table>
</div>
