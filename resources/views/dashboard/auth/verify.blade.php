<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - BonsaiKu | Khadir Florist</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logonobg.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
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
            background-color: #022c22;
            background-image: radial-gradient(rgba(16, 185, 129, 0.15) 1.2px, transparent 1.2px);
            background-size: 24px 24px;
        }

        .ambient-glow {
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(52, 211, 153, 0.25) 0%, rgba(5, 150, 105, 0) 70%);
            filter: blur(50px);
            pointer-events: none;
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

        .input-otp {
            letter-spacing: 0.35em;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
        }
    </style>
</head>
<body class="min-h-screen relative flex items-center justify-center p-4 sm:p-6 overflow-x-hidden">

    <!-- Fullpage Background bglogin.webp -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none select-none">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat scale-105 filter blur-[3px] brightness-[0.45]"
             style="background-image: url('{{ asset('images/bglogin.webp') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-tr from-slate-950/85 via-emerald-950/65 to-slate-950/85"></div>
        <div class="absolute inset-0 opacity-[0.07]" 
             style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
    </div>

    <!-- Ambient Glows -->
    <div class="ambient-glow -top-20 -left-20"></div>
    <div class="ambient-glow -bottom-20 -right-20"></div>

    <div class="w-full max-w-md bg-white/95 backdrop-blur-2xl rounded-3xl shadow-2xl shadow-emerald-950/50 p-7 sm:p-9 border border-white/40 relative z-10">
        
        <!-- Header & Logo -->
        <div class="text-center mb-6">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mx-auto mb-4 p-2 shadow-sm">
                <img src="{{ asset('images/logonobg.png') }}" alt="BonsaiKu" class="w-full h-full object-contain"
                     onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'%23059669\'><path d=\'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.4z\'/></svg>'">
            </div>
            <span class="inline-block text-[11px] font-bold tracking-widest uppercase text-emerald-600 bg-emerald-50 px-3 py-1 rounded-md mb-2">
                Verifikasi Keamanan
            </span>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Masukkan Kode OTP</h1>
            <p class="text-slate-500 text-sm mt-1.5 leading-relaxed">
                Kami telah mengirimkan 6 karakter kode verifikasi ke email Anda.
            </p>
        </div>

        <!-- Alert Success -->
        @if(session('success'))
            <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-2.5 text-xs">
                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Alert Error -->
        @if($errors->any())
            <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start space-x-2.5 text-xs">
                <svg class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Form OTP -->
        <form action="{{ route('verify.submit') }}" method="POST" id="verifyForm" class="space-y-5">
            @csrf
            <div>
                <label for="code" class="block text-xs font-bold text-slate-700 uppercase tracking-wider text-center mb-2">
                    Kode 6 Karakter
                </label>
                <input type="text" name="code" id="code" required autofocus maxlength="10"
                       class="input-otp w-full py-3.5 px-4 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/15 focus:outline-none text-slate-900 placeholder:text-slate-300 transition"
                       placeholder="••••••">
            </div>

            <button type="submit" id="submitBtn"
                    class="btn-gradient w-full text-white font-bold py-3.5 px-4 rounded-xl shadow-md focus:outline-none focus:ring-4 focus:ring-emerald-400/40 flex items-center justify-center space-x-2 text-sm">
                <span id="btnText">Verifikasi Sekarang</span>
                <span id="btnLoader" class="hidden items-center space-x-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>Memverifikasi...</span>
                </span>
            </button>
        </form>

        <!-- Footer Actions -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center space-y-2">
            <p class="text-xs text-slate-500">
                Belum menerima email? Periksa folder spam atau
                <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:underline">
                    Login ulang
                </a>
            </p>
            <div>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center text-xs text-slate-400 hover:text-slate-600 transition">
                    ← Kembali ke Beranda Toko
                </a>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('verifyForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');

            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');
            btnLoader.classList.add('inline-flex');
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.85';
        });
    </script>
</body>
</html>
