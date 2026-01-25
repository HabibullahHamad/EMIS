@props([
    'title' => '',
    'value' => 0,
    'color' => 'primary'
])

<div class="col-md-2 col-sm-6 mb-3">
    <div class="card border-0 shadow-sm text-center">
        <div class="card-body">
            <h6 class="text-muted mb-1">{{ $title }}</h6>
            <h3 class="fw-bold text-{{ $color }}">{{ $value }}</h3>
        </div>
        <div class="card-footer bg-{{ $color }} py-1"></div>
    </div>
</div>
