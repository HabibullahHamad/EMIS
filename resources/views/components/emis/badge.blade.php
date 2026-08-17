
@props(['type' => 'secondary'])

<span {{ $attributes->class([
    'badge',
    'emis-badge',
    'text-bg-' . $type,
]) }}>{{ $slot }}</span>
