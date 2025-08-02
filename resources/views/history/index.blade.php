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
                   @forelse ($histories as $history)
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
                            <a href="{{ route('history.show', $history['transaction_id']) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-xs">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500 dark:text-gray-400">
                            Belum ada riwayat pembelian tiket.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
