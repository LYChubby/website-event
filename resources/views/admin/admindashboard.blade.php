<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-8 bg-white dark:bg-[#1e1e1e] min-h-screen space-y-10">
        {{-- SECTION: Category Management --}}
        <div class="bg-[#78B5FF] text-white p-6 rounded-xl shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold">Manajemen Kategori</h3>
                <button onclick="openCategoryModal('create')" class="bg-white text-[#78B5FF] font-semibold px-4 py-2 rounded hover:bg-gray-200">
                    + Tambah Kategori
                </button>
            </div>

            <table class="w-full text-left bg-white text-gray-800 rounded overflow-hidden">
                <thead class="bg-[#78B5FF] text-white">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Nama Kategori</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                    {{-- Kategori akan dimuat lewat JS --}}
                </tbody>
            </table>
        </div>

        {{-- SECTION: Event Approval --}}
        <div class="bg-[#78B5FF] text-white p-6 rounded-xl shadow-lg">
            <h3 class="text-2xl font-bold mb-4">Persetujuan Event</h3>
            <table class="w-full text-left bg-white text-gray-800 rounded overflow-hidden">
                <thead class="bg-[#78B5FF] text-white">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Nama Event</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody id="eventTableBodyAdmin">
                    {{-- Event akan dimuat lewat JS --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah/Edit Kategori --}}
    <div id="categoryModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white w-96 p-6 rounded-xl shadow-lg">
            <h2 class="text-xl font-bold mb-4" id="categoryModalTitle">Tambah Kategori</h2>
            <form id="categoryForm">
                @csrf
                <input type="hidden" id="categoryId" name="category_id" />
                <input type="text" id="categoryName" name="name" class="w-full p-2 border rounded mb-4" placeholder="Nama Kategori" required />
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-[#78B5FF] text-white rounded hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @vite(['resources/js/admin-dashboard.js'])
</x-app-layout>