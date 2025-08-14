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
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hover-glow:hover {
            box-shadow: 0 0 30px rgba(92, 106, 208, 0.3);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(92, 106, 208, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #5C6AD0 0%, #684597 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4A5BC4 0%, #5A3C85 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(92, 106, 208, 0.3);
        }

        .filter-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.98) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(92, 106, 208, 0.1);
        }

        .category-filter {
            transition: all 0.3s ease;
        }

        .category-filter:hover {
            transform: translateX(4px);
        }

        .category-active {
            background: linear-gradient(135deg, rgba(92, 106, 208, 0.1) 0%, rgba(104, 69, 151, 0.1) 100%);
            border-color: #5C6AD0;
            color: #5C6AD0;
        }

        .event-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.95) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(92, 106, 208, 0.1);
            transition: all 0.4s ease;
        }

        .event-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(92, 106, 208, 0.2);
            border-color: rgba(92, 106, 208, 0.3);
        }

        .date-badge {
            background: linear-gradient(135deg, #5C6AD0 0%, #684597 100%);
            box-shadow: 0 4px 15px rgba(92, 106, 208, 0.4);
        }

        .search-input:focus {
            box-shadow: 0 0 20px rgba(92, 106, 208, 0.2);
            border-color: #5C6AD0;
        }

        .select-input:focus {
            box-shadow: 0 0 20px rgba(92, 106, 208, 0.2);
            border-color: #5C6AD0;
        }

        .page-background {
            background: linear-gradient(135deg, rgba(92, 106, 208, 0.02) 0%, rgba(104, 69, 151, 0.02) 100%);
            min-height: 100vh;
        }

        .section-divider {
            background: linear-gradient(90deg, transparent 0%, rgba(92, 106, 208, 0.3) 50%, transparent 100%);
            height: 1px;
            margin: 2rem 0;
        }

        .floating-element {
            animation: float 6s ease-in-out infinite;
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

        .pulse-glow {
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(92, 106, 208, 0.1);
            }

            50% {
                box-shadow: 0 0 30px rgba(104, 69, 151, 0.2);
            }
        }

        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(92, 106, 208, 0.1), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .no-events-bg {
            background: linear-gradient(135deg, rgba(92, 106, 208, 0.05) 0%, rgba(104, 69, 151, 0.05) 100%);
        }
    </style>

    <div class="page-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Enhanced Header -->
            <div class="text-center mb-12">
                <div class="inline-block p-3 rounded-full glass-effect mb-4">
                    <i class="fas fa-calendar-alt text-2xl gradient-text"></i>
                </div>
                <h1 class="text-4xl sm:text-5xl font-bold gradient-text mb-4">Jelajahi Event</h1>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">Temukan pengalaman tak terlupakan melalui berbagai acara menarik yang telah kami kurasi khusus untuk Anda</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Enhanced Sidebar Filter -->
                <aside class="lg:w-80 w-full">
                    <div class="filter-card rounded-3xl shadow-2xl p-8 sticky top-8 floating-element">
                        <!-- Filter Header -->
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-filter text-white"></i>
                            </div>
                            <h2 class="text-2xl font-bold gradient-text">Filter Event</h2>
                        </div>

                        <form method="GET" action="{{ route('events.index') }}" class="space-y-6">
                            <!-- Search Input -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-search mr-2 text-purple-600"></i>Pencarian
                                </label>
                                <div class="relative">
                                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari event impian Anda..."
                                        class="search-input w-full px-4 py-3 pl-12 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-purple-300 bg-white/70 backdrop-blur-sm transition-all duration-300" />
                                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Scope Select -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-clock mr-2 text-purple-600"></i>Periode Event
                                </label>
                                <select name="scope" class="select-input w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-purple-300 bg-white/70 backdrop-blur-sm transition-all duration-300">
                                    <option value="upcoming" {{ $scope==='upcoming' ? 'selected' : '' }}>🚀 Event Mendatang</option>
                                    <option value="featured" {{ $scope==='featured' ? 'selected' : '' }}>⭐ Featured (1 bulan)</option>
                                    <option value="past" {{ $scope==='past' ? 'selected' : '' }}>📅 Event Selesai</option>
                                </select>
                            </div>

                            <!-- Categories -->
                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-tags mr-2 text-purple-600"></i>Kategori Event
                                </label>

                                <!-- All Categories Button -->
                                <a href="{{ route('events.index', array_filter(['scope'=>$scope,'q'=>$search])) }}"
                                    class="category-filter inline-flex items-center text-sm px-4 py-3 rounded-2xl border-2 transition-all duration-300 hover-glow w-full justify-center font-semibold {{ empty($categoryId) || $categoryId==='all' ? 'category-active' : 'border-gray-200 text-gray-700 hover:border-purple-300' }}">
                                    <i class="fas fa-th-large mr-2"></i>
                                    Semua Kategori
                                </a>

                                <!-- Categories List -->
                                <div class="space-y-2 max-h-72 overflow-auto pr-2 custom-scrollbar">
                                    @foreach($categories as $cat)
                                    <a href="{{ route('events.index', array_filter(['category'=>$cat->category_id,'scope'=>$scope,'q'=>$search])) }}"
                                        class="category-filter flex items-center text-sm px-4 py-3 rounded-xl border-2 transition-all duration-300 hover:shadow-lg {{ (string)$categoryId === (string)$cat->category_id ? 'category-active font-semibold' : 'border-gray-200 text-gray-700 hover:border-purple-200 hover:bg-purple-50' }}">
                                        <div class="w-8 h-8 rounded-lg {{ (string)$categoryId === (string)$cat->category_id ? 'gradient-primary' : 'bg-gray-100' }} flex items-center justify-center mr-3">
                                            <i class="fas fa-bookmark text-xs {{ (string)$categoryId === (string)$cat->category_id ? 'text-white' : 'text-gray-600' }}"></i>
                                        </div>
                                        <span class="flex-1">{{ $cat->name }}</span>
                                        @if((string)$categoryId === (string)$cat->category_id)
                                        <i class="fas fa-check text-purple-600"></i>
                                        @endif
                                    </a>
                                    @endforeach
                                </div>
                            </div>

                            <div class="section-divider"></div>

                            <!-- Apply Button -->
                            <div class="pt-2">
                                <button class="w-full btn-primary text-white px-6 py-4 rounded-2xl font-semibold text-lg hover-glow shadow-xl">
                                    <i class="fas fa-magic mr-2"></i>Terapkan Filter
                                </button>
                            </div>
                        </form>

                        <!-- Filter Stats -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-center space-x-2 text-sm text-gray-600">
                                <i class="fas fa-info-circle"></i>
                                <span>{{ $events->total() ?? 0 }} event ditemukan</span>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Enhanced Main Content -->
                <main class="flex-1">
                    <!-- Page Header -->
                    <div class="glass-card rounded-3xl p-8 mb-8 shadow-xl">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-3xl sm:text-4xl font-bold gradient-text mb-2">{{ $pageTitle }}</h1>
                                @if($scope==='featured')
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-calendar-range mr-2"></i>
                                    <span class="text-sm">{{ $today->format('d M Y') }} – {{ $oneMonthLater->format('d M Y') }}</span>
                                </div>
                                @endif
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="px-4 py-2 gradient-primary rounded-2xl text-white font-semibold shadow-lg">
                                    <i class="fas fa-fire mr-2"></i>
                                    {{ $events->total() ?? 0 }} Events
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($events->count())
                    <!-- Events Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                        @foreach($events as $event)
                        <div class="event-card rounded-3xl overflow-hidden shadow-xl pulse-glow">
                            <a href="{{ route('events.show', $event->event_id) }}" class="block group">
                                <!-- Event Image -->
                                <div class="relative overflow-hidden h-56">
                                    <img src="{{ asset('storage/'.$event->event_image) }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                        alt="{{ $event->name_event }}" />

                                    <!-- Date Badge -->
                                    <div class="absolute top-4 left-4">
                                        <div class="date-badge text-white px-4 py-2 rounded-2xl text-sm font-bold">
                                            <i class="fas fa-calendar-day mr-1"></i>
                                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M') }}
                                        </div>
                                    </div>

                                    <!-- Featured Badge -->
                                    @if($scope === 'featured')
                                    <div class="absolute top-4 right-4">
                                        <div class="glass-effect text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-star mr-1"></i>Featured
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Gradient Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>

                                <!-- Event Content -->
                                <div class="p-6 space-y-4">
                                    <!-- Event Date -->
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <div class="w-8 h-8 gradient-primary rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-calendar-alt text-white text-xs"></i>
                                        </div>
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($event->start_date)->format('d F Y') }}</span>
                                    </div>

                                    <!-- Event Title -->
                                    <h3 class="font-bold text-xl text-gray-900 line-clamp-2 group-hover:text-purple-700 transition-colors duration-300">
                                        {{ $event->name_event }}
                                    </h3>

                                    <!-- Organizer Info -->
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-purple-600 text-xs"></i>
                                        </div>
                                        <span class="font-medium">{{ $event->organizer->name ?? 'Unknown Organizer' }}</span>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="pt-4 border-t border-gray-100">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500">
                                                <i class="fas fa-eye mr-1"></i>Lihat Detail
                                            </span>
                                            <div class="w-8 h-8 gradient-primary rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                <i class="fas fa-arrow-right text-white text-xs"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <!-- Enhanced Pagination -->
                    <div class="mt-12">
                        <div class="glass-card rounded-3xl p-6 shadow-xl">
                            {{ $events->links() }}
                        </div>
                    </div>
                    @else
                    <!-- Enhanced No Events State -->
                    <div class="no-events-bg rounded-3xl p-12 text-center shadow-xl">
                        <div class="max-w-md mx-auto">
                            <!-- Empty State Icon -->
                            <div class="mb-8">
                                <div class="w-24 h-24 mx-auto gradient-primary rounded-3xl flex items-center justify-center shadow-xl">
                                    <i class="fas fa-calendar-times text-4xl text-white"></i>
                                </div>
                            </div>

                            <!-- Empty State Content -->
                            <h3 class="text-2xl font-bold gradient-text mb-4">Oops! Tidak Ada Event</h3>
                            <p class="text-gray-600 mb-8 leading-relaxed">
                                Maaf, tidak ada event yang sesuai dengan filter yang Anda pilih.
                                Coba ubah kriteria pencarian atau jelajahi kategori lainnya.
                            </p>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{ route('events.index') }}"
                                    class="btn-primary text-white px-8 py-3 rounded-2xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                                    <i class="fas fa-refresh mr-2"></i>Reset Filter
                                </a>
                                <button onclick="window.history.back()"
                                    class="px-8 py-3 border-2 border-purple-300 text-purple-700 rounded-2xl font-semibold hover:bg-purple-50 transition-all duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                                </button>
                            </div>

                            <!-- Suggestion -->
                            <div class="mt-8 p-4 bg-white/50 rounded-2xl border border-purple-200">
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-lightbulb mr-2 text-yellow-500"></i>
                                    <strong>Tips:</strong> Coba gunakan kata kunci yang lebih umum atau hapus beberapa filter untuk hasil yang lebih luas.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </main>
            </div>
        </div>
        <footer class="gradient-primary mt-20 relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-10 left-10 w-20 h-20 bg-white rounded-full"></div>
                <div class="absolute top-20 right-20 w-32 h-32 bg-white rounded-full"></div>
                <div class="absolute bottom-10 left-1/3 w-16 h-16 bg-white rounded-full"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-white">
                    <!-- Enhanced Company Info -->
                    <div>
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="relative">
                                <img src="/images/logo.png" alt="Logo" class="h-16 w-auto" />
                                <div class="absolute -inset-2 bg-white/20 rounded-full blur-sm"></div>
                            </div>
                            <span class="text-2xl font-bold">NEO.Vibe</span>
                        </div>
                        <p class="text-white/90 text-base leading-relaxed mb-6">
                            Platform terpercaya untuk menemukan dan menghadiri berbagai event menarik di Indonesia. Bergabunglah dengan komunitas yang passionate!
                        </p>
                        <div class="flex items-center space-x-2 text-white/80">
                            <i class="fas fa-shield-alt"></i>
                            <span class="text-sm">Keamanan dan privasi terjamin</span>
                        </div>
                    </div>

                    <!-- Enhanced Quick Links -->
                    <div>
                        <h4 class="font-bold text-xl mb-6">Link Cepat</h4>
                        <div class="space-y-4">
                            <a href="#" class="flex items-center text-white/90 hover:text-white transition-colors group">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white/30 transition-colors">
                                    <i class="fas fa-info-circle text-sm"></i>
                                </div>
                                <span>Tentang Kami</span>
                            </a>
                            <a href="#" class="flex items-center text-white/90 hover:text-white transition-colors group">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white/30 transition-colors">
                                    <i class="fas fa-fire text-sm"></i>
                                </div>
                                <span>Event Populer</span>
                            </a>
                            <a href="#" class="flex items-center text-white/90 hover:text-white transition-colors group">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white/30 transition-colors">
                                    <i class="fas fa-envelope text-sm"></i>
                                </div>
                                <span>Kontak Kami</span>
                            </a>
                            <a href="#" class="flex items-center text-white/90 hover:text-white transition-colors group">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white/30 transition-colors">
                                    <i class="fas fa-question-circle text-sm"></i>
                                </div>
                                <span>FAQ</span>
                            </a>
                        </div>
                    </div>

                    <!-- Enhanced Social Media -->
                    <div>
                        <h4 class="font-bold text-xl mb-6">Ikuti Kami</h4>
                        <p class="text-white/90 mb-6">Dapatkan update terbaru tentang event-event menarik!</p>
                        <div class="flex space-x-4 mb-8">
                            <a href="#" class="w-12 h-12 glass-effect hover:bg-white/30 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 glass-effect hover:bg-white/30 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1">
                                <i class="fab fa-youtube text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 glass-effect hover:bg-white/30 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1">
                                <i class="fab fa-tiktok text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 glass-effect hover:bg-white/30 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1">
                                <i class="fab fa-facebook text-lg"></i>
                            </a>
                        </div>

                        <!-- Newsletter Signup -->
                        <div class="glass-effect rounded-2xl p-4">
                            <h5 class="font-semibold mb-3">Newsletter</h5>
                            <div class="flex">
                                <input type="email" placeholder="Email Anda" class="flex-1 px-4 py-2 rounded-l-xl bg-white/20 border-0 placeholder-white/70 text-white text-sm focus:outline-none focus:bg-white/30">
                                <button class="px-4 py-2 bg-white/30 hover:bg-white/40 rounded-r-xl transition-colors">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Copyright -->
                <div class="border-t border-white/20 mt-12 pt-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-white/90 text-sm mb-4 md:mb-0">
                            © {{ date('Y') }} NEO.Vibe. Semua hak dilindungi undang-undang.
                        </p>
                        <div class="flex space-x-6 text-sm text-white/80">
                            <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                            <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                            <a href="#" class="hover:text-white transition-colors">Cookie Policy</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <style>
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(92, 106, 208, 0.1);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #5C6AD0 0%, #684597 100%);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #4A5BC4 0%, #5A3C85 100%);
        }

        /* Line clamp utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>