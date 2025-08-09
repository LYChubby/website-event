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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

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

    <style>
        /* Header Styles Only */
        .gradient-header {
            background: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
            position: relative;
            overflow: hidden;
        }

        .gradient-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }

        .gradient-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        /* Subtle floating dots */
        .header-dots {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: float-gentle 4s ease-in-out infinite;
        }

        .header-dots:nth-child(1) {
            top: 20%;
            left: 15%;
            animation-delay: 0s;
        }

        .header-dots:nth-child(2) {
            top: 60%;
            right: 20%;
            animation-delay: -2s;
        }

        .header-dots:nth-child(3) {
            top: 40%;
            right: 40%;
            animation-delay: -1s;
        }

        @keyframes float-gentle {
            0%, 100% {
                transform: translateY(0px);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-8px);
                opacity: 0.6;
            }
        }

        /* Text enhancement */
        .header-text-shadow {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Subtle glow effect */
        .header-glow {
            box-shadow: 0 4px 20px rgba(104, 69, 151, 0.15);
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-[var(--color-bg-light)] dark:bg-[var(--color-bg-dark)]">

        @isset($header)
        <x-page-header class="gradient-header text-white header-glow">
            <!-- Subtle floating dots -->
            <div class="header-dots"></div>
            <div class="header-dots"></div>
            <div class="header-dots"></div>
            
            <!-- Header content with enhanced typography -->
            <div class="relative z-10 header-text-shadow">
                {{ $header }}
            </div>
        </x-page-header>
        @endisset

        <main class="w-full min-h-screen bg-white overflow-hidden">
            {{ $slot }}
        </main>
    </div>
</body>

</html>