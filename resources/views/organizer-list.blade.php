<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4 pb-6">
            <button onclick="window.location.href='/dashboard'" 
                class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center hover:bg-opacity-30 transition">
                <i class="fas fa-arrow-left text-white"></i>
            </button>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20 icon-glow">
                <i class="fas fa-users text-xl text-white"></i>
            </div>
            <div>
                    <h3 class="text-2xl font-bold text-white">Daftar Organizer</h3>
                <p class="text-blue-100 opacity-90">Lihat Organizermu</p>
            </div>
        </div>
    </x-slot>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
        }

        .gradient-secondary {
            background: linear-gradient(45deg, #5C6AD0 0%, #684597 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.90);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 20px 60px rgba(104, 69, 151, 0.12);
        }

        .glass-light {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-scale:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 80px rgba(104, 69, 151, 0.20);
        }

        .table-row-hover:hover {
            background: linear-gradient(90deg, rgba(104, 69, 151, 0.05) 0%, rgba(92, 106, 208, 0.05) 100%) !important;
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        .search-input {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .search-input:focus {
            box-shadow: 0 0 0 4px rgba(104, 69, 151, 0.15), 0 10px 40px rgba(92, 106, 208, 0.10);
            border-color: #684597;
            transform: translateY(-2px);
        }

        .search-input:hover {
            transform: translateY(-1px);
            border-color: rgba(104, 69, 151, 0.4);
        }

        .pagination-btn {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .pagination-btn:hover:not(.disabled) {
            background: rgba(104, 69, 151, 0.1);
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(104, 69, 151, 0.2);
        }

        .status-badge {
            transition: all 0.2s ease;
        }

        .action-btn {
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: translateY(-1px) scale(1.1);
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

        .floating-header {
            position: relative;
            overflow: hidden;
        }

        .floating-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
            50% { transform: translate(-30%, -70%) rotate(180deg); }
        }

        .stats-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stats-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 60px rgba(104, 69, 151, 0.15);
        }

        .text-shimmer {
            background: linear-gradient(45deg, #684597, #5C6AD0, #684597);
            background-size: 300% 300%;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .icon-glow {
            filter: drop-shadow(0 4px 8px rgba(104, 69, 151, 0.3));
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-indigo-50 to-blue-50">
        <div class="space-y-8 p-6">
            <!-- Header Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Organizers -->
                <div class="stats-card rounded-3xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-2">Total Organizer</p>
                            <p class="text-3xl font-bold text-shimmer">156</p>
                        </div>
                        <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center icon-glow">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Organizers -->
                <div class="stats-card rounded-3xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-2">Organizer Aktif</p>
                            <p class="text-3xl font-bold text-green-600">142</p>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl flex items-center justify-center icon-glow">
                            <i class="fas fa-check-circle text-white text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Events -->
                <div class="stats-card rounded-3xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-2">Total Event</p>
                            <p class="text-3xl font-bold text-orange-600">1,234</p>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center icon-glow">
                            <i class="fas fa-calendar-alt text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="glass-card rounded-3xl overflow-hidden hover-scale">
                <!-- Header Section -->
                <div class="gradient-bg px-6 py-4 floating-header">
                    <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between relative z-10">
                        
                        <!-- Left: Title -->
                        <div class="flex items-center space-x-4">
                            <div>
                                <h3 class="text-2xl font-bold text-white">List Organizer</h3>
                                <p class="text-blue-100 opacity-90">Cari & Temukan Organizer Favoritmu</p>
                            </div>
                        </div>

                        <!-- Right: Search Input -->
                        <div class="flex items-center mt-4 sm:mt-0">
                            <div class="relative w-full sm:w-80">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-purple-400"></i>
                                </div>
                                <input type="text" id="searchInput" placeholder="Cari organizer..."
                                    class="search-input pl-10 pr-4 py-2.5 w-full rounded-xl focus:ring-2 focus:ring-[#684597] focus:border-[#684597]">
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-6">

                    <!-- Table Section -->
                    <div class="overflow-hidden rounded-xl border border-gray-100">
                        <table class="w-full divide-y divide-gray-100">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-hashtag text-purple-500"></i>
                                            #
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-user text-blue-500"></i>
                                            Nama
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-toggle-on text-green-500"></i>
                                            Status
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-calendar text-orange-500"></i>
                                            Jumlah Event
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody" class="bg-white divide-y divide-gray-100">
                                <!-- Data will be loaded via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                        <div class="text-sm text-gray-500" id="paginationInfo">
                            Menampilkan 0 dari 0 data
                        </div>
                        <div class="flex space-x-2" id="paginationControls">
                            <!-- Pagination will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/organizer-list.js'])
</x-app-layout>