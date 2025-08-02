<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-400 to-blue-500" style="background: linear-gradient(135deg, #63A7F4 0%, #4A90E2 100%);">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <h2 class="font-bold text-2xl text-white leading-tight">
                        E-Tiket Pembelian
                    </h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Main Ticket Card -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
                <!-- Header Section -->
                <div class="relative" style="background: linear-gradient(135deg, #63A7F4 0%, #4A90E2 100%);">
                    <div class="absolute inset-0 bg-black/5"></div>
                    <div class="relative px-8 py-8 text-white">
                        <div class="flex items-start justify-between">
                            <div class="space-y-3">
                                <div class="inline-block bg-white/20 px-4 py-2 rounded-full text-sm font-medium">
                                    🎫 Tiket Digital
                                </div>
                                <h3 class="text-2xl font-bold leading-tight">
                                    {{ $transaction->event->name_event }}
                                </h3>
                                <div class="flex items-center space-x-2 text-blue-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0a2 2 0 00-2 2v10a2 2 0 002 2h6a2 2 0 002-2V9a2 2 0 00-2-2"></path>
                                    </svg>
                                    <span class="text-sm">Pembelian Berhasil</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="bg-white/20 p-3 rounded-xl">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -bottom-1 left-0 right-0">
                        <svg viewBox="0 0 1200 40" class="w-full h-auto text-white">
                            <path d="M0,20 Q300,40 600,20 T1200,20 L1200,40 L0,40 Z" fill="currentColor" />
                        </svg>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="px-8 py-8">
                    <!-- Purchase Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #63A7F4; opacity: 0.1;">
                                    <svg class="w-5 h-5" style="color: #63A7F4;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 font-medium">Nama Pembeli</p>
                                    <p class="text-lg font-semibold text-gray-800">{{ $transaction->user->name }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #63A7F4; opacity: 0.1;">
                                    <svg class="w-5 h-5" style="color: #63A7F4;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0a2 2 0 00-2 2v10a2 2 0 002 2h6a2 2 0 002-2V9a2 2 0 00-2-2"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 font-medium">No. Invoice</p>
                                    <p class="text-lg font-semibold text-gray-800 font-mono">{{ $transaction->no_invoice }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #63A7F4; opacity: 0.1;">
                                    <svg class="w-5 h-5" style="color: #63A7F4;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0a2 2 0 00-2 2v10a2 2 0 002 2h6a2 2 0 002-2V9a2 2 0 00-2-2"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 font-medium">Tanggal Pembelian</p>
                                    <p class="text-lg font-semibold text-gray-800">{{ $transaction->created_at->format('d M Y') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #63A7F4; opacity: 0.1;">
                                    <svg class="w-5 h-5" style="color: #63A7F4;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    @foreach($transaction->transactionDetails as $detail)
                                    <p class="text-sm text-gray-500 font-medium">Total Tiket</p>
                                    <span class="text-lg font-semibold text-gray-800">{{ ($detail->quantity) }} Tiket </span>
                                    <span class="text-lg font-semibold text-gray-800">{{ $detail->ticket->jenis_ticket ?? 'Tiket' }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-white px-6 text-sm font-medium text-gray-500">Detail Tiket</span>
                        </div>
                    </div>

                    <!-- Tickets Section -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2 mb-6">
                            <svg class="w-6 h-6" style="color: #63A7F4;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                            <h4 class="text-xl font-bold text-gray-800">Kode Tiket Anda</h4>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($transaction->transactionDetails as $index => $detail)
                            <div class="border-2 border-dashed rounded-xl p-6 transition-all duration-300 hover:shadow-lg" style="border-color: #63A7F4; background: linear-gradient(135deg, rgba(99, 167, 244, 0.03) 0%, rgba(99, 167, 244, 0.08) 100%);">
                                <div class="flex items-center justify-between">
                                    <div class="space-y-2">
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-block w-6 h-6 text-xs font-bold text-white rounded-full flex items-center justify-center" style="background-color: #63A7F4;">
                                                {{ $index + 1 }}
                                            </span>
                                            <span class="text-sm font-medium text-gray-600">Tiket #{{ $index + 1 }}</span>
                                        </div>
                                        <div class="bg-white rounded-lg px-4 py-3 shadow-sm border">
                                            <p class="text-xs text-gray-500 mb-1">Kode Tiket</p>
                                            <p class="text-lg font-bold font-mono" style="color: #63A7F4;">
                                                {{ $detail->ticket->ticket_code_prefix }}-{{ uniqid() }}-{{ bin2hex(random_bytes(6)) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #63A7F4; opacity: 0.1;">
                                            <svg class="w-6 h-6" style="color: #63A7F4;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="text-center space-y-2">
                            <p class="text-sm text-gray-500">
                                🎉 Terima kasih telah melakukan pembelian! Simpan e-tiket ini dengan baik.
                            </p>
                            <p class="text-xs text-gray-400">
                                E-tiket ini adalah bukti sah pembelian tiket Anda
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>