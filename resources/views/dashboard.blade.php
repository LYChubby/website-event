<x-app-layout>
    <style>
        .gradient-primary {
            background: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
        }
        .gradient-secondary {
            background: linear-gradient(135deg, #5C6AD0 0%, #684597 100%);
        }
        .gradient-text {
            background: linear-gradient(135deg, #684597, #5C6AD0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .hover-glow:hover {
            box-shadow: 0 0 30px rgba(104, 69, 151, 0.4);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
        }
        .shimmer {
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.3) 50%, transparent 70%);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>

    <!-- Background with Enhanced Gradient -->
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-indigo-50 to-blue-50">
        
        <!-- Enhanced Navbar -->
        <nav class="gradient-primary shadow-2xl sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo & Search Section -->
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 glass-effect rounded-xl flex items-center justify-center hover:scale-110 transition-transform">
                                <i class="fas fa-calendar-star text-white text-xl"></i>
                            </div>
                            <span class="text-white font-bold text-2xl tracking-wide">NEO.Vibe</span>
                        </div>

                        <form method="GET" action="{{ route('dashboard') }}" class="relative">
                            <div class="flex items-center glass-effect rounded-2xl px-6 py-3 transition-all hover:bg-white/20 focus-within:bg-white/20 min-w-80">
                                <input type="text"
                                    name="search"
                                    placeholder="Cari event yang menarik..."
                                    value="{{ request('search') }}"
                                    class="bg-transparent text-white placeholder-white/80 w-64 outline-none text-sm border-0 focus:border-0 focus:ring-0" />
                                <button type="submit" class="text-white/90 hover:text-white ml-3 hover:scale-110 transition-transform">
                                    <i class="fas fa-search text-lg"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="flex items-center space-x-4">
                        <!-- History Button -->
                        <a href="{{ route('history.index') }}"
                            class="glass-effect hover:bg-white/30 text-white px-6 py-3 rounded-2xl text-sm font-medium transition-all duration-300 hover:scale-105 hover-glow flex items-center">
                            <i class="fas fa-history mr-2"></i>Riwayat
                        </a>

                        <!-- User Dropdown -->
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-6 py-3 text-sm leading-4 font-medium rounded-2xl text-white glass-effect hover:bg-white/30 focus:outline-none transition-all duration-300 hover:scale-105">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-white/30 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-sm text-white"></i>
                                            </div>
                                            <span>{{ Auth::user()->name }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        <i class="fas fa-user-edit mr-2 text-purple-600"></i>{{ __('Profile') }}
                                    </x-dropdown-link>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="text-red-600 hover:bg-red-50">
                                            <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
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

        <section class="relative px-4 sm:px-6 lg:px-8 mt-8">
            <div class="max-w-7xl mx-auto">
                <div x-data="{ activeSlide: 0, total: {{ count($banners) }} }" class="relative rounded-3xl overflow-hidden shadow-2xl hover-glow">
                    
                    <!-- Slides -->
                    <template x-for="(banner, index) in {{ json_encode($banners) }}" :key="index">
                        <div x-show="activeSlide === index" class="relative w-full h-72 sm:h-96 transition-all duration-1000 ease-in-out">
                            <img :src="banner.image" class="absolute inset-0 w-full h-full object-cover" alt="" />
                            <div class="absolute inset-0 gradient-primary opacity-80"></div>
                            <div class="absolute inset-0 bg-black/20"></div>

                            <!-- Banner Content Overlay -->
                            <div class="absolute inset-0 flex items-center justify-center text-center px-8">
                                <div class="text-white animate-float">
                                    <h1 class="text-4xl sm:text-6xl font-bold mb-6 tracking-wide" x-text="banner.title"></h1>
                                    <p class="text-lg sm:text-2xl opacity-95 font-medium" x-text="banner.subtitle"></p>
                                    <div class="mt-8">
                                        <button class="glass-effect px-8 py-4 rounded-2xl text-white font-semibold hover:bg-white/30 transition-all duration-300 hover:scale-110">
                                            <i class="fas fa-rocket mr-2"></i>Jelajahi Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Navigation Arrows -->
                    <button @click="activeSlide = (activeSlide === 0) ? total - 1 : activeSlide - 1"
                        class="absolute left-6 top-1/2 transform -translate-y-1/2 glass-effect hover:bg-white/30 text-white p-4 rounded-full transition-all duration-300 hover:scale-125">
                        <i class="fas fa-chevron-left text-xl"></i>
                    </button>
                    <button @click="activeSlide = (activeSlide === total - 1) ? 0 : activeSlide + 1"
                        class="absolute right-6 top-1/2 transform -translate-y-1/2 glass-effect hover:bg-white/30 text-white p-4 rounded-full transition-all duration-300 hover:scale-125">
                        <i class="fas fa-chevron-right text-xl"></i>
                    </button>

                    <!-- Carousel Indicator -->
                    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3">
                        <template x-for="index in total" :key="index">
                            <button @click="activeSlide = index - 1" :class="{
                                'w-12 h-3 rounded-full bg-white shadow-lg': activeSlide === index - 1,
                                'w-3 h-3 rounded-full bg-white/50': activeSlide !== index - 1
                            }" class="transition-all duration-300"></button>
                        </template>
                    </div>
                </div>
            </div>
        </section>

        <!-- Enhanced Featured Events Section -->
        <section class="px-4 sm:px-6 lg:px-8 mt-16">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="text-4xl font-bold text-gray-800 flex items-center">
                        <div class="w-2 h-12 gradient-primary rounded-full mr-6 animate-pulse"></div>
                        <span class="gradient-text">Featured Events</span>
                    </h2>
                    <a href="#" class="gradient-primary text-white px-6 py-3 rounded-2xl font-medium flex items-center transition-all hover:scale-105 hover-glow">
                        Lihat Semua <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse ($featuredEvents as $event)
                    <div class="group bg-white/80 backdrop-blur-lg rounded-3xl overflow-hidden shadow-xl card-hover hover-glow border border-white/20">
                        <a href="{{ route('events.show', $event->event_id) }}" class="block">
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('storage/' . $event->event_image) }}"
                                    class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-700" />
                                <div class="absolute top-4 left-4">
                                    <span class="gradient-primary text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M') }}
                                    </span>
                                </div>
                                <div class="absolute top-4 right-4">
                                    <button class="w-10 h-10 glass-effect rounded-full flex items-center justify-center text-white hover:scale-110 transition-transform">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            </div>

                            <div class="p-6">
                                <div class="flex items-center text-sm text-purple-600 mb-3 font-medium">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d F Y') }}
                                </div>

                                <h3 class="font-bold text-gray-800 mb-4 group-hover:text-purple-600 transition-colors line-clamp-2 text-lg">
                                    {{ $event->name_event }}
                                </h3>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <div class="w-8 h-8 gradient-primary rounded-full flex items-center justify-center mr-3 shadow-lg">
                                            <i class="fas fa-user text-white text-xs"></i>
                                        </div>
                                        <span class="truncate font-medium">{{ $event->organizer->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-users mr-1"></i>120+
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-16">
                        <div class="w-32 h-32 gradient-primary rounded-full flex items-center justify-center mx-auto mb-6 animate-float">
                            <i class="fas fa-calendar-times text-4xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Event</h3>
                        <p class="text-gray-600 text-lg">Tidak ada event yang akan berlangsung dalam waktu dekat.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Enhanced Category Filter -->
        <section class="px-4 sm:px-6 lg:px-8 mt-20">
            <div class="max-w-7xl mx-auto">
                <!-- Title -->
                <h3 class="text-3xl font-bold text-gray-800 mb-8 flex items-center">
                    <div class="w-2 h-10 gradient-secondary rounded-full mr-6 animate-pulse"></div>
                    <span class="gradient-text">Kategori Event</span>
                </h3>

                <!-- Filter Buttons -->
                <div class="flex gap-4 mb-10 flex-wrap" id="categoryFilter">
                    <button class="filter-btn active px-8 py-4 rounded-2xl text-sm font-bold gradient-primary text-white shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-105 shimmer"
                        data-category="all">
                        <i class="fas fa-th-large mr-2"></i>Semua Kategori
                    </button>
                    @foreach ($categories as $category)
                    <button class="filter-btn px-8 py-4 rounded-2xl text-sm font-bold bg-white/60 backdrop-blur-lg text-gray-700 hover:bg-white/80 transition-all duration-300 hover:shadow-xl hover:scale-105 border border-white/30"
                        data-category="{{ $category->category_id }}">
                        <i class="fas fa-tag mr-2"></i>{{ $category->name }}
                    </button>
                    @endforeach
                </div>

                <!-- Event Grid -->
                <div id="eventGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse ($filteredEvents as $event)
                    <div class="event-card group bg-white/80 backdrop-blur-lg rounded-3xl overflow-hidden shadow-xl card-hover hover-glow border border-white/20"
                        data-category="{{ $event->category_id }}">
                        <a href="{{ route('events.show', $event->event_id) }}" class="block">
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('storage/' . $event->event_image) }}"
                                    class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-700" />
                                <div class="absolute top-4 left-4">
                                    <span class="gradient-secondary text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M') }}
                                    </span>
                                </div>
                                <div class="absolute top-4 right-4">
                                    <button class="w-10 h-10 glass-effect rounded-full flex items-center justify-center text-white hover:scale-110 transition-transform">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-purple-900/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            </div>

                            <div class="p-6">
                                <div class="flex items-center text-sm text-purple-600 mb-3 font-medium">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d F Y') }}
                                </div>

                                <h3 class="font-bold text-gray-800 mb-4 group-hover:text-purple-600 transition-colors line-clamp-2 text-lg">
                                    {{ $event->name_event }}
                                </h3>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <div class="w-8 h-8 gradient-secondary rounded-full flex items-center justify-center mr-3 shadow-lg">
                                            <i class="fas fa-user text-white text-xs"></i>
                                        </div>
                                        <span class="truncate font-medium">{{ $event->organizer->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-users mr-1"></i>{{ rand(50, 200) }}+
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-16">
                        <div class="w-32 h-32 gradient-secondary rounded-full flex items-center justify-center mx-auto mb-6 animate-float">
                            <i class="fas fa-search text-4xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Tidak Ada Event</h3>
                        <p class="text-gray-600 text-lg">Coba pilih kategori lain atau periksa kembali nanti.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Enhanced Footer -->
        <footer class="gradient-primary mt-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-white">
                    <!-- Company Info -->
                    <div class="md:col-span-2">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-12 h-12 glass-effect rounded-xl flex items-center justify-center">
                                <i class="fas fa-calendar-star text-white text-xl"></i>
                            </div>
                            <span class="text-2xl font-bold">NEO.Vibe</span>
                        </div>
                        <p class="text-white/90 text-base leading-relaxed mb-6 max-w-md">
                            Platform terpercaya untuk menemukan dan menghadiri berbagai event menarik di Indonesia. 
                            Bergabunglah dengan komunitas yang dinamis dan temukan pengalaman baru setiap hari.
                        </p>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-shield-alt mr-2 text-yellow-300"></i>
                                <span>Keamanan Terjamin</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-star mr-2 text-yellow-300"></i>
                                <span>Rating 4.9/5</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="font-bold mb-6 text-lg">Link Cepat</h4>
                        <div class="space-y-3">
                            <a href="#" class="block text-white/80 hover:text-white transition-colors text-sm hover:translate-x-2 transform duration-300">
                                <i class="fas fa-info-circle mr-3 w-4"></i>Tentang Kami
                            </a>
                            <a href="#" class="block text-white/80 hover:text-white transition-colors text-sm hover:translate-x-2 transform duration-300">
                                <i class="fas fa-fire mr-3 w-4"></i>Event Populer
                            </a>
                            <a href="#" class="block text-white/80 hover:text-white transition-colors text-sm hover:translate-x-2 transform duration-300">
                                <i class="fas fa-envelope mr-3 w-4"></i>Kontak Kami
                            </a>
                            <a href="#" class="block text-white/80 hover:text-white transition-colors text-sm hover:translate-x-2 transform duration-300">
                                <i class="fas fa-question-circle mr-3 w-4"></i>FAQ
                            </a>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h4 class="font-bold mb-6 text-lg">Ikuti Kami</h4>
                        <div class="flex space-x-4 mb-6">
                            <a href="#" class="w-12 h-12 glass-effect hover:bg-white/30 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="#" class="w-12 h-12 glass-effect hover:bg-white/30 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1">
                                <i class="fab fa-youtube text-xl"></i>
                            </a>
                            <a href="#" class="w-12 h-12 glass-effect hover:bg-white/30 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1">
                                <i class="fab fa-tiktok text-xl"></i>
                            </a>
                            <a href="#" class="w-12 h-12 glass-effect hover:bg-white/30 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1">
                                <i class="fab fa-facebook text-xl"></i>
                            </a>
                        </div>
                        <div class="glass-effect p-4 rounded-xl">
                            <p class="text-white/90 text-sm">
                                <i class="fas fa-bell mr-2"></i>Dapatkan notifikasi event terbaru!
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="border-t border-white/20 mt-12 pt-8 text-center">
                    <p class="text-white/80 text-sm">
                        © {{ date('Y') }} NEO.Vibe. Semua hak dilindungi undang-undang. 
                        <span class="text-white/60">Made with ❤️ in Indonesia</span>
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
                    // Get category from button
                    selectedCategory = this.getAttribute('data-category');

                    // Update active button with enhanced styling
                    filterButtons.forEach(btn => {
                        btn.classList.remove('active', 'gradient-primary', 'text-white', 'shimmer');
                        btn.classList.add('bg-white/60', 'text-gray-700');
                    });
                    
                    this.classList.remove('bg-white/60', 'text-gray-700');
                    this.classList.add('active', 'gradient-primary', 'text-white', 'shimmer');

                    // Show/hide cards with animation
                    eventCards.forEach(card => {
                        const cardCategory = card.getAttribute('data-category');
                        
                        if (selectedCategory === 'all' || selectedCategory === cardCategory) {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px)';
                            card.style.display = 'block';
                            
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, 100);
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(-20px)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });

            // Add smooth scroll behavior for better UX
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>