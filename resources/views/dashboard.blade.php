<x-app-layout>
    <style>
        /* Custom Gradient Styles */
        .gradient-primary {
            background: linear-gradient(135deg, #5C6AD0 0%, #684597 100%);
        }

        .gradient-secondary {
            background: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #5C6AD0 0%, #684597 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hover-glow:hover {
            box-shadow: 0 0 30px rgba(92, 106, 208, 0.4);
        }

        .pulse-border {
            animation: pulse-border 2s infinite;
        }

        @keyframes pulse-border {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(92, 106, 208, 0.2);
            }

            50% {
                box-shadow: 0 0 40px rgba(104, 69, 151, 0.4);
            }
        }

        .hover-lift:hover {
            transform: translateY(-5px);
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .search-glow:focus {
            box-shadow: 0 0 20px rgba(92, 106, 208, 0.3);
            border-color: #5C6AD0;
        }

        .event-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.95) 100%);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(92, 106, 208, 0.2);
        }

        .category-card {
            background: linear-gradient(135deg, rgba(92, 106, 208, 0.1) 0%, rgba(104, 69, 151, 0.1) 100%);
            border: 1px solid rgba(92, 106, 208, 0.2);
            transition: all 0.3s ease;
        }

        .category-card:hover {
            background: linear-gradient(135deg, rgba(92, 106, 208, 0.2) 0%, rgba(104, 69, 151, 0.2) 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(92, 106, 208, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #5C6AD0 0%, #684597 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4A5BC4 0%, #5A3C85 100%);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, rgba(92, 106, 208, 0.1) 0%, rgba(104, 69, 151, 0.1) 100%);
            border: 1px solid rgba(92, 106, 208, 0.3);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #5C6AD0 0%, #684597 100%);
            color: white !important;
        }

        .banner-overlay {
            background: linear-gradient(135deg, rgba(92, 106, 208, 0.8) 0%, rgba(104, 69, 151, 0.8) 100%);
        }

        .section-bg {
            background: linear-gradient(135deg, rgba(92, 106, 208, 0.02) 0%, rgba(104, 69, 151, 0.02) 100%);
        }

        .notification-modal {
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .notification-modal.show {
            opacity: 1;
            visibility: visible;
        }

        .notification-modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            cursor: pointer;
        }

        .notification-modal-content {
            position: relative;
            width: 90%;
            max-width: 28rem;
            max-height: 80vh;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            transform: translateY(20px);
            transition: transform 0.3s ease;
            z-index: 50;
        }

        .notification-modal.show .notification-modal-content {
            transform: translateY(0);
        }

        @media (min-width: 640px) {
            .notification-modal-content {
                width: 100%;
            }
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50" x-data="notificationData()">
        <!-- Enhanced Navigation -->
        <nav class="bg-white/80 backdrop-filter backdrop-blur-lg shadow-lg sticky top-0 z-50 border-b border-white/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo & Search Section -->
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center space-x-3 group">
                            <div class="relative">
                                <img src="/images/logo.png" alt="Logo" class="h-8 w-auto transition-all duration-300 group-hover:scale-110" />
                                <div class="gradient-primary  opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                            </div>
                            <span class="gradient-text font-bold text-3xl tracking-wide">NEO.Vibe</span>
                        </div>

                        <form method="GET" action="{{ route('dashboard') }}" class="relative">
                            <div class="hidden md:block">
                                <div class="relative">
                                    <input type="text" placeholder="Cari event impian Anda..."
                                        class="search-glow w-80 px-6 py-3 pl-12 rounded-2xl border border-gray-200 focus:outline-none text-gray-700 placeholder-gray-400 bg-white/70 backdrop-blur-sm transition-all duration-300" />
                                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Enhanced Navigation Menu -->
                    <div class="flex items-center space-x-4">
                        <!-- List Organizer -->
                        <a href="{{ route('organizer-list') }}"
                            class="btn-primary text-white px-6 py-3 rounded-2xl text-sm font-medium transition-all duration-300 hover:scale-105 hover-glow flex items-center shadow-lg">
                            <i class="fa-solid fa-users mr-2"></i>Daftar Organizer
                        </a>

                        <!-- History Button -->
                        <a href="{{ route('history.index') }}"
                            class="btn-primary text-white px-6 py-3 rounded-2xl text-sm font-medium transition-all duration-300 hover:scale-105 hover-glow flex items-center shadow-lg">
                            <i class="fas fa-history mr-2"></i>Riwayat
                        </a>

                        <!-- Enhanced User Dropdown -->
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="btn-secondary text-[#5C6AD0] px-6 py-3 rounded-2xl text-sm font-medium transition-all duration-300 hover:scale-105 hover-glow flex items-center gap-3 group shadow-md">
                                        <div class="w-8 h-8 gradient-primary rounded-full flex items-center justify-center shadow-sm">
                                            <i class="fas fa-user text-xs text-white"></i>
                                        </div>
                                        <span class="transition-colors duration-300 group-hover:text-white text-[#5C6AD0] truncate max-w-[120px] font-semibold">
                                            {{ Auth::user()->name }}
                                        </span>
                                        <svg class="fill-current h-4 w-4 text-[#5C6AD0] transition-all duration-300 group-hover:text-white group-hover:rotate-180 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="glass-effect rounded-lg border-0 shadow-xl">
                                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-gradient-to-r hover:from-purple-50 hover:to-blue-50">
                                            <i class="fas fa-user-edit mr-3 text-purple-600"></i>{{ __('Profile') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="text-red-600 hover:bg-red-50">
                                                <i class="fas fa-sign-out-alt mr-3"></i>{{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <!-- Notification Button -->
                        <div class="relative">
                            <button @click="openNotif = true; loadNotifications()"
                                class="relative btn-secondary text-[#5C6AD0] px-4 py-3 rounded-2xl text-sm font-medium transition-all duration-300 hover:scale-105 hover-glow flex items-center shadow-md">
                                <i class="fas fa-bell"></i>
                                <!-- Badge jumlah notifikasi - Diperbaiki untuk selalu menampilkan jumlah notifikasi yang belum dibaca -->
                                <span x-show="unreadCount > 0"
                                    x-text="unreadCount"
                                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Modal Notification -->
        <div x-show="openNotif"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="notification-modal"
            :class="{ 'show': openNotif }"
            @click.away="openNotif = false">
            <!-- Overlay -->
            <div class="notification-modal-overlay" @click="openNotif = false"></div>

            <!-- Modal Box -->
            <div class="notification-modal-content">
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold gradient-text">Notifikasi</h2>
                    <button @click="openNotif = false" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- List Notifikasi -->
                <div class="p-6 max-h-96 overflow-y-auto">
                    <template x-if="notifications.length === 0">
                        <p class="text-gray-500 text-center py-6">Tidak ada notifikasi</p>
                    </template>

                    <div class="space-y-4">
                        <template x-for="notif in notifications" :key="notif.notification_id">
                            <div class="p-4 rounded-xl border"
                                :class="notif.is_read ? 'bg-gray-50 border-gray-200' : 'bg-purple-50 border-purple-200'">
                                <h3 class="font-semibold text-gray-800" x-text="notif.title"></h3>
                                <p class="text-gray-600 text-sm" x-text="notif.message"></p>
                                <div class="flex justify-between items-center mt-2 text-xs text-gray-400">
                                    <span x-text="new Date(notif.created_at).toLocaleString()"></span>
                                    <button x-show="notif.is_read == 0"
                                        @click="markAsRead(notif.notification_id, notif)"
                                        class="text-blue-600 hover:underline">
                                        Tandai dibaca
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

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
                <div x-data="{ activeSlide: 0, total: {{ count($banners) }} }" class="relative rounded-3xl overflow-hidden shadow-2xl pulse-border hover-lift glass-card">

                    <!-- Enhanced Slides -->
                    <template x-for="(banner, index) in {{ json_encode($banners) }}" :key="index">
                        <div x-show="activeSlide === index" class="relative w-full h-80 sm:h-[500px] transition-all duration-1000 ease-in-out">
                            <img :src="banner.image" class="absolute inset-0 w-full h-full object-cover" alt="" />
                            <div class="absolute inset-0 banner-overlay"></div>

                            <!-- Animated Particles -->
                            <div class="absolute inset-0 overflow-hidden">
                                <div class="absolute top-10 left-10 w-2 h-2 bg-white/30 rounded-full animate-ping"></div>
                                <div class="absolute top-20 right-20 w-1 h-1 bg-white/40 rounded-full animate-pulse"></div>
                                <div class="absolute bottom-20 left-20 w-3 h-3 bg-white/20 rounded-full animate-bounce"></div>
                            </div>

                            <!-- Enhanced Banner Content -->
                            <div class="absolute inset-0 flex items-center justify-center text-center px-8">
                                <div class="text-white animate-float max-w-4xl">
                                    <div class="mb-6">
                                        <div class="inline-block p-3 rounded-full glass-effect mb-4">
                                            <i class="fas fa-star text-2xl"></i>
                                        </div>
                                    </div>
                                    <h1 class="text-4xl sm:text-7xl font-bold mb-8 tracking-wide leading-tight drop-shadow-2xl" x-text="banner.title"></h1>
                                    <p class="text-lg sm:text-2xl opacity-95 font-medium mb-8 drop-shadow-lg" x-text="banner.subtitle"></p>

                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Enhanced Navigation Arrows -->
                    <button @click="activeSlide = (activeSlide === 0) ? total - 1 : activeSlide - 1"
                        class="absolute left-6 top-1/2 transform -translate-y-1/2 glass-effect hover:bg-white/30 text-white p-4 rounded-full transition-all duration-300 hover:scale-125 shadow-xl">
                        <i class="fas fa-chevron-left text-xl"></i>
                    </button>
                    <button @click="activeSlide = (activeSlide === total - 1) ? 0 : activeSlide + 1"
                        class="absolute right-6 top-1/2 transform -translate-y-1/2 glass-effect hover:bg-white/30 text-white p-4 rounded-full transition-all duration-300 hover:scale-125 shadow-xl">
                        <i class="fas fa-chevron-right text-xl"></i>
                    </button>

                    <!-- Enhanced Carousel Indicators -->
                    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
                        <template x-for="index in total" :key="index">
                            <button @click="activeSlide = index - 1" :class="{
                                'w-12 h-3 rounded-full bg-white shadow-lg': activeSlide === index - 1,
                                'w-3 h-3 rounded-full bg-white/50 hover:bg-white/70': activeSlide !== index - 1
                            }" class="transition-all duration-300"></button>
                        </template>
                    </div>
                </div>
            </div>
        </section>

        <!-- Enhanced Content Sections -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
            <!-- Featured Events Section -->
            <div class="section-bg rounded-3xl p-8 mb-16">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-4xl font-bold gradient-text mb-2">Featured Events</h2>
                        <p class="text-gray-600">Acara pilihan terbaik untuk Anda</p>
                    </div>
                    <a href="{{ route('events.index', ['scope' => 'featured']) }}"
                        class="btn-primary text-white px-6 py-3 rounded-2xl font-semibold transition-all duration-300 hover:scale-105 hover-glow shadow-lg">
                        <i class="fas fa-arrow-right mr-2"></i>Lihat Semua
                    </a>
                </div>

                @if($featuredEvents->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-32 h-32 mx-auto mb-6 flex items-center justify-center bg-gradient-to-br from-purple-100 to-blue-100 rounded-full">
                            <i class="fas fa-calendar-times text-5xl gradient-text"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Tidak Ada Featured Event Saat Ini</h3>
                        <p class="text-gray-600 mb-6">Maaf, saat ini tidak ada featured event yang tersedia. Silakan cek kembali nanti atau jelajahi event lainnya.</p>
                        <a href="{{ route('events.index') }}"
                            class="btn-primary text-white px-6 py-3 rounded-2xl font-semibold inline-flex items-center transition-all duration-300 hover:scale-105">
                            <i class="fas fa-search mr-2"></i>Jelajahi Semua Event
                        </a>
                    </div>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredEvents as $event)
                    <div class="event-card rounded-2xl overflow-hidden shadow-xl border border-white/20">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/'.$event->event_image) }}" alt="{{ $event->name }}" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                            <div class="absolute top-4 left-4">
                                <span class="glass-effect text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-star mr-1"></i>Featured
                                </span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">{{ $event->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($event->description, 120) }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2 text-sm text-gray-500">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</span>
                                </div>
                                <a href="{{ route('events.show', $event->event_id) }}"
                                    class="btn-primary text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:scale-105">
                                    <i class="fas fa-eye mr-1"></i>Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Categories Section -->
            <div class="section-bg rounded-3xl p-8 mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold gradient-text mb-4">Kategori Event</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Temukan event sesuai minat dan passion Anda dari berbagai kategori menarik</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($categories as $category)
                    <a href="{{ route('events.index', ['category' => $category->category_id]) }}"
                        class="category-card block rounded-2xl p-6 text-center font-semibold shadow-lg group">
                        <div class="mb-4">
                            <div class="w-16 h-16 mx-auto gradient-primary rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-calendar text-white text-2xl"></i>
                            </div>
                        </div>
                        <span class="gradient-text text-lg">{{ $category->name }}</span>
                        <div class="mt-2 text-sm text-gray-500">
                            Jelajahi sekarang
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-white">
                    <!-- Company Info -->
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <img src="/images/logo.png" alt="Logo" class="h-8 w-auto" />
                            <span class="text-xl font-bold">NEO.Vibe</span>
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
                    <p class="text-white text-sm">
                        © {{ date('Y') }} NEO.Vibe. Semua hak dilindungi undang-undang.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        function notificationData() {
            return {
                openNotif: false,
                notifications: [],
                unreadCount: 0, // Menambahkan variabel untuk menyimpan jumlah notifikasi yang belum dibaca

                init() {
                    // Memuat notifikasi saat halaman pertama kali dimuat
                    this.loadNotifications();
                },

                loadNotifications() {
                    fetch(`{{ route('notifications.index') }}`)
                        .then(res => res.json())
                        .then(data => {
                            this.notifications = data;
                            // Menghitung jumlah notifikasi yang belum dibaca
                            this.unreadCount = data.filter(n => n.is_read == 0).length;
                        })
                        .catch(error => {
                            console.error('Error loading notifications:', error);
                        });
                },

                markAsRead(notificationId, notification) {
                    fetch('/notifications/' + notificationId + '/read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(updated => {
                            notification.is_read = true;
                            // Mengurangi jumlah notifikasi yang belum dibaca
                            this.unreadCount--;
                        })
                        .catch(error => {
                            console.error('Error marking notification as read:', error);
                        });
                }
            };
        }
    </script>
</x-app-layout>