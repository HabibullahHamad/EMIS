@props([
    'title',
    'description' => null,
    'icon' => 'fa-solid fa-file-lines',
])

<header {{ $attributes->class(['emis-page-header']) }}>
    <div class="emis-page-header__identity">
        <span class="emis-page-header__icon" aria-hidden="true">
            <i class="{{ $icon }}"></i>
        </span>

        <div>
            <h1 class="emis-page-title">{{ $title }}</h1>

            @if($description)
                <p class="emis-page-description">{{ $description }}</p>
            @endif
        </div>
    </div>

    @isset($actions)
        <div class="emis-page-actions">{{ $actions }}</div>
    @endisset
</header>
