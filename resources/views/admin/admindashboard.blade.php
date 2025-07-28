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
                        Dashboard Admin
                    </h2>
                    <p class="text-sm text-blue-100">Kelola kategori dan persetujuan event</p>
                </div>
            </div>

            <div class="hidden sm:flex items-center space-x-4">
                <div class="bg-white bg-opacity-10 px-4 py-2 rounded-full">
                    <i class="fas fa-user-circle text-xl mr-2 text-white"></i>
                    <span class="text-white font-medium">Admin</span>
                </div>
            </div>
        </div>
    </x-slot>

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #63A7F4 0%, #4A90E2 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(99, 167, 244, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, #63A7F4 0%, #4A90E2 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 167, 244, 0.3);
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-approved {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-rejected {
            background: #FEE2E2;
            color: #991B1B;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <div class="py-8 px-4 sm:px-8 bg-gray-50 min-h-screen space-y-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in">
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-[#63A7F4] bg-opacity-10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-tags text-xl text-[#63A7F4]"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Total Kategori</h3>
                        <p class="text-3xl font-bold text-[#63A7F4]" id="totalCategories">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-check text-xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Event Disetujui</h3>
                        <p class="text-3xl font-bold text-green-600" id="approvedEvents">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-xl text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Menunggu Persetujuan</h3>
                        <p class="text-3xl font-bold text-yellow-600" id="pendingEvents">0</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION: Manajemen Kategori --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in border border-gray-100">
            <div class="gradient-bg px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-tags text-lg text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Manajemen Kategori</h3>
                            <p class="text-blue-100">Kelola semua kategori event</p>
                        </div>
                    </div>
                    <button onclick="openCategoryModal('create')" class="mt-4 sm:mt-0 bg-white text-[#63A7F4] font-semibold px-6 py-3 rounded-xl hover:bg-gray-100 transition-all duration-300 flex items-center space-x-2 shadow-lg">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Kategori</span>
                    </button>
                </div>
            </div>

            <div class="p-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">#</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Nama Kategori</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTableBody" class="divide-y divide-gray-100">
                            {{-- Kategori dimuat lewat JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- SECTION: Persetujuan Event --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in border border-gray-100">
            <div class="gradient-bg px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-lg text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Persetujuan Event</h3>
                            <p class="text-blue-100">Review dan setujui event yang masuk</p>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Cari event..." class="pl-12 pr-4 py-3 rounded-xl border-0 bg-white bg-opacity-20 text-white placeholder-blue-200 focus:bg-white focus:text-gray-800 focus:placeholder-gray-400 transition-all duration-300 w-80" />
                    </div>
                </div>
            </div>

            <div class="p-8">
                {{-- Event dalam bentuk kartu --}}
                <div id="eventApprovalGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Event dimuat lewat JS --}}
                </div>

                <div id="noEventsMessage" class="text-center py-12 hidden">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-times text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Event</h3>
                    <p class="text-gray-500">Tidak ada event yang menunggu persetujuan saat ini.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah/Edit Kategori --}}
    <div id="categoryModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden items-center justify-center px-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 opacity-0 border border-gray-200" id="modalContent">
            <div class="gradient-bg px-6 py-4 rounded-t-2xl">
                <h2 class="text-xl font-bold text-white flex items-center" id="categoryModalTitle">
                    <i class="fas fa-tag mr-3"></i>
                    Tambah Kategori
                </h2>
            </div>

            <form id="categoryForm" class="p-6">
                @csrf
                <input type="hidden" id="categoryId" name="category_id" />

                <div class="mb-6">
                    <label for="categoryName" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tags mr-2 text-[#63A7F4]"></i>
                        Nama Kategori
                    </label>
                    <input type="text" id="categoryName" name="name"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#63A7F4] focus:border-[#63A7F4] transition-all duration-300 bg-white text-gray-800"
                        placeholder="Masukkan nama kategori..." required />
                </div>

                <div class="flex space-x-3">
                    <button type="button" onclick="closeCategoryModal()"
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 btn-primary text-white rounded-xl font-semibold px-4 py-3">
                        <i class="fas fa-save mr-2"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @vite(['resources/js/admin-dashboard.js'])
</x-app-layout>