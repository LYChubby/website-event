<x-app-layout>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .rating-star {
            color: #d1d5db;
        }

        .rating-star.active {
            color: #f59e0b;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(104, 69, 151, 0.15), 0 10px 10px -5px rgba(92, 106, 208, 0.1);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #5a3a7d 0%, #4d5bb0 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(104, 69, 151, 0.3);
        }

        .ticket-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(104, 69, 151, 0.1);
        }

        .ticket-vvip {
            border-left: 4px solid #8b5cf6;
        }

        .ticket-vip {
            border-left: 4px solid #3b82f6;
        }

        .ticket-regular {
            border-left: 4px solid #10b981;
        }

        .floating-action {
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

        .pulse-glow {
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(104, 69, 151, 0.3);
            }

            50% {
                box-shadow: 0 0 30px rgba(92, 106, 208, 0.5);
            }
        }
    </style>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Tombol kembali -->
                <button onclick="history.back()" class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center hover:bg-opacity-30 transition">
                    <i class="fas fa-arrow-left text-white"></i>
                </button>

                <!-- Icon gear -->
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-cog text-2xl text-white"></i>
                </div>

                <div>
                    <h2 class="font-semibold text-2xl text-white leading-tight">
                        Detail Event
                    </h2>
                    <p class="text-sm text-blue-100">Lihat Informasi Yang Kamu Inginkan</p>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Hero Image Section -->
    <div class="w-full h-96 bg-gray-200 overflow-hidden relative">
        <img src="{{ asset('storage/' . $event->event_image) }}" alt="{{ $event->name_event }}"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-50"></div>
        <div class="absolute bottom-6 left-6 text-white">
            <div class="flex items-center space-x-2 mb-2">
                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm backdrop-blur-sm">
                    <i class="fas fa-fire mr-1"></i>Event Populer
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="lg:flex">
                <!-- Left Content -->
                <div class="lg:w-2/3 p-8 lg:p-10">
                    <!-- Event Header -->
                    <div class="mb-10">
                        <h1 class="text-4xl lg:text-5xl font-bold gradient-text mb-4 leading-tight">
                            {{ $event->name_event }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-4 mb-6">
                            <div class="flex items-center text-gray-700">
                                <i class="fas fa-map-marker-alt text-primary-purple mr-2 text-lg"></i>
                                <span class="font-semibold">{{ $event->venue_name }}</span>
                            </div>
                            <div class="bg-gradient-to-r from-purple-100 to-blue-100 px-4 py-2 rounded-full">
                                <span class="gradient-text font-semibold">{{ $event->category->name ?? 'Kategori' }}</span>
                            </div>
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-location-dot text-primary-blue mr-3 text-lg"></i>
                                <span class="text-lg">{{ $event->venue_address }}</span>
                            </div>

                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar-alt text-primary-purple mr-3 text-lg"></i>
                                <span class="text-lg font-medium">
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d F Y, H:i') }} –
                                    {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }} WIB
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-4 mb-10">
                            <button class="flex items-center px-8 py-4 btn-gradient text-white rounded-xl font-semibold hover:shadow-xl transition-all duration-300">
                                <i class="fas fa-share-alt mr-3"></i>
                                Bagikan Event
                            </button>
                            <button class="flex items-center px-8 py-4 bg-white border-2 border-primary-purple text-primary-purple rounded-xl font-semibold hover:bg-primary-purple hover:text-white transition-all duration-300">
                                <i class="fas fa-heart mr-3"></i>
                                Favorit
                            </button>
                        </div>
                    </div>

                    <!-- Event Description -->
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold gradient-text mb-6 flex items-center">
                            <i class="fas fa-info-circle mr-3"></i>
                            Deskripsi Event
                        </h2>
                        <div class="bg-gradient-to-br from-purple-50 to-blue-50 p-8 rounded-2xl border border-purple-100">
                            <p class="text-gray-700 text-lg leading-relaxed">{{ $event->description }}</p>
                        </div>
                    </div>

                    <!-- Tickets Section -->
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold gradient-text mb-8 flex items-center">
                            <i class="fas fa-ticket-alt mr-3"></i>
                            Daftar Tiket
                        </h2>

                        @if($event->tickets->count() > 0)
                        <div class="space-y-6">
                            @foreach($event->tickets as $ticket)
                            <div class="ticket-card card-hover rounded-2xl shadow-lg overflow-hidden 
                                @if($ticket->jenis_ticket === 'VVIP') ticket-vvip
                                @elseif($ticket->jenis_ticket === 'VIP') ticket-vip
                                @else ticket-regular @endif">
                                <div class="p-8">
                                    <div class="flex justify-between items-start mb-6">
                                        <div>
                                            <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $ticket->jenis_ticket }}</h3>
                                            <p class="text-gray-600 flex items-center">
                                                <i class="fas fa-tag mr-2"></i>
                                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm font-mono">{{ $ticket->ticket_code_prefix }}</span>
                                            </p>
                                        </div>
                                        <span class="px-4 py-2 rounded-xl text-sm font-bold
                                            @if($ticket->jenis_ticket === 'VVIP') bg-purple-100 text-purple-800
                                            @elseif($ticket->jenis_ticket === 'VIP') bg-blue-100 text-blue-800
                                            @else bg-green-100 text-green-800 @endif">
                                            {{ $ticket->jenis_ticket }}
                                        </span>
                                    </div>

                                    <div class="mb-6">
                                        <p class="text-4xl font-bold gradient-text mb-4">
                                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </p>

                                        <div class="grid grid-cols-2 gap-6 mb-6">
                                            <div class="bg-white bg-opacity-50 p-4 rounded-xl">
                                                <p class="text-gray-500 text-sm">Tersedia</p>
                                                <p class="font-bold text-xl text-green-600">{{ $ticket->quantity_available }} tiket</p>
                                            </div>
                                            <div class="bg-white bg-opacity-50 p-4 rounded-xl">
                                                <p class="text-gray-500 text-sm">Terjual</p>
                                                <p class="font-bold text-xl text-orange-600">{{ $ticket->quantity_sold }} tiket</p>
                                            </div>
                                        </div>

                                        <div class="bg-white bg-opacity-30 p-4 rounded-xl">
                                            <p class="text-gray-600 text-sm mb-1">Periode Pemesanan</p>
                                            <p class="font-semibold text-gray-800">
                                                {{ \Carbon\Carbon::parse($ticket->start_pesan)->format('d M Y H:i') }} -
                                                {{ \Carbon\Carbon::parse($ticket->end_pesan)->format('d M Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gradient-to-r from-gray-50 to-white px-8 py-6 flex justify-between items-center border-t border-gray-100">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <span class="text-sm">{{ $ticket->description ?? 'Tidak ada deskripsi tambahan' }}</span>
                                    </div>
                                    <button onclick="openBuyTicketModal('{{ $ticket->ticket_id }}', '{{ $event->name_event }}', '{{ $ticket->price }}')"
                                        class="btn-gradient text-white px-8 py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 pulse-glow">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Beli Tiket
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="bg-gradient-to-br from-gray-50 to-white p-12 rounded-2xl text-center border border-gray-200">
                            <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-ticket-alt text-3xl gradient-text"></i>
                            </div>
                            <p class="text-gray-500 text-lg">Belum ada tiket tersedia untuk event ini</p>
                        </div>
                        @endif
                    </div>

                    <!-- Reviews Section -->
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold gradient-text mb-8 flex items-center">
                            <i class="fas fa-star mr-3"></i>
                            Ulasan dan Rating
                        </h2>

                        <!-- Form Tambah Feedback -->
                        @if(Auth::check() && Auth::user()->role === 'user')
                        @php
                        $currentDateTime = now();
                        $eventStartDate = \Carbon\Carbon::parse($event->start_date);
                        $canReview = $currentDateTime->gte($eventStartDate);
                        @endphp

                        @if($canReview)
                        <div class="bg-gradient-to-br from-purple-50 to-blue-50 p-8 rounded-2xl border border-purple-100 mb-8">
                            <form id="feedbackForm" onsubmit="submitFeedback(event)">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->event_id }}">
                                <input type="hidden" name="rating" id="ratingValue" value="0">

                                <!-- Rating -->
                                <div class="mb-6">
                                    <label class="block text-gray-800 font-semibold mb-4 text-lg">Berikan Rating</label>
                                    <div class="flex space-x-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button"
                                            onclick="setRating({{ $i }})"
                                            class="text-3xl focus:outline-none hover:scale-110 transition-transform">
                                            <i class="far fa-star rating-star" data-rating="{{ $i }}"></i>
                                            </button>
                                            @endfor
                                    </div>
                                </div>

                                <!-- Komentar -->
                                <div class="mb-6">
                                    <label class="block text-gray-800 font-semibold mb-3 text-lg">Komentar</label>
                                    <textarea name="comment" rows="4"
                                        class="w-full border-2 border-purple-200 rounded-xl px-6 py-4 focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 text-gray-700 placeholder-gray-400"
                                        placeholder="Bagikan pengalaman Anda tentang event ini..." required></textarea>
                                </div>

                                <!-- Tombol submit -->
                                <button type="submit"
                                    class="btn-gradient text-white px-8 py-4 rounded-xl font-semibold hover:shadow-lg transition-all duration-300">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Kirim Ulasan
                                </button>
                            </form>

                            <div id="feedbackMessage" class="hidden mt-6 p-4 rounded-xl"></div>
                        </div>
                        @else
                        <div class="bg-gradient-to-br from-purple-50 to-blue-50 p-8 rounded-2xl border border-purple-100 mb-8 text-center">
                            <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-clock text-3xl gradient-text"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Ulasan Belum Tersedia</h3>
                            <p class="text-gray-600">
                                Anda dapat memberikan ulasan setelah event dimulai pada
                                <span class="font-semibold">{{ \Carbon\Carbon::parse($event->start_date)->format('d F Y, H:i') }}</span>
                            </p>
                        </div>
                        @endif
                        @endif

                        <!-- Daftar Feedback -->
                        <div id="feedbackContainer" class="space-y-6">
                            @forelse($event->feedbacks as $feedback)
                            <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-8 card-hover">
                                <div class="flex items-start justify-between mb-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-purple-400 to-blue-400 flex items-center justify-center">
                                            <i class="fas fa-user text-white text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800 text-lg">{{ $feedback->user->name ?? 'Anonim' }}</h4>
                                            <div class="flex items-center mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-lg {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                    @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                            {{ $feedback->created_at->diffForHumans() }}
                                        </span>

                                        <!-- Tombol Hapus (Hanya Organizer) -->
                                        @if(Auth::check() && Auth::user()->role === 'organizer')
                                        <button type="button"
                                            onclick="deleteFeedback(`{{ $feedback->feedback_id }}`, this)"
                                            class="text-red-500 hover:text-red-700 ml-2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-gray-700 text-lg leading-relaxed">{{ $feedback->comment }}</p>
                            </div>
                            @empty
                            <div class="empty-state bg-gradient-to-br from-gray-50 to-white p-12 rounded-2xl text-center border border-gray-200">
                                <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i class="fas fa-comment-alt text-3xl gradient-text"></i>
                                </div>
                                <p class="text-gray-500 text-lg">Belum ada ulasan untuk event ini</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="lg:w-1/3 bg-gradient-to-br from-purple-50 to-blue-50 p-8 lg:p-10">
                    <div class="sticky top-6 space-y-6">
                        <!-- Date Picker Card -->
                        <div class="bg-white rounded-2xl shadow-lg p-8 card-hover">
                            <h3 class="text-xl font-bold gradient-text mb-6 flex items-center">
                                <i class="fas fa-calendar-check mr-3"></i>
                                Pilih Tanggal
                            </h3>
                            <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-xl">
                                <i class="fas fa-calendar-alt text-4xl mb-4 gradient-text"></i>
                                <p>Pilih tanggal tersedia</p>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <button type="button" class="w-full btn-gradient text-white font-bold py-6 px-6 rounded-2xl transition-all duration-300 hover:shadow-xl floating-action">
                            <i class="fas fa-rocket mr-3"></i>
                            Daftar Sekarang
                        </button>

                        <!-- Quick Info -->
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h4 class="font-bold gradient-text mb-4">Info Cepat</h4>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-users mr-3 text-purple-500"></i>
                                    <span>Kapasitas terbatas</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-shield-alt mr-3 text-blue-500"></i>
                                    <span>Pembayaran aman</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-mobile-alt mr-3 text-purple-500"></i>
                                    <span>E-ticket digital</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <img src="/images/logo.png" alt="Logo" class="h-14 w-auto" />
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

    <!-- Modal Pembelian Tiket -->
    <div id="buyTicketModal" class="fixed inset-0 bg-black bg-opacity-50 justify-center items-center z-50 hidden backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl p-8 relative max-h-[90vh] overflow-y-auto">
            <button class="absolute top-6 right-6 w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors" onclick="closeBuyTicketModal()">
                <i class="fas fa-times text-gray-600"></i>
            </button>

            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-blue-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-ticket-alt text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold gradient-text mb-2">Beli Tiket</h2>
                <p class="text-gray-600 text-lg">Event: <span id="buyTicketName" class="font-semibold gradient-text"></span></p>
                <p class="text-gray-600 text-lg">Harga: <span id="buyTicketPrice" class="font-bold text-2xl gradient-text"></span></p>
            </div>

            <form id="buyTicketForm" class="space-y-6">
                @csrf
                <input type="hidden" name="ticket_id" id="buyTicketId">
                <input type="hidden" name="event_id" value="{{ $event->event_id }}">

                <div>
                    <label class="block mb-3 font-semibold text-gray-800 text-lg">
                        <i class="fas fa-user mr-2 gradient-text"></i>Nama Peserta
                    </label>
                    <input type="text" name="nama" id="participantName"
                        class="w-full border-2 border-gray-200 rounded-xl px-6 py-4 focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 text-lg"
                        placeholder="Masukkan nama lengkap" required>
                </div>

                <div>
                    <label class="block mb-3 font-semibold text-gray-800 text-lg">
                        <i class="fas fa-sort-numeric-up mr-2 gradient-text"></i>Jumlah Tiket
                    </label>
                    <input type="number" name="quantity" id="ticketQuantity" min="1"
                        class="w-full border-2 border-gray-200 rounded-xl px-6 py-4 focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 text-lg"
                        placeholder="1" required>
                </div>

                <div class="flex justify-end space-x-4 pt-6">
                    <button type="button" onclick="closeBuyTicketModal()"
                        class="px-8 py-4 bg-gray-200 text-gray-800 rounded-xl font-semibold hover:bg-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-4 btn-gradient text-white rounded-xl font-semibold hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-credit-card mr-2"></i>
                        Konfirmasi Pembelian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openBuyTicketModal(ticketId, ticketName, price) {
            document.getElementById('buyTicketId').value = ticketId;
            document.getElementById('buyTicketName').textContent = ticketName;
            document.getElementById('buyTicketPrice').textContent = 'Rp ' + parseInt(price).toLocaleString('id-ID');
            document.getElementById('participantName').value = '';
            document.getElementById('ticketQuantity').value = 1;

            document.getElementById('buyTicketModal').classList.remove('hidden');
            document.getElementById('buyTicketModal').classList.add('flex');
        }

        function closeBuyTicketModal() {
            document.getElementById('buyTicketModal').classList.add('hidden');
            document.getElementById('buyTicketModal').classList.remove('flex');
        }

        // Handle form submission
        document.getElementById('buyTicketForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');

            // Show loading state
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            submitButton.disabled = true;

            fetch("{{ route('checkout') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value,
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.invoice_url) {
                        window.location.href = data.invoice_url;
                    } else {
                        alert('Pembayaran gagal dibuat. Coba lagi.');
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Terjadi kesalahan saat memproses pembayaran.');
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                });
        });

        // Set rating
        function setRating(rating) {
            document.getElementById('ratingValue').value = rating;

            const stars = document.querySelectorAll('.rating-star');
            stars.forEach(star => {
                const starRating = parseInt(star.dataset.rating);
                if (starRating <= rating) {
                    star.classList.remove('far');
                    star.classList.add('fas', 'active', 'text-yellow-400');
                } else {
                    star.classList.remove('fas', 'active', 'text-yellow-400');
                    star.classList.add('far');
                }
            });
        }

        // Submit feedback
        async function submitFeedback(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const messageDiv = document.getElementById('feedbackMessage');
            const submitButton = form.querySelector('button[type="submit"]');

            // Loading state
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';

            try {
                const response = await fetch("{{ route('feedbacks.store') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();
                messageDiv.classList.remove('hidden');

                if (data.message) {
                    messageDiv.className = 'mt-4 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200';
                    messageDiv.innerHTML = '<i class="fas fa-check-circle mr-2"></i>' + data.message;
                    form.reset();
                    resetStars();

                    if (data.feedback) {
                        addNewFeedback(data.feedback);
                    }
                } else if (data.error) {
                    messageDiv.className = 'mt-4 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200';
                    messageDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>' + data.error;
                }
            } catch (error) {
                console.error('Error:', error);
                messageDiv.className = 'mt-4 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200';
                messageDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>Terjadi kesalahan saat mengirim feedback';
                messageDiv.classList.remove('hidden');
            } finally {
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            }
        }

        // Reset bintang
        function resetStars() {
            const stars = document.querySelectorAll('.rating-star');
            stars.forEach(star => {
                star.classList.remove('fas', 'active', 'text-yellow-400');
                star.classList.add('far');
            });
            document.getElementById('ratingValue').value = 0;
        }

        // Tambah feedback baru
        function addNewFeedback(feedback) {
            const feedbackContainer = document.getElementById('feedbackContainer');

            if (!feedbackContainer) {
                console.error("Feedback container not found!");
                return;
            }

            // Hapus empty state kalau ada
            const emptyState = feedbackContainer.querySelector('.empty-state');
            if (emptyState) emptyState.remove();

            // Buat elemen feedback baru
            const newFeedback = document.createElement('div');
            newFeedback.className = 'bg-white border border-gray-200 rounded-2xl shadow-md p-6 opacity-0 translate-y-3 transition-all duration-300';
            newFeedback.innerHTML = `
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-blue-400 flex items-center justify-center">
                            <i class="fas fa-user text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">${feedback.user_name}</h4>
                            <div class="flex items-center mt-1">
                                ${'<i class="fas fa-star text-yellow-400"></i>'.repeat(feedback.rating)}
                                ${'<i class="fas fa-star text-gray-300"></i>'.repeat(5 - feedback.rating)}
                            </div>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Baru saja</span>
                </div>
                <p class="text-gray-700">${feedback.comment}</p>
            `;

            // Masukin di paling atas
            feedbackContainer.insertBefore(newFeedback, feedbackContainer.firstChild);

            // Animasi muncul
            setTimeout(() => {
                newFeedback.classList.remove('opacity-0', 'translate-y-3');
            }, 50);
        }

        async function deleteFeedback(feedbackId, btn) {
            if (!confirm("Yakin ingin menghapus ulasan ini?")) return;

            // Tombol hapus sementara disable
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin text-red-500"></i>';

            try {
                const response = await fetch(`/feedbacks/${feedbackId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.message) {
                    // Hapus card feedback dari DOM
                    const feedbackCard = btn.closest('.bg-white.border');
                    if (feedbackCard) {
                        feedbackCard.classList.add('opacity-0', 'translate-x-5', 'transition-all', 'duration-300');
                        setTimeout(() => feedbackCard.remove(), 300);
                    }
                } else {
                    alert(data.error || "Gagal menghapus feedback.");
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-trash"></i>';
                }
            } catch (error) {
                console.error(error);
                alert("Terjadi kesalahan pada server.");
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-trash"></i>';
            }
        }

        // Close modal when clicking outside
        document.getElementById('buyTicketModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBuyTicketModal();
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
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

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all cards for animation
        document.querySelectorAll('.card-hover').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>

</x-app-layout>