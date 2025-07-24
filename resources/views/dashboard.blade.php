<x-app-layout>
    <div class="bg-[#E6F0FF] min-h-screen">
        <!-- Navbar -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#78B5FF]">
            <div class="flex items-center space-x-4">
                <img src="/assets/logo.png" alt="Logo" class="h-6" />
                <input type="text" placeholder="Search" class="px-4 py-2 rounded-full w-64 text-sm outline-none" />
            </div>
            <div class="flex items-center space-x-3">
            <div class="flex gap-4">
            <!-- Riwayat -->
            <a href="{{ route('login') }}" class="bg-blue-400 hover:bg-blue-500 text-white px-6 py-2 rounded-md text-sm font-semibold shadow">
                <i class="fas fa-history mr-2"></i> Riwayat
            </a>

            <!-- Dashboard: hanya muncul kalau role bukan user -->
            @if (Auth::check())
            @php
                $role = Auth::user()->role;
                $dashboardRoute = '#';

                if ($role === 'admin') {
                    $dashboardRoute = route('admin.dashboard');
                } elseif ($role === 'organizer') {
                    $dashboardRoute = route('organizer.dashboard');
                } elseif ($role === 'user') {
                    $dashboardRoute = route('dashboard'); // atau bisa dihilangkan kalau emang nggak boleh akses
                }
            @endphp

            @if ($role !== 'user')
                <a href="{{ $dashboardRoute }}" class="bg-blue-400 hover:bg-blue-500 text-white px-6 py-2 rounded-md text-sm font-semibold shadow">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
            @endif
        @endif

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-blue-400 hover:bg-blue-500 text-white px-6 py-2 rounded-md text-sm font-semibold shadow">
                    Log out
                </button>
            </form>
        </div>
            </div>
        </div>

        <!-- Banner -->
        <div class="relative px-6 mt-4">
            <div class="bg-white rounded-lg overflow-hidden w-full">
                <img src="/assets/banner.png" class="w-full object-cover" />
            </div>
            <button class="absolute left-2 top-1/2 transform -translate-y-1/2 text-2xl font-bold">❮</button>
            <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-2xl font-bold">❯</button>
        </div>

        <!-- Featured Event -->
        <section class="px-6 mt-8">
            <h2 class="text-xl font-bold mb-4">Featured Event</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Card 1 -->
                <div class="bg-white rounded-xl p-4 shadow">
                    <img src="/assets/event1.png" class="rounded-lg mb-2" />
                    <p class="text-sm text-gray-500">26 Juli 2025</p>
                    <p class="text-lg font-bold">Rp. 250.000</p>
                    <p class="text-sm mt-1 text-gray-700">Cikal Pop Up Class</p>
                    <div class="flex items-center mt-2 text-sm">
                        <img src="/assets/logo-cikal.png" class="w-4 h-4 mr-1" />
                        <span>Sekolah Cikal</span>
                    </div>
                </div>

                <!-- Dummy Cards -->
                @for ($i = 0; $i < 3; $i++)
                    <div class="bg-white rounded-xl p-4 shadow">
                        <div class="w-full h-32 bg-gray-200 rounded mb-2"></div>
                        <p class="text-sm text-gray-500">Tanggal Event</p>
                        <p class="text-lg font-bold">Rp. 111111</p>
                        <p class="text-sm mt-1 text-gray-700">Nama Event</p>
                        <div class="flex items-center mt-2 text-sm">
                            <div class="w-4 h-4 bg-gray-300 rounded-full mr-1"></div>
                            <span>Nama</span>
                        </div>
                    </div>
                @endfor
            </div>
        </section>

        <!-- Loket Screen -->
        <section class="px-6 mt-10">
            <h2 class="text-xl font-bold mb-4">Loket Screen</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <img src="/assets/superman.jpg" class="rounded-lg" />
                <img src="/assets/selap.jpg" class="rounded-lg" />
                <img src="/assets/sore.jpg" class="rounded-lg" />
                <img src="/assets/jurassic.jpg" class="rounded-lg" />
            </div>
        </section>

        <!-- Rekomendasi Terkini -->
        <section class="px-6 mt-10">
            <h2 class="text-xl font-bold mb-4">Rekomendasi Terkini</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @for ($i = 0; $i < 4; $i++)
                    <div class="bg-white rounded-xl p-4 shadow">
                        <div class="w-full h-32 bg-gray-200 rounded mb-2"></div>
                        <p class="text-sm text-gray-500">Tanggal Event</p>
                        <p class="text-lg font-bold">Rp. 111111</p>
                        <p class="text-sm mt-1 text-gray-700">Nama Event</p>
                        <div class="flex items-center mt-2 text-sm">
                            <div class="w-4 h-4 bg-gray-300 rounded-full mr-1"></div>
                            <span>Nama</span>
                        </div>
                    </div>
                @endfor
            </div>
        </section>

        <!-- Kategori Event -->
        <section class="px-6 mt-10">
            <h2 class="text-xl font-bold mb-4">Kategori Event</h2>
            <div class="grid grid-cols-4 gap-3 mb-4">
                @for ($i = 0; $i < 8; $i++)
                    <div class="h-16 bg-gray-200 rounded-lg"></div>
                @endfor
            </div>
            <div class="grid grid-cols-4 gap-3">
                @for ($i = 0; $i < 6; $i++)
                    <div class="h-12 bg-gray-100 rounded-md"></div>
                @endfor
            </div>
        </section>

        <!-- Kreator Favorit -->
        <section class="px-6 mt-10 mb-16">
            <h2 class="text-xl font-bold mb-4">Kreator Favorit</h2>
            <div class="flex flex-wrap gap-6">
                @for ($i = 0; $i < 8; $i++)
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-gray-300 rounded-full mb-2"></div>
                        <p class="text-sm text-center">Nama Creator</p>
                    </div>
                @endfor
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-[#5BB5FF] text-center py-6 text-sm text-black">
            <div class="flex justify-center gap-8 mb-2 flex-wrap">
                <a href="#">Tentang Loket</a>
                <a href="#">Event Populer</a>
                <a href="#">Kontak Kami</a>
                <a href="#">FAQ</a>
            </div>
            <p class="mb-2">Keamanan dan privasi</p>
            <div class="flex justify-center gap-4 text-xl">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
            </div>
        </footer>
    </div>
</x-app-layout>
