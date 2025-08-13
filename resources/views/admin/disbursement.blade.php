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
                    <p id="totalGross" class="text-4xl font-bold bg-gradient-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent">{{ number_format($totalFee, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="absolute top-4 right-4 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                <i class="fas fa-coins text-6xl text-amber-500"></i>
            </div>
        </div>
    </div>

    <!-- Organizers List -->
    <div class="mt-8 bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden border border-white/20 animate-fade-in">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Organizer</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Organizer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Pemasukan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee (10%)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pendapatan Organizer</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($organizerList as $org)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-[#5C6AD0] to-[#684597] flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($org->organizer_name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $org->organizer_name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp{{ number_format($org->total_pemasukan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp{{ number_format($org->fee, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp{{ number_format($org->pendapatan_organizer, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-4">Tidak ada data organizer</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>