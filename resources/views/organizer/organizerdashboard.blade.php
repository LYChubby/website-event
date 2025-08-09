<x-app-layout>
    <nav class="custom-navbar">
    <div class="flex items-center justify-between px-6">
        
        <!-- Left: Brand + Search -->
        <div class="flex items-center space-x-6">
            <!-- Brand -->
            <a href="#" class="navbar-brand">
                <div class="brand-icon">
                    <i class="fas fa-calendar-star text-white text-xl"></i>
                </div>
                <div class="brand-text">
                    <h1>Dashboard Organizer</h1>
                </div>
            </a>

            <!-- Search -->
            <div class="nav-search">
                <i class="fas fa-search nav-search-icon"></i>
                <input type="text" placeholder="Cari event, kategori..." />
            </div>
        </div>

        <!-- Right: User Dropdown -->
        <div class="hidden sm:flex items-center space-x-4">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-4 py-2 text-sm leading-4 font-medium rounded-full text-white bg-white/20 hover:bg-white/30 focus:outline-none transition-all duration-300 backdrop-blur-sm border border-white/20"
                    >
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 bg-white/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-xs text-white"></i>
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                        <div class="ml-2">
                            <svg
                                class="fill-current h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 
                                       10.586l3.293-3.293a1 1 0 111.414 
                                       1.414l-4 4a1 1 0 01-1.414 
                                       0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
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
                        <x-dropdown-link
                            :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-600 hover:bg-red-50"
                        >
                            <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>

    {{-- Custom Styles --}}
    <style>
        :root {
            --primary-color: #5C6AD0;
            --primary-dark: #4A5BC4;
            --secondary-color: #684597;
            --secondary-dark: #5A3A85;
            --accent-color: #9C6ADE;
            --gradient-main: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
            --gradient-card: linear-gradient(145deg, #684597 0%, #5C6AD0 100%);
            --gradient-hover: linear-gradient(135deg, #5A3A85 0%, #4A5BC4 100%);
        }

        body {
            overflow-x: hidden;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            min-height: 100vh;
        }

        /* Navbar Styles */
        .custom-navbar {
            background: var(--gradient-main);
            backdrop-filter: blur(20px);
            border: none;
            box-shadow: 0 8px 32px rgba(104, 69, 151, 0.3);
            padding: 1rem 0;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand-text h1 {
            color: white;
            font-size: 1.8rem;
            font-weight: 800;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .brand-text p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            margin: 0;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-search {
            position: relative;
        }

        .nav-search input {
            padding: 0.7rem 1rem 0.7rem 2.5rem;
            border-radius: 25px;
            border: none;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            width: 280px;
            color: white;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .nav-search input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .nav-search input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .nav-search-icon {
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .user-dropdown {
            position: relative;
        }

        .user-trigger {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .user-trigger:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
            color: white;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Dashboard Container */
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stats-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(104, 69, 151, 0.1);
            border: 1px solid rgba(104, 69, 151, 0.05);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-main);
        }

        .stats-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(104, 69, 151, 0.2);
        }

        .stats-card-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            position: relative;
        }

        .stats-icon.events {
            background: var(--gradient-main);
        }

        .stats-icon.tickets {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }

        .stats-icon.revenue {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        }

        .stats-info h3 {
            color: #64748B;
            font-size: 0.9rem;
            font-weight: 600;
            margin: 0 0 0.5rem 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-info .stats-number {
            color: #1E293B;
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0;
            line-height: 1;
        }

        /* Management Section */
        .management-section {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(104, 69, 151, 0.1);
            border: 1px solid rgba(104, 69, 151, 0.05);
        }

        .management-header {
            background: var(--gradient-main);
            padding: 2.5rem 2rem;
            color: white;
        }

        .management-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .management-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .management-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .management-title h2 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .management-title p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0.5rem 0 0 0;
            font-size: 1rem;
        }

        .management-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-box-header {
            position: relative;
        }

        .search-box-header input {
            padding: 0.8rem 1rem 0.8rem 2.8rem;
            border-radius: 20px;
            border: none;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            width: 280px;
            color: white;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .search-box-header input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-box-header input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .search-box-header .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .add-event-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .add-event-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Filter Section */
        .filter-section {
            padding: 2rem;
            border-bottom: 1px solid #E2E8F0;
        }

        .filter-container {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.7rem 1.5rem;
            border-radius: 20px;
            border: 2px solid #E2E8F0;
            background: white;
            color: #64748B;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-btn.active {
            background: var(--gradient-main);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(104, 69, 151, 0.3);
        }

        .filter-btn:hover:not(.active) {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Events Grid */
        .events-content {
            padding: 2rem;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 2rem;
        }

        .event-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(104, 69, 151, 0.1);
            transition: all 0.4s ease;
            position: relative;
            border: 1px solid rgba(104, 69, 151, 0.05);
        }

        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(104, 69, 151, 0.2);
        }

        .event-image {
            height: 220px;
            background: var(--gradient-main);
            position: relative;
            overflow: hidden;
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .event-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-hover);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .event-card:hover .event-image::before {
            opacity: 0.8;
        }

        .event-image-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            color: white;
            height: 100%;
        }

        .event-content {
            padding: 2rem;
        }

        .event-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }

        .event-date {
            color: #64748B;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #E2E8F0, transparent);
            margin: 1.5rem 0;
        }

        .organizer-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .organizer-avatar {
            width: 45px;
            height: 45px;
            background: var(--gradient-main);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .organizer-name {
            font-weight: 600;
            color: #374151;
            font-size: 1rem;
        }

        .card-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .action-btn {
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .edit-btn {
            background: var(--gradient-main);
            color: white;
        }

        .edit-btn:hover {
            background: var(--gradient-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(104, 69, 151, 0.3);
        }

        .delete-btn {
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: white;
        }

        .delete-btn:hover {
            background: linear-gradient(135deg, #DC2626, #B91C1C);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .detail-btn {
            background: linear-gradient(135deg, #10B981, #059669);
            color: white;
        }

        .detail-btn:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(15px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            width: 90%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.9);
            transition: all 0.3s ease;
            box-shadow: 0 25px 80px rgba(104, 69, 151, 0.3);
            border: 1px solid rgba(104, 69, 151, 0.1);
        }

        .modal.show .modal-content {
            transform: scale(1);
        }

        .modal-header {
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .modal-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1E293B;
            background: var(--gradient-main);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 700;
            color: #374151;
            font-size: 0.95rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #E2E8F0;
            border-radius: 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #F8FAFC;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(92, 106, 208, 0.1);
            background: white;
        }

        .form-row {
            display: flex;
            gap: 1.5rem;
        }

        .form-row .form-group {
            flex: 1;
        }

        .modal-actions {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .btn-cancel {
            padding: 1rem 2rem;
            background: #F1F5F9;
            color: #64748B;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #E2E8F0;
            transform: translateY(-2px);
        }

        .btn-primary {
            padding: 1rem 2rem;
            background: var(--gradient-main);
            color: white;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--gradient-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(104, 69, 151, 0.3);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stats-card,
        .event-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .stats-card:nth-child(1) { animation-delay: 0.1s; }
        .stats-card:nth-child(2) { animation-delay: 0.2s; }
        .stats-card:nth-child(3) { animation-delay: 0.3s; }

        .event-card:nth-child(1) { animation-delay: 0.1s; }
        .event-card:nth-child(2) { animation-delay: 0.2s; }
        .event-card:nth-child(3) { animation-delay: 0.3s; }
        .event-card:nth-child(4) { animation-delay: 0.4s; }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-content {
                flex-direction: column;
                gap: 1rem;
                padding: 0 1rem;
            }

            .navbar-actions {
                width: 100%;
                justify-content: center;
            }

            .nav-search input {
                width: 200px;
            }

            .dashboard-container {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .management-header {
                padding: 2rem 1.5rem;
            }

            .management-header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-box-header input {
                width: 200px;
            }

            .events-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                flex-direction: column;
            }

            .modal-content {
                padding: 2rem;
                margin: 1rem;
            }
        }

        @media (max-width: 480px) {
            .brand-text h1 {
                font-size: 1.4rem;
            }

            .management-title h2 {
                font-size: 1.6rem;
            }

            .stats-number {
                font-size: 2rem !important;
            }
        }
    </style>
    <div class="py-8 px-4 sm:px-8 bg-gray-50 min-h-screen space-y-8">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in">
            <!-- Total Event -->
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-[#63A7F4] bg-opacity-10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-xl text-[#63A7F4]"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Total Event</h3>
                        <p class="text-3xl font-bold text-[#63A7F4]" id="totalEvents">0</p>
                    </div>
                </div>
            </div>

            <!-- Total Tiket Terjual -->
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Total Tiket Terjual</h3>
                        <p class="text-3xl font-bold text-green-600" id="totalTicketsSold">0</p>
                    </div>
                </div>
            </div>

            <!-- Total Pendapatan -->
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-xl text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Total Pendapatan</h3>
                        <p class="text-3xl font-bold text-purple-600" id="totalRevenue">Rp 0</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-container">
            {{-- Main Header --}}
            <div class="custom-navbar px-8 py-6 rounded-2xl">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <!-- Title Section -->
                    <div class="flex items-center space-x-4 mt-4 sm:mt-0">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-tags text-lg text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Manajemen Event</h3>
                            <p class="text-blue-100">Kelola Event Dengan Mudah</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Search Box -->
                        <div class="relative hidden sm:block">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-white"></i>
                            <input type="text" placeholder="Cari Event..."
                                class="pl-10 pr-4 py-2 rounded-xl border-0 bg-white bg-opacity-20 text-white placeholder-blue-100 focus:bg-white focus:text-gray-800 focus:placeholder-gray-400 transition-all duration-300 w-64" />
                        </div>

                        <!-- Add Category Button -->
                        <button onclick="openEventModal()"
                            class="bg-white text-[#63A7F4] font-semibold px-4 py-2 rounded-xl hover:bg-gray-100 transition-all duration-300 flex items-center space-x-2 shadow-lg">
                            <i class="fas fa-plus"></i>
                            <span class="hidden sm:inline">Tambah Event</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="main-content">
                {{-- Filter Section --}}
                <div class="filter-section">
                    <div class="filter-container" id="categoryFilter">
                        <button class="filter-btn active" data-category="all" onclick="filterEvents('all')">
                            <i class="fas fa-th-large"></i> Semua
                        </button>
                        {{-- Filter buttons will be loaded by JS --}}
                    </div>
                </div>

                {{-- Events Grid --}}
                <div class="events-grid" id="eventGrid">
                    {{-- Event cards will be loaded by JS --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Load Categories --}}

    {{-- Modal Tambah/Edit Event --}}
    <div id="eventModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="eventModalTitle">Tambah Event</h2>
            </div>
            <form id="eventForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="eventId" name="event_id" />
                <input type="hidden" id="status_approval" name="status_approval" />

                <div class="form-group">
                    <label for="name_event" class="form-label">Nama Event</label>
                    <input type="text" id="name_event" name="name_event" class="form-input" required />
                </div>

                <div class="form-group">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select id="category_id" name="category_id" class="form-select" required>
                        <option value="">Pilih Kategori</option>
                        {{-- Options will be loaded by JS --}}
                    </select>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" class="form-textarea" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="venue_name" class="form-label">Nama Tempat</label>
                    <input type="text" id="venue_name" name="venue_name" class="form-input" required />
                </div>

                <div class="form-group">
                    <label for="venue_address" class="form-label">Alamat Tempat</label>
                    <textarea id="venue_address" name="venue_address" class="form-textarea" rows="3" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date" class="form-input" required />
                    </div>
                    <div class="form-group">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" id="end_date" name="end_date" class="form-input" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_image" class="form-label">Gambar Event</label>
                    <input type="file" id="event_image" name="event_image" accept="image/*" class="form-input" />
                </div>
                <div id="fileInfo" style="display: none; color: #666; font-size: 0.8rem; margin-top: 4px;"></div>
                <input type="hidden" name="existing_image" value="">

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeEventModal()">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Load Font Awesome --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    @vite(['resources/js/organizer-dashboard.js']) {{-- file JS khusus organizer --}}
</x-app-layout>