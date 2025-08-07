<!-- resources/views/admin/users.blade.php -->
<x-admin-layout>
    <div class="space-y-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="gradient-bg px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-lg text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Manajemen User</h3>
                            <p class="text-blue-100">Kelola semua user sistem</p>
                        </div>
                    </div>
                    <button onclick="openUserModal('create')" class="mt-4 sm:mt-0 bg-white text-[#63A7F4] font-semibold px-6 py-3 rounded-xl hover:bg-gray-100 transition-all duration-300 flex items-center space-x-2 shadow-lg">
                        <i class="fas fa-plus"></i>
                        <span>Tambah User</span>
                    </button>
                </div>
            </div>

            <div class="p-8">
                <div class="mb-4 flex justify-between items-center">
                    <div class="relative w-64">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="userSearch" placeholder="Cari user..." class="pl-10 pr-4 py-2 w-full border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="roleFilter" class="text-sm font-medium text-gray-700">Filter Role:</label>
                        <select id="roleFilter" class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                            <option value="organizer">Organizer</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">#</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Nama</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Email</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Role</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Tanggal Daftar</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Status</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody" class="divide-y divide-gray-100">
                            <!-- Data user akan dimuat di sini -->
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <div class="text-sm text-gray-500" id="userPaginationInfo">
                        Menampilkan 0 dari 0 data
                    </div>
                    <div class="flex space-x-2" id="userPagination">
                        <!-- Pagination akan dimuat di sini -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('modals')
    <!-- Modal User -->
    <div id="userModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden items-center justify-center px-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 opacity-0 border border-gray-200" id="userModalContent">
            <div class="gradient-bg px-6 py-4 rounded-t-2xl">
                <h2 class="text-xl font-bold text-white flex items-center" id="userModalTitle">
                    <i class="fas fa-user-plus mr-3"></i>
                    Tambah User
                </h2>
            </div>

            <!-- Inside the modal form -->
            <form id="userForm" class="p-6">
                @csrf
                <input type="hidden" id="userId" name="user_id" />

                <!-- Only show these fields for create -->
                <div id="createFields">
                    <div class="mb-4">
                        <label for="userName" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-[#63A7F4]"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" id="userName" name="name"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#63A7F4] focus:border-[#63A7F4] transition-all duration-300 bg-white text-gray-800"
                            placeholder="Masukkan nama lengkap..." />
                    </div>

                    <div class="mb-4">
                        <label for="userEmail" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-[#63A7F4]"></i>
                            Email
                        </label>
                        <input type="email" id="userEmail" name="email"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#63A7F4] focus:border-[#63A7F4] transition-all duration-300 bg-white text-gray-800"
                            placeholder="Masukkan email..." />
                    </div>

                    <div class="mb-4">
                        <label for="userRole" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user-tag mr-2 text-[#63A7F4]"></i>
                            Role
                        </label>
                        <select id="userRole" name="role"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#63A7F4] focus:border-[#63A7F4] transition-all duration-300 bg-white text-gray-800">
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="organizer">Organizer</option>
                            <option value="user">User</option>
                        </select>
                    </div>

                    <div class="mb-6" id="passwordFields">
                        <label for="userPassword" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-[#63A7F4]"></i>
                            Password
                        </label>
                        <input type="password" id="userPassword" name="password"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#63A7F4] focus:border-[#63A7F4] transition-all duration-300 bg-white text-gray-800"
                            placeholder="Masukkan password..." />
                    </div>
                </div>

                <!-- Status field (shown for both create and edit) -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-toggle-on mr-2 text-[#63A7F4]"></i>
                        Status
                    </label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="Aktif" checked
                                class="form-radio h-5 w-5 text-[#63A7F4] focus:ring-[#63A7F4] border-gray-300">
                            <span class="ml-2 text-gray-700">Aktif</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="Non-Aktif"
                                class="form-radio h-5 w-5 text-[#63A7F4] focus:ring-[#63A7F4] border-gray-300">
                            <span class="ml-2 text-gray-700">Non-Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <button type="button" onclick="closeUserModal()"
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