<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900">
    <!-- Wrapper -->
    <div class="min-h-screen flex">
        <!-- Left: Content injected by Blade -->
        <div class="w-full flex justify-center items-center p-6">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </div>

        <!-- Right: Illustration -->
        <div class="hidden md:flex justify-center items-center">
                <img src="{{ asset('images/side-image-login.png') }}" alt="Login Illustration"
                    class="w-screen h-screen object-cover" />
            
        </div>
    </div>
</body>
</html>
