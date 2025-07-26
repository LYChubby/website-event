
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Organizer
        </h2>
    </x-slot>

    {{-- Custom Styles --}}
    <style>
        :root {
            --primary-color: #63A7F4;
            --primary-dark: #4A90E2;
            --secondary-color: #FF6B6B;
            --secondary-dark: #FF4757;
        }

        body {
            overflow-x: hidden; /* biar nggak scroll kanan */
        }

        .dashboard-container {
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            min-height: calc(100vh - 64px);
            border-radius: 0;
            padding: 0;
            margin: 0;
        }


        .main-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2rem;
            margin: -1.5rem -1.5rem 0 -1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 0.75rem;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .header-title {
            font-size: 2rem;
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 0;
        }

        .header-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-box {
            position: relative;
        }

        .search-input {
            padding: 0.75rem 1rem 0.75rem 3rem;
            border-radius: 25px;
            border: none;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            width: 300px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
        }

        .add-btn {
            background: linear-gradient(135deg, var(--secondary-color), var(--secondary-dark));
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .add-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .main-content {
            padding: 2rem 1.5rem;
        }

        .filter-section {
            margin-bottom: 2rem;
        }

        .filter-container {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            border: 2px solid #E5E7EB;
            background: white;
            color: #6B7280;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .filter-btn.active {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(99, 167, 244, 0.3);
        }

        .filter-btn:hover:not(.active) {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }

        .event-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            position: relative;
        }

        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .event-image {
            height: 200px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
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
            background: linear-gradient(45deg, rgba(99, 167, 244, 0.8), rgba(74, 144, 226, 0.8));
            opacity: 0;
            transition: all 0.3s ease;
        }

        .event-card:hover .event-image::before {
            opacity: 1;
        }

        .event-image-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            height: 100%;
        }

        .event-content {
            padding: 1.5rem;
        }

        .event-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .event-date {
            color: #6B7280;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #E5E7EB, transparent);
            margin: 1rem 0;
        }

        .organizer-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .organizer-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .organizer-name {
            font-weight: 600;
            color: #374151;
        }

        .card-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .edit-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
        }

        .edit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(99, 167, 244, 0.3);
        }

        .delete-btn {
            background: linear-gradient(135deg, var(--secondary-color), var(--secondary-dark));
            color: white;
        }

        .delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
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
            border-radius: 20px;
            padding: 2rem;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.9);
            transition: all 0.3s ease;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal.show .modal-content {
            transform: scale(1);
        }

        .modal-header {
            margin-bottom: 2rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1F2937;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #E5E7EB;
            border-radius: 12px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 167, 244, 0.1);
        }

        .form-row {
            display: flex;
            gap: 1rem;
        }

        .form-row .form-group {
            flex: 1;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-cancel {
            padding: 0.75rem 1.5rem;
            background: #F3F4F6;
            color: #6B7280;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #E5E7EB;
        }

        .btn-primary {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(99, 167, 244, 0.3);
        }

        /* Animations */
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

        .event-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .event-card:nth-child(1) { animation-delay: 0.1s; }
        .event-card:nth-child(2) { animation-delay: 0.2s; }
        .event-card:nth-child(3) { animation-delay: 0.3s; }
        .event-card:nth-child(4) { animation-delay: 0.4s; }
        .event-card:nth-child(5) { animation-delay: 0.5s; }
        .event-card:nth-child(6) { animation-delay: 0.6s; }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            .header-controls {
                width: 100%;
                justify-content: center;
            }

            .search-input {
                width: 250px;
            }

            .events-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                flex-direction: column;
            }

            .main-header {
                margin: -1rem -1rem 0 -1rem;
                padding: 1.5rem 1rem;
            }

            .main-content {
                padding: 1.5rem 1rem;
            }
        }
    </style>

    <div class="dashboard-container">
        {{-- Main Header --}}
        <div class="main-header">
            <div class="header-content">
                <div class="header-left">
                    <button class="back-btn" onclick="history.back()">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <h1 class="header-title">Kelola Event</h1>
                </div>
                <div class="header-controls">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" placeholder="Cari event..." />
                    </div>
                    <button class="add-btn" onclick="openEventModal()">
                        <i class="fas fa-plus"></i>
                        Tambah Event
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