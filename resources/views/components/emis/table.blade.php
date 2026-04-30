<div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg">
        
        {{-- Table Head --}}
        <thead class="bg-gray-100">
            <tr>
                {{ $head }}
            </tr>
        </thead>

        {{-- Table Body --}}
        <tbody>
            {{ $slot }}
        </tbody>

    </table>
</div>