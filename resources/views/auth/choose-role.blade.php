<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Pilih Peran - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #7fc1fd 0%, #4d9ef8 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #1a202c;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1.5rem;
            padding: 2.5rem;
            width: 100%;
            max-width: 28rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
            animation: slideIn 0.5s ease-out;
        }

        .role-option {
            display: flex;
            align-items: center;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border-radius: 1rem;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .role-option:hover {
            border-color: #7fc1fd;
            transform: translateY(-2px);
        }

        .role-option.selected {
            border-color: #7fc1fd;
            background-color: rgba(59, 130, 246, 0.05);
        }

        .role-radio {
            appearance: none;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            margin-right: 1rem;
            transition: all 0.2s ease;
            position: relative;
            cursor: pointer;
        }

        .role-radio:checked {
            border-color: #7fc1fd;
            background-color: #7fc1fd;
        }

        .role-radio:checked::after {
            content: '';
            position: absolute;
            width: 0.5rem;
            height: 0.5rem;
            background: white;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .role-icon {
            width: 2.5rem;
            height: 2.5rem;
            margin-right: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #7fc1fd 0%, #4d9ef8 100%);
            color: white;
            border-radius: 0.75rem;
        }

        .btn-continue {
            background: linear-gradient(135deg, #7fc1fd 0%, #4d9ef8 100%);
            color: white;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-continue:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-avatar {
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1rem;
            display: block;
            border: 3px solid white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="glass-card">
        <!-- User Avatar -->
        @if(isset($googleUser['picture']))
        <img src="{{ $googleUser['picture'] }}" alt="User Avatar" class="user-avatar">
        @endif

        <h1 class="text-center text-2xl font-bold mb-2">Pilih Peran Anda</h1>
        <p class="text-center text-gray-600 mb-6">Halo <span class="font-semibold">{{ $googleUser['name'] }}</span>, silakan pilih peran Anda:</p>

        <form action="/choose-role" method="POST" class="mt-4">
            @csrf

            <!-- User Role Option -->
            <label class="role-option" onclick="selectRole(this)">
                <input type="radio" name="role" value="user" class="role-radio" required>
                <div class="role-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold">Pengguna</h3>
                    <p class="text-sm text-gray-500">Saya ingin mencari dan mengikuti acara</p>
                </div>
            </label>

            <!-- Organizer Role Option -->
            <label class="role-option" onclick="selectRole(this)">
                <input type="radio" name="role" value="organizer" class="role-radio">
                <div class="role-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold">Penyelenggara</h3>
                    <p class="text-sm text-gray-500">Saya ingin membuat dan mengelola acara</p>
                </div>
            </label>

            <button type="submit" class="btn-continue">Lanjutkan</button>
        </form>
    </div>

    <script>
        function selectRole(element) {
            // Remove selected class from all options
            document.querySelectorAll('.role-option').forEach(opt => {
                opt.classList.remove('selected');
            });

            // Add selected class to clicked option
            element.classList.add('selected');

            // Trigger click on the radio input
            const radio = element.querySelector('input[type="radio"]');
            radio.checked = true;
        }
    </script>
</body>

</html>