@props([
    'name' => 'search',
    'placeholder' => null,
])

<form method="GET" action="{{ url()->current() }}"
      {{ $attributes->class(['emis-filter-bar']) }}>
    <div class="flex-grow-1">
        <label for="emis-global-search" class="visually-hidden">
            {{ __('emis.search') }}
        </label>

        <input
            id="emis-global-search"
            type="search"
            name="{{ $name }}"
            value="{{ request($name) }}"
            placeholder="{{ $placeholder ?: __('emis.search') }}"
            class="form-control"
        >
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
        {{ __('emis.search') }}
    </button>
</form>
