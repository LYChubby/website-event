<head>
    <title>
        Daftar
    </title>
</head>
<x-login-layout>

    <!-- Background with Gradient and Floating Orbs -->

    <main class="w-full max-w-2xl p-6 mx-auto">
        <div class="glass-effect rounded-3xl p-1 shadow-2xl slide-fade-in">
            <!-- Register Card Content -->
            <div class="p-5">
                <!-- Logo Section -->
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center shadow-md transform hover:scale-105 transition-all duration-300">
                        <img src="/images/logo.png" alt="Logo" class="h-8 w-8 filter brightness-0 invert" />
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-center text-3xl font-bold mb-1 gradient-text">NEO.Vibe</h1>
                <p class="text-center text-gray-500 text-xs mb-6">Create your account to get started</p>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-3">
                    @csrf

                    <!-- Row 1: Name & Email -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Name Input -->
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-gray-700">Full Name</label>
                            <div class="relative">
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    required
                                    placeholder="Your name"
                                    value="{{ old('name') }}"
                                    class="input-enhanced w-full rounded-xl px-3 py-2.5 text-sm text-gray-700 focus:outline-none pl-10 @error('name') border-red-300 @enderror" />
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 icon-bg rounded flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

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
                    </div>

                    <!-- Row 2: Role (Full Width) -->
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-gray-700">Role</label>
                        <div class="relative">
                            <select
                                id="role"
                                name="role"
                                required
                                class="input-enhanced w-full rounded-xl px-3 py-2.5 text-sm text-gray-700 focus:outline-none pl-10 pr-10 appearance-none @error('role') border-red-300 @enderror"
                                onfocus="toggleArrow(true)"
                                onblur="toggleArrow(false)">
                                <option value="">Select your role</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Organizer</option>
                            </select>
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 icon-bg rounded flex items-center justify-center">
                                <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                <svg id="arrow-icon" class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('role')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Row 3: Password & Confirm Password -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Password Input -->
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-gray-700">Password</label>
                            <div class="relative">
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    placeholder="Password"
                                    class="input-enhanced w-full rounded-xl px-3 py-2.5 text-sm text-gray-700 focus:outline-none pl-10 pr-10 @error('password') border-red-300 @enderror" />
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 icon-bg rounded flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-2 0h4m-2 0v-6m2 0V9a4 4 0 00-8 0v2" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 13h12a1 1 0 011 1v6a1 1 0 01-1 1H6a1 1 0 01-1-1v-6a1 1 0 011-1z" />
                                    </svg>
                                </div>
                                <button
                                    type="button"
                                    onclick="togglePassword('password', 'eye-icon1')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 w-6 h-6 rounded hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-all duration-200">
                                    <svg id="eye-icon1" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.442-4.263m3.123-2.21A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.263M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-gray-700">Confirm Password</label>
                            <div class="relative">
                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    required
                                    placeholder="Confirm"
                                    class="input-enhanced w-full rounded-xl px-3 py-2.5 text-sm text-gray-700 focus:outline-none pl-10 pr-10" />
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 icon-bg rounded flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <button
                                    type="button"
                                    onclick="togglePassword('password_confirmation', 'eye-icon2')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 w-6 h-6 rounded hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-all duration-200">
                                    <svg id="eye-icon2" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.442-4.263m3.123-2.21A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.263M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="btn-gradient w-full text-white font-semibold py-2.5 rounded-xl shadow-md text-sm">
                        <span class="flex items-center justify-center space-x-2">
                            <span>Create Account</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>

                    <!-- Login Link -->
                    <div class="mt-4 text-center">
                        <p class="text-gray-600 text-xs">
                            Already have an account?
                            <a href="{{ route('login') }}" class="gradient-text font-semibold hover:underline transition-all duration-300 ml-1">
                                Login Now
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </main>
    </body>

    <!-- Toggle Arrow Script -->
    <script>
        function toggleArrow(open) {
            const arrow = document.getElementById('arrow-icon');
            arrow.style.transform = open ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    </script>

    <!-- Toggle Password Script -->
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            } else {
                input.type = "password";
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.442-4.263m3.123-2.21A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.263M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                `;
            }
        }
    </script>
</x-login-layout>