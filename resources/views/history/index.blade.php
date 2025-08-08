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
                                    {{ strtoupper(substr($history['nama_pembeli'], 0, 2)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $history['nama_pembeli'] }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-medium text-gray-800">{{ $history['nama_event'] }}</p>
                                <p class="text-sm text-gray-500">Event Location</p>
                            </td>
                            <td class="py-4 px-6 text-gray-600">
                                {{ \Carbon\Carbon::parse($history['tanggal_beli'])->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6">
                                <span
                                    class="px-4 py-2 rounded-full text-white text-sm font-medium {{ $history['status_pembayaran'] === 'paid' ? 'status-paid' : 'status-unpaid' }}">
                                    {{ $history['status_pembayaran'] === 'paid' ? '✅ Paid' : '⏳ Unpaid' }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <button onclick="showTransactionDetail(`{{ $history['transaction_id'] }}`)"
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
</x-app-layout>
