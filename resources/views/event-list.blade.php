<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <button onclick="history.back()" class="w-12 h-12 bg-black bg-opacity-20 rounded-xl flex items-center justify-center hover:bg-opacity-30 transition">
            <i class="fas fa-arrow-left text-white"></i>
        </button>
        <h1 class="text-2xl font-bold mb-6">
            Event dari {{ $organizer->name }}
        </h1>

        <div id="eventCardContainer" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($events as $event)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                    Tidak ada gambar
                </div>
                @endif
                <div class="p-4">
                    <h2 class="text-lg font-semibold mb-2">{{ $event->title }}</h2>
                    <p class="text-sm text-gray-500 mb-2">
                        {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                    </p>
                    <p class="text-gray-700 text-sm mb-4">
                        {{ Str::limit($event->description, 100) }}
                    </p>
                    <a href="{{ route('events.show', $event->event_id) }}"
                        class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div id="loading" class="text-center py-4 hidden">
            <span class="text-gray-500">Memuat...</span>
        </div>
    </div>

    @vite(['resources/js/event-list.js'])
</x-app-layout>