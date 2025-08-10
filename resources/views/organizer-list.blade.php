<x-app-layout>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #5C6AD0 0%, #684597 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(92, 106, 208, 0.1);
        }

        .hover-scale {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-scale:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(92, 106, 208, 0.15);
        }

        .table-row-hover:hover {
            background: rgba(92, 106, 208, 0.03) !important;
        }

        .search-input {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(92, 106, 208, 0.2);
        }

        .pagination-btn {
            transition: all 0.2s ease;
        }

        .pagination-btn:hover:not(.disabled) {
            background: rgba(92, 106, 208, 0.1) !important;
        }

        .status-badge {
            transition: all 0.2s ease;
        }

        .action-btn {
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-enter {
            animation: modalEnter 0.3s ease-out forwards;
        }

        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-exit {
            animation: modalExit 0.2s ease-in forwards;
        }

        @keyframes modalExit {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: 0;
                transform: scale(0.95);
            }
        }
    </style>

    <div class="space-y-6 p-6">
        <!-- Main Card -->
        <div class="glass-card rounded-2xl overflow-hidden hover-scale">
            <!-- Header Section -->
            <div class="gradient-bg px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                            <i class="fas fa-users text-xl text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Daftar Organizer</h3>
                            <p class="text-blue-100 opacity-90">Cari & Temukan Organizer Favoritmu</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6">
                <!-- Filter and Search -->
                <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="relative w-full md:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="userSearch" placeholder="Cari user..."
                            class="search-input pl-10 pr-4 py-2.5 w-full border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#5C6AD0] focus:border-[#5C6AD0]">
                    </div>
                </div>

                <!-- Table Section -->
                <div class="overflow-hidden rounded-xl border border-gray-100">
                    <table class="w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody" class="bg-white divide-y divide-gray-100">
                            <!-- Data akan diisi via JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <div class="text-sm text-gray-500" id="userPaginationInfo">
                        Menampilkan 0 dari 0 data
                    </div>
                    <div class="flex space-x-2" id="userPagination">
                        <!-- Pagination akan diisi di sini -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/organizer-list.js'])
</x-app-layout>