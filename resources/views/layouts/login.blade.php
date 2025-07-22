<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #7fc1fd 0%, #4d9ef8 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-input {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }

        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #7fc1fd 0%, #4d9ef8 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .profile-image {
            background: linear-gradient(135deg, #7fc1fd 0%, #4d9ef8 100%);
            animation: float 3s ease-in-out infinite;
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

        .slide-fade-in {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .carousel-overlay {
            background: linear-gradient(45deg, rgba(127, 193, 253, 0.8), rgba(77, 158, 248, 0.8));
        }
    </style>
</head>

<body class="font-sans antialiased gradient-bg">
    <!-- Main Container -->
    <div class="min-h-screen flex">
        <!-- Left: Login Form -->
        <div class="w-full md:w-1/2 flex justify-center items-center p-6 relative">
            <!-- Animated background elements -->
            <!-- <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-32 h-32 bg-white/5 rounded-full animate-bounce"></div> -->

            <div class="w-full max-w-md glass-effect rounded-3xl p-8 shadow-2xl slide-fade-in">
                {{ $slot }}
            </div>
        </div>

        <!-- Right: Carousel -->
        <div class="hidden md:flex w-1/2 relative overflow-hidden">
            <div x-data="{
                currentIndex: 0,
                images: [
                    '{{ asset('images/side-image-login.png') }}',
                    '{{ asset('images/slide2.jpg') }}',
                    '{{ asset('images/side-image-login.png') }}'
                ],
                titles: [
                    'Welcome to Our Platform',
                    'Innovation Meets Technology',
                    'Your Journey Starts Here'
                ],
                descriptions: [
                    'Experience the future of digital solutions with our cutting-edge platform.',
                    'Discover powerful tools designed to transform your workflow and boost productivity.',
                    'Join thousands of satisfied users who trust our platform for their success.'
                ],
                next() {
                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                },
                prev() {
                    this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                },
                goTo(index) {
                    this.currentIndex = index;
                },
                init() {
                    setInterval(() => {
                        this.next();
                    }, 5000);
                }
            }" class="w-full h-full relative">

                <!-- Slides -->
                <div class="flex w-full h-screen transition-transform duration-500 ease-in-out"
                    :style="`transform: translateX(-${currentIndex * 100}%)`">
                    <template x-for="(image, index) in images" :key="index">
                        <div class="w-full h-full flex-shrink-0 relative">
                            <img :src="image" alt="Slide" class="w-full h-full object-cover" />
                            <!-- Overlay with gradient -->
                            <div class="absolute inset-0 carousel-overlay"></div>
                            <!-- Content overlay -->
                            <div class="absolute inset-0 flex flex-col justify-center items-center text-white p-12">
                                <h2 class="text-4xl font-bold mb-4 text-center" x-text="titles[index]"></h2>
                                <p class="text-xl text-center leading-relaxed max-w-md opacity-90" x-text="descriptions[index]"></p>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Navigation Buttons -->
                <button @click="prev()"
                    class="absolute left-6 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-sm text-white p-3 rounded-full opacity-0 hover:opacity-100 hover:bg-white/30 transition-all duration-300 group">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="next()"
                    class="absolute right-6 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-sm text-white p-3 rounded-full opacity-0 hover:opacity-100 hover:bg-white/30 transition-all duration-300 group">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Indicators -->
                <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
                    <template x-for="(image, index) in images" :key="index">
                        <button @click="goTo(index)"
                            class="w-3 h-3 rounded-full transition-all duration-300 hover:scale-125"
                            :class="{
                                'bg-white shadow-lg': currentIndex === index, 
                                'bg-white/50 hover:bg-white/70': currentIndex !== index
                            }">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</body>

</html>