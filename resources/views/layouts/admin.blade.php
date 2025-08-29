<!-- resources/views/layouts/admin.blade.php -->
<x-app-layout>
    <!-- Header with proper z-index -->
<nav x-data="{ open: false }" 
     class="relative bg-gradient-to-br from-[#5C6AD0] via-[#6B73FF] to-[#684597] px-4 sm:px-6 py-4 shadow-2xl border-b border-white/10 backdrop-blur-lg z-50">
        <!-- Floating particles background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="floating-particle w-2 h-2 bg-white/20 rounded-full absolute top-4 left-1/4 animate-float-slow"></div>
            <div class="floating-particle w-1 h-1 bg-white/30 rounded-full absolute top-8 right-1/3 animate-float-medium"></div>
            <div class="floating-particle w-3 h-3 bg-white/10 rounded-full absolute bottom-6 left-1/2 animate-float-fast"></div>
        </div>

        <div class="flex items-center justify-between relative z-10">
            <!-- Logo & Title Section -->
            <div class="flex items-center space-x-4 sm:space-x-6">
                <!-- Enhanced Logo -->
                <div class="relative group">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl flex items-center justify-center shadow-2xl 
                               bg-gradient-to-br from-white/20 to-white/5 backdrop-blur-xl border border-white/20
                               hover:shadow-3xl hover:scale-105 transition-all duration-500 group-hover:rotate-3">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-[#AFCBFF] to-[#C9A9DD] opacity-0 
                                   group-hover:opacity-30 blur-xl transition-all duration-500"></div>
                        <div class="absolute inset-2 rounded-xl bg-white/10 blur-sm"></div>
                        <i class="fas fa-cog text-xl sm:text-2xl text-white drop-shadow-lg relative z-10 
                                 group-hover:rotate-180 transition-transform duration-700"></i>
                    </div>
                </div>

                <!-- Title Section -->
                <div class="space-y-1">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-wide drop-shadow-lg
                              bg-clip-text text-transparent bg-gradient-to-r from-white via-[#AFCBFF] to-white
                              hover:from-[#AFCBFF] hover:to-white transition-all duration-500">
                        Dashboard
                        <span class="inline-block bg-clip-text text-transparent bg-gradient-to-r from-[#AFCBFF] to-[#C9A9DD]
                                   hover:scale-105 transition-transform duration-300">Admin</span>
                    </h1>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-gradient-to-r from-[#AFCBFF] to-[#C9A9DD] rounded-full animate-pulse"></div>
                        <p class="text-xs sm:text-sm text-white/90 font-semibold tracking-wide
                                 hover:text-[#AFCBFF] transition-colors duration-300">
                            🚀 Kelola sistem dengan teknologi terdepan
                        </p>
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown - Fixed Clickable Area -->
            <div class="hidden sm:flex items-center space-x-4 relative z-50">
                <!-- Date and time display -->
                <div class="hidden lg:flex items-center space-x-3">
                    <div class="px-3 py-2 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20
                               hover:bg-white/20 transition-all duration-300 cursor-pointer group">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                            <span class="text-xs text-white/90 font-medium group-hover:text-white" id="current-datetime"></span>
                        </div>
                    </div>
                </div>

                <!-- Dropdown Component -->
                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="group inline-flex items-center px-4 py-2.5 text-sm font-semibold rounded-2xl 
                     text-white bg-white/15 hover:bg-white/25 focus:outline-none focus:ring-2 
                     focus:ring-white/50 transition-all duration-300 backdrop-blur-xl 
                     border border-white/20 hover:border-white/40 hover:shadow-xl">
                            <div class="flex items-center space-x-3">
                                <div class="relative">
                                    <div class="w-8 h-8 bg-gradient-to-br from-[#AFCBFF] to-[#C9A9DD] rounded-xl 
                               flex items-center justify-center shadow-lg">
                                        <i class="fas fa-user text-sm text-white"></i>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 rounded-full 
                               border-2 border-white shadow-sm animate-pulse"></div>
                                </div>
                                <div class="hidden md:block text-left">
                                    <div class="font-semibold text-white text-sm">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-white/70">Administrator</div>
                                </div>
                            </div>
                            <div class="ml-2">
                                <svg class="fill-current h-4 w-4 text-white/80" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 
                           111.414 1.414l-4 4a1 1 0 
                           01-1.414 0l-4-4a1 1 0 
                           010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <div class="px-4 py-3 bg-gradient-to-r from-[#5C6AD0]/5 to-[#684597]/5 border-b border-gray-100">
                            <div class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-600">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="py-1">
                            <x-dropdown-link :href="route('profile.edit')"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">
                                <i class="fas fa-user-edit mr-3 text-[#5C6AD0] w-4"></i>
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 cursor-pointer">
                                    <i class="fas fa-sign-out-alt mr-3 w-4"></i>
                                    {{ __('Sign Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>

                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button -->
            <div class="sm:hidden">
                <button @click="open = true" 
                        class="p-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/20 text-white
                            hover:bg-white/30 transition-all duration-300">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <!-- Mobile Drawer -->
            <div 
                class="fixed inset-0 z-50 sm:hidden" 
                x-show="open" 
                x-transition.opacity
                @keydown.escape.window="open = false">

                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
                    @click="open = false"></div>

                <!-- Drawer panel -->
                <div x-show="open" 
                    x-transition:enter="transform transition ease-out duration-300"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in duration-200"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="absolute right-0 top-0 h-full w-64 bg-white shadow-2xl rounded-l-2xl flex flex-col">

                    <!-- Header -->
                    <div class="p-4 flex items-center justify-between border-b border-gray-200">
                        <div>
                            <div class="font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-600">{{ Auth::user()->email }}</div>
                        </div>
                        <button @click="open = false" 
                                class="p-2 rounded-lg hover:bg-gray-100 text-gray-500">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Menu -->
                    <div class="flex-1 overflow-y-auto">
                        <a href="{{ route('profile.edit') }}" 
                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user-edit mr-3 text-[#5C6AD0] w-4"></i>
                            Profile Settings
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 text-left">
                                <i class="fas fa-sign-out-alt mr-3 w-4"></i>
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Mobile Dropdown Menu -->
            <div x-show="open"
                x-transition
                class="sm:hidden mt-4 bg-white/95 rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                
                <div class="px-4 py-3 border-b border-gray-100">
                    <div class="font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-600">{{ Auth::user()->email }}</div>
                </div>

                <a href="{{ route('profile.edit') }}" 
                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-user-edit mr-3 text-[#5C6AD0] w-4"></i>
                    Profile Settings
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 text-left">
                        <i class="fas fa-sign-out-alt mr-3 w-4"></i>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-purple-50/30 relative overflow-hidden">
        <!-- Background elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute top-20 left-10 w-32 h-32 bg-gradient-to-r from-[#5C6AD0]/10 to-[#684597]/10 
                       rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute bottom-20 right-10 w-48 h-48 bg-gradient-to-r from-[#684597]/10 to-[#5C6AD0]/10 
                       rounded-full blur-3xl animate-pulse-slow animation-delay-2s"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
                       w-96 h-96 bg-gradient-to-r from-[#5C6AD0]/5 to-[#684597]/5 
                       rounded-full blur-3xl animate-spin-slow"></div>
        </div>

        <div class="relative z-10 py-6 sm:py-8 px-4 sm:px-8">
            <!-- Navigation Tabs -->
            <div class="mb-8 animate-slide-up">
                <div class="flex justify-center">
                    <nav class="inline-flex bg-white/80 backdrop-blur-xl shadow-2xl rounded-3xl p-2 
                      border border-white/50 hover:shadow-3xl transition-all duration-500
                      max-w-full overflow-x-auto scrollbar-hide">
                        @php
                        $tabs = [
                        [
                        'route' => 'admin.dashboard',
                        'icon' => 'fas fa-tachometer-alt',
                        'label' => 'Dashboard',
                        'color' => 'from-blue-500 to-blue-600',
                        'active_color' => 'from-[#5C6AD0] to-[#684597]'
                        ],
                        [
                        'route' => 'admin.categories',
                        'icon' => 'fas fa-tags',
                        'label' => 'Kategori',
                        'color' => 'from-green-500 to-green-600',
                        'active_color' => 'from-[#5C6AD0] to-[#684597]'
                        ],
                        [
                        'route' => 'admin.organizers',
                        'icon' => 'fas fa-user-check',
                        'label' => 'Organizer',
                        'color' => 'from-purple-500 to-purple-600',
                        'active_color' => 'from-[#5C6AD0] to-[#684597]'
                        ],
                        [
                        'route' => 'admin.events-approval',
                        'icon' => 'fas fa-calendar-check',
                        'label' => 'Approval',
                        'color' => 'from-orange-500 to-orange-600',
                        'active_color' => 'from-[#5C6AD0] to-[#684597]'
                        ],
                        [
                        'route' => 'admin.users',
                        'icon' => 'fas fa-users',
                        'label' => 'Users',
                        'color' => 'from-pink-500 to-pink-600',
                        'active_color' => 'from-[#5C6AD0] to-[#684597]'
                        ],
                        [
                        'route' => 'admin.disbursement',
                        'icon' => 'fas fa-money-bill-transfer',
                        'label' => 'Disbursement',
                        'color' => 'from-amber-500 to-amber-600',
                        'active_color' => 'from-[#5C6AD0] to-[#684597]'
                        ],
                        ];
                        @endphp

                        @foreach($tabs as $tab)
                        <a href="{{ route($tab['route']) }}"
                            class="group relative flex items-center px-4 sm:px-6 py-3 rounded-2xl font-semibold text-sm
                              transition-all duration-500 hover:scale-105 whitespace-nowrap
                              {{ Route::is($tab['route']) 
                                  ? 'bg-gradient-to-r ' . $tab['active_color'] . ' text-white shadow-xl scale-105 z-10' 
                                  : 'text-gray-600 hover:text-[#5C6AD0] hover:bg-white/70' }}">

                            <!-- Active tab glow effect -->
                            @if(Route::is($tab['route']))
                            <div class="absolute inset-0 bg-gradient-to-r {{ $tab['active_color'] }} rounded-2xl 
                                   blur-lg opacity-50 -z-10 animate-pulse"></div>
                            @endif

                            <!-- Icon container -->
                            <div class="relative mr-2 sm:mr-3">
                                <i class="{{ $tab['icon'] }} text-sm sm:text-base 
                                     {{ Route::is($tab['route']) 
                                         ? 'text-white drop-shadow-sm' 
                                         : 'text-gray-500 group-hover:text-[#5C6AD0]' }}
                                     group-hover:scale-110 transition-all duration-300"></i>

                                <!-- Hover gradient effect -->
                                @if(!Route::is($tab['route']))
                                <div class="absolute inset-0 bg-gradient-to-r {{ $tab['color'] }} rounded-full 
                                       opacity-0 group-hover:opacity-20 blur-sm transition-all duration-300"></div>
                                @endif
                            </div>

                            <!-- Label (hidden on mobile) -->
                            <span class="hidden sm:inline font-medium tracking-wide">{{ $tab['label'] }}</span>

                            <!-- Active indicator dot -->
                            @if(Route::is($tab['route']))
                            <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 
                                   w-2 h-2 bg-white rounded-full shadow-sm animate-bounce"></div>
                            @endif
                        </a>
                        @endforeach
                    </nav>
                </div>
            </div>

            <!-- Content Slot -->
            <div class="animate-fade-in-up">
                <div class="max-w-full mx-auto">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    @stack('modals')
    @vite(['resources/js/admin.js'])

    <script>
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            };

            const dateTimeString = now.toLocaleDateString('id-ID', options);
            const element = document.getElementById('current-datetime');
            if (element) {
                element.textContent = dateTimeString;
            }
        }

        updateDateTime();
        setInterval(updateDateTime, 60000);

        document.addEventListener('alpine:init', () => {
            // Alpine.js initialization
        });
    </script>
</x-app-layout>

<style>
    /* Animation Styles */
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
        opacity: 0;
    }

    .animate-slide-up {
        animation: slideUp 0.7s ease-out;
    }

    .animate-float-slow {
        animation: float 6s ease-in-out infinite;
    }

    .animate-float-medium {
        animation: float 4s ease-in-out infinite;
        animation-delay: 2s;
    }

    .animate-float-fast {
        animation: float 3s ease-in-out infinite;
        animation-delay: 1s;
    }

    .animate-pulse-slow {
        animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .animate-spin-slow {
        animation: spin 20s linear infinite;
    }

    .animation-delay-2s {
        animation-delay: 2s;
    }

    /* Keyframes */
    @keyframes fadeIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 0.5;
        }

        50% {
            opacity: 1;
        }
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Utility Styles */
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .shadow-3xl {
        box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
    }

    /* Accessibility */
    button:focus-visible,
    a:focus-visible {
        outline: 2px solid #5C6AD0;
        outline-offset: 2px;
    }

    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {

        .animate-fade-in,
        .animate-fade-in-up,
        .animate-slide-up,
        .animate-float-slow,
        .animate-float-medium,
        .animate-float-fast,
        .animate-pulse-slow,
        .animate-spin-slow {
            animation: none;
        }
    }
</style>