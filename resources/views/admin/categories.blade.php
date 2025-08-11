<!-- resources/views/admin/categories.blade.php -->
<x-admin-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 p-6">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in">
                <!-- Total Categories Card -->
                <div class="group relative overflow-hidden bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-6 border border-white/20">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#5C6AD0]/5 to-[#684597]/5 group-hover:from-[#5C6AD0]/10 group-hover:to-[#684597]/10 transition-all duration-300"></div>
                    <div class="relative flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#5C6AD0] to-[#684597] rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-tags text-2xl text-white"></i>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-1">Total Kategori</h3>
                            <p class="text-4xl font-bold bg-gradient-to-r from-[#5C6AD0] to-[#684597] bg-clip-text text-transparent" id="totalCategories">0</p>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                        <i class="fas fa-tags text-6xl text-[#5C6AD0]"></i>
                    </div>
                </div>

                <!-- Active Categories Card -->
                <div class="group relative overflow-hidden bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-6 border border-white/20">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-green-600/5 group-hover:from-emerald-500/10 group-hover:to-green-600/10 transition-all duration-300"></div>
                    <div class="relative flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-check-circle text-2xl text-white"></i>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-1">Kategori Aktif</h3>
                            <p class="text-4xl font-bold bg-gradient-to-r from-emerald-500 to-green-600 bg-clip-text text-transparent" id="activeCategories">0</p>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                        <i class="fas fa-check-circle text-6xl text-emerald-500"></i>
                    </div>
                </div>

                <!-- Total Events Card -->
                <div class="group relative overflow-hidden bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-6 border border-white/20">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-orange-600/5 group-hover:from-amber-500/10 group-hover:to-orange-600/10 transition-all duration-300"></div>
                    <div class="relative flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-calendar-alt text-2xl text-white"></i>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-1">Event Terkait</h3>
                            <p class="text-4xl font-bold bg-gradient-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent" id="totalEvents">0</p>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                        <i class="fas fa-calendar-alt text-6xl text-amber-500"></i>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden animate-fade-in border border-white/20">
                <!-- Header -->
                <div class="relative bg-gradient-to-r from-[#5C6AD0] to-[#684597] px-8 py-8 overflow-hidden">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-24 -translate-x-24"></div>

                    <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center space-x-6 mb-6 lg:mb-0">
                            <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-tags text-2xl text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-3xl font-bold text-white mb-1">Daftar Kategori</h3>
                                <p class="text-white/80 text-lg">Kelola semua kategori event Anda</p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                            <!-- Search -->
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400 group-hover:text-[#5C6AD0] transition-colors duration-200"></i>
                                </div>
                                <input type="text" id="categorySearch" placeholder="Cari kategori..."
                                    class="pl-12 pr-4 py-3 w-full sm:w-72 rounded-xl border-0 bg-white/90 backdrop-blur-sm focus:ring-2 focus:ring-white focus:bg-white transition-all duration-300 shadow-lg text-gray-700 placeholder-gray-400">
                            </div>

                            <!-- Add Button -->
                            <button onclick="openCategoryModal('create')"
                                class="group bg-white/90 backdrop-blur-sm hover:bg-white text-[#5C6AD0] font-semibold px-6 py-3 rounded-xl transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl hover:scale-105">
                                <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                                <span>Tambah Kategori</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="p-8">
                    <div class="overflow-hidden rounded-2xl border border-gray-100 shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                        <th class="text-left py-6 px-6 font-bold text-gray-700 text-sm uppercase tracking-wider">#</th>
                                        <th class="text-left py-6 px-6 font-bold text-gray-700 text-sm uppercase tracking-wider">Nama Kategori</th>
                                        <th class="text-left py-6 px-6 font-bold text-gray-700 text-sm uppercase tracking-wider">Jumlah Event</th>
                                        <th class="text-left py-6 px-6 font-bold text-gray-700 text-sm uppercase tracking-wider">Status</th>
                                        <th class="text-left py-6 px-6 font-bold text-gray-700 text-sm uppercase tracking-wider">Tanggal Dibuat</th>
                                        <th class="text-left py-6 px-6 font-bold text-gray-700 text-sm uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="categoryTableBody" class="bg-white divide-y divide-gray-100">
                                    <!-- Data akan dimuat via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-gradient-to-r from-[#5C6AD0] to-[#684597] rounded-full"></div>
                            <div class="text-sm text-gray-600 font-medium" id="categoryPaginationInfo">
                                Menampilkan 0 dari 0 data
                            </div>
                        </div>
                        <div class="flex items-center space-x-2" id="categoryPagination">
                            <!-- Pagination akan dimuat di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('modals')
    <!-- Enhanced Modal -->
    <div id="categoryModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden items-center justify-center px-4">
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl transform transition-all duration-300 scale-95 opacity-0 border border-gray-200 overflow-hidden" id="modalContent">
            <!-- Modal Header -->
            <div class="relative bg-gradient-to-r from-[#5C6AD0] to-[#684597] px-8 py-6 overflow-hidden">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                <div class="relative">
                    <h2 class="text-2xl font-bold text-white flex items-center" id="categoryModalTitle">
                        <i class="fas fa-tag mr-3 text-xl"></i>
                        Tambah Kategori
                    </h2>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="categoryForm" class="p-8 space-y-6">
                @csrf
                <input type="hidden" id="categoryId" name="category_id" />

                <!-- Category Name -->
                <div class="group">
                    <label for="categoryName" class="block text-sm font-bold text-gray-700 mb-3">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-gradient-to-r from-[#5C6AD0] to-[#684597] rounded-full"></div>
                            <span>Nama Kategori</span>
                        </div>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-tags text-gray-400 group-hover:text-[#5C6AD0] transition-colors duration-200"></i>
                        </div>
                        <input type="text" id="categoryName" name="name"
                            class="pl-12 pr-4 py-4 w-full border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#5C6AD0] focus:border-[#5C6AD0] transition-all duration-300 bg-gray-50 focus:bg-white text-gray-800 placeholder-gray-400"
                            placeholder="Masukkan nama kategori..." required />
                    </div>
                </div>

                <!-- Status -->
                <div class="group">
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-gradient-to-r from-[#5C6AD0] to-[#684597] rounded-full"></div>
                            <span>Status Kategori</span>
                        </div>
                    </label>
                    <div class="grid grid-cols-2 gap-3 mb-6">
                    <!-- Aktif -->
                    <label class="cursor-pointer">
                        <input type="radio" name="is_active" value="1" checked class="peer hidden">
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-4 transition-all duration-300
                                    hover:border-emerald-300 hover:shadow-lg peer-checked:border-emerald-500 peer-checked:bg-emerald-50 relative">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mb-2 transition-colors duration-300
                                            peer-checked:bg-emerald-200">
                                    <i class="fas fa-check-circle text-emerald-600 text-base"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800 text-sm">Aktif</h3>
                            </div>
                        </div>
                    </label>

                    <!-- Non-aktif -->
                    <label class="cursor-pointer">
                        <input type="radio" name="is_active" value="0" class="peer hidden">
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-4 transition-all duration-300
                                    hover:border-red-300 hover:shadow-lg peer-checked:border-red-500 peer-checked:bg-red-50 relative">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mb-2 transition-colors duration-300
                                            peer-checked:bg-red-200">
                                    <i class="fas fa-ban text-red-600 text-base"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800 text-sm">Non-aktif</h3>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-4 pt-6">
                    <button type="button" onclick="closeCategoryModal()"
                        class="flex-1 px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-all duration-300 font-semibold flex items-center justify-center space-x-2 group">
                        <i class="fas fa-times group-hover:rotate-90 transition-transform duration-300"></i>
                        <span>Batal</span>
                    </button>
                    <button type="submit"
                        class="flex-1 px-6 py-4 bg-gradient-to-r from-[#5C6AD0] to-[#684597] text-white rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl hover:scale-105 group">
                        <i class="fas fa-save group-hover:scale-110 transition-transform duration-300"></i>
                        <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }

        .status-card input[type="radio"]:checked+div {
            border-color: #5C6AD0;
            background: linear-gradient(to right, #5C6AD0, #684597);
            color: white;
        }

        .status-card input[type="radio"]:checked+div span {
            color: white;
        }

        .status-card input[type="radio"]:checked+div .w-4 {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Enhanced table styles */
        #categoryTableBody tr {
            transition: all 0.3s ease;
        }

        #categoryTableBody tr:hover {
            background: linear-gradient(to right, #f8fafc, #f1f5f9);
            transform: translateX(4px);
        }

        /* Pagination styles */
        #categoryPagination button {
            transition: all 0.3s ease;
        }

        #categoryPagination button:hover {
            transform: translateY(-1px);
        }

        #categoryPagination button.bg-blue-600 {
            background: linear-gradient(to right, #5C6AD0, #684597);
        }
    </style>
    @endpush
</x-admin-layout>