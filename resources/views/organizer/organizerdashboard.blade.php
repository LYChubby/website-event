<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Organizer
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-8 bg-white dark:bg-[#1e1e1e] min-h-screen">
        {{-- Header Atas --}}
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <a href="#" class="text-2xl"><i class="fas fa-arrow-left"></i></a>
                <h1 class="text-2xl font-bold text-[#78B5FF]">Kelola Event</h1>
            </div>
            <div class="flex space-x-2">
                <input type="text" placeholder="Search" class="rounded-full px-4 py-2 w-80 border focus:outline-none focus:ring" />
                <button onclick="openEventModal()" class="bg-[#78B5FF] hover:bg-blue-500 text-white px-4 py-2 rounded shadow flex items-center">
                    Tambah Event <span class="text-xl ml-1">+</span>
                </button>
            </div>
        </div>

        {{-- Filter Kategori --}}
        <div class="mb-6">
            <div id="categoryFilter" class="flex space-x-2">
                <button data-category="all" class="filter-btn bg-[#78B5FF] text-white px-3 py-1 rounded">All</button>
                {{-- Tombol kategori lain akan dimuat lewat JS --}}
            </div>
        </div>

        {{-- Grid Event --}}
        <div id="eventGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Kartu event akan dimuat lewat JS --}}
        </div>
    </div>

    {{-- Modal Tambah/Edit Event --}}
    <div id="eventModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white w-full max-w-xl p-6 rounded-xl shadow-lg">
            <h2 class="text-xl font-bold mb-4" id="eventModalTitle">Tambah Event</h2>
            <form id="eventForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="eventId" name="event_id" />
                <input type="hidden" id="status_approval" name="status_approval" />
                <div class="mb-4">
                    <label for="name_event" class="block font-medium mb-1">Nama Event</label>
                    <input type="text" id="name_event" name="name_event" class="w-full p-2 border rounded" required />
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block font-medium mb-1">Kategori</label>
                    <select id="category_id" name="category_id" class="w-full p-2 border rounded" required>
                        {{-- Opsi kategori akan dimuat dari JS --}}
                    </select>
                </div>
                <div class="mb-4">
                    <label for="description" class="block font-medium mb-1">Deskripsi</label>
                    <textarea id="description" name="description" class="w-full p-2 border rounded" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="venue_name" class="block font-medium mb-1">Nama Tempat</label>
                    <input type="text" id="venue_name" name="venue_name" class="w-full p-2 border rounded" required />
                </div>

                <div class="mb-4">
                    <label for="venue_address" class="block font-medium mb-1">Alamat Tempat</label>
                    <textarea id="venue_address" name="venue_address" class="w-full p-2 border rounded" required></textarea>
                </div>

                <div class="mb-4 flex gap-4">
                    <div class="flex-1">
                        <label for="start_date" class="block font-medium mb-1">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date" class="w-full p-2 border rounded" required />
                    </div>
                    <div class="flex-1">
                        <label for="end_date" class="block font-medium mb-1">Tanggal Selesai</label>
                        <input type="date" id="end_date" name="end_date" class="w-full p-2 border rounded" required />
                    </div>
                </div>
                <div class="mb-4">
                    <label for="event_image" class="block font-medium mb-1">Gambar Event</label>
                    <input type="file" id="event_image" name="event_image" accept="image/*" class="w-full p-2 border rounded" />
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEventModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-[#78B5FF] text-white rounded hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @vite(['resources/js/organizer-dashboard.js']) {{-- file JS khusus organizer --}}
</x-app-layout>