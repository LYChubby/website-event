<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#5C6AD0',
                            600: '#4F46E5',
                            700: '#684597'
                        }
                    },
                    animation: {
                        'float': 'float 20s ease-in-out infinite',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'shimmer': 'shimmer 2s linear infinite'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'rotate(0deg) scale(1)'
                            },
                            '50%': {
                                transform: 'rotate(180deg) scale(1.1)'
                            }
                        },
                        slideUp: {
                            'from': {
                                opacity: '0',
                                transform: 'translateY(30px)'
                            },
                            'to': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        shimmer: {
                            '0%': {
                                transform: 'translateX(-100%)'
                            },
                            '100%': {
                                transform: 'translateX(100%)'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .bg-gradient-custom {
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

        .text-gradient {
            background: linear-gradient(135deg, #5C6AD0, #684597);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #5C6AD0, #684597);
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #4F46E5, #5B21B6);
        }

        .glass-morphism {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .floating-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            z-index: 1;
        }

        .shimmer-effect::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 2s linear infinite;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-custom flex items-center justify-center p-5 relative overflow-hidden floating-bg">

    <!-- Main Container -->
    <div class="glass-morphism rounded-3xl shadow-2xl p-12 w-full max-w-md relative z-10 animate-slide-up">

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gradient mb-3">Reset Password</h1>
            <p class="text-gray-600 text-sm leading-relaxed mb-6">
                Lupa password? Tidak masalah. Berikan alamat email Anda dan kami akan mengirimkan link reset password yang memungkinkan Anda untuk memilih password baru.
            </p>
        </div>

        <!-- Success Status Message -->
        <div id="statusMessage" class="hidden bg-gradient-to-r from-green-500 to-green-600 text-white p-3 rounded-xl mb-6 text-sm text-center shadow-lg">
            Link reset password telah dikirim ke email Anda!
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}" id="resetForm" class="space-y-6">
            @csrf

            <!-- Email Input -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-semibold text-gray-700">
                    Email
                </label>
                <div class="relative">
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="Masukkan alamat email Anda"
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-2xl text-base bg-gray-50 
                               focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-4 
                               focus:ring-primary-500/10 hover:border-gray-300 transition-all duration-300
                               focus:-translate-y-0.5" />
                </div>
                <!-- Error Messages -->
                <span id="emailError" class="hidden text-red-500 text-xs">
                    @error('email')
                    {{ $message }}
                    @enderror
                </span>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                id="submitBtn"
                class="w-full btn-gradient text-white font-semibold py-4 px-6 rounded-2xl 
                       hover:-translate-y-0.5 hover:shadow-xl hover:shadow-primary-500/25 
                       active:translate-y-0 transition-all duration-300 relative overflow-hidden
                       disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none">
                <span class="relative z-10" id="buttonText">Kirim Link Reset Password</span>
                <div class="absolute inset-0 shimmer-effect opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-8 pt-6 border-t border-gray-200 text-center">
            <a href="/login" class="text-primary-500 hover:text-primary-700 font-medium transition-colors duration-300">
                Kembali ke Login
            </a>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="hidden fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-6 shadow-2xl flex items-center space-x-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary-500"></div>
            <span class="text-gray-700 font-medium">Mengirim email...</span>
        </div>
    </div>

    <script>
        // Form submission handling
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const buttonText = document.getElementById('buttonText');
            const loadingOverlay = document.getElementById('loadingOverlay');

            // Show loading state
            submitBtn.disabled = true;
            buttonText.textContent = 'Mengirim...';
            loadingOverlay.classList.remove('hidden');

            // Reset after timeout (fallback)
            setTimeout(() => {
                submitBtn.disabled = false;
                buttonText.textContent = 'Kirim Link Reset Password';
                loadingOverlay.classList.add('hidden');
            }, 5000);
        });

        // Show status message based on URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status') === 'sent' || urlParams.get('success')) {
            document.getElementById('statusMessage').classList.remove('hidden');
        }

        // Enhanced form interactions
        document.querySelectorAll('input[type="email"]').forEach(input => {
            input.addEventListener('invalid', function(e) {
                e.preventDefault();
                this.classList.add('border-red-500', 'focus:border-red-500');
                this.classList.remove('border-gray-200', 'focus:border-primary-500');

                const errorElement = document.getElementById('emailError');
                errorElement.classList.remove('hidden');
                errorElement.textContent = this.validationMessage;
            });

            input.addEventListener('input', function() {
                if (this.validity.valid) {
                    this.classList.remove('border-red-500', 'focus:border-red-500');
                    this.classList.add('border-gray-200', 'focus:border-primary-500');
                    document.getElementById('emailError').classList.add('hidden');
                }
            });
        });

        // Add floating particles effect
        function createFloatingParticle() {
            const particle = document.createElement('div');
            particle.className = 'absolute w-1 h-1 bg-white/20 rounded-full pointer-events-none';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animation = `float ${15 + Math.random() * 10}s linear infinite`;

            document.body.appendChild(particle);

            setTimeout(() => {
                particle.remove();
            }, 25000);
        }

        // Create particles periodically
        setInterval(createFloatingParticle, 3000);
    </script>
</body>

</html>