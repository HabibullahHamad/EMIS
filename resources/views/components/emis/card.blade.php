<div class="bg-white shadow-md rounded-lg p-4 border">
    
    @isset($title)
        <h2 class="text-lg font-semibold mb-2">
            {{ $title }}
        </h2>
    @endisset

    <div class="text-gray-700">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="mt-4 border-t pt-2 text-sm text-gray-500">
            {{ $footer }}
        </div>
    @endisset

</div>