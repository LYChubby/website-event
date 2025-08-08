<!-- resources/views/admin/organizer-verification.blade.php -->
<x-admin-layout>
    <div class="space-y-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="gradient-bg px-8 py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-tie text-lg text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">Manajemen Organizer</h3>
                        <p class="text-blue-100">Verifikasi data organizer</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="mb-4">
                    <div class="relative w-64">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="organizerSearch" placeholder="Cari organizer..."
                            class="pl-10 pr-4 py-2 w-full border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Nama</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Rekening Bank</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Terverifikasi</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Siap Pencairan</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="organizerTableBody">
                            <!-- Data akan diisi via JavaScript -->
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <div class="text-sm text-gray-500" id="organizerPaginationInfo">
                        Menampilkan 0 dari 0 data
                    </div>
                    <div class="flex space-x-2" id="organizerPagination">
                        <!-- Pagination akan diisi di sini -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>