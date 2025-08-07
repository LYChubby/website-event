<!-- resources/views/admin/categories.blade.php -->
<x-admin-layout>
    <div class="space-y-8">
        <!-- Stats Cards (khusus kategori) -->
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
                        <i class="fas fa-check-circle text-xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Kategori Aktif</h3>
                        <p class="text-3xl font-bold text-green-600" id="activeCategories">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Event Terkait</h3>
                        <p class="text-3xl font-bold text-blue-600" id="totalEvents">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Manajemen Kategori -->
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
                    <div class="flex space-x-3 mt-4 sm:mt-0">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="categorySearch" placeholder="Cari kategori..."
                                class="pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                        </div>
                        <button onclick="openCategoryModal('create')"
                            class="bg-white text-[#63A7F4] font-semibold px-6 py-2 rounded-xl hover:bg-gray-100 transition-all duration-300 flex items-center space-x-2 shadow-lg">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Kategori</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">#</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Nama Kategori</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Jumlah Event</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Status</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Tanggal Dibuat</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTableBody" class="divide-y divide-gray-100">
                            <!-- Data akan dimuat via JavaScript -->
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <div class="text-sm text-gray-500" id="categoryPaginationInfo">
                        Menampilkan 0 dari 0 data
                    </div>
                    <div class="flex space-x-2" id="categoryPagination">
                        <!-- Pagination akan dimuat di sini -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('modals')
    <!-- Modal Kategori -->
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

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-toggle-on mr-2 text-[#63A7F4]"></i>
                        Status
                    </label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="is_active" value="1" checked
                                class="form-radio h-5 w-5 text-[#63A7F4] focus:ring-[#63A7F4] border-gray-300">
                            <span class="ml-2 text-gray-700">Aktif</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="is_active" value="0"
                                class="form-radio h-5 w-5 text-[#63A7F4] focus:ring-[#63A7F4] border-gray-300">
                            <span class="ml-2 text-gray-700">Nonaktif</span>
                        </label>
                    </div>
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
    @endpush
</x-admin-layout>