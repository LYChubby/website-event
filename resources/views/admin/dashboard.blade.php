<head>
    <title>
        Dashboard
    </title>
</head>
<x-admin-layout>
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in">
            <!-- Total Categories -->
            <div class="group relative overflow-hidden bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-6 border border-white/20">
                <div class="absolute inset-0 bg-gradient-to-br from-[#5C6AD0]/5 to-[#684597]/5 group-hover:from-[#5C6AD0]/10 group-hover:to-[#684597]/10 transition-all duration-300"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#5C6AD0] to-[#684597] rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-tags text-2xl text-white"></i>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-1">Total Kategori</h3>
                            <p class="text-4xl font-bold bg-gradient-to-r from-[#5C6AD0] to-[#684597] bg-clip-text text-transparent" id="totalCategories">0</p>
                        </div>
                    </div>
                    <div class="pulse-dot bg-blue-800"></div>
                </div>
                <div class="absolute top-4 right-4 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                    <i class="fas fa-tags text-6xl text-[#5C6AD0]"></i>
                </div>
            </div>

            <!-- Approved Events -->
            <div class="group relative overflow-hidden bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-6 border border-white/20">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-green-600/5 group-hover:from-emerald-500/10 group-hover:to-green-600/10 transition-all duration-300"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-calendar-check text-2xl text-white"></i>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-1">Event Disetujui</h3>
                            <p class="text-4xl font-bold bg-gradient-to-r from-emerald-500 to-green-600 bg-clip-text text-transparent" id="approvedEvents">0</p>
                        </div>
                    </div>
                    <div class="pulse-dot bg-green-400"></div>
                </div>
                <div class="absolute top-4 right-4 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                    <i class="fas fa-calendar-check text-6xl text-emerald-500"></i>
                </div>
            </div>

            <!-- Pending Events -->
            <div class="group relative overflow-hidden bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-6 border border-white/20">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-orange-600/5 group-hover:from-amber-500/10 group-hover:to-orange-600/10 transition-all duration-300"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-clock text-2xl text-white"></i>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-1">Menunggu Persetujuan</h3>
                            <p class="text-4xl font-bold bg-gradient-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent" id="pendingEvents">0</p>
                        </div>
                    </div>
                    <div class="pulse-dot bg-yellow-400"></div>
                </div>
                <div class="absolute top-4 right-4 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                    <i class="fas fa-clock text-6xl text-amber-500"></i>
                </div>
            </div>

            <!-- Total Users -->
            <div class="group relative overflow-hidden bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-6 border border-white/20">
                <div class="absolute inset-0 bg-gradient-to-br from-[#9C6AD0]/5 to-[#c471f5]/5 group-hover:from-[#9C6AD0]/10 group-hover:to-[#c471f5]/10 transition-all duration-300"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#9C6AD0] to-[#c471f5] rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-2xl text-white"></i>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-1">Total User</h3>
                            <p class="text-4xl font-bold bg-gradient-to-r from-[#9C6AD0] to-[#c471f5] bg-clip-text text-transparent" id="totalUsers">0</p>
                        </div>
                    </div>
                    <div class="pulse-dot bg-purple-400"></div>
                </div>
                <div class="absolute top-4 right-4 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                    <i class="fas fa-users text-6xl text-[#9C6AD0]"></i>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="card overflow-hidden slide-up">
            <!-- Header -->
            <div class="header-gradient px-6 py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 glass-icon rounded-xl flex items-center justify-center">
                        <i class="fas fa-bell text-xl text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Aktivitas Terkini</h3>
                        <p class="text-blue-100 text-sm">Aktivitas terbaru di sistem</p>
                    </div>
                </div>
            </div>

            <!-- Activities List -->
            <div class="p-6">
                <div id="activitiesList" 
                class="space-y-3 max-h-96 overflow-y-auto p-2 bg-white rounded-xl shadow-inner">
                    <!-- Activities will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Activity Section Styles - Enhanced to match stat cards */
        .header-gradient {
            background: linear-gradient(135deg, #5C6AD0 0%, #684597 100%);
            border-top-left-radius: 1.5rem;
            border-top-right-radius: 1.5rem;
        }

        .glass-icon {
            width: 3.5rem;
            height: 3.5rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
        }

        .glass-icon:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.2);
        }

        .activity-item {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            padding: 1.25rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 0.75rem;
        }

        .activity-item:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(92, 106, 208, 0.1);
            border-color: rgba(92, 106, 208, 0.15);
        }

        .activity-icon {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .activity-icon:hover {
            transform: scale(1.1);
        }

        .activity-icon-user {
            background: linear-gradient(135deg, #5C6AD0 0%, #684597 100%);
        }

        .activity-icon-event {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .activity-icon-category {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        /* Animations */
        .pulse-dot {
            width: 0.625rem;
            height: 0.625rem;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
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

        .animate-slide-up {
            animation: slideUp 0.6s ease-out forwards;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</x-admin-layout>