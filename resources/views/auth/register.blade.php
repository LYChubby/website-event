<x-login-layout>
    <!-- Profile Image with Animation -->
    <div class="flex justify-center mb-6">
        <div class="w-24 h-24 profile-image rounded-full flex items-center justify-center shadow-lg">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
    </div>

    <!-- Title -->
    <h1 class="text-center text-3xl font-bold mb-8 text-gray-800">Create Your Account</h1>

    <!-- Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name Input -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">Full Name</label>
            <div class="relative">
                <input
                    id="name"
                    name="name"
                    type="text"
                    required
                    placeholder="Your full name"
                    value="{{ old('name') }}"
                    class="form-input w-full rounded-xl px-4 py-3 text-gray-700 focus:outline-none pl-12" />
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
        </div>

        <!-- Email Input -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">Email Address</label>
            <div class="relative">
                <input
                    id="email"
                    name="email"
                    type="email"
                    required
                    placeholder="example@gmail.com"
                    value="{{ old('email') }}"
                    class="form-input w-full rounded-xl px-4 py-3 text-gray-700 focus:outline-none pl-12" />
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                </svg>
            </div>
        </div>

        <!-- Role Select -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">Role</label>
            <div class="relative">
                <select
                    id="role"
                    name="role"
                    required
                    class="form-input w-full rounded-xl px-4 py-3 text-gray-700 focus:outline-none pl-12 pr-12 appearance-none"
                    onfocus="toggleArrow(true)"
                    onblur="toggleArrow(false)">
                    <option value="">Select your role</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Organizer</option>
                </select>
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                    <svg id="arrow-icon" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Password Input -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">Password</label>
            <div class="relative">
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    placeholder="Create your password"
                    class="form-input w-full rounded-xl px-4 py-3 text-gray-700 focus:outline-none pl-12 pr-12" />
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m4-6V9a4 4 0 00-8 0v2m12 0H4a1 1 0 00-1 1v8a1 1 0 001 1h16a1 1 0 001-1v-8a1 1 0 00-1-1z" />
                </svg>
                <button
                    type="button"
                    onclick="togglePassword('password', 'eye-icon1')"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg id="eye-icon1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Confirm Password Input -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">Confirm Password</label>
            <div class="relative">
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    placeholder="Confirm your password"
                    class="form-input w-full rounded-xl px-4 py-3 text-gray-700 focus:outline-none pl-12 pr-12" />
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <button
                    type="button"
                    onclick="togglePassword('password_confirmation', 'eye-icon2')"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg id="eye-icon2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="btn-primary w-full text-white font-semibold py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
            Create Account
        </button>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline transition-colors">
                    Login Now
                </a>
            </p>
        </div>
    </form>
</x-login-layout>

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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.442-4.263m3.123-2.21A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.263M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
            `;
        } else {
            input.type = "password";
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }
</script>