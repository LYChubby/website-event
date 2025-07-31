<x-app-layout>
    <!-- Background Gradient -->
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100">

        <!-- Enhanced Navbar -->
        <nav class="bg-gradient-to-r from-[#63A7F4] to-[#4A90E2] shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo & Search Section -->
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-1">
                            <img src="/images/logo.png" alt="Logo" class="h-20 w-20 transition-transform hover:scale-105" />
                            <span class="text-white font-bold text-xl hidden sm:block">NEO.Vibe</span>
                        </div>

                        <form method="GET" action="{{ route('dashboard') }}" class="relative">
                            <div class="flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 transition-all hover:bg-white/30 focus-within:bg-white/30 border-none">
                                <input type="text"
                                    name="search"
                                    placeholder="Cari event yang menarik..."
                                    value="{{ request('search') }}"
                                    class="bg-transparent text-white placeholder-white/80 w-64 outline-none text-sm border-0 focus:border-0 focus:ring-0" />
                                <button type="submit" class="text-white/90 hover:text-white ml-2">
                                    <i class="fas fa-search text-sm"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="flex items-center space-x-4">
                        <!-- History Button -->
                        <a href="{{ route('login') }}"
                            class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 backdrop-blur-sm border border-white/20 hover:border-white/40">
                            <i class="fas fa-history mr-2"></i>Riwayat
                        </a>

                        @if (Auth::check())
                        @php
                        $role = Auth::user()->role;
                        $dashboardRoute = match($role) {
                        'admin' => route('admin.dashboard'),
                        'organizer' => route('organizer.dashboard'),
                        'user' => route('dashboard'),
                        default => '#'
                        };
                        @endphp

                        @if ($role !== 'user')
                        <a href="{{ $dashboardRoute }}"
                            class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 backdrop-blur-sm border border-white/20 hover:border-white/40">
                            <i class="fas fa-home mr-2"></i>Dashboard
                        </a>
                        @endif

                        <!-- User Dropdown -->
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-4 py-2 text-sm leading-4 font-medium rounded-full text-white bg-white/20 hover:bg-white/30 focus:outline-none transition-all duration-300 backdrop-blur-sm border border-white/20">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 bg-white/30 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-xs text-white"></i>
                                            </div>
                                            <span>{{ Auth::user()->name }}</span>
                                        </div>
                                        <div class="ml-2">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="bg-white rounded-lg shadow-lg border border-gray-200">
                                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-[#63A7F4] hover:text-white transition-colors">
                                            <i class="fas fa-user-edit mr-2"></i>{{ __('Profile') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="text-red-600 hover:bg-red-50 hover:text-red-700">
                                                <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Enhanced Banner Section -->
        @php
        $banners = [
        ['image' => 'storage/banner1.jpg', 'title' => 'Temukan Event Terbaik', 'subtitle' => 'Jelajahi berbagai acara menarik di sekitar Anda'],
        ['image' => 'storage/banner2.jpg', 'title' => 'Bergabung dalam Komunitas', 'subtitle' => 'Ikuti event favorit Anda sekarang juga'],
        ['image' => 'storage/banner3.jpg', 'title' => 'Eksplorasi Acara Lokal', 'subtitle' => 'Dari seminar, konser hingga workshop'],
        ];
        @endphp

        <section class="relative px-4 sm:px-6 lg:px-8 mt-6">
            <div class="max-w-7xl mx-auto">
                <div x-data="{ activeSlide: 0, total: {{ count($banners) }} }" class="relative rounded-2xl overflow-hidden shadow-xl">

                    <!-- Slides -->
                    <template x-for="(banner, index) in {{ json_encode($banners) }}" :key="index">
                        <div x-show="activeSlide === index" class="relative w-full h-64 sm:h-80 transition-all duration-700 ease-in-out">
                            <img :src="banner.image" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay bg-gradient-to-r from-[#63A7F4] to-[#4A90E2]" alt="" />
                            <div class="absolute inset-0 bg-black/30"></div>

                            <!-- Banner Content Overlay -->
                            <div class="absolute inset-0 flex items-center justify-center text-center px-6">
                                <div class="text-white">
                                    <h1 class="text-3xl sm:text-5xl font-bold mb-4" x-text="banner.title"></h1>
                                    <p class="text-lg sm:text-xl opacity-90" x-text="banner.subtitle"></p>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Navigation Arrows -->
                    <button @click="activeSlide = (activeSlide === 0) ? total - 1 : activeSlide - 1"
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white p-3 rounded-full transition-all duration-300 hover:scale-110">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button @click="activeSlide = (activeSlide === total - 1) ? 0 : activeSlide + 1"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white p-3 rounded-full transition-all duration-300 hover:scale-110">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <!-- Carousel Indicator -->
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        <template x-for="index in total" :key="index">
                            <div :class="{
                            'w-3 h-3 rounded-full bg-white': activeSlide === index - 1,
                            'w-3 h-3 rounded-full bg-white/40': activeSlide !== index - 1
                        }"></div>
                        </template>
                    </div>
                </div>
            </div>
        </section>


        <!-- Enhanced Featured Events Section -->
        <section class="px-4 sm:px-6 lg:px-8 mt-12">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                        <div class="w-1 h-8 bg-[#63A7F4] rounded-full mr-4"></div>
                        Featured Events
                    </h2>
                    <a href="#" class="text-[#63A7F4] hover:text-[#4A90E2] font-medium flex items-center transition-colors">
                        Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse ($featuredEvents as $event)
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <a href="{{ route('events.show', $event->event_id) }}" class="block">
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('storage/' . $event->event_image) }}"
                                    class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
                                <div class="absolute top-4 left-4">
                                    <span class="bg-[#63A7F4] text-white px-3 py-1 rounded-full text-xs font-medium">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M') }}
                                    </span>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>

                            <div class="p-5">
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <i class="fas fa-calendar-alt mr-2 text-[#63A7F4]"></i>
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d F Y') }}
                                </div>

                                <h3 class="font-bold text-gray-800 mb-3 group-hover:text-[#63A7F4] transition-colors line-clamp-2">
                                    {{ $event->name_event }}
                                </h3>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <div class="w-6 h-6 bg-gradient-to-r from-[#63A7F4] to-[#4A90E2] rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-user text-white text-xs"></i>
                                        </div>
                                        <span class="truncate">{{ $event->organizer->name ?? 'Unknown' }}</span>
                                    </div>
                                    <button class="text-[#63A7F4] hover:text-[#4A90E2] transition-colors">
                                        <i class="fas fa-heart text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-calendar-times text-3xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 text-lg">Tidak ada event yang akan berlangsung dalam waktu dekat.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Enhanced Category Filter -->
        <section class="px-4 sm:px-6 lg:px-8 mt-16">
            <div class="max-w-7xl mx-auto">
                <!-- Judul -->
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <div class="w-1 h-6 bg-[#63A7F4] rounded-full mr-4"></div>
                    Kategori Event
                </h3>

                <!-- Tombol Filter -->
                <div class="flex gap-3 mb-8 flex-wrap" id="categoryFilter">
                    <button class="filter-btn active px-6 py-3 rounded-full text-sm font-medium bg-gradient-to-r from-[#63A7F4] to-[#4A90E2] text-white shadow-lg transition-all duration-300 hover:shadow-lg hover:scale-105"
                        data-category="all">
                        <i class="fas fa-th-large mr-2"></i>Semua
                    </button>
                    @foreach ($categories as $category)
                    <button class="filter-btn px-6 py-3 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all duration-300 hover:shadow-lg hover:scale-105"
                        data-category="{{ $category->category_id }}">
                        {{ $category->name }}
                    </button>
                    @endforeach
                </div>

                <!-- Daftar Event -->
                <div id="eventGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse ($filteredEvents as $event)
                    <div class="event-card group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2"
                        data-category="{{ $event->category_id }}">
                        <a href="{{ route('events.show', $event->event_id) }}" class="block">
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('storage/' . $event->event_image) }}"
                                    class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
                                <div class="absolute top-4 left-4">
                                    <span class="bg-[#63A7F4] text-white px-3 py-1 rounded-full text-xs font-medium">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M') }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-5">
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <i class="fas fa-calendar-alt mr-2 text-[#63A7F4]"></i>
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d F Y') }}
                                </div>

                                <h3 class="font-bold text-gray-800 mb-3 group-hover:text-[#63A7F4] transition-colors line-clamp-2">
                                    {{ $event->name_event }}
                                </h3>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <div class="w-6 h-6 bg-gradient-to-r from-[#63A7F4] to-[#4A90E2] rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-user text-white text-xs"></i>
                                        </div>
                                        <span class="truncate">{{ $event->organizer->name ?? 'Unknown' }}</span>
                                    </div>
                                    <button class="text-[#63A7F4] hover:text-[#4A90E2] transition-colors">
                                        <i class="fas fa-heart text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12 text-gray-500">Tidak ada event.</div>
                    @endforelse
                </div>
            </div>
        </section>


        <!-- Enhanced Footer -->
        <footer class="bg-gradient-to-r from-[#63A7F4] to-[#4A90E2] mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-white">
                    <!-- Company Info -->
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <img src="/assets/logo.png" alt="Logo" class="h-8 w-auto" />
                            <span class="text-xl font-bold">EventHub</span>
                        </div>
                        <p class="text-white/80 text-sm leading-relaxed">
                            Platform terpercaya untuk menemukan dan menghadiri berbagai event menarik di Indonesia.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="font-semibold mb-4">Link Cepat</h4>
                        <div class="space-y-2">
                            <a href="#" class="block text-white/80 hover:text-white transition-colors text-sm">
                                <i class="fas fa-info-circle mr-2"></i>Tentang Kami
                            </a>
                            <a href="#" class="block text-white/80 hover:text-white transition-colors text-sm">
                                <i class="fas fa-fire mr-2"></i>Event Populer
                            </a>
                            <a href="#" class="block text-white/80 hover:text-white transition-colors text-sm">
                                <i class="fas fa-envelope mr-2"></i>Kontak Kami
                            </a>
                            <a href="#" class="block text-white/80 hover:text-white transition-colors text-sm">
                                <i class="fas fa-question-circle mr-2"></i>FAQ
                            </a>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h4 class="font-semibold mb-4">Ikuti Kami</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <i class="fab fa-tiktok"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </div>
                        <div class="mt-4">
                            <p class="text-white/60 text-xs">
                                <i class="fas fa-shield-alt mr-2"></i>Keamanan dan privasi terjamin
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="border-t border-white/20 mt-8 pt-8 text-center">
                    <p class="text-white/60 text-sm">
                        © {{ date('Y') }} EventHub. Semua hak dilindungi undang-undang.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedCategory = "all";

            const filterButtons = document.querySelectorAll('.filter-btn');
            const eventCards = document.querySelectorAll('.event-card');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Ambil kategori dari tombol
                    selectedCategory = this.getAttribute('data-category');

                    // Update tombol active
                    filterButtons.forEach(btn => btn.classList.remove('active', 'bg-gradient-to-r', 'from-[#63A7F4]', 'to-[#4A90E2]', 'text-white'));
                    this.classList.add('active', 'bg-gradient-to-r', 'from-[#63A7F4]', 'to-[#4A90E2]', 'text-white');

                    // Tampilkan / sembunyikan card
                    eventCards.forEach(card => {
                        const cardCategory = card.getAttribute('data-category');

                        if (selectedCategory === 'all' || selectedCategory === cardCategory) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>





</x-app-layout>