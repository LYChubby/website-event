<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-4">Dashboard Event: {{ $event->name_event }}</h2>

        <!-- Detail Event -->
        <div class="bg-white p-6 rounded-2xl shadow-xl mb-6 border border-gray-100 animate-fade-in">
            <div class="flex flex-col space-y-3">
                <p><strong class="text-gray-700">Tanggal:</strong> {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }} s.d. {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}</p>
                <p>
                    <strong class="text-gray-700">Status:</strong>
                    <span class="text-sm px-3 py-1 rounded-full 
                        {{ $event->status_approval === 'approved' ? 'bg-green-100 text-green-800' : 
                           ($event->status_approval === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($event->status_approval) }}
                    </span>
                </p>
                <p><strong class="text-gray-700">Venue:</strong> {{ $event->venue_name }} - {{ $event->venue_address }}</p>
            </div>
        </div>

        <!-- Daftar Tiket -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in border border-gray-100">
            <div class="gradient-bg px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-lg text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Manajemen Tiket</h3>
                            <p class="text-blue-100">Kelola semua tiket untuk event ini</p>
                        </div>
                    </div>
                    <button onclick="openTicketModal('create')" class="mt-4 sm:mt-0 bg-white text-[#63A7F4] font-semibold px-6 py-3 rounded-xl hover:bg-gray-100 transition-all duration-300 flex items-center space-x-2 shadow-lg">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Tiket</span>
                    </button>
                </div>
            </div>

            <div class="p-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">#</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Kode</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Jenis</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Harga</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Tersedia</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Terjual</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Periode</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="ticketTableBody" class="divide-y divide-gray-100">
                            <!-- Tickets will be loaded via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Modal -->
    <div id="ticketModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300">
        <div id="modalContent" class="bg-white p-8 rounded-2xl w-full max-w-2xl transform transition-all duration-300 scale-95 opacity-0">
            <div class="flex justify-between items-center mb-6">
                <h3 id="ticketModalTitle" class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-plus mr-3 text-[#63A7F4]"></i>
                    <span>Tambah Tiket</span>
                </h3>
                <button onclick="closeTicketModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="ticketForm" class="space-y-4">
                <input type="hidden" id="ticketId" name="ticket_id">
                <input type="hidden" id="eventId" name="event_id" value="{{ $event->event_id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="ticketCodePrefix" class="block text-sm font-medium text-gray-700 mb-1">Kode Tiket</label>
                        <input type="text" id="ticketCodePrefix" name="ticket_code_prefix" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#63A7F4] focus:border-[#63A7F4]" required>
                    </div>

                    <div>
                        <label for="jenisTicket" class="block text-sm font-medium text-gray-700 mb-1">Jenis Tiket</label>
                        <select id="jenisTicket" name="jenis_ticket" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#63A7F4] focus:border-[#63A7F4]" required>
                            <option value="VVIP">VVIP</option>
                            <option value="VIP">VIP</option>
                            <option value="Reguler">Reguler</option>
                            <option value="Online">Online</option>
                        </select>
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" id="price" name="price" min="0" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#63A7F4] focus:border-[#63A7F4]" required>
                    </div>

                    <div>
                        <label for="quantityAvailable" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tiket</label>
                        <input type="number" id="quantityAvailable" name="quantity_available" min="1" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#63A7F4] focus:border-[#63A7F4]" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Periode Pemesanan</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="startPesan" class="block text-xs text-gray-500 mb-1">Mulai</label>
                                <input type="datetime-local" id="startPesan" name="start_pesan" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#63A7F4] focus:border-[#63A7F4]" required>
                            </div>
                            <div>
                                <label for="endPesan" class="block text-xs text-gray-500 mb-1">Selesai</label>
                                <input type="datetime-local" id="endPesan" name="end_pesan" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#63A7F4] focus:border-[#63A7F4]" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeTicketModal()" class="px-6 py-3 border border-gray-300 rounded-xl font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-300">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-3 bg-[#63A7F4] text-white rounded-xl font-medium hover:bg-[#4a8fd6] transition-colors duration-300 flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Simpan Tiket</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @vite(['resources/js/organizer-dashboard-events.js']) {{-- file JS khusus organizer --}}
</x-app-layout>