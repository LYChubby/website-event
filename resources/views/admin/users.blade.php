<head>
    <title>
        Users
    </title>
</head>
<x-admin-layout>
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
            animation: modalExit ease-in forwards;
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
                            <h3 class="text-2xl font-bold text-white">Manajemen User</h3>
                            <p class="text-blue-100 opacity-90">Kelola semua user sistem</p>
                        </div>
                    </div>
                    <button onclick="openUserModal('create')" class="mt-4 sm:mt-0 bg-white/90 text-[#5C6AD0] font-semibold px-6 py-3 rounded-xl hover:bg-white transition-all duration-300 flex items-center space-x-2 shadow-lg hover:shadow-xl">
                        <i class="fas fa-plus"></i>
                        <span>Tambah User</span>
                    </button>
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
                    <div class="flex items-center space-x-3">
                        <label for="roleFilter" class="text-sm font-medium text-gray-600">Filter Role:</label>
                        <select id="roleFilter" class="border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#5C6AD0] focus:border-[#5C6AD0] bg-white">
                            <option value="">Semua</option>
                            <option value="user">User</option>
                            <option value="organizer">Organizer</option>
                        </select>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-100 rounded-xl overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
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

</x-admin-layout>
<!-- User Modal -->
    <div id="userModal" class="fixed inset-0 z-50 bg-black backdrop-blur-sm bg-opacity-50 hidden items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden modal-enter" id="userModalContent">
            <div class="gradient-bg px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center" id="userModalTitle">
                    <i class="fas fa-user-plus mr-3"></i>
                    Tambah User
                </h2>
            </div>

            <form id="userForm" class="p-6">
                @csrf
                <input type="hidden" id="userId" name="user_id">

                <div id="createFields">
                    <div class="mb-4">
                        <label for="userName" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-[#5C6AD0]"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" id="userName" name="name"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#5C6AD0] focus:border-[#5C6AD0] transition-all duration-300 bg-white text-gray-800"
                            placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="mb-4">
                        <label for="userEmail" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-[#5C6AD0]"></i>
                            Email
                        </label>
                        <input type="email" id="userEmail" name="email"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#5C6AD0] focus:border-[#5C6AD0] transition-all duration-300 bg-white text-gray-800"
                            placeholder="Masukkan email">
                    </div>

                    <div class="mb-4">
                        <label for="userRole" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user-tag mr-2 text-[#5C6AD0]"></i>
                            Role
                        </label>
                        <select id="userRole" name="role"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#5C6AD0] focus:border-[#5C6AD0] transition-all duration-300 bg-white text-gray-800">
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="organizer">Organizer</option>
                            <option value="user">User</option>
                        </select>
                    </div>

                    <div class="mb-6" id="passwordFields">
                        <label for="userPassword" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-[#5C6AD0]"></i>
                            Password
                        </label>
                        <input type="password" id="userPassword" name="password"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#5C6AD0] focus:border-[#5C6AD0] transition-all duration-300 bg-white text-gray-800"
                            placeholder="Masukkan password">
                    </div>
                </div>

                <div class="mb-6">
                    <div class="grid grid-cols-2 gap-3 mb-6">
                    <!-- Option Aktif -->
                    <label class="cursor-pointer">
                        <input type="radio" name="status" value="Aktif"
                            class="peer hidden">
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-2 transition-all duration-300
                                    hover:border-emerald-300 hover:shadow-lg peer-checked:border-emerald-500 peer-checked:bg-emerald-50 relative">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mb-2 transition-colors duration-300
                                            peer-checked:bg-emerald-200">
                                    <i class="fas fa-check-circle text-emerald-600 text-base"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800 text-sm">Aktif</h3>
                            </div>
                        </div>
                    </label>

                    <!-- Option Non-aktif -->
                    <label class="cursor-pointer">
                        <input type="radio" name="status" value="Non-Aktif"
                            class="peer hidden">
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-2 transition-all duration-300
                                    hover:border-red-300 hover:shadow-lg peer-checked:border-red-500 peer-checked:bg-red-50 relative">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mb-2 transition-colors duration-300
                                            peer-checked:bg-red-200">
                                    <i class="fas fa-ban text-red-600 text-base"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800 text-sm">Non-aktif</h3>
                            </div>
                        </div>
                    </label>
                </div>

                <div class="flex mb-4 space-x-3">
                    <button type="button" onclick="closeUserModal()"
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold">
                        <i class="fas fa-times group-hover:rotate-90 transition-transform duration-300"></i>
                        <span>Batal</span>
                    </button>
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-[#5C6AD0] to-[#684597] text-white rounded-xl font-semibold px-4 py-3 hover:opacity-90 transition-opacity">
                        <i class="fas fa-save group-hover:rotate-90 transition-transform duration-300"></i>
                        <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>