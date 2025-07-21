<x-login-layout>
    <div class="flex flex-col justify-center items-center">
        <!-- Profile Image Placeholder -->
        <div class="w-32 h-32 rounded-full bg-gray-300 mb-4"></div>
        <h1 class="text-center text-2xl font-bold mb-8">Judul</h1>

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}" class="w-full">
            @csrf

            <!-- Name -->
            <input id="name" name="name" type="text" required placeholder="Name"
                value="{{ old('name') }}"
                class="w-full border rounded px-4 py-2 mb-4" />

            <!-- Email -->
            <input id="email" name="email" type="email" required placeholder="Email"
                value="{{ old('email') }}"
                class="w-full border rounded px-4 py-2 mb-4" />

            <!-- Role -->
            <div class="relative mb-4">
            <select id="role" name="role" required
                class="w-full border rounded px-4 py-2 pr-10 appearance-none bg-white"
                onfocus="toggleArrow(true)" onblur="toggleArrow(false)">
                <option value="">Role</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Organizer</option>
            </select>

            <!-- Custom Arrow Icon -->
            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-600">
                <svg id="arrow-icon" xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 transition-transform duration-200 transform"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>

            <!-- Password -->
            <div class="relative mb-4">
                <input id="password" name="password" type="password" required placeholder="Password"
                    class="w-full border rounded px-4 py-2 pr-10" />
                <button type="button" onclick="togglePassword('password', 'eye-icon1')"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <svg id="eye-icon1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19
                            c-4.477 0-8.268-2.943-9.542-7
                            a9.956 9.956 0 012.442-4.263m3.123-2.21
                            A9.953 9.953 0 0112 5
                            c4.477 0 8.268 2.943 9.542 7
                            a9.965 9.965 0 01-4.293 5.263M15 12
                            a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3l18 18" />
                    </svg>
                </button>
            </div>

            <!-- Confirm Password -->
            <div class="relative mb-6">
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    placeholder="Confirm Password"
                    class="w-full border rounded px-4 py-2 pr-10" />
                <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon2')"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <svg id="eye-icon2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19
                            c-4.477 0-8.268-2.943-9.542-7
                            a9.956 9.956 0 012.442-4.263m3.123-2.21
                            A9.953 9.953 0 0112 5
                            c4.477 0 8.268 2.943 9.542 7
                            a9.965 9.965 0 01-4.293 5.263M15 12
                            a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3l18 18" />
                    </svg>
                </button>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded">
                Sign Up
            </button>

            <!-- Login Link -->
            <div class="mt-2 text-left pl-2">
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline text-sm">Login Now</a>
            </div>
        </form>
    </div>
</x-login-layout>

<!--  Script toggle panah -->
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
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5
                c4.477 0 8.268 2.943 9.542 7
                -1.274 4.057-5.065 7-9.542 7
                -4.477 0-8.268-2.943-9.542-7z" />`;
        } else {
            input.type = "password";
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19
                c-4.477 0-8.268-2.943-9.542-7
                a9.956 9.956 0 012.442-4.263m3.123-2.21
                A9.953 9.953 0 0112 5
                c4.477 0 8.268 2.943 9.542 7
                a9.965 9.965 0 01-4.293 5.263M15 12
                a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3l18 18" />`;
        }
    }
</script>
