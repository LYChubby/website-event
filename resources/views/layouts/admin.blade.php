<!-- resources/views/layouts/admin.blade.php -->
<x-app-layout>

    <!-- Header dalam nav -->
    <nav class="bg-gradient-to-r from-[#5C6AD0] to-[#684597] px-6 py-4 shadow-lg">
        <div class="flex items-center justify-between">
            <!-- Logo & Judul -->
            <div class="flex items-center space-x-5">
                <!-- Ikon dengan gradient & glow -->
                <div
                    class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg 
               bg-gradient-to-br from-[#5C6AD0] to-[#684597] relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 blur-md"></div>
                    <i class="fas fa-cog text-2xl text-white drop-shadow-md"></i>
                </div>

                <!-- Teks Judul -->
                <div>
                    <h1 class="text-3xl font-extrabold text-white tracking-wide drop-shadow-sm">
                        Dashboard <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#AFCBFF] to-white">Admin</span>
                    </h1>
                    <p class="text-sm text-white/80 mt-1 font-medium">
                        🚀 Kelola sistem secara menyeluruh dengan mudah
                    </p>
                </div>
            </div>


            <!-- Profil Dropdown -->
            <div class="hidden sm:flex items-center space-x-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-full text-white bg-white/20 hover:bg-white/30 focus:outline-none transition-all duration-300 backdrop-blur-sm border border-white/20">
                            <div class="flex items-center space-x-2">
                                <div
                                    class="w-6 h-6 bg-white/30 rounded-full flex items-center justify-center shadow-sm">
                                    <i class="fas fa-user text-xs text-white"></i>
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <div class="ml-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 
                                        1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 
                                        010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user-edit mr-2"></i>{{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <div class="py-8 px-4 sm:px-8 bg-gray-50 min-h-screen">

        <!-- Navigation Tabs -->
        <div class="mb-8 animate-fade-in">
            <nav class="flex space-x-2 bg-white shadow-md rounded-xl p-2 w-fit mx-auto">
                @php
                $tabs = [
                ['route' => 'admin.dashboard', 'icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard'],
                ['route' => 'admin.categories', 'icon' => 'fas fa-tags', 'label' => 'Kategori'],
                ['route' => 'admin.organizers', 'icon' => 'fas fa-user-check', 'label' => 'Organizer Info'],
                ['route' => 'admin.events-approval', 'icon' => 'fas fa-calendar-check', 'label' => 'Persetujuan Event'],
                ['route' => 'admin.users', 'icon' => 'fas fa-users', 'label' => 'Manajemen User'],
                ];
                @endphp

                @foreach($tabs as $tab)
                <a href="{{ route($tab['route']) }}"
                    class="flex items-center px-4 py-2 rounded-lg font-medium text-sm transition-all duration-300
                        {{ Route::is($tab['route']) 
                            ? 'bg-gradient-to-r from-[#5C6AD0] to-[#684597] text-white shadow-md scale-105' 
                            : 'text-gray-600 hover:text-[#5C6AD0] hover:bg-gray-100' }}">
                    <i class="{{ $tab['icon'] }} mr-2"></i> {{ $tab['label'] }}
                </a>
                @endforeach
            </nav>
        </div>

        <!-- Slot Konten Halaman -->
        <div class="animate-fade-in">
            {{ $slot }}
        </div>
    </div>

    @stack('modals')
    @vite(['resources/js/admin.js'])
</x-app-layout>

<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>