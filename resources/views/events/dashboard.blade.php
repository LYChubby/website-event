<x-app-layout>
    <style>
        /* Custom Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-slide-in-up {
            animation: slideInUp 0.8s ease-out forwards;
        }

        .animate-pulse-custom {
            animation: pulse 2s ease-in-out infinite;
        }

        .animate-shimmer {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        /* Gradient Backgrounds */
        .gradient-primary {
            background: linear-gradient(135deg, #5C6AD0 0%, #684597 100%);
        }

        .gradient-secondary {
            background: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
        }

        .gradient-light {
            background: linear-gradient(135deg, rgba(92, 106, 208, 0.1) 0%, rgba(104, 69, 151, 0.1) 100%);
        }

        .gradient-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Glass Effect */
        .glass {
            backdrop-filter: blur(20px);
        }

        .glass-light {
            backdrop-filter: blur(10px);
        }

        /* Status Colors */
        .status-approved {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }

        .status-pending {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        }

        .status-rejected {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        }

        /* Custom Hover Effects */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .btn-pulse:hover {
            animation: pulse 0.6s ease-in-out;
        }

        /* Custom Input Styles */
        .input {
            @apply w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white/80 backdrop-blur-sm;
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #5C6AD0, #684597);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #4C5BC4, #5A3D87);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .responsive-padding {
                padding: 1rem;
            }

            .responsive-text {
                font-size: 1.5rem;
            }
        }
    </style>


    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8 relative">

        {{-- DETAIL EVENT --}}
        <div class="glass bg-white/90 shadow-2xl rounded-3xl border border-white/50 p-8 hover-lift animate-slide-in-up overflow-hidden relative">
            <!-- Decorative Background -->
            <div class="absolute top-0 right-0 w-64 h-64 gradient-light rounded-full blur-3xl opacity-30 animate-float"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 gradient-secondary rounded-full blur-2xl opacity-20 animate-float" style="animation-delay: 1s;"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-6 mb-8">
                    <!-- Back Button -->
                    <button onclick="history.back()" class="group flex items-center">
                        <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                            <i class="fas fa-arrow-left text-white text-sm"></i>
                        </div>
                    </button>
                    <div class="relative group">
                        <div class="w-16 h-16 gradient-card text-white flex items-center justify-center rounded-2xl shadow-xl group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-calendar-alt text-2xl"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full animate-pulse-custom shadow-lg"></div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-800 via-purple-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                            Detail Event: {{ $event->name_event }}
                        </h2>
                        <p class="text-gray-600 font-medium">Informasi lengkap event yang sedang dikelola</p>
                    </div>
                    <a href="{{ route('organizer.checkin.scanner') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Scanner Check-in
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="group bg-gradient-to-br from-blue-50 to-indigo-100 p-6 rounded-2xl border-2 border-blue-100 hover:border-blue-200 transition-all duration-300 hover-lift">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-calendar text-white text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm text-blue-600 font-bold uppercase tracking-wide mb-1">Periode Event</p>
                                <p class="text-lg font-bold text-gray-800 leading-tight">
                                    {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }} -
                                    {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-gradient-to-br from-emerald-50 to-green-100 p-6 rounded-2xl border-2 border-emerald-100 hover:border-emerald-200 transition-all duration-300 hover-lift">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-green-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-check-circle text-white text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm text-emerald-600 font-bold uppercase tracking-wide mb-2">Status</p>
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold text-white shadow-lg
                                        {{ $event->status_approval === 'approved' ? 'status-approved' : 
                                        ($event->status_approval === 'pending' ? 'status-pending' : 'status-rejected') }}">
                                    <i class="fas fa-{{ $event->status_approval === 'approved' ? 'check' : ($event->status_approval === 'pending' ? 'clock' : 'times') }} mr-2"></i>
                                    {{ ucfirst($event->status_approval) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-gradient-to-br from-purple-50 to-pink-100 p-6 rounded-2xl border-2 border-purple-100 hover:border-purple-200 transition-all duration-300 hover-lift">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-map-marker-alt text-white text-lg"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm text-purple-600 font-bold uppercase tracking-wide mb-1">Venue</p>
                                <p class="text-lg font-bold text-gray-800 leading-tight truncate">{{ $event->venue_name }}</p>
                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $event->venue_address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MANAJEMEN TIKET --}}
        <div class="glass bg-white/90 rounded-3xl shadow-2xl border border-white/50 hover-lift animate-slide-in-up overflow-hidden relative" style="animation-delay: 0.2s;">
            <!-- Decorative Background -->
            <div class="absolute top-0 left-0 w-96 h-96 gradient-light rounded-full blur-3xl opacity-20 animate-float" style="animation-delay: 0.5s;"></div>

            <!-- Header -->
            <div class="relative overflow-hidden">
                <div class="absolute inset-0 gradient-primary"></div>
                <div class="absolute inset-0 animate-shimmer"></div>
                <div class="relative px-8 py-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div class="flex items-center space-x-6">
                            <div class="w-16 h-16 bg-white/20 glass-light rounded-2xl flex items-center justify-center shadow-xl animate-pulse-custom">
                                <i class="fas fa-ticket-alt text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-3xl font-bold text-white mb-2">Manajemen Tiket</h3>
                                <p class="text-white/90 text-lg">Kelola semua tiket untuk event ini</p>
                            </div>
                        </div>
                        <button onclick="openTicketModal('create')" class="group bg-white text-purple-600 font-bold px-8 py-4 rounded-2xl hover:bg-gray-50 transition-all duration-300 flex items-center space-x-3 shadow-xl hover:shadow-2xl transform hover:scale-105 btn-pulse">
                            <div class="w-6 h-6 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center group-hover:rotate-90 transition-transform duration-300">
                                <i class="fas fa-plus text-white text-sm"></i>
                            </div>
                            <span>Tambah Tiket</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="relative px-8 py-8 bg-gradient-to-r from-indigo-50/80 to-purple-50/80 glass-light">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="group glass bg-white/90 p-6 rounded-2xl border border-white/50 text-center shadow-lg hover-lift hover:bg-white transition-all duration-300">
                        <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-200">
                            <i class="fas fa-ticket-alt text-white"></i>
                        </div>
                        <div class="text-3xl font-bold text-blue-600 mb-1" id="totalTickets">{{ number_format($totalTickets) }}</div>
                        <div class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Tiket</div>
                    </div>
                    <div class="group glass bg-white/90 p-6 rounded-2xl border border-white/50 text-center shadow-lg hover-lift hover:bg-white transition-all duration-300">
                        <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-200">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                        <div class="text-3xl font-bold text-green-600 mb-1" id="availableTickets">{{ number_format($availableTickets) }}</div>
                        <div class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Tersedia</div>
                    </div>
                    <div class="group glass bg-white/90 p-6 rounded-2xl border border-white/50 text-center shadow-lg hover-lift hover:bg-white transition-all duration-300">
                        <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-200">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </div>
                        <div class="text-3xl font-bold text-orange-600 mb-1" id="soldTickets">{{ number_format($soldTickets) }}</div>
                        <div class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Terjual</div>
                    </div>
                    <div class="group glass bg-white/90 p-6 rounded-2xl border border-white/50 text-center shadow-lg hover-lift hover:bg-white transition-all duration-300">
                        <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-200">
                            <i class="fas fa-chart-pie text-white"></i>
                        </div>
                        <div class="text-3xl font-bold {{ $soldPercentageClass }} mb-1" id="soldPercentage">{{ $soldPercentage }}%</div>
                        <div class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Sold Out</div>
                    </div>
                    <!-- Card Full Width: Total Pendapatan -->
                    <div class="group glass bg-white/90 p-6 rounded-2xl border border-white/50 shadow-lg hover-lift hover:bg-white transition-all duration-300 col-span-full">
                        <div class="flex items-center justify-between">
                            <!-- Icon -->
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-coins text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-600 uppercase tracking-wide">Total Pendapatan</h3>
                                    <p class="text-3xl font-bold text-yellow-600" id="totalRevenue">
                                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            <!-- Optional: Persentase atau info tambahan -->
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Sudah dipotong 10%</p>
                                <p class="text-sm text-gray-500">Dari penjualan tiket</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="relative p-8">
                <div class="overflow-x-auto custom-scrollbar rounded-2xl border border-gray-100">
                    <table class="w-full text-left bg-white rounded-2xl overflow-hidden">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100 text-gray-700 text-sm border-b-2 border-gray-200">
                                <th class="py-6 px-6 font-bold">#</th>
                                <th class="py-6 px-6 font-bold">Kode</th>
                                <th class="py-6 px-6 font-bold">Jenis</th>
                                <th class="py-6 px-6 font-bold">Harga</th>
                                <th class="py-6 px-6 font-bold">Tersedia</th>
                                <th class="py-6 px-6 font-bold">Terjual</th>
                                <th class="py-6 px-6 font-bold">Periode</th>
                                <th class="py-6 px-6 font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="ticketTableBody" class="text-gray-700 text-sm divide-y divide-gray-100">
                            {{-- Tiket akan dimuat via JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- DAFTAR PARTICIPANT --}}
    <div class="glass bg-white/90 rounded-3xl shadow-2xl border border-white/50 hover-lift mt-8">
        <div class="px-8 py-6 border-b border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                <i class="fas fa-users text-purple-500"></i> Daftar Participant
            </h3>
            <p class="text-gray-500 text-sm">Peserta yang telah membeli tiket event ini</p>
        </div>

        <div class="p-8 overflow-x-auto custom-scrollbar">
            <table class="w-full text-left bg-white rounded-2xl overflow-hidden">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 text-gray-700 text-sm border-b-2 border-gray-200">
                        <th class="py-4 px-6 font-bold">#</th>
                        <th class="py-4 px-6 font-bold">Nama Peserta</th>
                        <th class="py-4 px-6 font-bold">Jenis Tiket</th>
                        <th class="py-4 px-6 font-bold">Jumlah</th>
                        <th class="py-4 px-6 font-bold">Tanggal Beli</th>
                        <th class="py-4 px-6 font-bold">Check-In</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                    @forelse($participants as $index => $p)
                    <tr>
                        <td class="py-4 px-6">{{ $index + 1 }}</td>
                        <td class="py-4 px-6 font-semibold">{{ $p->nama }}</td>
                        <td class="py-4 px-6">{{ $p->jenis_ticket }}</td>
                        <td class="py-4 px-6">{{ $p->jumlah }}</td>
                        <td class="py-4 px-6">{{ $p->created_at->format('d M Y H:i') }}</td>
                        <td class="py-4 px-6">
                            @if($p->checkin_at)
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-600">
                                {{ $p->checkin_at->format('d M Y H:i') }}
                            </span>
                            @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600">
                                Belum
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-6 px-6 text-center text-gray-500">Belum ada participant</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL TIKET --}}
    <div id="ticketModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div id="modalContent" class="bg-white/95 backdrop-blur-md p-8 rounded-3xl w-full max-w-5xl shadow-2xl border border-white/50 max-h-[90vh] overflow-y-auto transform scale-95 opacity-0 transition-all duration-300">

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h3 id="ticketModalTitle" class="text-3xl font-bold text-gray-800 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-ticket-alt text-white text-xl"></i>
                    </div>
                    <span class="bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">Tambah Tiket</span>
                </h3>
                <button onclick="closeTicketModal()" class="group text-gray-400 hover:text-gray-600 p-3 hover:bg-gray-100 rounded-2xl transition-all duration-200 hover:rotate-90">
                    <i class="fas fa-times text-2xl group-hover:scale-110 transition-transform duration-200"></i>
                </button>
            </div>

            <!-- Form -->
            <form id="ticketForm" class="space-y-8">
                <input type="hidden" id="ticketId" name="ticket_id">
                <input type="hidden" id="eventId" name="event_id" value="{{ $event->event_id }}">

                <!-- Basic Information Section -->
                <div class="bg-gradient-to-br from-white/60 to-white/40 backdrop-blur-sm p-6 rounded-3xl border border-white/50 hover:from-white/70 hover:to-white/50 transition-all duration-300">
                    <h4 class="text-lg font-bold text-gray-700 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-info-circle text-purple-600 text-sm"></i>
                        </div>
                        <span>Informasi Dasar Tiket</span>
                    </h4>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Kode Tiket -->
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-200/20 to-indigo-200/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <label class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                                    <div class="w-5 h-5 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-barcode text-purple-600 text-xs"></i>
                                    </div>
                                    <span>Kode Tiket</span>
                                </label>
                                <input type="text"
                                    id="ticketCodePrefix"
                                    name="ticket_code_prefix"
                                    class="w-full px-6 py-4 bg-white/80 border-2 border-gray-200 rounded-2xl text-gray-800 placeholder-gray-400 transition-all duration-300 backdrop-blur-sm shadow-lg hover:border-gray-300 hover:bg-white/90 hover:-translate-y-0.5 focus:outline-none focus:border-purple-400 focus:bg-white/95 focus:-translate-y-0.5 focus:shadow-xl focus:shadow-purple-500/10"
                                    placeholder="Contoh: VVIP-001"
                                    required>
                            </div>
                        </div>

                        <!-- Jenis Tiket -->
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-200/20 to-indigo-200/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <label class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                                    <div class="w-5 h-5 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-tags text-purple-600 text-xs"></i>
                                    </div>
                                    <span>Jenis Tiket</span>
                                </label>
                                <div class="relative">
                                    <select id="jenisTicket"
                                        name="jenis_ticket"
                                        class="w-full px-6 py-4 pr-12 bg-white/80 border-2 border-gray-200 rounded-2xl text-gray-800 placeholder-gray-400 transition-all duration-300 backdrop-blur-sm shadow-lg hover:border-gray-300 hover:bg-white/90 hover:-translate-y-0.5 focus:outline-none focus:border-purple-400 focus:bg-white/95 focus:-translate-y-0.5 focus:shadow-xl focus:shadow-purple-500/10 appearance-none cursor-pointer"
                                        required>
                                        <option value="">Pilih Jenis Tiket</option>
                                        <option value="VVIP">🌟 VVIP - Very Very Important Person</option>
                                        <option value="VIP">⭐ VIP - Very Important Person</option>
                                        <option value="Reguler">🎫 Reguler - Tiket Standar</option>
                                        <option value="Online">💻 Online - Akses Digital</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Quantity Section -->
                <div class="bg-gradient-to-br from-white/60 to-white/40 backdrop-blur-sm p-6 rounded-3xl border border-white/50 hover:from-white/70 hover:to-white/50 transition-all duration-300">
                    <h4 class="text-lg font-bold text-gray-700 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-green-600 text-sm"></i>
                        </div>
                        <span>Harga & Ketersediaan</span>
                    </h4>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Harga -->
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-200/20 to-emerald-200/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <label class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                                    <div class="w-5 h-5 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-rupiah-sign text-green-600 text-xs"></i>
                                    </div>
                                    <span>Harga (Rupiah)</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-6 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold z-10">Rp</span>
                                    <input type="number"
                                        id="price"
                                        name="price"
                                        min="0"
                                        class="w-full pl-12 pr-6 py-4 bg-white/80 border-2 border-gray-200 rounded-2xl text-gray-800 placeholder-gray-400 transition-all duration-300 backdrop-blur-sm shadow-lg hover:border-gray-300 hover:bg-white/90 hover:-translate-y-0.5 focus:outline-none focus:border-purple-400 focus:bg-white/95 focus:-translate-y-0.5 focus:shadow-xl focus:shadow-purple-500/10"
                                        placeholder="100.000"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Jumlah Tiket -->
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-200/20 to-emerald-200/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <label class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                                    <div class="w-5 h-5 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-calculator text-green-600 text-xs"></i>
                                    </div>
                                    <span>Jumlah Tiket Tersedia</span>
                                </label>
                                <div class="relative">
                                    <input type="number"
                                        id="quantityAvailable"
                                        name="quantity_available"
                                        min="1"
                                        class="w-full px-6 pr-12 py-4 bg-white/80 border-2 border-gray-200 rounded-2xl text-gray-800 placeholder-gray-400 transition-all duration-300 backdrop-blur-sm shadow-lg hover:border-gray-300 hover:bg-white/90 hover:-translate-y-0.5 focus:outline-none focus:border-purple-400 focus:bg-white/95 focus:-translate-y-0.5 focus:shadow-xl focus:shadow-purple-500/10"
                                        placeholder="100"
                                        required>
                                    <span class="absolute right-6 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm font-medium">pcs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Period Section -->
                <div class="bg-gradient-to-br from-white/60 to-white/40 backdrop-blur-sm p-6 rounded-3xl border border-white/50 hover:from-white/70 hover:to-white/50 transition-all duration-300">
                    <h4 class="text-lg font-bold text-gray-700 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-blue-600 text-sm"></i>
                        </div>
                        <span>Periode Pemesanan Tiket</span>
                    </h4>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Tanggal Mulai -->
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-200/20 to-indigo-200/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <label class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                                    <div class="w-5 h-5 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-play-circle text-green-600 text-xs"></i>
                                    </div>
                                    <span>Mulai Pemesanan</span>
                                </label>
                                <input type="datetime-local"
                                    id="startPesan"
                                    name="start_pesan"
                                    class="w-full px-6 py-4 bg-white/80 border-2 border-gray-200 rounded-2xl text-gray-800 placeholder-gray-400 transition-all duration-300 backdrop-blur-sm shadow-lg hover:border-gray-300 hover:bg-white/90 hover:-translate-y-0.5 focus:outline-none focus:border-purple-400 focus:bg-white/95 focus:-translate-y-0.5 focus:shadow-xl focus:shadow-purple-500/10"
                                    required>
                            </div>
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-200/20 to-indigo-200/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <label class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                                    <div class="w-5 h-5 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-stop-circle text-red-600 text-xs"></i>
                                    </div>
                                    <span>Selesai Pemesanan</span>
                                </label>
                                <input type="datetime-local"
                                    id="endPesan"
                                    name="end_pesan"
                                    class="w-full px-6 py-4 bg-white/80 border-2 border-gray-200 rounded-2xl text-gray-800 placeholder-gray-400 transition-all duration-300 backdrop-blur-sm shadow-lg hover:border-gray-300 hover:bg-white/90 hover:-translate-y-0.5 focus:outline-none focus:border-purple-400 focus:bg-white/95 focus:-translate-y-0.5 focus:shadow-xl focus:shadow-purple-500/10"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Info Helper -->
                    <div class="mt-6 p-4 bg-blue-50/80 backdrop-blur-sm rounded-2xl border-l-4 border-blue-400">
                        <p class="text-sm text-blue-700 flex items-center gap-3">
                        <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-info text-blue-600 text-xs"></i>
                        </div>
                        <span>Pastikan periode pemesanan sesuai dengan waktu pelaksanaan event Anda</span>
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-end gap-4 pt-8 border-t-2 border-gray-100">
                    <button type="button"
                        onclick="closeTicketModal()"
                        class="group px-8 py-4 border-2 border-gray-300 rounded-2xl text-gray-700 font-bold hover:bg-gray-50 hover:border-gray-400 hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl">
                        <i class="fas fa-times group-hover:rotate-90 transition-transform duration-200"></i>
                        <span>Batal</span>
                    </button>
                    <button type="submit"
                        class="px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-2xl hover:from-purple-700 hover:to-indigo-700 hover:-translate-y-1 hover:scale-105 transition-all duration-200 flex items-center justify-center gap-3 shadow-lg hover:shadow-2xl">
                        <i class="fas fa-save"></i>
                        <span>Simpan Tiket</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @vite(['resources/js/organizer-dashboard-events.js']) {{-- JS kamu --}}
</x-app-layout>