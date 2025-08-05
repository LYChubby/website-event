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

    <!-- Custom Style -->
    <style>
        body {
            @apply font-sans antialiased;
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

        .gradient-primary {
            background: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #684597 0%, #5C6AD0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
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
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center relative">
    <!-- Floating Orbs Background -->
    <div class="floating-orb orb-1"></div>
    <div class="floating-orb orb-2"></div>

    <main class="w-full max-w-2xl p-6 mx-auto z-10">
        <div class="glass-effect rounded-3xl p-1 shadow-2xl slide-fade-in">
            <!-- More transparent content area -->
            <div class="p-5 bg-white bg-opacity-70 rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </main>
</body>

</html>