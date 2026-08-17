<div {{ $attributes->class(['emis-card']) }}>
    @if(isset($title) || isset($actions))
        <div class="emis-card__header">
            @isset($title)
                <h2 class="h6 mb-0">{{ $title }}</h2>
            @endisset

            @isset($actions)
                <div class="emis-page-actions">{{ $actions }}</div>
            @endisset
        </div>
    @endif

    <div class="emis-card__body">{{ $slot }}</div>

    @isset($footer)
        <div class="emis-card__footer">{{ $footer }}</div>
    @endisset
</div>
