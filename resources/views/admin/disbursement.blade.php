<head>
    <title>
        disbursement
    </title>
</head>
<x-admin-layout>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in">
        <!-- Total Revenue Card -->
        <div class="group relative overflow-hidden bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-6 border border-white/20">
            <div class="absolute inset-0 bg-gradient-to-br from-[#5C6AD0]/5 to-[#684597]/5 group-hover:from-[#5C6AD0]/10 group-hover:to-[#684597]/10 transition-all duration-300"></div>
            <div class="relative flex items-center">
                <div class="w-16 h-16 bg-gradient-to-br from-[#5C6AD0] to-[#684597] rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-money-bill-wave text-2xl text-white"></i>
                </div>
                <div class="ml-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Total Pemasukan</h3>
                    <p id="totalRevenue" class="text-4xl font-bold bg-gradient-to-r from-[#5C6AD0] to-[#684597] bg-clip-text text-transparent">{{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="absolute top-4 right-4 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                <i class="fas fa-money-bill-wave text-6xl text-[#5C6AD0]"></i>
            </div>
        </div>

        <!-- Total Fee Card -->
        <div class="group relative overflow-hidden bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-6 border border-white/20">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-green-600/5 group-hover:from-emerald-500/10 group-hover:to-green-600/10 transition-all duration-300"></div>
            <div class="relative flex items-center">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-percentage text-2xl text-white"></i>
                </div>
                <div class="ml-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Total Fee</h3>
                    <p id="totalFee" class="text-4xl font-bold bg-gradient-to-r from-emerald-500 to-green-600 bg-clip-text text-transparent">{{ number_format($totalFee, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="absolute top-4 right-4 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                <i class="fas fa-percentage text-6xl text-emerald-500"></i>
            </div>
        </div>

        <!-- Total Gross Card -->
        <div class="group relative overflow-hidden bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-6 border border-white/20">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-orange-600/5 group-hover:from-amber-500/10 group-hover:to-orange-600/10 transition-all duration-300"></div>
            <div class="relative flex items-center">
                <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-coins text-2xl text-white"></i>
                </div>
                <div class="ml-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Total Bersih</h3>
                    <p id="totalGross" class="text-4xl font-bold bg-gradient-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent">{{ number_format($totalBersih, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="absolute top-4 right-4 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                <i class="fas fa-coins text-6xl text-amber-500"></i>
            </div>
        </div>
    </div>

    <!-- Organizers List with Enhanced Header -->
    <div class="mt-8 bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden border border-white/20 animate-fade-in">
        <div class="px-6 py-6 bg-gradient-to-r from-[#5C6AD0] to-[#684597] relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-32 h-32 bg-white rounded-full -translate-x-16 -translate-y-16"></div>
                <div class="absolute bottom-0 right-0 w-24 h-24 bg-white rounded-full translate-x-12 translate-y-12"></div>
            </div>

            <!-- Header Content -->
            <div class="relative flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-1">Daftar Organizer</h3>
                        <p class="text-white/80 text-sm">Kelola dan pantau performa setiap organizer</p>
                    </div>
                </div>

                <!-- Stats Badge -->
                <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/20">
                    <div class="text-white/80 text-xs uppercase tracking-wide">Total Organizer</div>
                    <div class="text-white text-center font-bold text-lg">{{ count($organizerList) }}</div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gradient-to-r from-[#5C6AD0] to-[#684597]">
                        <th class="group px-6 py-4 text-left">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-[#5C6AD0] to-[#684597] rounded-lg flex items-center justify-center opacity-80 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-user text-white text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-800 uppercase tracking-wide">Nama Organizer</div>
                                    <div class="text-xs text-gray-500">Identitas & Profil</div>
                                </div>
                            </div>
                        </th>
                        <th class="group px-6 py-4 text-left">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg flex items-center justify-center opacity-80 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-money-bill text-white text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-800 uppercase tracking-wide">Total Pemasukan</div>
                                    <div class="text-xs text-gray-500">Revenue Kotor</div>
                                </div>
                            </div>
                        </th>
                        <th class="group px-6 py-4 text-left">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center opacity-80 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-percentage text-white text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-800 uppercase tracking-wide">Disbursement</div>
                                    <div class="text-xs text-gray-500">Pengeluaran</div>
                                </div>
                            </div>
                        </th>
                        <th class="group px-6 py-4 text-left">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center opacity-80 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-coins text-white text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-800 uppercase tracking-wide">Pendapatan Organizer</div>
                                    <div class="text-xs text-gray-500">Revenue Bersih</div>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($organizerList as $org)
                    <tr class="hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50/30 transition-all duration-300 group">
                        <td class="px-6 py-4 whitespace-nowrap flex items-center">
                            <div class="flex-shrink-0 h-12 w-12 rounded-2xl bg-gradient-to-br from-[#5C6AD0] to-[#684597] flex items-center justify-center text-white font-bold shadow-lg group-hover:scale-105 transition-transform">
                                {{ strtoupper(substr($org->organizer_name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-semibold text-gray-900 group-hover:text-[#5C6AD0] transition-colors">{{ $org->organizer_name }}</div>
                                <div class="text-xs text-gray-500">Active Organizer</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-emerald-600">
                                Rp{{ number_format($org->total_credit, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-500">Total Credit</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-red-600">
                                Rp{{ number_format($org->total_debit, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-500">Total Debit</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-amber-600">
                                Rp{{ number_format($org->saldo, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-500">Current Balance</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-12">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-users text-gray-400 text-2xl"></i>
                                </div>
                                <div class="text-gray-500 font-medium">Tidak ada data organizer</div>
                                <div class="text-gray-400 text-sm">Belum ada organizer yang terdaftar</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>