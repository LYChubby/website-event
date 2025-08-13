<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>NEO.Vibe</title>
    <link rel="icon" type="image/png" href="/images/logo.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Styles & Scripts -->
    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/js/organizer-dashboard-events.js',
    ])

    @if(request()->is('admin/*'))
    @vite(['resources/js/admin.js'])
    @elseif(request()->is('organizer/*'))
    @vite(['resources/js/organizer-dashboard.js'])
    @endif


<body class="font-sans antialiased">
    <div class="min-h-screen bg-[var(--color-bg-light)] dark:bg-[var(--color-bg-dark)]">

        @isset($header)
        <x-page-header class="gradient-header text-white">
            {{ $header }}
        </x-page-header>
        @endisset

        <main class="w-full min-h-screen bg-white overflow-hidden">
            {{ $slot }}
        </main>
    </div>
</body>

</html>