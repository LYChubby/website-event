<head>
    <title>
        Dashboard
    </title>
</head>
<x-app-layout>
    <nav class="custom-navbar">
        <div class="flex items-center justify-between px-6">

            <!-- Left: Brand + Search -->
            <div class="flex items-center space-x-6">
                <!-- Brand -->
                <a href="#" class="navbar-brand">
                    <div class="brand-icon">
                        <i class="fa-solid fa-gears text-white text-xl"></i>
                    </div>
                    <div class="brand-text">
                        <h1>Dashboard Organizer</h1>
                    </div>
                </a>
            </div>

            <!-- Right: User Dropdown -->
            <div class="hidden sm:flex items-center space-x-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-4 py-2 text-sm leading-4 font-medium rounded-full text-white bg-white/20 hover:bg-white/30 focus:outline-none transition-all duration-300 backdrop-blur-sm border border-white/20">
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
                                    viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 
                                           10.586l3.293-3.293a1 1 0 111.414 
                                           1.414l-4 4a1 1 0 01-1.414 
                                           0l-4-4a1 1 0 010-1.414z"
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
                            <x-dropdown-link
                                :href="route('logout')"
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
            --shadow-sm: 0 2px 8px rgba(104, 69, 151, 0.06);
            --shadow-md: 0 8px 25px rgba(104, 69, 151, 0.1);
            --shadow-lg: 0 15px 35px rgba(104, 69, 151, 0.15);
            --shadow-xl: 0 20px 60px rgba(104, 69, 151, 0.2);
            --border-radius-sm: 12px;
            --border-radius-md: 16px;
            --border-radius-lg: 20px;
            --border-radius-xl: 24px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* ========== NAVBAR STYLES ========== */
        .custom-navbar {
            background: var(--gradient-main);
            backdrop-filter: blur(20px);
            border: none;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: translateY(-2px);
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
            transition: all 0.3s ease;
        }

        .navbar-brand:hover .brand-icon {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.05);
        }

        .brand-text h1 {
            color: white;
            font-size: 1.8rem;
            font-weight: 800;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            letter-spacing: -0.025em;
        }

        .nav-search {
            position: relative;
        }

        .nav-search input {
            padding: 0.75rem 1rem 0.75rem 2.8rem;
            border-radius: 25px;
            border: none;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            width: 300px;
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
            width: 320px;
        }

        .nav-search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            transition: color 0.3s ease;
        }

        .nav-search input:focus+.nav-search-icon {
            color: rgba(255, 255, 255, 0.9);
        }

        /* ========== MAIN CONTAINER ========== */
        .main-wrapper {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            min-height: calc(100vh - 120px);
            padding: 2rem 0;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* ========== STATS CARDS ========== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stats-card {
            background: white;
            border-radius: var(--border-radius-xl);
            padding: 2rem;
            box-shadow: var(--shadow-md);
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
            box-shadow: var(--shadow-xl);
        }

        .stats-card-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .stats-icon {
            width: 65px;
            height: 65px;
            border-radius: var(--border-radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            position: relative;
            flex-shrink: 0;
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

        .stats-info {
            flex: 1;
            min-width: 0;
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
            letter-spacing: -0.025em;
        }

        /* ========== MANAGEMENT SECTION ========== */
        .management-section {
            background: white;
            border-radius: var(--border-radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(104, 69, 151, 0.05);
            margin-bottom: 2rem;
        }

        .management-header {
            background: var(--gradient-main);
            padding: 3rem 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .management-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(30px, -30px) rotate(120deg);
            }

            66% {
                transform: translate(-20px, 20px) rotate(240deg);
            }
        }

        .management-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
            position: relative;
            z-index: 2;
        }

        .management-title {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .management-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: var(--border-radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .management-title h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            letter-spacing: -0.025em;
        }

        .management-title p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0.5rem 0 0 0;
            font-size: 1rem;
            font-weight: 500;
        }

        .management-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .search-box-header {
            position: relative;
        }

        .search-box-header input {
            padding: 0.875rem 1.25rem 0.875rem 3rem;
            border-radius: var(--border-radius-lg);
            border: none;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            width: 300px;
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
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .search-box-header .search-icon {
            position: absolute;
            left: 1.125rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .add-event-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            border: none;
            padding: 0.875rem 1.75rem;
            border-radius: var(--border-radius-lg);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.95rem;
        }

        .add-event-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .add-event-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        /* ========== FILTER SECTION ========== */
        .filter-section {
            padding: 2.5rem;
            border-bottom: 1px solid #E2E8F0;
            background: #FAFBFC;
        }

        .filter-container {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .filter-btn {
            padding: 0.75rem 1.75rem;
            border-radius: var(--border-radius-lg);
            border: 2px solid #E2E8F0;
            background: white;
            color: #64748B;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            box-shadow: var(--shadow-sm);
        }

        .filter-btn.active {
            background: var(--gradient-main);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(104, 69, 151, 0.3);
            transform: translateY(-2px);
        }

        .filter-btn:hover:not(.active) {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* ========== EVENTS GRID ========== */
        .events-content {
            padding: 2.5rem;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 2.5rem;
        }

        .event-card {
            background: white;
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.4s ease;
            position: relative;
            border: 1px solid rgba(104, 69, 151, 0.05);
        }

        .event-card:hover {
            transform: translateY(-12px);
            box-shadow: var(--shadow-xl);
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
            transition: transform 0.4s ease;
        }

        .event-card:hover .event-image img {
            transform: scale(1.05);
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
            z-index: 1;
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
            position: relative;
            z-index: 2;
        }

        .event-content {
            padding: 2.25rem;
        }

        .event-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 1rem;
            line-height: 1.3;
            letter-spacing: -0.025em;
        }

        .event-date {
            color: #64748B;
            font-size: 0.95rem;
            margin-bottom: 1.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #E2E8F0, transparent);
            margin: 1.75rem 0;
        }

        .organizer-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .organizer-avatar {
            width: 48px;
            height: 48px;
            background: var(--gradient-main);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .organizer-name {
            font-weight: 600;
            color: #374151;
            font-size: 1rem;
        }

        .card-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 0.65rem 1.25rem;
            border-radius: var(--border-radius-sm);
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
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

        /* ========== MODAL STYLES ========== */
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
            padding: 1rem;
        }

        .modal.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            border-radius: var(--border-radius-xl);
            padding: 3rem;
            width: 100%;
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
            letter-spacing: -0.025em;
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
            padding: 1rem 1.25rem;
            border: 2px solid #E2E8F0;
            border-radius: var(--border-radius-md);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #F8FAFC;
            font-family: inherit;
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
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .modal-actions {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 3rem;
            flex-wrap: wrap;
        }

        .btn-cancel {
            padding: 1rem 2rem;
            background: #F1F5F9;
            color: #64748B;
            border: none;
            border-radius: var(--border-radius-md);
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.95rem;
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
            border-radius: var(--border-radius-md);
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-primary:hover {
            background: var(--gradient-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(104, 69, 151, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: var(--border-radius-xl);
            border: 2px dashed #E2E8F0;
            margin: 2rem 0;
        }

        .empty-state i {
            font-size: 4rem;
            color: #E5E7EB;
            margin-bottom: 1.5rem;
        }

        .empty-state h3 {
            color: #6B7280;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .empty-state p {
            color: #9CA3AF;
            font-size: 1rem;
            margin: 0;
        }

        /* ========== LOADING STATE ========== */
        .loading-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
        }

        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid #F3F4F6;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 1.5rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            color: #6B7280;
            font-size: 1.1rem;
            margin: 0;
        }

        /* ========== ANIMATIONS ========== */
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

        .stats-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stats-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stats-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .event-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .event-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .event-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .event-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        /* ========== RESPONSIVE DESIGN ========== */
        @media (max-width: 1200px) {
            .dashboard-container {
                max-width: 1200px;
                padding: 0 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem;
            }

            .events-grid {
                grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
                gap: 2rem;
            }
        }

        @media (max-width: 768px) {
            .custom-navbar {
                padding: 1rem 0;
            }

            .custom-navbar .flex {
                flex-direction: column;
                gap: 1rem;
                padding: 0 1rem;
            }

            .nav-search input {
                width: 250px;
            }

            .dashboard-container {
                padding: 0 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .stats-card {
                padding: 1.5rem;
            }

            .stats-number {
                font-size: 2rem !important;
            }

            .management-header {
                padding: 2rem 1.5rem;
            }

            .management-header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
            }

            .management-title h2 {
                font-size: 1.8rem;
            }

            .management-actions {
                width: 100%;
                justify-content: space-between;
            }

            .search-box-header input {
                width: 200px;
            }

            .filter-section {
                padding: 2rem 1.5rem;
            }

            .filter-container {
                justify-content: flex-start;
                gap: 0.75rem;
            }

            .filter-btn {
                padding: 0.625rem 1.25rem;
                font-size: 0.85rem;
            }

            .events-content {
                padding: 2rem 1.5rem;
            }

            .events-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .event-content {
                padding: 1.75rem;
            }

            .card-actions {
                flex-direction: column;
                gap: 0.5rem;
            }

            .action-btn {
                justify-content: center;
                width: 100%;
            }

            .modal-content {
                padding: 2rem;
                margin: 1rem;
                max-width: calc(100vw - 2rem);
            }

            .modal-title {
                font-size: 1.75rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .modal-actions {
                flex-direction: column;
                gap: 1rem;
            }

            .btn-cancel,
            .btn-primary {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .brand-text h1 {
                font-size: 1.5rem;
            }

            .nav-search input {
                width: 200px;
            }

            .stats-card-content {
                gap: 1rem;
            }

            .stats-icon {
                width: 55px;
                height: 55px;
                font-size: 1.5rem;
            }

            .management-title {
                gap: 1rem;
            }

            .management-icon {
                width: 50px;
                height: 50px;
            }

            .management-title h2 {
                font-size: 1.6rem;
            }

            .search-box-header input {
                width: 180px;
            }

            .add-event-btn {
                padding: 0.75rem 1.25rem;
                font-size: 0.9rem;
            }

            .event-title {
                font-size: 1.25rem;
            }

            .organizer-avatar {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .modal-content {
                padding: 1.5rem;
            }

            .form-input,
            .form-select,
            .form-textarea {
                padding: 0.875rem 1rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 360px) {
            .dashboard-container {
                padding: 0 0.75rem;
            }

            .stats-card {
                padding: 1.25rem;
            }

            .management-header {
                padding: 1.5rem 1rem;
            }

            .events-content {
                padding: 1.5rem 1rem;
            }

            .event-content {
                padding: 1.5rem;
            }

            .filter-section {
                padding: 1.5rem 1rem;
            }
        }

        /* ========== PRINT STYLES ========== */
        @media print {

            .custom-navbar,
            .management-actions,
            .filter-section,
            .card-actions,
            .modal {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .stats-card,
            .event-card,
            .management-section {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
                break-inside: avoid;
            }
        }

        /* ========== ACCESSIBILITY ========== */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* ========== FOCUS STATES ========== */
        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        .filter-btn:focus-visible {
            box-shadow: 0 0 0 3px rgba(92, 106, 208, 0.3);
        }

        .action-btn:focus-visible {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .swal2-popup {
            border-radius: 20px !important; /* kayak rounded-2xl */
        }
    </style>

    <div class="main-wrapper">
        <div class="py-8 px-4 sm:px-8 bg-gradient-to-br from-gray-50 to-blue-50/30 min-h-screen space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in">
                <!-- Total Event -->
                <div class="stats-card">
                    <div class="stats-card-content">
                        <div class="stats-icon events">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stats-info">
                            <h3>Total Event</h3>
                            <p class="stats-number" id="totalEvents">{{ $totalEvent }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Tiket Terjual -->
                <div class="stats-card">
                    <div class="stats-card-content">
                        <div class="stats-icon tickets">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="stats-info">
                            <h3>Total Tiket Terjual</h3>
                            <p class="stats-number" id="totalTicketsSold">{{ $totalTickets }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Pendapatan -->
                <div class="stats-card">
                    <div class="stats-card-content">
                        <div class="stats-icon revenue">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="stats-info">
                            <h3>Total Pendapatan</h3>
                            <p class="stats-number" id="totalRevenue">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-container">
                {{-- Management Header --}}
                <div class="management-section">
                    <div class="management-header">
                        <div class="management-header-content">
                            <!-- Title Section -->
                            <div class="management-title">
                                <div class="management-icon">
                                    <i class="fas fa-tags text-lg text-white"></i>
                                </div>
                                <div>
                                    <h2>Manajemen Event</h2>
                                    <p>Kelola Event Dengan Mudah</p>
                                </div>
                            </div>

                            <div class="management-actions">
                                <!-- Search Box -->
                                <div class="search-box-header">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" placeholder="Cari Event..." class="search-input" />
                                </div>

                                <!-- Add Event Button -->
                                <button onclick="openEventModal()" class="add-event-btn">
                                    <i class="fas fa-plus"></i>
                                    <span>Tambah Event</span>
                                </button>
                            </div>
                        </div>
                    </div>

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
                    <div class="events-content">
                        <div class="events-grid" id="eventGrid">
                            {{-- Event cards will be loaded by JS --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    <div id="fileInfo" style="display: none; color: #666; font-size: 0.8rem; margin-top: 4px;"></div>
                    <input type="hidden" name="existing_image" value="">
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeEventModal()">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @vite(['resources/js/organizer-dashboard.js']) {{-- file JS khusus organizer --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</x-app-layout>