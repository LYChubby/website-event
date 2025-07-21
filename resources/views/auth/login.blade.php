<x-login-layout>
    <div class="flex flex-col justify-center items-center">
        <!-- Placeholder Profile Image -->
        <div class="w-32 h-32 rounded-full bg-gray-300 mb-4"></div>
        <h1 class="text-center text-2xl font-bold mb-8">Judul</h1>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="w-full">
            @csrf

            <!-- Email -->
            <label class="block mb-1 font-semibold">Login</label>
            <input id="email" name="email" type="email" required
                   placeholder="example@gmail.com"
                   class="w-full border rounded px-4 py-2 mb-4" />

            <!-- Password -->
            <div class="relative mb-4">
                <input id="password" name="password" type="password" required
                       placeholder="password"
                       class="w-full border rounded px-4 py-2 pr-10" />
                <button type="button" onclick="togglePassword()"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
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
                Sign In
            </button>

            <!-- OR -->
            <div class="my-4 flex items-center justify-center text-gray-500">
                <hr class="w-1/4 border-gray-300" />
                <span class="mx-2 text-sm">or sign in with</span>
                <hr class="w-1/4 border-gray-300" />
            </div>

            <!-- Google Login -->
            <a href="/auth/google"
               class="flex items-center justify-center w-full border rounded py-2 hover:bg-gray-100">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-5 w-5 mr-2" alt="Google">
                <span>Continue With Google</span>
            </a>

            <!-- Register -->
            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-blue-500 hover:underline text-sm">Register Now</a>
            </div>
        </form>
    </div>
</x-login-layout>

<!-- Toggle Password Script -->
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
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