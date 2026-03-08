<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ShopHub</title>
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
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .animate-fade-in  { animation: fadeInUp 0.6s ease-out both; }
        .animate-fade-in-delay  { animation: fadeInUp 0.6s ease-out 0.15s both; }
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
        .input-field.error { border-color: #EF4444; background: #FEF2F2; }

        .select-field {
            width: 100%;
            padding: 12px 44px 12px 44px;
            border: 1.5px solid #E5E5E5;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Outfit', sans-serif;
            background: #FAFAFA;
            color: #1A1A1A;
            transition: all 0.25s ease;
            outline: none;
            appearance: none;
            cursor: pointer;
        }
        .select-field:focus {
            background: white;
            border-color: #FF6B35;
            box-shadow: 0 0 0 4px rgba(255,107,53,0.1);
        }

        .btn-register {
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
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(255,107,53,0.45);
        }
        .btn-register:active { transform: translateY(0); }

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

        /* Role card selector */
        .role-card {
            flex: 1;
            border: 2px solid #E5E5E5;
            border-radius: 14px;
            padding: 16px 12px;
            cursor: pointer;
            transition: all 0.25s ease;
            background: #FAFAFA;
            text-align: center;
            position: relative;
            user-select: none;
        }
        .role-card:hover { border-color: #FF6B35; background: #FFF7F4; }
        .role-card.selected {
            border-color: #FF6B35;
            background: linear-gradient(135deg, #FFF3EE, #FFF7F4);
            box-shadow: 0 0 0 4px rgba(255,107,53,0.1);
        }
        .role-card .check-badge {
            position: absolute;
            top: -8px; right: -8px;
            width: 22px; height: 22px;
            background: #FF6B35;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }
        .role-card.selected .check-badge { display: flex; }
        .role-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 10px;
            font-size: 20px;
            transition: all 0.25s ease;
        }
        .role-card.selected .role-icon { transform: scale(1.1); }

        /* Password strength bar */
        .strength-bar {
            height: 4px;
            border-radius: 4px;
            background: #E5E5E5;
            overflow: hidden;
            margin-top: 6px;
        }
        .strength-fill {
            height: 100%;
            border-radius: 4px;
            transition: all 0.4s ease;
            width: 0%;
        }

        /* Steps indicator */
        .step-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transition: all 0.3s ease;
        }
        .step-dot.active {
            background: white;
            width: 24px;
            border-radius: 4px;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">

    <!-- Top Header -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-50 shadow-sm">
        <a href="#" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md">
                <i class="fas fa-store text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900">ShopHub</h1>
                <p class="text-xs text-gray-500">Your Trusted Online Shop</p>
            </div>
        </a>
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-500">Already have an account?</span>
            <a href="#" class="px-4 py-2 text-sm font-semibold text-orange-600 border border-orange-300 rounded-lg hover:bg-orange-50 transition">
                <i class="fas fa-sign-in-alt mr-1"></i> Login
            </a>
        </div>
    </header>

    <!-- Main -->
    <main class="flex-1 pt-16 flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-4xl card-shadow rounded-2xl overflow-hidden flex animate-fade-in bg-white">

            <!-- Left Decorative Panel -->
            <div class="left-panel hidden md:flex md:w-5/12 flex-col justify-between p-10 text-white relative">

                <!-- Floating bubbles -->
                <div class="bubble w-36 h-36 bg-white/10 top-[-30px] right-[-30px]" style="animation-duration:6s;"></div>
                <div class="bubble w-20 h-20 bg-white/10 bottom-24 left-[-10px]" style="animation-duration:8s; animation-delay:1s;"></div>
                <div class="bubble w-14 h-14 bg-white/15 top-1/2 right-6" style="animation-duration:5s; animation-delay:2s;"></div>

                <div>
                    <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mb-6 border border-white/30">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <h2 class="display-font text-3xl font-bold leading-tight mb-3">Join Our Community!</h2>
                    <p class="text-white/85 text-sm leading-relaxed">Create your account and start discovering amazing products from trusted sellers.</p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-white/15 backdrop-blur rounded-xl p-4 border border-white/20 text-center">
                        <p class="text-2xl font-bold"></p>
                        <p class="text-xs text-white/70 mt-1">Trusted Sellers</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur rounded-xl p-4 border border-white/20 text-center">
                        <p class="text-2xl font-bold"></p>
                        <p class="text-xs text-white/70 mt-1">Happy Buyers</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur rounded-xl p-4 border border-white/20 text-center">
                        <p class="text-2xl font-bold"></p>
                        <p class="text-xs text-white/70 mt-1">Products Listed</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur rounded-xl p-4 border border-white/20 text-center">
                        <p class="text-2xl font-bold"></p>
                        <p class="text-xs text-white/70 mt-1">Avg. Rating</p>
                    </div>
                </div>

                <!-- Benefits list -->
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-white/80 text-sm"></i>
                        <span class="text-xs text-white/80">Free to join, no hidden fees</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-white/80 text-sm"></i>
                        <span class="text-xs text-white/80">Secure payments & buyer protection</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-white/80 text-sm"></i>
                        <span class="text-xs text-white/80">Sell or shop — your choice</span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-white/70 text-xs"></i>
                    <span class="text-xs text-white/70">Philippines</span>
                </div>
            </div>

            <!-- Right Form Panel -->
            <div class="flex-1 flex flex-col justify-center px-8 md:px-12 py-10">

                <!-- Header -->
                <div class="mb-7 animate-fade-in-delay">
                    <div class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 px-3 py-1.5 rounded-full text-xs font-semibold mb-4 border border-orange-100">
                        <i class="fas fa-shield-alt text-xs"></i> Free Registration
                    </div>
                    <h2 class="display-font text-3xl font-bold text-gray-900 mb-1">Create your account</h2>
                    <p class="text-sm text-gray-500">Join thousands of buyers and sellers on ShopHub</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="animate-fade-in-delay2">
                    @csrf

                    <!-- Name + Email (2 col) -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Juan Dela Cruz" class="input-field">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" class="input-field">
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input id="password" type="password" name="password" placeholder="Create a strong password" class="input-field" style="padding-right:44px;" oninput="checkStrength(this.value)">
                            <button type="button" onclick="togglePw('password','eye1')" style="background:none;border:none;cursor:pointer;" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-eye text-sm" id="eye1"></i>
                            </button>
                        </div>
                        <!-- Strength bar -->
                        <div class="strength-bar mt-2">
                            <div class="strength-fill" id="strength-fill"></div>
                        </div>
                        <p class="text-xs mt-1" id="strength-label" style="color:#AAAAAA;">Enter a password</p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input id="password_confirm" type="password" name="password_confirmation" placeholder="Re-enter your password" class="input-field" style="padding-right:44px;">
                            <button type="button" onclick="togglePw('password_confirm','eye2')" style="background:none;border:none;cursor:pointer;" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-eye text-sm" id="eye2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Role Selector (Hidden - all users register as buyers by default) -->
                    <input type="hidden" id="role-input" name="role" value="buyer">

                    <!-- Submit -->
                    <button type="submit" class="btn-register">
                        <i class="fas fa-user-plus mr-2"></i> Create My Account
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-5 flex items-center gap-4">
                    <div class="divider-line flex-1"></div>
                    <span class="text-xs text-gray-400 font-medium">OR</span>
                    <div class="divider-line flex-1"></div>
                </div>

                <!-- Login CTA -->
                <p class="text-center text-sm text-gray-500">
                    Already have an account?
                    <a href="#" class="font-bold text-orange-500 hover:text-orange-700 transition ml-1">
                        Sign in here <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </p>

                <!-- Back to home -->
                <div class="mt-5 text-center">
                    <a href="#" class="inline-flex items-center gap-2 text-xs text-gray-400 hover:text-orange-500 transition">
                        <i class="fas fa-arrow-left text-xs"></i> Back to ShopHub
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer class="pb-6 text-center">
        <p class="text-xs text-gray-400">&copy; {{ date('Y') }} ShopHub. All rights reserved.</p>
    </footer>

    <script>
        function togglePw(inputId, iconId) {
            const pw = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (pw.type === 'password') {
                pw.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                pw.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        function selectRole(role) {
            document.getElementById('role-input').value = role;
            document.getElementById('card-buyer').classList.toggle('selected', role === 'buyer');
            document.getElementById('card-seller').classList.toggle('selected', role === 'seller');
        }

        function checkStrength(val) {
            const fill = document.getElementById('strength-fill');
            const label = document.getElementById('strength-label');
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [
                { w: '0%',   color: '#E5E5E5', text: 'Enter a password',  textColor: '#AAAAAA' },
                { w: '25%',  color: '#EF4444', text: 'Weak',              textColor: '#EF4444' },
                { w: '50%',  color: '#F59E0B', text: 'Fair',              textColor: '#F59E0B' },
                { w: '75%',  color: '#3B82F6', text: 'Good',              textColor: '#3B82F6' },
                { w: '100%', color: '#10B981', text: 'Strong ✓',          textColor: '#10B981' },
            ];
            const lvl = val.length === 0 ? levels[0] : levels[score];
            fill.style.width = lvl.w;
            fill.style.background = lvl.color;
            label.textContent = lvl.text;
            label.style.color = lvl.textColor;
        }
    </script>
</body>
</html>