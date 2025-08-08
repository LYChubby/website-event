<!-- resources/views/layouts/admin.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-cog text-2xl text-white"></i>
                </div>
                <div>
                    <h2 class="font-semibold text-2xl text-white leading-tight">
                        Dashboard Admin
                    </h2>
                    <p class="text-sm text-blue-100">Kelola sistem secara menyeluruh</p>
                </div>
            </div>

            <div class="hidden sm:flex items-center space-x-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 text-sm leading-4 font-medium rounded-full text-white bg-white/20 hover:bg-white/30 focus:outline-none transition-all duration-300 backdrop-blur-sm border border-white/20">
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 bg-white/30 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-xs text-white"></i>
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <div class="ml-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
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
    </x-slot>

    <div class="py-8 px-4 sm:px-8 bg-gray-50 min-h-screen">
        <!-- Navigation -->
        <div class="mb-8">
            <nav class="flex space-x-4" aria-label="Tabs">
                <a href="{{ route('admin.dashboard') }}" class="@if(Route::is('admin.dashboard')) bg-white text-blue-600 @else text-gray-500 hover:text-gray-700 @endif px-3 py-2 font-medium text-sm rounded-md">
                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                </a>
                <a href="{{ route('admin.categories') }}" class="@if(Route::is('admin.categories')) bg-white text-blue-600 @else text-gray-500 hover:text-gray-700 @endif px-3 py-2 font-medium text-sm rounded-md">
                    <i class="fas fa-tags mr-1"></i> Kategori
                </a>
                <a href="{{ route('admin.organizers') }}" class="@if(Route::is('admin.organizers-info')) bg-white text-blue-600 @else text-gray-500 hover:text-gray-700 @endif px-3 py-2 font-medium text-sm rounded-md">
                    <i class="fas fa-user-check mr-1"></i> Organizer Info
                </a>
                <a href="{{ route('admin.events-approval') }}" class="@if(Route::is('admin.events-approval')) bg-white text-blue-600 @else text-gray-500 hover:text-gray-700 @endif px-3 py-2 font-medium text-sm rounded-md">
                    <i class="fas fa-calendar-check mr-1"></i> Persetujuan Event
                </a>
                <a href="{{ route('admin.users') }}" class="@if(Route::is('admin.users')) bg-white text-blue-600 @else text-gray-500 hover:text-gray-700 @endif px-3 py-2 font-medium text-sm rounded-md">
                    <i class="fas fa-users mr-1"></i> Manajemen User
                </a>
            </nav>
        </div>

        {{ $slot }}
    </div>

    @stack('modals')
    @vite(['resources/js/admin.js'])
</x-app-layout>

<style>
    .gradient-bg {
        background: linear-gradient(135deg, #63A7F4 0%, #4A90E2 100%);
    }

    .card-hover {
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(99, 167, 244, 0.2);
    }

    .btn-primary {
        background: linear-gradient(135deg, #63A7F4 0%, #4A90E2 100%);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(99, 167, 244, 0.3);
    }

    .btn-white {
        background: white;
        color: #4A90E2;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-white:hover {
        background: #f8fafc;
        transform: translateY(-2px);
    }

    .glass-effect {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-pending {
        background: #FEF3C7;
        color: #92400E;
    }

    .status-approved {
        background: #D1FAE5;
        color: #065F46;
    }

    .status-rejected {
        background: #FEE2E2;
        color: #991B1B;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>