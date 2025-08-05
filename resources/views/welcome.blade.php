<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Event - Modern Clean Design</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .hover-lift {
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            border-radius: 16px;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            outline: none;
            border: 1px solid rgba(238, 242, 255, 0.8);
            position: relative;
            overflow: hidden;
        }

        .hover-lift:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 16px 32px rgba(102, 126, 234, 0.2);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .hover-lift::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .hover-lift:hover::before {
            opacity: 1;
        }

        .stats-counter {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }

        /* Remove outline on focus (e.g. on click) */
        .hover-lift:focus,
        .hover-lift:focus-visible {
            outline: none;
            box-shadow: 0 0 0 3px rgba(100, 149, 237, 0.4);
            /* Optional: if you want to remove shadow on focus too */
        }


        .floating-animation {
            animation: floating 6s ease-in-out infinite;
        }

        .floating-animation:nth-child(2n) {
            animation-delay: -2s;
        }

        .floating-animation:nth-child(3n) {
            animation-delay: -4s;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .pulse-border {
            animation: pulse-border 3s infinite;
        }

        @keyframes pulse-border {

            0%,
            100% {
                border-color: rgba(102, 126, 234, 0.3);
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
            }

            50% {
                border-color: rgba(102, 126, 234, 0.6);
                box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
            }
        }

        .event-card {
            background: linear-gradient(145deg, #ffffff, #f8fafc);
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .event-card:hover {
            background: linear-gradient(145deg, #f8fafc, #ffffff);
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border-color: #667eea;
        }

        .team-card {
            background: linear-gradient(145deg, #ffffff, #f1f5f9);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
        }

        .team-card:hover {
            background: linear-gradient(145deg, #f1f5f9, #ffffff);
            transform: scale(1.05) translateY(-5px);
            border-color: #667eea;
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
        }

        .search-glow {
            transition: all 0.3s ease;
        }

        .search-glow:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            border-color: #667eea;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8, #6a4190);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #ffffff;
            border: 2px solid #667eea;
            color: #667eea;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .navbar-blur {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .sparkle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #667eea;
            border-radius: 50%;
            animation: sparkle 2s infinite;
        }

        @keyframes sparkle {

            0%,
            100% {
                opacity: 0;
                transform: scale(0);
            }

            50% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .feature-icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar-blur sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-3">
                        <img src="/images/logo.png" alt="Logo" class="h-10 w-auto transition-transform hover:scale-105" />
                        <span class="gradient-text font-bold text-2xl">NEO.Vibe</span>
                    </div>
                    <div class="hidden md:block">
                        <input type="text" placeholder="Cari event impian Anda..."
                            class="search-glow w-80 px-6 py-3 rounded-full border border-gray-200 focus:outline-none text-gray-700 placeholder-gray-400" />
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('register') }}"
                        class="btn-secondary px-6 py-2 rounded-full font-semibold">Daftar
                    </a>
                    <a href="{{ route('login') }}"
                        class="btn-primary text-white px-6 py-2 rounded-full font-semibold">Masuk
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section py-20 relative">
        <div class="sparkle" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
        <div class="sparkle" style="top: 60%; left: 80%; animation-delay: 1s;"></div>
        <div class="sparkle" style="top: 30%; left: 90%; animation-delay: 0.5s;"></div>
        <div class="sparkle" style="top: 80%; left: 20%; animation-delay: 1.5s;"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="glass-card rounded-3xl p-12 hover-lift floating-animation pulse-border">
                <div class="text-center max-w-4xl mx-auto">
                    <h1 class="font-bold text-5xl mb-6 text-gray-800 leading-tight">
                        Selamat Datang di <span class="gradient-text">NEO.Vibe</span>
                    </h1>
                    <p class="text-xl leading-relaxed text-gray-600 mb-8">
                        Platform terdepan untuk mengelola dan mengikuti berbagai acara spektakuler. Dari konser musik yang memukau,
                        seminar inspiratif, workshop kreatif, hingga festival budaya yang meriah.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <a href="{{ route('login') }}"
                            class="btn-primary text-white px-8 py-4 rounded-full font-semibold text-lg">
                            <i class="fas fa-rocket mr-2"></i>Jelajahi Event</a>
                        <a href="{{ route('login') }}"
                            class="btn-secondary px-8 py-4 rounded-full font-semibold text-lg">
                            <i class="fas fa-plus mr-2"></i>Buat Event</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Event Terselenggara -->
                <div class="hover-lift text-center">
                    <div class="stats-counter" data-target="10000" data-unit="number">0</div>
                    <p class="text-gray-700 font-medium text-lg">Event Terselenggara</p>
                </div>

                <!-- Peserta Aktif -->
                <div class="hover-lift text-center">
                    <div class="stats-counter" data-target="10000" data-unit="number">0</div>
                    <p class="text-gray-700 font-medium text-lg">Peserta Aktif</p>
                </div>

                <!-- Organizer Terpercaya -->
                <div class="hover-lift text-center">
                    <div class="stats-counter" data-target="10000" data-unit="number">0</div>
                    <p class="text-gray-700 font-medium text-lg">Organizer Terpercaya</p>
                </div>

                <!-- Kepuasan Pengguna -->
                <div class="hover-lift text-center">
                    <div class="stats-counter" data-target="99" data-unit="percent">0%</div>
                    <p class="text-gray-700 font-medium text-lg">Kepuasan Pengguna</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Event Showcase -->
    <section class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="font-bold text-4xl gradient-text mb-4">Event Populer</h2>
                <p class="text-xl text-gray-600">Temukan pengalaman tak terlupakan bersama kami</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="event-card rounded-2xl overflow-hidden hover-lift">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-pink-500 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                            <div class="text-center text-white">
                                <i class="fas fa-music text-4xl mb-3"></i>
                                <h3 class="text-xl font-bold">Lord of The Rings Concert</h3>
                                <p class="text-sm opacity-90">Epic Musical Journey</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500"><i class="fas fa-calendar mr-2"></i>15 Aug 2025</span>
                            <span class="text-purple-600 font-semibold">Rp 350.000</span>
                        </div>
                    </div>
                </div>

                <div class="event-card rounded-2xl overflow-hidden hover-lift">
                    <div class="h-48 bg-gradient-to-br from-green-500 to-teal-500 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                            <div class="text-center text-white">
                                <i class="fas fa-leaf text-4xl mb-3"></i>
                                <h3 class="text-xl font-bold">Ryokucha Festival</h3>
                                <p class="text-sm opacity-90">Traditional Tea Culture</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500"><i class="fas fa-calendar mr-2"></i>20 Aug 2025</span>
                            <span class="text-green-600 font-semibold">Rp 150.000</span>
                        </div>
                    </div>
                </div>

                <div class="event-card rounded-2xl overflow-hidden hover-lift">
                    <div class="h-48 bg-gradient-to-br from-orange-500 to-red-500 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                            <div class="text-center text-white">
                                <i class="fas fa-basketball-ball text-4xl mb-3"></i>
                                <h3 class="text-xl font-bold">FIBA Basketball</h3>
                                <p class="text-sm opacity-90">World Championship</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500"><i class="fas fa-calendar mr-2"></i>25 Aug 2025</span>
                            <span class="text-orange-600 font-semibold">Rp 250.000</span>
                        </div>
                    </div>
                </div>

                <div class="event-card rounded-2xl overflow-hidden hover-lift">
                    <div class="h-48 bg-gradient-to-br from-yellow-500 to-orange-500 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                            <div class="text-center text-white">
                                <i class="fas fa-motorcycle text-4xl mb-3"></i>
                                <h3 class="text-xl font-bold">MotoGP Racing</h3>
                                <p class="text-sm opacity-90">Speed & Adrenaline</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500"><i class="fas fa-calendar mr-2"></i>30 Aug 2025</span>
                            <span class="text-yellow-600 font-semibold">Rp 500.000</span>
                        </div>
                    </div>
                </div>

                <div class="event-card rounded-2xl overflow-hidden hover-lift">
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-indigo-500 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                            <div class="text-center text-white">
                                <i class="fas fa-guitar text-4xl mb-3"></i>
                                <h3 class="text-xl font-bold">Peterpan Reunion</h3>
                                <p class="text-sm opacity-90">Nostalgia Concert</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500"><i class="fas fa-calendar mr-2"></i>05 Sep 2025</span>
                            <span class="text-blue-600 font-semibold">Rp 400.000</span>
                        </div>
                    </div>
                </div>

                <div class="event-card rounded-2xl overflow-hidden hover-lift">
                    <div class="h-48 bg-gradient-to-br from-gray-600 to-gray-800 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                            <div class="text-center text-white">
                                <i class="fas fa-volume-up text-4xl mb-3"></i>
                                <h3 class="text-xl font-bold">Rock Festival</h3>
                                <p class="text-sm opacity-90">Heavy Metal Night</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500"><i class="fas fa-calendar mr-2"></i>10 Sep 2025</span>
                            <span class="text-gray-600 font-semibold">Rp 300.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="font-bold text-4xl gradient-text mb-4">Mengapa Memilih NEO.Vibe?</h2>
                <p class="text-xl text-gray-600">Fitur terdepan untuk pengalaman event yang sempurna</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center hover-lift">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Keamanan Terjamin</h3>
                    <p class="text-gray-600">Sistem pembayaran dan data yang aman dengan enkripsi tingkat tinggi</p>
                </div>

                <div class="text-center hover-lift">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Real-time Updates</h3>
                    <p class="text-gray-600">Dapatkan notifikasi instant untuk setiap update event favorit Anda</p>
                </div>

                <div class="text-center hover-lift">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Komunitas Aktif</h3>
                    <p class="text-gray-600">Bergabung dengan ribuan event enthusiast di seluruh Indonesia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="font-bold text-4xl gradient-text mb-4">Tim Kreatif Kami</h2>
                <p class="text-xl text-gray-600">Bertemu dengan para ahli di balik kesuksesan NEO.Vibe</p>
            </div>

            <div class="flex flex-wrap justify-center gap-6">
                <!-- Anang -->
                <div class="team-card rounded-2xl p-6 text-center w-40 flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-fuchsia-500 to-purple-600 mx-auto mb-4 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        A
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Anang</h4>
                    <p class="text-sm text-gray-600">Mentor</p>
                </div>

                <!-- Lintang -->
                <div class="team-card rounded-2xl p-6 text-center w-40 flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-sky-500 to-blue-600 mx-auto mb-4 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        L
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Lintang</h4>
                    <p class="text-sm text-gray-600">UI/UX Designer</p>
                </div>

                <!-- M Farras -->
                <div class="team-card rounded-2xl p-6 text-center w-40 flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-emerald-500 to-green-600 mx-auto mb-4 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        MF
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">M Farras</h4>
                    <p class="text-sm text-gray-600">Back End</p>
                </div>

                <!-- Ilzam -->
                <div class="team-card rounded-2xl p-6 text-center w-40 flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 mx-auto mb-4 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        I
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Ilzam</h4>
                    <p class="text-sm text-gray-600">Front End</p>
                </div>

                <!-- Fauzi -->
                <div class="team-card rounded-2xl p-6 text-center w-40 flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-violet-500 to-purple-700 mx-auto mb-4 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        F
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Fauzi</h4>
                    <p class="text-sm text-gray-600">Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-white">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="/images/logo.png" alt="Logo" class="h-14 w-auto" />
                        <span class="text-xl font-bold">NEO.Vibe</span>
                    </div>
                    <p class="text-white/80 text-sm leading-relaxed">
                        Platform terpercaya untuk menemukan dan menghadiri berbagai event menarik di Indonesia.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold mb-4">Link Cepat</h4>
                    <div class="space-y-2">
                        <a href="#" class="block text-white/80 hover:text-white transition-colors text-sm">
                            <i class="fas fa-info-circle mr-2"></i>Tentang Kami
                        </a>
                        <a href="#" class="block text-white/80 hover:text-white transition-colors text-sm">
                            <i class="fas fa-fire mr-2"></i>Event Populer
                        </a>
                        <a href="#" class="block text-white/80 hover:text-white transition-colors text-sm">
                            <i class="fas fa-envelope mr-2"></i>Kontak Kami
                        </a>
                        <a href="#" class="block text-white/80 hover:text-white transition-colors text-sm">
                            <i class="fas fa-question-circle mr-2"></i>FAQ
                        </a>
                    </div>
                </div>

                <!-- Social Media -->
                <div>
                    <h4 class="font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                    <div class="mt-4">
                        <p class="text-white/60 text-xs">
                            <i class="fas fa-shield-alt mr-2"></i>Keamanan dan privasi terjamin
                        </p>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-white/20 mt-8 pt-8 text-center">
                <p class="text-white text-sm">
                    © {{ date('Y') }} NEO.Vibe. Semua hak dilindungi undang-undang.
                </p>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.stats-counter');
            const speed = 200;

            const animateCounter = (counter) => {
                const target = +counter.getAttribute('data-target');
                const unit = counter.getAttribute('data-unit') || 'number';

                const updateCount = () => {
                    const currentText = counter.innerText.replace(/[^0-9]/g, '');
                    const count = +currentText;
                    const increment = Math.ceil(target / speed);

                    if (count < target) {
                        const newVal = count + increment;
                        counter.innerText = unit === 'percent' ?
                            `${Math.min(newVal, target)}%` :
                            new Intl.NumberFormat().format(newVal);
                        setTimeout(updateCount, 15);
                    } else {
                        counter.innerText = unit === 'percent' ?
                            `${target}%` :
                            new Intl.NumberFormat().format(target);
                    }
                };

                updateCount();
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.6
            });

            counters.forEach(counter => observer.observe(counter));
        });
    </script>

</body>

</html>