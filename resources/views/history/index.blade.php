<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Riwayat Pembelian Tiket
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="py-3 px-4 text-left">Nama</th>
                        <th class="py-3 px-4 text-left">Event</th>
                        <th class="py-3 px-4 text-left">Tanggal Pembelian</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($histories as $history)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="py-3 px-4">{{ $history['nama_pembeli'] }}</td>
                        <td class="py-3 px-4">{{ $history['nama_event'] }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($history['tanggal_beli'])->format('d M Y') }}</td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 rounded-full text-white text-xs {{ $history['status_pembayaran'] === 'paid' ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ ucfirst($history['status_pembayaran']) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <button onclick="showTransactionDetail(`{{ $history['transaction_id'] }}`)"
                                class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-xs">
                                Lihat Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal -->
            <div id="transactionModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xl">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Detail Transaksi</h3>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                    </div>
                    <div id="modalContent">
                        <!-- Detail akan dimuat via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTransactionDetail(transactionId) {
            fetch(`/history/${transactionId}`)
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        const data = response.data;
                        let html = `
                            <p><strong>Event:</strong> ${data.event_name}</p>
                            <p><strong>Tanggal Beli:</strong> ${data.tanggal_beli}</p>
                            <p><strong>Status:</strong> ${data.status_pembayaran}</p>
                            <p><strong>Metode Pembayaran:</strong> ${data.payment_method}</p>
                            <hr class="my-2">
                            <p class="font-semibold">Tiket:</p>
                            <ul class="list-disc list-inside">`;

                        data.details.forEach(item => {
                            html += `<li>${item.ticket_name} - ${item.quantity} x Rp${Number(item.price).toLocaleString("id-ID")} = Rp${Number(item.subtotal).toLocaleString("id-ID")}</li>`;
                        });

                        html += `</ul>
                            <hr class="my-2">
                            <p><strong>Total:</strong> Rp${Number(data.total).toLocaleString("id-ID")}</p>`;

                        document.getElementById('modalContent').innerHTML = html;
                        const modal = document.getElementById('transactionModal');
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    } else {
                        alert('Gagal mengambil detail transaksi');
                    }
                })
                .catch(() => alert('Terjadi kesalahan'));
        }

        function closeModal() {
            const modal = document.getElementById('transactionModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
