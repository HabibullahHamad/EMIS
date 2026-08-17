@props([
    'title' => null,
    'description' => null,
    'icon' => 'fa-solid fa-inbox',
])

<div {{ $attributes->class(['emis-empty-state']) }}>
    <span class="emis-empty-state__icon" aria-hidden="true">
        <i class="{{ $icon }}"></i>
    </span>

    @if($title)
        <h3 class="h6">{{ $title }}</h3>
    @endif

    @if($description)
        <p class="mb-0">{{ $description }}</p>
    @endif

    @isset($actions)
        <div class="emis-page-actions justify-content-center mt-3">
            {{ $actions }}
        </div>
    @endisset
</div>
