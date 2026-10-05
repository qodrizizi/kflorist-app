<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Akun - BonsaiKu | Khadir Florist</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logonobg.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN for high reliability -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        bonsai: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f172a;
        }

        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 1.2px, transparent 1.2px);
            background-size: 24px 24px;
        }

        .glass-hero {
            background: linear-gradient(135deg, rgba(2, 44, 34, 0.95) 0%, rgba(6, 78, 59, 0.9) 60%, rgba(4, 47, 46, 0.95) 100%);
            position: relative;
            overflow: hidden;
        }

        .ambient-glow {
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(52, 211, 153, 0.25) 0%, rgba(5, 150, 105, 0) 70%);
            filter: blur(40px);
            pointer-events: none;
        }

        .input-group {
            transition: all 0.2s ease;
        }

        .input-group:focus-within {
            border-color: #059669;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.4);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
            box-shadow: 0 14px 28px -5px rgba(5, 150, 105, 0.5);
            transform: translateY(-2px);
        }

        .btn-gradient:active {
            transform: translateY(0);
        }
    </style>
</head>
<body class="min-h-screen bg-slate-900 text-slate-800 flex items-center justify-center p-3 sm:p-6 lg:p-10">

    <!-- Container Card (Split Screen) -->
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 border border-slate-100/80">
        
        <!-- ================= LEFT PANEL: BRAND SHOWCASE ================= -->
        <div class="lg:col-span-5 glass-hero p-8 sm:p-10 flex flex-col justify-between text-white relative">
            <!-- Glow Accents -->
            <div class="ambient-glow -top-20 -left-20"></div>
            <div class="ambient-glow -bottom-20 -right-20"></div>

            <!-- Top Header in Hero -->
            <div class="relative z-10">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-inner overflow-hidden p-1.5">
                        <img src="{{ asset('images/logonobg.png') }}" alt="BonsaiKu Logo" class="w-full h-full object-contain"
                             onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'%2334d399\'><path d=\'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.4z\'/></svg>'">
                    </div>
                    <div>
                        <span class="text-xs uppercase font-extrabold tracking-widest text-emerald-300 block">Khadir Florist</span>
                        <h2 class="text-xl font-bold tracking-tight text-white">BonsaiKu</h2>
                    </div>
                </div>

                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 text-xs font-medium mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>Portal Pelanggan & Kolektor</span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight text-white mb-4">
                    Hadirkan Ketenangan Seni Hidup di Ruangan Anda.
                </h1>
                <p class="text-emerald-100/80 text-sm leading-relaxed">
                    Akses katalog tanaman langka, pantau status pesanan bonsai eksklusif, serta konsultasikan perawatan tanaman langsung dengan tim ahli kami.
                </p>
            </div>

            <!-- Features Badge Cards -->
            <div class="relative z-10 space-y-3.5 my-8">
                <div class="flex items-start space-x-3.5 p-3 rounded-2xl bg-white/5 backdrop-blur-md border border-white/10 hover:bg-white/10 transition duration-300">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 flex items-center justify-center flex-shrink-0 text-emerald-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white">Bonsai Terkurasi & Bersertifikat</h4>
                        <p class="text-xs text-emerald-200/70">Koleksi varietas pilihan dengan kesehatan akar dan estetika prima.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3.5 p-3 rounded-2xl bg-white/5 backdrop-blur-md border border-white/10 hover:bg-white/10 transition duration-300">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 flex items-center justify-center flex-shrink-0 text-emerald-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white">Pengiriman Bergaransi Aman</h4>
                        <p class="text-xs text-emerald-200/70">Palet kayu proteksi khusus menjamin tanaman tiba tetap segar.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3.5 p-3 rounded-2xl bg-white/5 backdrop-blur-md border border-white/10 hover:bg-white/10 transition duration-300">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 flex items-center justify-center flex-shrink-0 text-emerald-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white">Panduan & Edukasi Perawatan</h4>
                        <p class="text-xs text-emerald-200/70">Konsultasi berkala untuk teknik prunning, kawat, dan nutrisi.</p>
                    </div>
                </div>
            </div>

            <!-- Social Proof Footer -->
            <div class="relative z-10 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-emerald-200/80">
                <div class="flex items-center space-x-1 text-amber-300">
                    <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                    <span class="font-bold text-white ml-1.5">4.9 / 5.0</span>
                </div>
                <span>1.500+ Kolektor Terdaftar</span>
            </div>
        </div>

        <!-- ================= RIGHT PANEL: LOGIN FORM ================= -->
        <div class="lg:col-span-7 bg-pattern p-6 sm:p-10 lg:p-12 flex flex-col justify-between">
            
            <!-- Top bar: Back to Shop -->
            <div class="flex items-center justify-between mb-6">
                <!-- Mobile brand logo (visible on mobile only) -->
                <div class="flex lg:hidden items-center space-x-2">
                    <img src="{{ asset('images/logonobg.png') }}" class="w-8 h-8 object-contain" alt="Logo">
                    <span class="font-bold text-emerald-800 text-lg">BonsaiKu</span>
                </div>

                <a href="{{ route('shop.index') }}" 
                   class="inline-flex items-center text-xs font-semibold text-slate-500 hover:text-emerald-700 bg-white hover:bg-emerald-50 px-3.5 py-2 rounded-full border border-slate-200/80 hover:border-emerald-200 transition duration-200 shadow-sm ml-auto">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Toko
                </a>
            </div>

            <!-- Form Content -->
            <div class="max-w-md w-full mx-auto my-auto">
                <div class="mb-8">
                    <span class="inline-block text-xs font-bold tracking-wider uppercase text-emerald-600 bg-emerald-50 px-3 py-1 rounded-md mb-2">
                        Selamat Datang Kembali 👋
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Masuk ke Akun</h2>
                    <p class="text-slate-500 text-sm mt-1.5">
                        Kelola koleksi bonsai, pantau pengiriman pesanan, dan nikmati penawaran eksklusif.
                    </p>
                </div>

                <!-- Alert Feedback Messages -->
                @if(session('success'))
                    <div class="mb-5 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 text-sm animate-fade-in">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex-1 font-medium">{{ session('success') }}</div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-5 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start space-x-3 text-sm animate-fade-in">
                        <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex-1">
                            <span class="font-semibold block mb-0.5">Terjadi Kesalahan:</span>
                            <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-700">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Form Login -->
                <form method="POST" action="{{ route('login.post') }}" id="loginForm" class="space-y-4">
                    @csrf

                    <!-- Field Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Alamat Email
                        </label>
                        <div class="input-group relative flex items-center bg-white rounded-xl border border-slate-200 overflow-hidden">
                            <div class="pl-3.5 pr-2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" required autocomplete="email"
                                   value="{{ old('email') }}"
                                   placeholder="nama@email.com"
                                   class="w-full py-3 pr-4 text-sm text-slate-800 placeholder-slate-400 bg-transparent focus:outline-none">
                        </div>
                    </div>

                    <!-- Field Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Kata Sandi
                            </label>
                        </div>
                        <div class="input-group relative flex items-center bg-white rounded-xl border border-slate-200 overflow-hidden">
                            <div class="pl-3.5 pr-2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" required autocomplete="current-password"
                                   placeholder="Masukkan password Anda"
                                   class="w-full py-3 pr-10 text-sm text-slate-800 placeholder-slate-400 bg-transparent focus:outline-none">
                            <button type="button" id="togglePasswordBtn"
                                    class="absolute right-3 text-slate-400 hover:text-slate-600 focus:outline-none p-1"
                                    title="Tampilkan / Sembunyikan Password">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember me & Forgot Password -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center cursor-pointer select-none text-xs text-slate-600">
                            <input type="checkbox" name="remember" value="1" 
                                   class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 accent-emerald-600 cursor-pointer">
                            <span class="ml-2">Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn"
                            class="btn-gradient w-full text-white font-bold py-3.5 px-4 rounded-xl shadow-md focus:outline-none focus:ring-4 focus:ring-emerald-400/40 flex items-center justify-center space-x-2 text-sm mt-2">
                        <span id="btnText">Masuk ke Akun</span>
                        <svg id="btnArrow" class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                        <span id="btnLoader" class="hidden items-center space-x-2">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span>Memproses...</span>
                        </span>
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative flex items-center justify-center my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative bg-slate-50 px-3 text-xs uppercase tracking-wider text-slate-400 font-semibold rounded">
                        Atau masuk lebih cepat
                    </div>
                </div>

                <!-- Google OAuth Button -->
                <a href="{{ route('auth.google') }}"
                   class="w-full bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 hover:border-slate-300 font-semibold py-3 px-4 rounded-xl shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center space-x-3 text-sm group">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17z"/>
                        <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.34 24 12 24z"/>
                        <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
                        <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.34 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                    </svg>
                    <span class="group-hover:text-slate-900">Masuk dengan Akun Google</span>
                </a>

                <!-- Register Link -->
                <div class="text-center mt-6 pt-5 border-t border-slate-100">
                    <p class="text-sm text-slate-600">
                        Belum memiliki akun?
                        <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition ml-1">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>

            <!-- Security Footer -->
            <div class="text-center mt-6 text-xs text-slate-400 flex items-center justify-center space-x-1.5">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>Privasi data Anda terlindungi dengan standar enkripsi aman.</span>
            </div>

        </div>
    </div>

    <!-- Interactive Script -->
    <script>
        // Toggle Show/Hide Password
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeOffIcon = document.getElementById('eyeOffIcon');

        togglePasswordBtn.addEventListener('click', function() {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            eyeIcon.classList.toggle('hidden', isPassword);
            eyeOffIcon.classList.toggle('hidden', !isPassword);
        });

        // Form Submit Loading Feedback
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnArrow = document.getElementById('btnArrow');
            const btnLoader = document.getElementById('btnLoader');

            btnText.classList.add('hidden');
            btnArrow.classList.add('hidden');
            btnLoader.classList.remove('hidden');
            btnLoader.classList.add('inline-flex');
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.85';
            submitBtn.style.cursor = 'not-allowed';
        });
    </script>
</body>
</html>