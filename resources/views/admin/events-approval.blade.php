<head>
    <title>
        Approval
    </title>
</head>
<!-- resources/views/admin/events-approval.blade.php -->
<x-admin-layout>
    <div class="space-y-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in">
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-xl text-green-600"></i>
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

            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-times-circle text-xl text-red-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Event Ditolak</h3>
                        <p class="text-3xl font-bold text-red-600" id="rejectedEvents">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Persetujuan Event -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in border border-gray-100">
            <div class="gradient-bg px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-check text-lg text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Persetujuan Event</h3>
                            <p class="text-blue-100">Review dan setujui event yang masuk</p>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="eventSearch" placeholder="Cari event..."
                            class="pl-12 pr-4 py-3 rounded-xl border-0 bg-white bg-opacity-20 text-white placeholder-blue-200 focus:bg-white focus:text-gray-800 focus:placeholder-gray-400 transition-all duration-300 w-80">
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div id="eventApprovalGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Event cards will be loaded here -->
                </div>

                <div id="noEventsMessage" class="text-center py-12 hidden">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-times text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Event</h3>
                    <p class="text-gray-500">Tidak ada event yang menunggu persetujuan saat ini.</p>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <div class="text-sm text-gray-500" id="eventPaginationInfo">
                        Menampilkan 0 dari 0 data
                    </div>
                    <div class="flex space-x-2" id="eventPagination">
                        <!-- Pagination will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>