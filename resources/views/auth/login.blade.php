<x-login-layout>
    <style>
        .gradient-primary {
            background: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-bg {
            background-image:
                url('/images/event.svg'),
                linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
            background-repeat: no-repeat;
            background-position: center center;
            background-size: contain;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }


        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(30px);
            opacity: 0.2;
            animation: float 10s ease-in-out infinite;
        }

        .orb-1 {
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, #684597, #5C6AD0);
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 150px;
            height: 150px;
            background: linear-gradient(45deg, #5C6AD0, #684597);
            bottom: -75px;
            left: -75px;
            animation-delay: 5s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) scale(1);
            }

            50% {
                transform: translateY(-20px) scale(1.05);
            }
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
        }

        .input-enhanced {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(104, 69, 151, 0.1);
            transition: all 0.3s ease;
        }

        .input-enhanced:focus {
            background: rgba(255, 255, 255, 1);
            border-color: rgba(104, 69, 151, 0.3);
            box-shadow: 0 5px 15px rgba(104, 69, 151, 0.1);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #5a3a7d 0%, #4d5bb6 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(104, 69, 151, 0.3);
        }

        .icon-bg {
            background: linear-gradient(135deg, #684597 20%, #5C6AD0 80%);
        }

        body {
            margin: 0;
            padding: 0;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
        }

        .slide-fade-in {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- Background with Gradient and Floating Orbs -->

    <body class="gradient-bg min-h-screen flex items-center justify-center">
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>

        <main class="w-full max-w-sm p-6 mx-auto px-4">
            <div class="glass-effect rounded-3xl p-1 shadow-2xl slide-fade-in">
                <!-- Login Card Content -->
                <div class="p-5">
                    <!-- Logo Section -->
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center shadow-md transform hover:scale-105 transition-all duration-300">
                            <img src="/images/logo.png" alt="Logo" class="h-8 w-8 filter brightness-0 invert" />
                        </div>
                    </div>

                    <!-- Title -->
                    <h1 class="text-center text-3xl font-bold mb-1 gradient-text">NEO.Vibe</h1>
                    <p class="text-center text-gray-500 text-xs mb-6">Welcome back! Please sign in</p>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- Email Input -->
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-gray-700">Email Address</label>
                            <div class="relative">
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    required
                                    placeholder="example@gmail.com"
                                    value="{{ old('email') }}"
                                    class="input-enhanced w-full rounded-xl px-3 py-2.5 text-sm text-gray-700 focus:outline-none pl-10 @error('email') border-red-300 @enderror" />
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 icon-bg rounded flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                            </div>
                            @error('email')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-gray-700">Password</label>
                            <div class="relative">
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    placeholder="Enter your password"
                                    class="input-enhanced w-full rounded-xl px-3 py-2.5 text-sm text-gray-700 focus:outline-none pl-10 pr-10 @error('password') border-red-300 @enderror" />
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 icon-bg rounded flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-2 0h4m-2 0v-6m2 0V9a4 4 0 00-8 0v2" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 13h12a1 1 0 011 1v6a1 1 0 01-1 1H6a1 1 0 01-1-1v-6a1 1 0 011-1z" />
                                    </svg>
                                </div>
                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 w-6 h-6 rounded hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-all duration-200">
                                    <svg id="eye-icon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.442-4.263m3.123-2.21A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.263M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between text-xs">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 w-3 h-3">
                                <span class="ml-1.5 text-gray-600">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="gradient-text font-medium hover:underline transition-all duration-300">
                                Forgot Password?
                            </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="btn-gradient w-full text-white font-semibold py-2.5 rounded-xl shadow-md text-sm">
                            <span class="flex items-center justify-center space-x-2">
                                <span>Sign In</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                        </button>

                        <!-- Divider -->
                        <div class="my-4 text-center">
                            <span class="text-xs font-medium text-gray-400">or continue with</span>
                        </div>

                        <!-- Google Login -->
                        <a href="/auth/google" class="flex items-center justify-center w-full bg-white border-2 border-gray-200 rounded-xl py-2.5 hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 group shadow-sm">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-4 w-4 mr-2" alt="Google">
                            <span class="font-medium text-gray-700 group-hover:text-gray-900 text-sm">Continue with Google</span>
                        </a>

                        <!-- Register Link -->
                        <div class="mt-4 text-center">
                            <p class="text-gray-600 text-xs">
                                Don't have an account?
                                <a href="{{ route('register') }}" class="gradient-text font-semibold hover:underline transition-all duration-300 ml-1">
                                    Register Now
                                </a>
                            </p>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-gray-400 text-xs">
                                By signing in, you agree to our
                                <a href="#" class="text-gray-500 hover:text-gray-700 underline">Terms</a> and
                                <a href="#" class="text-gray-500 hover:text-gray-700 underline">Privacy Policy</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>

    <!-- Toggle Password Script -->
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');

            if (input.type === "password") {
                input.type = "text";
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            } else {
                input.type = "password";
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.442-4.263m3.123-2.21A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.263M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                `;
            }
        }
    </script>
</x-login-layout>