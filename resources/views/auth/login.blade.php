<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ShopHinoba-an</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Outfit', sans-serif; background-color: #FAFAFA; color: #1A1A1A; }
        .display-font { font-family: 'Playfair Display', serif; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes floatBubble {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50%       { transform: translateY(-20px) rotate(5deg); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(255,107,53,0.4); }
            50%       { box-shadow: 0 0 0 12px rgba(255,107,53,0); }
        }

        .animate-fade-in { animation: fadeInUp 0.6s ease-out both; }
        .animate-fade-in-delay { animation: fadeInUp 0.6s ease-out 0.15s both; }
        .animate-fade-in-delay2 { animation: fadeInUp 0.6s ease-out 0.3s both; }

        .bubble { position: absolute; border-radius: 50%; animation: floatBubble ease-in-out infinite; }

        .input-field {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border: 1.5px solid #E5E5E5;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Outfit', sans-serif;
            background: #FAFAFA;
            color: #1A1A1A;
            transition: all 0.25s ease;
            outline: none;
        }
        .input-field:focus {
            background: white;
            border-color: #FF6B35;
            box-shadow: 0 0 0 4px rgba(255,107,53,0.1);
        }
        .input-field::placeholder { color: #AAAAAA; }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #FF6B35, #e85a22);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            animation: pulse-glow 2.5s infinite;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(255,107,53,0.45);
        }
        .btn-login:active { transform: translateY(0); }

        .left-panel {
            background: linear-gradient(145deg, #FF6B35 0%, #e85a22 40%, #c9461a 100%);
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .card-shadow {
            box-shadow: 0 24px 60px rgba(0,0,0,0.10), 0 4px 16px rgba(0,0,0,0.06);
        }

        .divider-line {
            height: 1px;
            background: linear-gradient(to right, transparent, #E5E5E5, transparent);
        }

        .checkbox-custom {
            width: 18px; height: 18px;
            accent-color: #FF6B35;
            cursor: pointer;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">

    <!-- Top Header -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-50 shadow-sm">
        <a href="{{ route('welcome') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md">
                <i class="fas fa-store text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900">Hinoban-on Works</h1>
                <p class="text-xs text-gray-500">Support Hinoban-on</p>
            </div>
        </a>
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-500">Don't have an account?</span>
            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-orange-600 border border-orange-300 rounded-lg hover:bg-orange-50 transition">
                <i class="fas fa-user-plus mr-1"></i> Register
            </a>
        </div>
    </header>

    <!-- Main -->
    <main class="flex-1 pt-16 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-4xl card-shadow rounded-2xl overflow-hidden flex min-h-[560px] animate-fade-in bg-white">

            <!-- Left Decorative Panel -->
            <div class="left-panel hidden md:flex md:w-5/12 flex-col justify-between p-10 text-white relative">

                <!-- Floating bubbles -->
                <div class="bubble w-32 h-32 bg-white/10 top-[-20px] right-[-20px]" style="animation-duration:6s;"></div>
                <div class="bubble w-20 h-20 bg-white/10 bottom-20 left-[-10px]" style="animation-duration:8s; animation-delay:1s;"></div>
                <div class="bubble w-12 h-12 bg-white/15 top-1/2 right-8" style="animation-duration:5s; animation-delay:2s;"></div>

                <!-- Top logo badge -->
                <div>
                    <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mb-6 border border-white/30">
                        <i class="fas fa-store text-white text-2xl"></i>
                    </div>
                    <h2 class="display-font text-3xl font-bold leading-tight mb-3">Welcome Back!</h2>
                    <p class="text-white/85 text-sm leading-relaxed">Log in to explore unique handcrafted treasures from local Hinoban-on artisans.</p>
                </div>

                <!-- Feature pills -->
                <div class="space-y-3">
                    <div class="flex items-center gap-3 bg-white/15 backdrop-blur px-4 py-3 rounded-xl border border-white/20">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-hand-holding-heart text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Support Local Artisans</p>
                            <p class="text-xs text-white/70">Every purchase makes a difference</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/15 backdrop-blur px-4 py-3 rounded-xl border border-white/20">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-medal text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">100% Handmade Quality</p>
                            <p class="text-xs text-white/70">Carefully crafted with love</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/15 backdrop-blur px-4 py-3 rounded-xl border border-white/20">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shipping-fast text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Fast Nationwide Shipping</p>
                            <p class="text-xs text-white/70">Across the Philippines & beyond</p>
                        </div>
                    </div>
                </div>

                <!-- Bottom tag -->
                <div class="flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-white/70 text-xs"></i>
                    <span class="text-xs text-white/70">Municipality of Hinobaan, Negros Occidental</span>
                </div>
            </div>

            <!-- Right Form Panel -->
            <div class="flex-1 flex flex-col justify-center px-8 md:px-12 py-10">

                <!-- Header -->
                <div class="mb-8 animate-fade-in-delay">
                    <div class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 px-3 py-1.5 rounded-full text-xs font-semibold mb-4 border border-orange-100">
                        <i class="fas fa-lock text-xs"></i> Secure Login
                    </div>
                    <h2 class="display-font text-3xl font-bold text-gray-900 mb-1">Sign in to your account</h2>
                    <p class="text-sm text-gray-500">Enter your credentials to continue shopping</p>
                </div>

                <!-- Session Status -->
                @if(session('status'))
                <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('status') }}</span>
                </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="animate-fade-in-delay2">
                    @csrf

                    <!-- Email -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="you@example.com"
                                class="input-field {{ $errors->get('email') ? 'border-red-400 bg-red-50' : '' }}"
                            >
                        </div>
                        @foreach($errors->get('email') as $message)
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                        @endforeach
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="input-field {{ $errors->get('password') ? 'border-red-400 bg-red-50' : '' }}"
                            >
                            <button type="button" onclick="togglePassword()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-eye text-sm" id="eye-icon"></i>
                            </button>
                        </div>
                        @foreach($errors->get('password') as $message)
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                        @endforeach
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="flex items-center gap-2 cursor-pointer select-none">
                            <input id="remember_me" type="checkbox" name="remember" class="checkbox-custom rounded">
                            <span class="text-sm text-gray-600">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-semibold text-orange-500 hover:text-orange-700 transition">
                            Forgot password?
                        </a>
                        @endif
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt mr-2"></i> Log In
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-6 flex items-center gap-4">
                    <div class="divider-line flex-1"></div>
                    <span class="text-xs text-gray-400 font-medium">OR</span>
                    <div class="divider-line flex-1"></div>
                </div>

                <!-- Register CTA -->
                <p class="text-center text-sm text-gray-500">
                    New to ShopHinoba-an?
                    <a href="{{ route('register') }}" class="font-bold text-orange-500 hover:text-orange-700 transition ml-1">
                        Create an account <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </p>

                <!-- Back to home -->
                <div class="mt-6 text-center">
                    <a href="{{ route('welcome') }}" class="inline-flex items-center gap-2 text-xs text-gray-400 hover:text-orange-500 transition">
                        <i class="fas fa-arrow-left text-xs"></i> Back to ShopHinoba-an
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer note -->
    <footer class="pb-6 text-center">
        <p class="text-xs text-gray-400">&copy; {{ date('Y') }} Hinoban-on Works. All rights reserved.</p>
    </footer>

    <script>
        function togglePassword() {
            const pw = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (pw.type === 'password') {
                pw.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                pw.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>