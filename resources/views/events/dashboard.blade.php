<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
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
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes shimmer {
            0% { background-position: -200px 0; }
            100% { background-position: calc(200px + 100%) 0; }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-slide-in-up {
            animation: slideInUp 0.6s ease-out;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200px 100%;
            animation: shimmer 1.5s infinite;
        }
        
        /* Gradient backgrounds */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .ticket-gradient {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        /* Glass morphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Hover effects */
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        /* Button effects */
        .btn-pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.03);
            }
            100% {
                transform: scale(1);
            }
        }
        
        /* Status badges */
        .status-approved {
            background: linear-gradient(45deg, #4ade80, #22c55e);
        }
        
        .status-pending {
            background: linear-gradient(45deg, #fbbf24, #f59e0b);
        }
        
        .status-rejected {
            background: linear-gradient(45deg, #f87171, #ef4444);
        }
        
        /* Modal animations */
        .modal-enter {
            animation: modalSlideIn 0.3s ease-out;
        }
        
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        /* Table row hover */
        .table-row:hover {
            background: linear-gradient(90deg, rgba(103, 167, 244, 0.05), rgba(103, 167, 244, 0.1));
            transform: scale(1.01);
            transition: all 0.3s ease;
        }
        
        /* Background decoration */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: -40%;
            right: -20%;
            width: 80vw;
            height: 80vh;
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1), rgba(0, 242, 254, 0.1));
            border-radius: 50%;
            z-index: -1;
            animation: float 8s ease-in-out infinite;
        }
        
        body::after {
            content: '';
            position: fixed;
            bottom: -40%;
            left: -20%;
            width: 90vw;
            height: 90vh;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 50%;
            z-index: -1;
            animation: float 8s ease-in-out infinite reverse;
        }
    </style>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        {{-- DETAIL EVENT --}}
        <div class="bg-white/80 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/50 p-8 hover-lift animate-slide-in-up">
            <div class="flex items-center gap-4 mb-6">
                <div class="relative">
                    <div class="w-14 h-14 gradient-card text-white flex items-center justify-center rounded-2xl shadow-lg">
                        <i class="fas fa-calendar-alt text-xl"></i>
                    </div>
                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full animate-pulse"></div>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text">
                        Detail Event: {{ $event->name_event }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Informasi lengkap event yang sedang dikelola</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-2xl border border-blue-100">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-calendar text-blue-500 text-lg"></i>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Periode Event</p>
                            <p class="text-lg font-bold text-gray-800">
                                {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }} - 
                                {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-4 rounded-2xl border border-green-100">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-500 text-lg"></i>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold text-white shadow-lg
                                {{ $event->status_approval === 'approved' ? 'status-approved' : 
                                ($event->status_approval === 'pending' ? 'status-pending' : 'status-rejected') }}">
                                <i class="fas fa-{{ $event->status_approval === 'approved' ? 'check' : ($event->status_approval === 'pending' ? 'clock' : 'times') }} mr-1"></i>
                                {{ ucfirst($event->status_approval) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-4 rounded-2xl border border-purple-100">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-map-marker-alt text-purple-500 text-lg"></i>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Venue</p>
                            <p class="text-lg font-bold text-gray-800">{{ $event->venue_name }}</p>
                            <p class="text-sm text-gray-500">{{ $event->venue_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MANAJEMEN TIKET --}}
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 hover-lift animate-slide-in-up" style="animation-delay: 0.2s;">
            <!-- Header -->
            <div class="bg-[#63A7F4] px-8 py-8 rounded-t-3xl">
            <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-ticket-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold text-white">Manajemen Tiket</h3>
                            <p class="text-white/90 text-sm mt-1">Kelola semua tiket untuk event ini</p>
                        </div>
                    </div>
                    <button onclick="openTicketModal('create')" class="mt-6 sm:mt-0 bg-white text-blue-600 font-bold px-8 py-4 rounded-2xl hover:bg-gray-50 transition-all duration-300 flex items-center space-x-3 shadow-xl hover:shadow-2xl transform hover:scale-105 btn-pulse">
                        <i class="fas fa-plus text-lg"></i>
                        <span>Tambah Tiket</span>
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="px-8 py-6 bg-gradient-to-r from-blue-50/50 to-indigo-50/50">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-white/50 text-center shadow-lg hover-lift">
                        <div class="text-2xl font-bold text-blue-600" id="totalTickets">0</div>
                        <div class="text-sm text-gray-600">Total Tiket</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-white/50 text-center shadow-lg hover-lift">
                        <div class="text-2xl font-bold text-green-600" id="availableTickets">0</div>
                        <div class="text-sm text-gray-600">Tersedia</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-white/50 text-center shadow-lg hover-lift">
                        <div class="text-2xl font-bold text-orange-600" id="soldTickets">0</div>
                        <div class="text-sm text-gray-600">Terjual</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-white/50 text-center shadow-lg hover-lift">
                        <div class="text-2xl font-bold text-purple-600" id="soldPercentage">0%</div>
                        <div class="text-sm text-gray-600">Sold Out</div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="p-8">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b-2 border-gray-200 text-gray-600 text-sm">
                                <th class="py-6 px-4 font-bold">#</th>
                                <th class="py-6 px-4 font-bold">Kode</th>
                                <th class="py-6 px-4 font-bold">Jenis</th>
                                <th class="py-6 px-4 font-bold">Harga</th>
                                <th class="py-6 px-4 font-bold">Tersedia</th>
                                <th class="py-6 px-4 font-bold">Terjual</th>
                                <th class="py-6 px-4 font-bold">Periode</th>
                                <th class="py-6 px-4 font-bold">Aksi</th>
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

    {{-- MODAL TIKET --}}
    <div id="ticketModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div id="modalContent" class="bg-white/95 backdrop-blur-sm p-8 rounded-3xl w-full max-w-4xl shadow-2xl border border-white/50">
        <div class="flex justify-between items-center mb-8">
            <h3 id="ticketModalTitle" class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <div class="w-12 h-12 bg-[#63A7F4] rounded-2xl flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-white text-lg"></i>
                </div>
                <span>Tambah Tiket</span>
            </h3>
            <button onclick="closeTicketModal()" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-xl transition-colors duration-200">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <form id="ticketForm" class="space-y-8">
            <input type="hidden" id="ticketId" name="ticket_id">
            <input type="hidden" id="eventId" name="event_id" value="{{ $event->event_id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Tiket</label>
                    <input type="text" id="ticketCodePrefix" name="ticket_code_prefix" class="input" placeholder="Contoh: VVIP-001" required>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Tiket</label>
                    <select id="jenisTicket" name="jenis_ticket" class="input" required>
                        <option value="">Pilih Jenis Tiket</option>
                        <option value="VVIP">VVIP</option>
                        <option value="VIP">VIP</option>
                        <option value="Reguler">Reguler</option>
                        <option value="Online">Online</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp)</label>
                    <input type="number" id="price" name="price" min="0" class="input" placeholder="0" required>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Tiket</label>
                    <input type="number" id="quantityAvailable" name="quantity_available" min="1" class="input" placeholder="100" required>
                </div>
                <div class="md:col-span-2 space-y-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-4">Periode Pemesanan</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-medium text-gray-500 mb-2">Mulai</label>
                            <input type="datetime-local" id="startPesan" name="start_pesan" class="input" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-medium text-gray-500 mb-2">Selesai</label>
                            <input type="datetime-local" id="endPesan" name="end_pesan" class="input" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-8 border-t border-gray-200">
                <button type="button" onclick="closeTicketModal()" class="px-8 py-4 border-2 border-gray-200 rounded-2xl text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </button>
                <button type="submit" class="px-8 py-4 bg-[#63A7F4] text-white font-bold rounded-2xl hover:shadow-lg transition-all duration-200 flex items-center gap-3 transform hover:scale-105">
                    <i class="fas fa-save"></i>
                    <span>Simpan Tiket</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let tickets = [];

    function openTicketModal(action, data = {}) {
        const modal = document.getElementById('ticketModal');
        const modalContent = document.getElementById('modalContent');
        const form = document.getElementById('ticketForm');

        form.reset();
        document.getElementById('ticketModalTitle').querySelector('span').textContent = action === 'edit' ? 'Edit Tiket' : 'Tambah Tiket';

        if (action === 'edit') {
            document.getElementById('ticketId').value = data.id || '';
            document.getElementById('ticketCodePrefix').value = data.ticket_code_prefix || '';
            document.getElementById('jenisTicket').value = data.jenis_ticket || '';
            document.getElementById('price').value = data.price || '';
            document.getElementById('quantityAvailable').value = data.quantity_available || '';

            const formatDateTime = (dateStr) => {
            if (!dateStr) return '';
            const date = new Date(dateStr);

            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');

            return `${year}-${month}-${day}T${hours}:${minutes}`;
        };


            document.getElementById('startPesan').value = formatDateTime(data.start_pesan);
            document.getElementById('endPesan').value = formatDateTime(data.end_pesan);
        }

        modal.classList.remove('hidden');
        setTimeout(() => modalContent.classList.add('modal-enter'), 10);
    }

    function closeTicketModal() {
        const modal = document.getElementById('ticketModal');
        const modalContent = document.getElementById('modalContent');
        modalContent.classList.remove('modal-enter');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    document.getElementById('ticketModal').addEventListener('click', function(e) {
        if (e.target === this) closeTicketModal();
    });

    function editTicket(id) {
        const ticket = tickets.find(t => t.id === id);
        if (ticket) openTicketModal('edit', ticket);
    }
</script>

    @vite(['resources/js/organizer-dashboard-events.js']) {{-- JS kamu --}}
</x-app-layout>