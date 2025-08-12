<x-app-layout>
    <!-- Background putih dengan container untuk konten -->
    <div class="min-h-screen bg-white">
        <!-- Container utama dengan padding -->
        <div class="relative py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section dengan tema warna yang ada -->
            <div class="bg-gradient-to-r from-[#5C6AD0] to-[#684597] rounded-2xl p-6 mb-8 shadow-xl">
                <!-- Back Button -->
                <div class="flex items-center justify-between mb-6">
                    <button onclick="history.back()"
                        class="group w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center hover:bg-white/30 transition-all duration-300 border border-white/20 hover:border-white/30">
                        <i class="fas fa-arrow-left text-white group-hover:transform group-hover:-translate-x-0.5 transition-transform duration-300"></i>
                    </button>

                    <!-- Search Bar (jika ada) -->
                    <div class="relative hidden md:block">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-white/50"></i>
                        </div>
                        <input id="searchEventInput" type="text" placeholder="Cari event..."
                            class="bg-white/10 backdrop-blur-sm border border-white/20 text-white placeholder-white/50 rounded-xl pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/40 transition-all duration-300">
                    </div>
                </div>

                <!-- Title dengan efek gradient text -->
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                    Event dari {{ $organizer->name }}
                </h1>
                <p class="text-white/70 text-lg">Temukan event menarik yang diselenggarakan</p>
            </div>

            <!-- Search Bar Mobile -->
            <div class="md:hidden mb-6 px-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input id="searchEventInput" type="text" placeholder="Cari event..."
                        class="w-full bg-gray-100 border border-gray-200 text-gray-700 placeholder-gray-400 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#5C6AD0]/50 focus:border-[#5C6AD0] transition-all duration-300">
                </div>
            </div>

            <!-- Event Cards Grid -->
            <div id="eventCardContainer" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 px-4 md:px-0">
                @foreach ($events as $event)
                <div class="group bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-500 border border-gray-100 hover:border-[#5C6AD0]/30 hover:transform hover:scale-[1.02]">
                    <!-- Image Container dengan overlay gradient -->
                    <div class="relative overflow-hidden">
                        @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                            class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                        <div class="w-full h-52 bg-gradient-to-br from-[#5C6AD0] to-[#684597] flex items-center justify-center">
                            <div class="text-center text-white/70">
                                <i class="fas fa-image text-3xl mb-2"></i>
                                <p class="text-sm">Tidak ada gambar</p>
                            </div>
                        </div>
                        @endif

                        <!-- Overlay gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <!-- Floating badge -->
                        <div class="absolute top-4 right-4">
                            <span class="bg-gradient-to-r from-[#5C6AD0] to-[#684597] text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                Event
                            </span>
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6">
                        <!-- Event Title -->
                        <h2 class="text-xl font-bold mb-3 text-gray-800 group-hover:text-[#5C6AD0] transition-colors duration-300 line-clamp-2">
                            {{ $event->title }}
                        </h2>

                        <!-- Event Date dengan icon -->
                        <div class="flex items-center mb-3 text-gray-600">
                            <i class="fas fa-calendar-alt mr-2 text-[#5C6AD0]"></i>
                            <p class="text-sm font-medium">
                                {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                            </p>
                        </div>

                        <!-- Event Description -->
                        <p class="text-gray-500 text-sm mb-6 leading-relaxed line-clamp-3">
                            {{ Str::limit($event->description, 120) }}
                        </p>

                        <!-- Action Button dengan gradient -->
                        <a href="{{ route('events.show', $event->event_id) }}"
                            class="group/btn inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-[#5C6AD0] to-[#684597] text-white font-semibold rounded-xl hover:from-[#4A5BC4] hover:to-[#5A3F85] transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <span class="mr-2">Lihat Detail</span>
                            <i class="fas fa-arrow-right group-hover/btn:translate-x-1 transition-transform duration-300"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Loading State -->
            <div id="loading" class="text-center py-8 hidden">
                <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm">
                    <div class="animate-spin h-12 w-12 border-4 border-gray-200 border-t-[#5C6AD0] rounded-full mx-auto mb-4"></div>
                    <span class="text-gray-600 text-lg">Memuat event...</span>
                </div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-16 hidden">
                <div class="bg-white rounded-2xl p-12 border border-gray-200 shadow-sm">
                    <div class="text-gray-300 mb-6">
                        <i class="fas fa-calendar-times text-6xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-4">Belum Ada Event</h3>
                    <p class="text-gray-500 text-lg">Event dari organizer ini akan segera hadir</p>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/event-list.js'])

    <style>
        /* Custom animations dan utilities */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Line clamp utilities */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(92, 106, 208, 0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #5C6AD0, #684597);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #4A5BC4, #5A3F85);
        }

        /* Glassmorphism effect enhancement */
        .backdrop-blur-lg {
            backdrop-filter: blur(16px);
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
        }
    </style>
</x-app-layout>