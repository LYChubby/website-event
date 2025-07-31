<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Event - Modern Design</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #63A7F4 0%, #4F96F3 25%, #3B85F2 50%, #2774F1 75%, #1363F0 100%);
            min-height: 100vh;
        }

        .glass-morphism {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .glass-morphism-dark {
            background: rgba(99, 167, 244, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .floating-animation {
            animation: floating 3s ease-in-out infinite;
        }

        .floating-animation:nth-child(2n) {
            animation-delay: -1s;
        }

        .floating-animation:nth-child(3n) {
            animation-delay: -2s;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-scale:hover {
            transform: scale(1.05) translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .gradient-text {
            background: linear-gradient(135deg, #1363F0, #63A7F4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .pulse-glow {
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(99, 167, 244, 0.4);
            }

            50% {
                box-shadow: 0 0 30px rgba(99, 167, 244, 0.8), 0 0 40px rgba(99, 167, 244, 0.6);
            }
        }

        .banner-overlay {
            background: linear-gradient(45deg, rgba(99, 167, 244, 0.8), rgba(19, 99, 240, 0.6));
            opacity: 0;
            transition: all 0.3s ease;
        }

        .banner-container:hover .banner-overlay {
            opacity: 1;
        }

        .crew-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .crew-card:hover {
            background: rgba(255, 255, 255, 1);
            transform: scale(1.1) translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .search-container {
            position: relative;
            overflow: hidden;
        }

        .search-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .search-container:focus-within::before {
            left: 100%;
        }

        .animated-bg {
            background: linear-gradient(-45deg, #63A7F4, #4F96F3, #3B85F2, #2774F1);
            background-size: 400% 400%;
            animation: gradient-shift 15s ease infinite;
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .nav-button {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .nav-button:hover {
            background: rgba(255, 255, 255, 0.9);
            color: #63A7F4;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="animated-bg">

    <!-- Navbar -->
    <nav class="glass-morphism shadow-xl sticky top-0 z-50">
        <div class="flex items-center justify-between px-6 py-4">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-1">
                    <img src="/images/logo.png" alt="Logo" class="h-20 w-20 transition-transform hover:scale-105" />
                    <span class="text-white font-bold text-xl hidden sm:block">NEO.Vibe</span>
                </div>
                <div class="search-container">
                    <input type="text" placeholder="Cari event impian Anda..."
                        class="glass-morphism rounded-full px-6 py-3 focus:outline-none w-80 text-white placeholder-blue-100 focus:ring-2 focus:ring-white transition-all duration-300" />
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('register') }}" 
                class="nav-button text-white px-6 py-3 rounded-full font-semibold">
                Daftar
                </a>
                <a href="{{ route('login') }}" 
                class="nav-button text-white px-6 py-3 rounded-full font-semibold">
                Masuk
                </a>
            </div>
        </div>
    </nav>

    <!-- Welcome Section -->
    <div class="container mx-auto px-6 py-8">
        <div class="glass-morphism rounded-3xl p-8 mb-8 hover-scale floating-animation">
            <h1 class="font-bold text-3xl mb-4 text-white">
                Selamat Datang di <span class="gradient-text bg-white bg-clip-text text-transparent">EventHub</span>
            </h1>
            <p class="text-lg leading-relaxed text-blue-50">
                Platform terdepan untuk mengelola dan mengikuti berbagai acara spektakuler. Dari konser musik yang memukau,
                seminar inspiratif, workshop kreatif, hingga festival budaya yang meriah. Dengan teknologi terdepan dan
                antarmuka yang elegan, kami menghadirkan pengalaman event yang tak terlupakan untuk setiap momen berharga Anda.
            </p>
            <div class="mt-6 flex space-x-4">
                <button class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-blue-50 transition-all duration-300 hover:scale-105">
                    Jelajahi Event
                </button>
                <button class="glass-morphism-dark text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-all duration-300">
                    Buat Event
                </button>
            </div>
        </div>

        <!-- Event Showcase -->
        <div class="mb-12">
            <h2 class="font-bold text-2xl mb-8 text-white text-center">Event Populer</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="banner-container relative rounded-2xl overflow-hidden shadow-2xl hover-scale group">
                    <div class="h-64 bg-gradient-to-br from-purple-500 to-pink-500"></div>
                    <div class="banner-overlay absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">Lord of The Rings Concert</h3>
                            <p class="text-sm opacity-90">Epic Musical Journey</p>
                        </div>
                    </div>
                </div>

                <div class="banner-container relative rounded-2xl overflow-hidden shadow-2xl hover-scale group">
                    <div class="h-64 bg-gradient-to-br from-green-500 to-teal-500"></div>
                    <div class="banner-overlay absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">Ryokucha Festival</h3>
                            <p class="text-sm opacity-90">Traditional Tea Culture</p>
                        </div>
                    </div>
                </div>

                <div class="banner-container relative rounded-2xl overflow-hidden shadow-2xl hover-scale group">
                    <div class="h-64 bg-gradient-to-br from-orange-500 to-red-500"></div>
                    <div class="banner-overlay absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">FIBA Basketball</h3>
                            <p class="text-sm opacity-90">World Championship</p>
                        </div>
                    </div>
                </div>

                <div class="banner-container relative rounded-2xl overflow-hidden shadow-2xl hover-scale group">
                    <div class="h-64 bg-gradient-to-br from-yellow-500 to-orange-500"></div>
                    <div class="banner-overlay absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">MotoGP Racing</h3>
                            <p class="text-sm opacity-90">Speed & Adrenaline</p>
                        </div>
                    </div>
                </div>

                <div class="banner-container relative rounded-2xl overflow-hidden shadow-2xl hover-scale group">
                    <div class="h-64 bg-gradient-to-br from-blue-500 to-indigo-500"></div>
                    <div class="banner-overlay absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">Peterpan Reunion</h3>
                            <p class="text-sm opacity-90">Nostalgia Concert</p>
                        </div>
                    </div>
                </div>

                <div class="banner-container relative rounded-2xl overflow-hidden shadow-2xl hover-scale group">
                    <div class="h-64 bg-gradient-to-br from-gray-600 to-gray-800"></div>
                    <div class="banner-overlay absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">Rock Festival</h3>
                            <p class="text-sm opacity-90">Heavy Metal Night</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="glass-morphism rounded-3xl p-8 mb-8">
            <h2 class="font-bold text-2xl mb-8 text-white text-center">Tim Kreatif Kami</h2>
            <div class="flex overflow-x-auto space-x-6 pb-4">
                <div class="crew-card rounded-2xl p-4 min-w-max flex flex-col items-center shadow-lg">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-pink-400 to-purple-500 mb-4 flex items-center justify-center text-white font-bold text-xl">
                        D
                    </div>
                    <span class="font-semibold text-gray-800">Davina</span>
                    <span class="text-sm text-gray-600">Creative Director</span>
                </div>

                <div class="crew-card rounded-2xl p-4 min-w-max flex flex-col items-center shadow-lg">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-cyan-500 mb-4 flex items-center justify-center text-white font-bold text-xl">
                        N
                    </div>
                    <span class="font-semibold text-gray-800">Nayla</span>
                    <span class="text-sm text-gray-600">Event Manager</span>
                </div>

                <div class="crew-card rounded-2xl p-4 min-w-max flex flex-col items-center shadow-lg">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-green-400 to-teal-500 mb-4 flex items-center justify-center text-white font-bold text-xl">
                        R
                    </div>
                    <span class="font-semibold text-gray-800">Risa</span>
                    <span class="text-sm text-gray-600">Marketing Lead</span>
                </div>

                <div class="crew-card rounded-2xl p-4 min-w-max flex flex-col items-center shadow-lg">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-orange-400 to-red-500 mb-4 flex items-center justify-center text-white font-bold text-xl">
                        A
                    </div>
                    <span class="font-semibold text-gray-800">Ariel T</span>
                    <span class="text-sm text-gray-600">Tech Lead</span>
                </div>

                <div class="crew-card rounded-2xl p-4 min-w-max flex flex-col items-center shadow-lg">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 mb-4 flex items-center justify-center text-white font-bold text-xl">
                        L
                    </div>
                    <span class="font-semibold text-gray-800">Lara</span>
                    <span class="text-sm text-gray-600">UI/UX Designer</span>
                </div>

                <div class="crew-card rounded-2xl p-4 min-w-max flex flex-col items-center shadow-lg">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-400 to-blue-500 mb-4 flex items-center justify-center text-white font-bold text-xl">
                        V
                    </div>
                    <span class="font-semibold text-gray-800">Vonzy</span>
                    <span class="text-sm text-gray-600">Content Creator</span>
                </div>

                <div class="crew-card rounded-2xl p-4 min-w-max flex flex-col items-center shadow-lg">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 mb-4 flex items-center justify-center text-white font-bold text-xl">
                        Z
                    </div>
                    <span class="font-semibold text-gray-800">Zee</span>
                    <span class="text-sm text-gray-600">Social Media</span>
                </div>

                <div class="crew-card rounded-2xl p-4 min-w-max flex flex-col items-center shadow-lg">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 mb-4 flex items-center justify-center text-white font-bold text-xl">
                        R
                    </div>
                    <span class="font-semibold text-gray-800">Remar</span>
                    <span class="text-sm text-gray-600">Operations</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="glass-morphism mt-16 py-8">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-center items-center space-x-8 text-white">
                <a href="#" class="hover:text-blue-200 transition-colors duration-300 font-medium">Tentang EventHub</a>
                <a href="#" class="hover:text-blue-200 transition-colors duration-300 font-medium">Kebijakan Privasi</a>
                <a href="#" class="hover:text-blue-200 transition-colors duration-300 font-medium">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-blue-200 transition-colors duration-300 font-medium">Hubungi Kami</a>
            </div>
            <div class="text-center mt-6 text-blue-100">
                <p>&copy; 2025 EventHub. Membuat setiap momen menjadi tak terlupakan.</p>
            </div>
        </div>
    </footer>

</body>

</html>