<!-- resources/views/admin/dashboard.blade.php -->
<x-admin-layout>
    <div class="space-y-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 animate-fade-in">
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

            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-xl text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Total User</h3>
                        <p class="text-3xl font-bold text-purple-600" id="totalUsers">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in border border-gray-100">
            <div class="gradient-bg px-8 py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-bell text-lg text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">Aktivitas Terkini</h3>
                        <p class="text-blue-100">Aktivitas terbaru di sistem</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div id="activitiesList" class="space-y-4">
                    <!-- Activities will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>