<x-app-layout>
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

    <div class="w-full h-64 bg-gray-200 overflow-hidden">
        <img src="{{ asset('storage/' . $event->event_image) }}" alt="{{ $event->name_event }}" class="w-full h-full object-cover">
    </div>

    <!-- Event Detail -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="md:flex">
                <div class="md:w-2/3 p-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $event->name_event }}</h1>
                    <p class="text-gray-600 mb-4">{{ $event->venue_name }} | {{ $event->category->name ?? 'Kategori' }}</p>

                    <div class="flex items-center text-gray-600 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $event->venue_address }}</span>
                    </div>

                    <div class="flex items-center text-gray-600 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d F Y, H:i') }} –
                            {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }} WIB
                        </span>
                    </div>

                    <div class="flex space-x-4 mb-6">
                        <button type="button" class="flex items-center px-4 py-2 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            Bagikan Event
                        </button>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Deskripsi Event</h2>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700">{{ $event->description }}</p>
                        </div>
                    </div>

                    <!-- Section Daftar Tiket -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Tiket</h2>

                        @if($event->tickets->count() > 0)
                        <div class="space-y-4">
                            @foreach($event->tickets as $ticket)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                                <div class="p-5">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-800">{{ $ticket->jenis_ticket }}</h3>
                                            <p class="text-gray-600 text-sm mt-1">
                                                <i class="fas fa-tag mr-1"></i> {{ $ticket->ticket_code_prefix }}
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-sm font-medium 
                                            @if($ticket->jenis_ticket === 'VVIP')
                                                bg-purple-100 text-purple-800
                                            @elseif($ticket->jenis_ticket === 'VIP')
                                                bg-blue-100 text-blue-800
                                            @elseif($ticket->jenis_ticket === 'Reguler')
                                                bg-green-100 text-green-800
                                            @else
                                                bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $ticket->jenis_ticket }}
                                        </span>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-2xl font-bold text-gray-800">
                                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </p>

                                        <div class="mt-3 grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <p class="text-gray-500">Tersedia</p>
                                                <p class="font-medium">{{ $ticket->quantity_available }} tiket</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Terjual</p>
                                                <p class="font-medium">{{ $ticket->quantity_sold }} tiket</p>
                                            </div>
                                        </div>

                                        <div class="mt-3 text-sm">
                                            <p class="text-gray-500">Periode Pemesanan</p>
                                            <p class="font-medium">
                                                {{ \Carbon\Carbon::parse($ticket->start_pesan)->format('d M Y H:i') }} -
                                                {{ \Carbon\Carbon::parse($ticket->end_pesan)->format('d M Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-5 py-3 flex justify-between items-center">
                                    <span class="text-sm text-gray-500">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        {{ $ticket->description ?? 'Tidak ada deskripsi tambahan' }}
                                    </span>
                                    <button
                                        onclick="openBuyTicketModal('{{ $ticket->ticket_id }}', '{{ $event->name_event }}', '{{ $ticket->price }}')"
                                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                        Beli Tiket
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="bg-gray-50 p-8 rounded-lg text-center">
                            <i class="fas fa-ticket-alt text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Belum ada tiket tersedia untuk event ini</p>
                        </div>
                        @endif
                    </div>
                </div>



                <div class="md:w-1/3 bg-gray-50 p-6">
                    <div class="sticky top-6">
                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pilih Tanggal</h3>
                            <!-- Date picker would go here -->
                            <div class="text-center py-4 text-gray-500">
                                Pilih tanggal tersedia
                            </div>
                        </div>

                        <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                            Daftar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
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

    <!-- MODAL PEMBELIAN TIKET -->
    <div id="buyTicketModal" class="fixed inset-0 bg-black bg-opacity-50 justify-center items-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 relative">
            <button class="absolute top-3 right-3 text-gray-500 hover:text-black" onclick="closeBuyTicketModal()">
                <i class="fas fa-times"></i>
            </button>

            <h2 class="text-2xl font-bold mb-2 text-center">Beli Tiket</h2>
            <p class="text-gray-700 text-center mb-4">Event: <span id="buyTicketName" class="font-semibold"></span></p>
            <p class="text-gray-700 text-center mb-4">Harga: <span id="buyTicketPrice" class="font-semibold"></span></p>

            <form id="buyTicketForm">
                @csrf
                <input type="hidden" name="ticket_id" id="buyTicketId">
                <input type="hidden" name="event_id" value="{{ $event->event_id }}">

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Nama Peserta</label>
                    <input type="text" name="nama" id="participantName" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Jumlah Tiket</label>
                    <input type="number" name="quantity" id="ticketQuantity" min="1" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-6">
                    <label class="block mb-1 font-semibold">Metode Pembayaran</label>
                    <select name="payment_method" id="paymentMethod" class="w-full border rounded px-3 py-2" required>
                        <option value="QRIS">QRIS</option>
                        <option value="BANK_TRANSFER">Transfer Bank</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
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
            document.getElementById('paymentMethod').value = 'qris';

            document.getElementById('buyTicketModal').classList.remove('hidden');
            document.getElementById('buyTicketModal').classList.add('flex');
        }

        function closeBuyTicketModal() {
            document.getElementById('buyTicketModal').classList.add('hidden');
            document.getElementById('buyTicketModal').classList.remove('flex');
        }

        document.getElementById('buyTicketForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

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
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Terjadi kesalahan saat memproses pembayaran.');
                });
        });
    </script>

</x-app-layout>