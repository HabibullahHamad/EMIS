@props(['type' => 'primary', 'href' => null])

@if($href)
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => 'btn emis-btn emis-btn-' . $type]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $attributes->get('type', 'button') }}"
        {{ $attributes->merge(['class' => 'btn emis-btn emis-btn-' . $type]) }}>
        {{ $slot }}
    </button>
@endif