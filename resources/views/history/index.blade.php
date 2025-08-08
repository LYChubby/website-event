<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center space-x-4 pb-6">
        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
            <i class="fas fa-history text-2xl text-white"></i>
        </div>
        <div>
            <h2 class="font-semibold text-2xl text-white leading-tight">
                Riwayat
            </h2>
            <p class="text-sm text-purple-100">Kelola dan lihat semua riwayat transaksi tiket Anda</p>
        </div>
    </div>
</x-slot>

    <style>
        :root {
            --purple: #684597;
            --blue: #5C6AD0;
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--purple) 0%, var(--blue) 100%);
        }

        .table-header {
            background: linear-gradient(135deg, var(--purple), var(--blue));
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(108, 99, 255, 0.15);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(108, 99, 255, 0.2);
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--purple), var(--blue));
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, var(--blue), var(--purple));
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.4);
        }

        .status-paid {
            background: linear-gradient(45deg, #10B981, #059669);
        }

        .status-unpaid {
            background: linear-gradient(45deg, #EF4444, #DC2626);
        }
    </style>

    <div class="py-6 px-4 max-w-7xl mx-auto -mt-10 mt-6">
        <div class="glass-effect rounded-2xl shadow-xl overflow-hidden">
            <!-- Stats Cards -->
            <div class="py-10 px-6 border-b border-purple-100 bg-gradient-to-r from-purple-50 to-purple-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Transaksi -->
                    <div class="bg-gradient-to-r from-purple-500 to-blue-500 rounded-xl p-4 text-white hover-lift">
                        <p class="text-purple-100 text-sm">Total Transaksi</p>
                        <p class="text-3xl font-bold">{{ count($histories) }}</p>
                    </div>
                    <!-- Paid -->
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 text-white hover-lift">
                        <p class="text-green-100 text-sm">Pembayaran Berhasil</p>
                        <p class="text-3xl font-bold">{{ $histories->where('status_pembayaran', 'paid')->count() }}</p>
                    </div>
                    <!-- Unpaid -->
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-4 text-white hover-lift">
                        <p class="text-orange-100 text-sm">Menunggu Pembayaran</p>
                        <p class="text-3xl font-bold">{{ $histories->where('status_pembayaran', '!=', 'paid')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="p-6 border-b border-purple-100">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="relative flex-1 max-w-md">
                        <input type="text" placeholder="Cari event atau nama pembeli..."
                            class="w-full pl-10 pr-4 py-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-300">
                        <svg class="absolute left-3 top-3.5 w-5 h-5 text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 1114 0 7 7 0 01-14 0z"></path>
                        </svg>
                    </div>
                    <div class="flex gap-3">
                        <select
                            class="px-4 py-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-300 bg-white">
                            <option>Semua Status</option>
                            <option>Paid</option>
                            <option>Unpaid</option>
                        </select>
                        <button class="btn-primary text-white px-6 py-3 rounded-xl font-medium">
                            Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="table-header text-white">
                        <tr>
                            <th class="py-4 px-6 text-left font-semibold">👤 Nama</th>
                            <th class="py-4 px-6 text-left font-semibold">🎫 Event</th>
                            <th class="py-4 px-6 text-left font-semibold">📅 Tanggal Pembelian</th>
                            <th class="py-4 px-6 text-left font-semibold">💳 Status</th>
                            <th class="py-4 px-6 text-left font-semibold">⚙️ Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-purple-100">
    @foreach ($histories as $history)
    <tr class="hover-lift hover:bg-purple-50">
        <td class="py-4 px-6 flex items-center">
            <div
                class="w-10 h-10 bg-gradient-to-r from-purple-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                {{ strtoupper(substr($history->nama_peserta, 0, 2)) }}
            </div>
            <span class="font-medium text-gray-800">{{ $history->nama_peserta }}</span>
        </td>
        <td class="py-4 px-6">
            <p class="font-medium text-gray-800">{{ $history->name_event }}</p>
            <p class="text-sm text-gray-500">{{ $history->venue_name }} - {{ $history->venue_address }}</p>
        </td>
        <td class="py-4 px-6 text-gray-600">
            {{ \Carbon\Carbon::parse($history->tanggal_beli)->format('d M Y') }}
        </td>
        <td class="py-4 px-6">
            <span
                class="px-4 py-2 rounded-full text-white text-sm font-medium {{ $history->status_pembayaran === 'paid' ? 'status-paid' : 'status-unpaid' }}">
                {{ $history->status_pembayaran === 'paid' ? '✅ Paid' : '⏳ Unpaid' }}
            </span>
        </td>
        <td class="py-4 px-6">
            <button onclick="showTransactionDetail(`{{ $history->transaction_id }}`)"
                class="btn-primary text-white py-2 px-4 rounded-lg text-sm font-medium flex items-center gap-2">
                Lihat Detail
            </button>
        </td>
    </tr>
    @endforeach
</tbody>

                </table>
            </div>
        </div>
    </div>
    <!-- Enhanced Modal - Mempertahankan struktur asli dengan styling baru -->
    <div id="transactionModal" class="fixed inset-0 z-50 hidden modal-backdrop items-center justify-center">
        <div class="glass-effect rounded-2xl shadow-2xl p-6 w-full max-w-4xl animate-fade-in">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-blue-200">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Detail Transaksi</h3>
                    <p class="text-blue-600 mt-1">Informasi lengkap pembelian tiket</p>
                </div>
                <button onclick="closeModal()"
                    class="bg-red-100 hover:bg-red-200 rounded-full p-2 transition-colors">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content - Area tempat konten akan dimuat -->
            <div id="modalContent">
                <!-- Detail akan dimuat via JavaScript - mempertahankan fungsi asli -->
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
                    <p class="mt-4 text-gray-600">Memuat detail transaksi...</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        function showTransactionDetail(transactionId) {
            // Menampilkan modal
            const modal = document.getElementById('transactionModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            fetch(`/history/${transactionId}`)
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        const data = response.data;
                        let html = `
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                            <div class="space-y-4">
                                <div class="bg-blue-50 rounded-xl p-4 border-l-4 border-blue-400">
                                    <h4 class="font-semibold text-blue-800 mb-3 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Informasi Event
                                    </h4>
                                    <div class="space-y-2">
                                        <p class="text-gray-700"><strong>Event:</strong> ${data.event_name}</p>
                                        <p class="text-gray-700"><strong>Tanggal Beli:</strong> ${data.tanggal_beli}</p>
                                        <p class="text-gray-700"><strong>Status:</strong> 
                                            <span class="px-3 py-1 rounded-full text-white text-xs ${data.status_pembayaran === 'paid' ? 'bg-green-500' : 'bg-red-500'}">
                                                ${data.status_pembayaran === 'paid' ? '✅ Paid' : '⏳ Unpaid'}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-xl p-4 text-center border-l-4 border-gray-400">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 011-1h2a1 1 0 011 1v1a1 1 0 001-1h2a1 1 0 011 1v3H5V8z"></path>
                                    </svg>
                                    QR Code & Invoice
                                </h4>
                                <p class="text-sm text-gray-600 mb-3"><strong>No. Invoice:</strong></p>
                                <div id="qrcode" class="flex justify-center mb-3"></div>
                                <p class="text-xs text-gray-500 font-mono">${data.no_invoice}</p>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 rounded-xl p-6 border-l-4 border-blue-400">
                            <h4 class="font-semibold text-blue-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"></path>
                                </svg>
                                Detail Tiket
                            </h4>
                            <div class="space-y-3">`;

                        data.details.forEach(item => {
                            html += `
                                <div class="bg-white rounded-lg p-4 border shadow-sm">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-medium text-gray-800">${item.ticket_name}</p>
                                            <p class="text-sm text-gray-600">${item.quantity} x Rp${Number(item.price).toLocaleString("id-ID")} = Rp${Number(item.subtotal).toLocaleString("id-ID")}</p>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 mt-3">
                                        <p class="text-sm font-medium text-gray-700">Kode Tiket:</p>
                                        <p class="font-mono text-blue-600 text-lg">${item.ticket_code}</p>
                                    </div>
                                </div>`;
                        });

                        html += `
                            </div>
                            <div class="border-t border-blue-200 mt-6 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-800">Total:</span>
                                    <span class="text-2xl font-bold text-blue-600">Rp${Number(data.total).toLocaleString("id-ID")}</span>
                                </div>
                            </div>
                        </div>`;

                        document.getElementById('modalContent').innerHTML = html;

                        // Generate QR Code dengan warna theme
                        new QRCode(document.getElementById("qrcode"), {
                            text: `${window.location.origin}/tiket/${data.no_invoice}`,
                            width: 128,
                            height: 128,
                            colorDark: "#63A7F4",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });

                    } else {
                        document.getElementById('modalContent').innerHTML = `
                            <div class="text-center py-8">
                                <div class="text-red-500 text-6xl mb-4">❌</div>
                                <p class="text-gray-600">Gagal mengambil detail transaksi</p>
                            </div>`;
                    }
                })
                .catch(() => {
                    document.getElementById('modalContent').innerHTML = `
                        <div class="text-center py-8">
                            <div class="text-red-500 text-6xl mb-4">⚠️</div>
                            <p class="text-gray-600">Terjadi kesalahan saat memuat data</p>
                        </div>`;
                });
        }

        function closeModal() {
            const modal = document.getElementById('transactionModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('transactionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</x-app-layout>
