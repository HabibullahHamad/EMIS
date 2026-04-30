<form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2">
    <input 
        type="text" 
        name="search" 
        value="{{ request('search') }}"
        placeholder="Search..."
        class="border rounded px-3 py-2 w-64 focus:outline-none focus:ring focus:border-blue-300"
    >

    <button 
        type="submit"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
    >
        Search
    </button>
</form>