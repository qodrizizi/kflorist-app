<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUANGBONSAI - Toko Bonsai Online Terpercaya</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Anti-flicker Dark Mode Detection & Toggle --}}
    <script>
        (function() {
            const isDark = localStorage.getItem('darkMode') === 'true' || 
                           localStorage.getItem('theme') === 'dark' || 
                           (!localStorage.getItem('darkMode') && !localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', isDark ? 'true' : 'false');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { isDark } }));
        }
    </script>


    <style>
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Mobile Menu Styles */
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-menu.active {
            transform: translateX(0);
        }

        /* Mobile Search Styles */
        .mobile-search {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }

        .mobile-search.active {
            max-height: 120px;
        }

        /* Map container */
        .map-container {
            height: 250px;
            border-radius: 12px;
            overflow: hidden;
        }

        /* Main content spacing */
        .main-content {
            min-height: calc(100vh - 80px);
            /* Adjust based on header height */
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #10b981, #3b82f6);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #059669, #2563eb);
        }

        /* Page Loader Styles */
        #page-loader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: white;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        #page-loader.hidden-loader {
            opacity: 0;
            visibility: hidden;
        }

        @keyframes leafSpin {
            0% {
                transform: rotate(0deg) scale(1);
            }

            50% {
                transform: rotate(180deg) scale(1.2);
            }

            100% {
                transform: rotate(360deg) scale(1);
            }
        }

        .loader-leaf {
            animation: leafSpin 1.5s ease-in-out infinite;
            filter: drop-shadow(0 0 10px rgba(16, 185, 129, 0.4));
        }

        /* Page Enter Animation */
        .page-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===================================================
           MODERN, COMPACT & ROUNDED SWEETALERT2 STYLES
           =================================================== */
        .swal2-container {
            backdrop-filter: blur(5px) !important;
            -webkit-backdrop-filter: blur(5px) !important;
            background-color: rgba(15, 23, 42, 0.45) !important;
            z-index: 99999 !important;
        }

        .swal2-popup {
            width: 23rem !important;
            max-width: calc(100vw - 2rem) !important;
            border-radius: 1.5rem !important;
            /* 24px */
            padding: 1.6rem 1.4rem 1.4rem !important;
            background: #ffffff !important;
            border: 1px solid rgba(226, 232, 240, 0.9) !important;
            box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.18), 0 0 0 1px rgba(15, 23, 42, 0.04) !important;
            font-family: inherit !important;
        }

        /* Proportional and Elegant Icons */
        .swal2-icon {
            width: 3.5rem !important;
            height: 3.5rem !important;
            min-width: 3.5rem !important;
            margin: 0.25rem auto 1rem !important;
            border-width: 2.5px !important;
            transform: scale(0.9) !important;
        }

        /* Success Icon */
        .swal2-icon.swal2-success {
            border-color: #10b981 !important;
            color: #10b981 !important;
            background: rgba(16, 185, 129, 0.08) !important;
        }

        .swal2-icon.swal2-success .swal2-success-ring {
            border: 2px solid rgba(16, 185, 129, 0.2) !important;
        }

        .swal2-icon.swal2-success [class^='swal2-success-line'] {
            background-color: #10b981 !important;
        }

        .swal2-icon.swal2-success .swal2-success-fix,
        .swal2-icon.swal2-success .swal2-success-circular-line-left,
        .swal2-icon.swal2-success .swal2-success-circular-line-right {
            background-color: transparent !important;
        }

        /* Error Icon */
        .swal2-icon.swal2-error {
            border-color: #f43f5e !important;
            color: #f43f5e !important;
            background: rgba(244, 63, 94, 0.08) !important;
        }

        .swal2-icon.swal2-error [class^='swal2-x-mark-line'] {
            background-color: #f43f5e !important;
            height: 2.5px !important;
            width: 22px !important;
            top: 24px !important;
        }

        /* Warning Icon */
        .swal2-icon.swal2-warning {
            border-color: #f59e0b !important;
            color: #f59e0b !important;
            background: rgba(245, 158, 11, 0.08) !important;
        }

        /* Question Icon */
        .swal2-icon.swal2-question {
            border-color: #3b82f6 !important;
            color: #3b82f6 !important;
            background: rgba(59, 130, 246, 0.08) !important;
        }

        /* Info Icon */
        .swal2-icon.swal2-info {
            border-color: #6366f1 !important;
            color: #6366f1 !important;
            background: rgba(99, 102, 241, 0.08) !important;
        }

        /* Title */
        .swal2-title {
            font-size: 1.15rem !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            padding: 0 0.5rem !important;
            margin: 0 0 0.4rem 0 !important;
            line-height: 1.4 !important;
            letter-spacing: -0.01em !important;
        }

        /* Description / HTML Container */
        .swal2-html-container {
            font-size: 0.875rem !important;
            color: #64748b !important;
            line-height: 1.55 !important;
            margin: 0 0 1.25rem 0 !important;
            padding: 0 0.5rem !important;
            font-weight: 400 !important;
        }

        .swal2-html-container b,
        .swal2-html-container strong {
            color: #0f172a !important;
            font-weight: 600 !important;
        }

        /* Action Buttons */
        .swal2-actions {
            margin: 0.25rem 0 0 0 !important;
            width: 100% !important;
            gap: 0.625rem !important;
            justify-content: center !important;
            align-items: center !important;
        }

        .swal2-styled {
            border-radius: 0.875rem !important;
            /* 14px */
            padding: 0.65rem 1.4rem !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            margin: 0 !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            outline: none !important;
            box-shadow: none !important;
            cursor: pointer !important;
            min-height: 2.6rem !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .swal2-styled:hover {
            transform: translateY(-1.5px) !important;
        }

        .swal2-styled:active {
            transform: translateY(0px) scale(0.98) !important;
        }

        /* Ensure hidden buttons (Deny, Cancel) are never forced visible */
        .swal2-actions button[style*="display: none"],
        .swal2-styled[style*="display: none"],
        button.swal2-styled[style*="display: none"] {
            display: none !important;
        }

        /* Confirm Button - Emerald Gradient */
        .swal2-styled.swal2-confirm {
            background: linear-gradient(135deg, #10b981, #059669) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px -1px rgba(16, 185, 129, 0.4) !important;
            border: none !important;
        }

        .swal2-styled.swal2-confirm:hover {
            box-shadow: 0 6px 18px -1px rgba(16, 185, 129, 0.5) !important;
        }

        /* Danger Confirm Button */
        .swal2-styled.swal2-confirm[style*="#ef4444"],
        .swal2-styled.swal2-confirm[style*="rgb(239, 68, 68)"],
        .swal2-styled.swal2-confirm[style*="#f43f5e"] {
            background: linear-gradient(135deg, #f43f5e, #e11d48) !important;
            box-shadow: 0 4px 14px -1px rgba(244, 63, 94, 0.4) !important;
        }

        .swal2-styled.swal2-confirm[style*="#ef4444"]:hover,
        .swal2-styled.swal2-confirm[style*="rgb(239, 68, 68)"]:hover {
            box-shadow: 0 6px 18px -1px rgba(244, 63, 94, 0.5) !important;
        }

        /* Cancel Button */
        .swal2-styled.swal2-cancel {
            background: #f1f5f9 !important;
            color: #475569 !important;
            border: 1px solid #e2e8f0 !important;
        }

        .swal2-styled.swal2-cancel:hover {
            background: #e2e8f0 !important;
            color: #1e293b !important;
        }

        /* Sleek Modern Toasts */
        .swal2-toast {
            border-radius: 1rem !important;
            /* 16px */
            padding: 0.65rem 1rem !important;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.08) !important;
            border: 1px solid rgba(226, 232, 240, 0.85) !important;
            background: #ffffff !important;
        }

        .swal2-toast .swal2-title {
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            margin: 0 !important;
        }

        .swal2-toast .swal2-icon {
            width: 1.75rem !important;
            height: 1.75rem !important;
            min-width: 1.75rem !important;
            margin: 0 0.5rem 0 0 !important;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-300">

    <!-- PAGE LOADER START -->
    <div id="page-loader" class="fixed inset-0 z-[100] flex flex-col items-center justify-center bg-white dark:bg-slate-950">
        <div class="relative">
            <div class="w-20 h-20 border-4 border-green-100 dark:border-slate-800 rounded-full"></div>
            <div class="w-20 h-20 border-t-4 border-green-500 rounded-full absolute top-0 left-0 animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <i class="fas fa-leaf text-3xl text-green-500 loader-leaf"></i>
            </div>
        </div>
        <div class="mt-6 flex flex-col items-center">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white tracking-wider">RUANGBONSAI</h3>
            <div class="flex space-x-1 mt-2">
                <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
            </div>
        </div>
    </div>
    <!-- PAGE LOADER END -->

    <div class="page-fade-in">

        @php
            $headerCartCount = Auth::check() ? \App\Models\Cart::where('user_id', Auth::id())->sum('quantity') : 0;
            $headerUserName = Auth::check() ? Auth::user()->name : null;
            $headerUserInitial = $headerUserName ? strtoupper(substr($headerUserName, 0, 1)) : '';
        @endphp

        <!-- TOP BAR (ANNOUNCEMENT & HIGHLIGHTS) -->
        <div class="bg-slate-900 dark:bg-slate-950 border-b border-slate-800 dark:border-slate-800/80 text-slate-300 text-[11px] py-1.5 transition-all">
            <div class="container mx-auto px-4 sm:px-6 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 font-semibold text-[10px] border border-emerald-500/30">
                        <i class="fas fa-shield-alt text-[9px]"></i> Garansi Hidup
                    </span>
                    <span class="text-slate-300 hidden md:inline">Spesialis Seni Bonsai Nusantara • Packing Kayu Bergaransi Aman ke Seluruh Indonesia</span>
                    <span class="text-slate-300 md:hidden">Koleksi Seni Bonsai Nusantara</span>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-4 text-slate-400">
                    <a href="https://wa.me/6281234567890" target="_blank" class="hidden sm:flex hover:text-emerald-400 transition items-center gap-1.5">
                        <i class="fab fa-whatsapp text-emerald-400 text-xs"></i>
                        <span>+62 812-3456-7890</span>
                    </a>
                    <span class="text-slate-700 hidden lg:inline">|</span>
                    <span class="hidden lg:flex items-center gap-1.5 text-slate-400">
                        <i class="fas fa-clock text-[10px] text-emerald-500"></i>
                        <span>08.00 - 18.00 WIB</span>
                    </span>
                    <span class="text-slate-700 hidden sm:inline">|</span>

                    <!-- Night & Dark Mode Switcher -->
                    <button type="button" onclick="toggleTheme()" 
                        class="theme-toggle-btn inline-flex items-center p-0.5 rounded-full bg-slate-800 hover:bg-slate-700/90 border border-slate-700 hover:border-slate-600 transition-all text-[10px] font-bold text-slate-300 cursor-pointer shadow-xs group" 
                        title="Beralih Mode Gelap / Terang" aria-label="Toggle Dark/Light Mode">
                        <!-- Light Mode Pill -->
                        <span class="flex items-center gap-1 px-2 py-0.5 rounded-full transition-all duration-300 text-amber-900 bg-amber-400 shadow-xs dark:text-slate-400 dark:bg-transparent dark:shadow-none">
                            <i class="fas fa-sun text-[10px]"></i>
                            <span class="hidden sm:inline font-semibold">Light</span>
                        </span>
                        <!-- Dark Mode Pill -->
                        <span class="flex items-center gap-1 px-2 py-0.5 rounded-full transition-all duration-300 text-slate-400 bg-transparent dark:text-emerald-950 dark:bg-emerald-400 dark:shadow-xs">
                            <i class="fas fa-moon text-[10px]"></i>
                            <span class="hidden sm:inline font-semibold">Dark</span>
                        </span>
                    </button>
                </div>

            </div>
        </div>

        <!-- MAIN HEADER START -->
        <header class="sticky top-0 z-50 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800 shadow-xs dark:shadow-slate-950/40 transition-all duration-300">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="flex items-center justify-between h-20 gap-3 md:gap-6">
                    
                    <!-- Left: Brand Logo -->
                    <a href="{{ route('shop.index') }}" class="flex items-center gap-2.5 sm:gap-3 group flex-shrink-0">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo RUANGBONSAI" class="h-10 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                        <span class="text-xl sm:text-2xl font-black tracking-tight leading-none">
                            <span style="color: #22472e;" class="dark:!text-emerald-400">RUANG</span><span style="color: #90673a;" class="dark:!text-amber-400">BONSAI</span>
                        </span>
                    </a>

                    <!-- Center: Desktop Navigation Pills -->
                    <nav class="hidden lg:flex items-center p-1.5 bg-slate-100/80 dark:bg-slate-800/80 rounded-2xl border border-slate-200/60 dark:border-slate-700/60 shadow-2xs">
                        <a href="{{ route('shop.index') }}"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('shop.index') ? 'bg-white dark:bg-slate-900 text-emerald-700 dark:text-emerald-400 shadow-xs ring-1 ring-slate-200/50 dark:ring-slate-700/60' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-700/50' }}">
                            <i class="fas fa-home {{ request()->routeIs('shop.index') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-400' }} text-xs"></i>
                            <span>Beranda</span>
                        </a>
                        <a href="{{ route('shop.tentang') }}"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('shop.tentang') ? 'bg-white dark:bg-slate-900 text-emerald-700 dark:text-emerald-400 shadow-xs ring-1 ring-slate-200/50 dark:ring-slate-700/60' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-700/50' }}">
                            <i class="fas fa-feather-alt {{ request()->routeIs('shop.tentang') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-400' }} text-xs"></i>
                            <span>Tentang</span>
                        </a>
                        <a href="{{ route('shop.kategori') }}"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('shop.kategori') ? 'bg-white dark:bg-slate-900 text-emerald-700 dark:text-emerald-400 shadow-xs ring-1 ring-slate-200/50 dark:ring-slate-700/60' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-700/50' }}">
                            <i class="fas fa-layer-group {{ request()->routeIs('shop.kategori') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-400' }} text-xs"></i>
                            <span>Kategori</span>
                        </a>
                        <a href="{{ route('shop.produk') }}"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('shop.produk') ? 'bg-white dark:bg-slate-900 text-emerald-700 dark:text-emerald-400 shadow-xs ring-1 ring-slate-200/50 dark:ring-slate-700/60' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-700/50' }}">
                            <i class="fas fa-tree {{ request()->routeIs('shop.produk') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-400' }} text-xs"></i>
                            <span>Produk</span>
                        </a>
                        <a href="{{ route('shop.komunitas') }}"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('shop.komunitas') ? 'bg-white dark:bg-slate-900 text-emerald-700 dark:text-emerald-400 shadow-xs ring-1 ring-slate-200/50 dark:ring-slate-700/60' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-700/50' }}">
                            <i class="fas fa-users {{ request()->routeIs('shop.komunitas') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-400' }} text-xs"></i>
                            <span>Komunitas</span>
                            <span class="relative flex h-2 w-2 ml-0.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                        </a>
                    </nav>

                    <!-- Right: Search, Cart, Orders & User Profile -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        
                        <!-- Desktop Search Input (XL+) -->
                        <form action="{{ route('shop.produk') }}" method="GET" class="hidden xl:block relative w-48 2xl:w-60">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari koleksi bonsai..."
                                class="w-full pl-9 pr-4 py-2 bg-slate-100/80 dark:bg-slate-800/80 hover:bg-slate-100 dark:hover:bg-slate-800 focus:bg-white dark:focus:bg-slate-900 text-xs rounded-xl border border-transparent dark:border-slate-700/50 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500 text-slate-800 dark:text-slate-100">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        </form>

                        <!-- Search Toggle Icon (for Mobile & Tablet) -->
                        <button id="search-toggle" type="button" class="xl:hidden p-2.5 rounded-xl bg-slate-100/80 dark:bg-slate-800/80 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-600 dark:hover:text-emerald-400 text-slate-600 dark:text-slate-300 transition flex items-center justify-center cursor-pointer border border-transparent dark:border-slate-700/50" title="Cari Produk">
                            <i class="fas fa-search text-sm"></i>
                        </button>

                        @auth
                        <!-- Pesanan Saya (Desktop & Tablet) -->
                        <a href="{{ route('shop.pesanan') }}" title="Pesanan Saya"
                            class="hidden md:flex p-2.5 rounded-xl bg-slate-100/80 dark:bg-slate-800/80 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-600 dark:hover:text-emerald-400 text-slate-600 dark:text-slate-300 transition items-center justify-center border border-transparent dark:border-slate-700/50 hover:border-emerald-200 dark:hover:border-emerald-500/30">
                            <i class="fas fa-receipt text-sm"></i>
                        </a>
                        @endauth

                        <!-- Keranjang Belanja -->
                        <a href="{{ route('shop.keranjang') }}" title="Keranjang Belanja"
                            class="relative p-2.5 rounded-xl bg-slate-100/80 dark:bg-slate-800/80 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-600 dark:hover:text-emerald-400 text-slate-600 dark:text-slate-300 transition flex items-center justify-center border border-transparent dark:border-slate-700/50 hover:border-emerald-200 dark:hover:border-emerald-500/30">
                            <i class="fas fa-shopping-cart text-sm"></i>
                            <span id="cart-count"
                                class="cart-count-badge absolute -top-1 -right-1 min-w-[19px] h-[19px] px-1 bg-emerald-600 text-white text-[10px] font-black rounded-full flex items-center justify-center ring-2 ring-white dark:ring-slate-900 shadow-xs {{ $headerCartCount > 0 ? '' : 'hidden' }}">
                                {{ $headerCartCount }}
                            </span>
                        </a>

                        <!-- User Profile / Auth Area -->
                        @auth
                        <!-- User Dropdown (Desktop & Tablet) -->
                        <div class="relative group">
                            <button type="button" class="flex items-center gap-2 p-1 pl-1.5 sm:pr-2.5 rounded-2xl bg-slate-100/80 dark:bg-slate-800/80 hover:bg-emerald-50/80 dark:hover:bg-slate-700/80 border border-slate-200/60 dark:border-slate-700/60 transition group cursor-pointer">
                                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-bold flex items-center justify-center overflow-hidden text-xs shadow-xs">
                                    @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ $headerUserName }}" class="w-full h-full object-cover">
                                    @else
                                    {{ $headerUserInitial }}
                                    @endif
                                </div>
                                <span class="hidden md:block text-xs font-bold text-slate-800 dark:text-slate-200 max-w-[85px] truncate">{{ $headerUserName }}</span>
                                <i class="hidden md:block fas fa-chevron-down text-[10px] text-slate-400 group-hover:text-emerald-600 transition"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right group-hover:translate-y-0 translate-y-2 z-50 overflow-hidden">
                                <div class="p-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
                                    <p class="text-[10px] text-emerald-100 font-medium">Selamat Datang,</p>
                                    <p class="text-sm font-extrabold truncate">{{ $headerUserName }}</p>
                                    <p class="text-[11px] text-emerald-100/80 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="p-2 space-y-1">
                                    <a href="{{ route('shop.profile') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-emerald-400 rounded-xl transition">
                                        <div class="w-6 h-6 rounded-lg bg-emerald-100 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-[10px]">
                                            <i class="fas fa-user-circle"></i>
                                        </div>
                                        <span>Profil Saya</span>
                                    </a>
                                    <a href="{{ route('shop.pesanan') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-emerald-400 rounded-xl transition">
                                        <div class="w-6 h-6 rounded-lg bg-amber-100 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center text-[10px]">
                                            <i class="fas fa-receipt"></i>
                                        </div>
                                        <span>Pesanan Saya</span>
                                    </a>
                                    <a href="{{ route('shop.keranjang') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-emerald-400 rounded-xl transition">
                                        <div class="w-6 h-6 rounded-lg bg-teal-100 dark:bg-teal-950/50 text-teal-600 dark:text-teal-400 flex items-center justify-center text-[10px]">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                        <span>Keranjang Belanja</span>
                                    </a>
                                    <div class="border-t border-slate-100 dark:border-slate-800 my-1 pt-1"></div>
                                    <button onclick="confirmLogout('logout-form-desktop')" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-xl transition text-left cursor-pointer">
                                        <div class="w-6 h-6 rounded-lg bg-rose-100 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 flex items-center justify-center text-[10px]">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </div>
                                        <span>Keluar</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Form Logout Hidden -->
                        <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        @else
                        <!-- Guest Auth Buttons -->
                        <div class="hidden sm:flex items-center gap-2">
                            <a href="{{ route('login') }}" class="px-3.5 py-2 text-xs font-bold text-slate-700 dark:text-slate-200 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 rounded-xl shadow-xs shadow-emerald-600/30 hover:shadow-md transition active:scale-95 flex items-center gap-1.5">
                                <i class="fas fa-user-plus text-[10px]"></i>
                                <span>Daftar</span>
                            </a>
                        </div>
                        <a href="{{ route('login') }}" class="sm:hidden p-2.5 rounded-xl bg-slate-100/80 dark:bg-slate-800/80 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-600 dark:hover:text-emerald-400 text-slate-600 dark:text-slate-300 transition flex items-center justify-center border border-transparent dark:border-slate-700/50" title="Masuk">
                            <i class="fas fa-user text-sm"></i>
                        </a>
                        @endauth

                        <!-- Mobile Hamburger Button -->
                        <button id="mobile-menu-button" type="button" class="lg:hidden p-2.5 rounded-xl bg-slate-100/80 dark:bg-slate-800/80 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-600 dark:hover:text-emerald-400 text-slate-700 dark:text-slate-200 transition flex items-center justify-center focus:outline-none cursor-pointer border border-transparent dark:border-slate-700/50" aria-label="Buka Menu">
                            <i class="fas fa-bars-staggered text-base"></i>
                        </button>
                    </div>

                </div>

                <!-- Mobile / Tablet Search Slide-Down Bar -->
                <div id="mobile-search" class="mobile-search xl:hidden">
                    <div class="py-3 border-t border-slate-100 dark:border-slate-800">
                        <form action="{{ route('shop.produk') }}" method="GET" class="relative flex items-center">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama bonsai, kategori, atau kode..."
                                class="w-full pl-10 pr-24 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none focus:bg-white dark:focus:bg-slate-800 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 shadow-2xs transition">
                            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-xs cursor-pointer">
                                Cari
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </header>

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu-overlay" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden lg:hidden transition-all duration-300"></div>

        <!-- Mobile Drawer (Ultra-Modern Offcanvas) -->
        <div id="mobile-menu" class="mobile-menu fixed left-0 top-0 w-80 max-w-[85vw] h-full bg-white dark:bg-slate-900 shadow-2xl z-50 lg:hidden flex flex-col justify-between overflow-y-auto">
            <div>
                <!-- Drawer Header -->
                <div class="p-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/60 dark:bg-slate-800/60">
                    <div class="flex items-center gap-2.5">
                        <img src="{{ asset('images/logo.png') }}" alt="RUANGBONSAI" class="h-9 w-auto object-contain">
                        <span class="text-lg font-black tracking-tight leading-none">
                            <span style="color: #22472e;" class="dark:!text-emerald-400">RUANG</span><span style="color: #90673a;" class="dark:!text-amber-400">BONSAI</span>
                        </span>
                    </div>
                    <button id="close-menu" class="w-8 h-8 rounded-xl bg-slate-200/60 dark:bg-slate-700/60 hover:bg-rose-50 dark:hover:bg-rose-950/50 hover:text-rose-600 text-slate-500 dark:text-slate-300 flex items-center justify-center transition cursor-pointer">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <!-- User Card / Guest Banner -->
                @auth
                <div class="p-4 mx-4 mt-4 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl text-white shadow-md shadow-emerald-700/15">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-white/20 border border-white/30 flex items-center justify-center overflow-hidden font-black text-sm flex-shrink-0">
                            @if(Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ $headerUserName }}" class="w-full h-full object-cover">
                            @else
                            {{ $headerUserInitial }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold truncate">{{ $headerUserName }}</p>
                            <p class="text-[11px] text-emerald-100 truncate">{{ Auth::user()->email }}</p>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-md bg-white/20 text-[9px] font-bold uppercase tracking-wider">Member</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="p-4 mx-4 mt-4 bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/60 rounded-2xl">
                    <p class="text-xs font-bold text-slate-800 dark:text-slate-100">Selamat Datang di RUANGBONSAI</p>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Masuk untuk melihat pesanan dan menikmati promo spesial.</p>
                    <div class="grid grid-cols-2 gap-2 mt-3">
                        <a href="{{ route('login') }}" class="py-2 text-center text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-600 transition shadow-2xs">Masuk</a>
                        <a href="{{ route('register') }}" class="py-2 text-center text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-xs">Daftar</a>
                    </div>
                </div>
                @endauth

                <!-- Drawer Navigation Links -->
                <nav class="p-4 space-y-1.5">
                    <p class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-2">Navigasi Utama</p>
                    <a href="{{ route('shop.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('shop.index') ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/70' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xs">
                                <i class="fas fa-home"></i>
                            </div>
                            <span>Beranda</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                    </a>
                    <a href="{{ route('shop.tentang') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('shop.tentang') ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/70' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-sky-100 dark:bg-sky-950/60 text-sky-600 dark:text-sky-400 flex items-center justify-center text-xs">
                                <i class="fas fa-feather-alt"></i>
                            </div>
                            <span>Tentang Kami</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                    </a>
                    <a href="{{ route('shop.kategori') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('shop.kategori') ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/70' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xs">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <span>Kategori Bonsai</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                    </a>
                    <a href="{{ route('shop.produk') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('shop.produk') ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/70' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xs">
                                <i class="fas fa-tree"></i>
                            </div>
                            <span>Koleksi Produk</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                    </a>
                    <a href="{{ route('shop.komunitas') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('shop.komunitas') ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/70' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-purple-100 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xs">
                                <i class="fas fa-users"></i>
                            </div>
                            <span>Komunitas</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 uppercase tracking-wide">Baru</span>
                    </a>

                    <!-- Account & Orders Section -->
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 mt-3">
                        <p class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-2">Aktivitas & Akun</p>
                        @auth
                        <a href="{{ route('shop.profile') }}"
                            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/70 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center text-xs">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <span>Profil Saya</span>
                            </div>
                            <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                        </a>
                        <a href="{{ route('shop.pesanan') }}"
                            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/70 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xs">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <span>Pesanan Saya</span>
                            </div>
                            <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                        </a>
                        @endauth
                        <a href="{{ route('shop.keranjang') }}"
                            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/70 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg bg-teal-100 dark:bg-teal-950/60 text-teal-600 dark:text-teal-400 flex items-center justify-center text-xs">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <span>Keranjang Belanja</span>
                            </div>
                            <span class="cart-count-badge px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-600 text-white {{ $headerCartCount > 0 ? '' : 'hidden' }}">
                                {{ $headerCartCount }}
                            </span>
                        </a>
                    </div>

                    <!-- Theme Toggle for Mobile Drawer -->
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 mt-3">
                        <div class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/60">
                            <div class="flex items-center gap-2.5">
                                <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-amber-100 dark:bg-emerald-950/60 text-amber-500 dark:text-emerald-400 text-xs">
                                    <i class="fas fa-sun dark:hidden"></i>
                                    <i class="fas fa-moon hidden dark:inline"></i>
                                </span>
                                <div>
                                    <span class="text-xs font-bold text-slate-700 dark:text-slate-200 block leading-tight">Mode Tampilan</span>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-400 block dark:hidden">Terang (Light)</span>
                                    <span class="text-[10px] text-emerald-400 hidden dark:block">Gelap (Dark)</span>
                                </div>
                            </div>
                            <button type="button" onclick="toggleTheme()" class="relative inline-flex h-6 w-11 items-center rounded-full bg-slate-300 dark:bg-emerald-600 transition-colors focus:outline-none cursor-pointer">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-md transition-transform translate-x-1 dark:translate-x-6"></span>
                            </button>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- Drawer Bottom / Logout -->
            <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/70">
                @auth
                <button onclick="confirmLogout('mobile-logout-form')" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-xl transition border border-rose-200 dark:border-rose-900/40 cursor-pointer">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar dari Akun</span>
                </button>
                <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                @else
                <div class="text-center text-[11px] text-slate-500 dark:text-slate-400">
                    <p>Hubungi Kami: <a href="https://wa.me/6281234567890" target="_blank" class="font-bold text-emerald-600 dark:text-emerald-400 hover:underline">+62 812-3456-7890</a></p>
                </div>
                @endauth
            </div>
        </div>
        <!-- HEADER END -->

        @yield('content')

        <!-- FOOTER START -->
        <footer class="relative text-white pt-16 pb-12 overflow-hidden bg-slate-950">
            <!-- Background Wallpaper: footer.webp -->
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat pointer-events-none scale-105"
                style="background-image: url('{{ asset('images/footer.webp') }}');"></div>
            <!-- Elegant Dark Overlay for text contrast & aesthetic depth -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-slate-950/75 pointer-events-none"></div>

            <div class="container mx-auto px-4 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12">
                    <!-- Company Info -->
                    <div class="space-y-5">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo RUANGBONSAI" class="h-12 w-auto object-contain">
                            <div>
                                <h4 class="text-2xl font-black text-white leading-tight">
                                    <span class="text-emerald-400">RUANG</span><span style="color: #d4a373;">BONSAI</span>
                                </h4>
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Destinasi terpercaya untuk koleksi seni bonsai nusantara berkualitas prima dan bergaransi. Kami menghadirkan ketenangan alam langsung ke hunian Anda.
                        </p>
                        <div class="flex space-x-3 pt-1">
                            <a href="#" class="w-9 h-9 bg-slate-900/90 border border-slate-700/80 rounded-xl flex items-center justify-center text-gray-400 hover:bg-emerald-600 hover:text-white hover:border-emerald-500 transition-all duration-300" title="Facebook">
                                <i class="fab fa-facebook-f text-sm"></i>
                            </a>
                            <a href="#" class="w-9 h-9 bg-slate-900/90 border border-slate-700/80 rounded-xl flex items-center justify-center text-gray-400 hover:bg-emerald-600 hover:text-white hover:border-emerald-500 transition-all duration-300" title="Instagram">
                                <i class="fab fa-instagram text-sm"></i>
                            </a>
                            <a href="https://wa.me/6281234567890" target="_blank" class="w-9 h-9 bg-slate-900/90 border border-slate-700/80 rounded-xl flex items-center justify-center text-gray-400 hover:bg-emerald-600 hover:text-white hover:border-emerald-500 transition-all duration-300" title="WhatsApp">
                                <i class="fab fa-whatsapp text-sm"></i>
                            </a>
                            <a href="#" class="w-9 h-9 bg-slate-900/90 border border-slate-700/80 rounded-xl flex items-center justify-center text-gray-400 hover:bg-emerald-600 hover:text-white hover:border-emerald-500 transition-all duration-300" title="TikTok">
                                <i class="fab fa-tiktok text-sm"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h5 class="text-base font-bold mb-5 flex items-center text-white">
                            <span class="w-2 h-2 bg-emerald-500 mr-2.5 rounded-full"></span>
                            Koleksi Pilihan
                        </h5>
                        <ul class="space-y-3 text-sm">
                            <li>
                                <a href="{{ route('shop.produk', ['kategori' => 'Indoor']) }}" class="text-gray-400 hover:text-emerald-400 hover:translate-x-1.5 flex items-center transition-all duration-300">
                                    <i class="fas fa-chevron-right text-[9px] mr-2.5 text-emerald-500/60"></i>
                                    Bonsai Indoor
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('shop.produk', ['kategori' => 'Outdoor']) }}" class="text-gray-400 hover:text-emerald-400 hover:translate-x-1.5 flex items-center transition-all duration-300">
                                    <i class="fas fa-chevron-right text-[9px] mr-2.5 text-emerald-500/60"></i>
                                    Bonsai Outdoor
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('shop.produk', ['kategori' => 'Premium']) }}" class="text-gray-400 hover:text-emerald-400 hover:translate-x-1.5 flex items-center transition-all duration-300">
                                    <i class="fas fa-chevron-right text-[9px] mr-2.5 text-emerald-500/60"></i>
                                    Koleksi Eksklusif & Juara
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('shop.produk', ['kategori' => 'Bibit']) }}" class="text-gray-400 hover:text-emerald-400 hover:translate-x-1.5 flex items-center transition-all duration-300">
                                    <i class="fas fa-chevron-right text-[9px] mr-2.5 text-emerald-500/60"></i>
                                    Bakalan & Bahan Bonsai
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('shop.produk') }}" class="text-gray-400 hover:text-emerald-400 hover:translate-x-1.5 flex items-center transition-all duration-300">
                                    <i class="fas fa-chevron-right text-[9px] mr-2.5 text-emerald-500/60"></i>
                                    Semua Produk Toko
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Support & Navigation -->
                    <div>
                        <h5 class="text-base font-bold mb-5 flex items-center text-white">
                            <span class="w-2 h-2 bg-emerald-500 mr-2.5 rounded-full"></span>
                            Bantuan & Layanan
                        </h5>
                        <ul class="space-y-3 text-sm">
                            <li>
                                <a href="{{ route('shop.tentang') }}" class="text-gray-400 hover:text-emerald-400 hover:translate-x-1.5 flex items-center transition-all duration-300">
                                    <i class="fas fa-chevron-right text-[9px] mr-2.5 text-emerald-500/60"></i>
                                    Tentang Khadir Florist
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('shop.komunitas') }}" class="text-gray-400 hover:text-emerald-400 hover:translate-x-1.5 flex items-center transition-all duration-300">
                                    <i class="fas fa-chevron-right text-[9px] mr-2.5 text-emerald-500/60"></i>
                                    Komunitas Bonsai Nusantara
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('shop.pesanan') }}" class="text-gray-400 hover:text-emerald-400 hover:translate-x-1.5 flex items-center transition-all duration-300">
                                    <i class="fas fa-chevron-right text-[9px] mr-2.5 text-emerald-500/60"></i>
                                    Status & Lacak Pesanan
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="triggerPolicyModal('kebijakan-privasi')" class="text-gray-400 hover:text-emerald-400 hover:translate-x-1.5 flex items-center transition-all duration-300">
                                    <i class="fas fa-chevron-right text-[9px] mr-2.5 text-emerald-500/60"></i>
                                    Kebijakan Privasi
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="triggerPolicyModal('syarat-ketentuan')" class="text-gray-400 hover:text-emerald-400 hover:translate-x-1.5 flex items-center transition-all duration-300">
                                    <i class="fas fa-chevron-right text-[9px] mr-2.5 text-emerald-500/60"></i>
                                    Syarat & Ketentuan Layanan
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h5 class="text-base font-bold mb-5 flex items-center text-white">
                            <span class="w-2 h-2 bg-emerald-500 mr-2.5 rounded-full"></span>
                            Galeri & Kontak
                        </h5>
                        <ul class="space-y-3.5 text-sm">
                            <li class="flex items-start group">
                                <div class="bg-slate-900 border border-slate-700/80 p-2 rounded-xl mr-3 group-hover:bg-emerald-500/20 group-hover:border-emerald-500/40 transition-colors flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-emerald-400 text-xs"></i>
                                </div>
                                <span class="text-gray-400 text-xs leading-relaxed">
                                    Jl. Bilal No. 123, Pulo Brayan Darat I, Kec. Medan Timur, Kota Medan, Sumatera Utara 20239
                                </span>
                            </li>
                            <li class="flex items-center group">
                                <div class="bg-slate-900 border border-slate-700/80 p-2 rounded-xl mr-3 group-hover:bg-emerald-500/20 group-hover:border-emerald-500/40 transition-colors flex-shrink-0">
                                    <i class="fas fa-phone text-emerald-400 text-xs"></i>
                                </div>
                                <a href="tel:+6281234567890" class="text-gray-400 text-xs hover:text-emerald-400 transition-colors">+62 812-3456-7890</a>
                            </li>
                            <li class="flex items-center group">
                                <div class="bg-slate-900 border border-slate-700/80 p-2 rounded-xl mr-3 group-hover:bg-emerald-500/20 group-hover:border-emerald-500/40 transition-colors flex-shrink-0">
                                    <i class="fas fa-envelope text-emerald-400 text-xs"></i>
                                </div>
                                <a href="mailto:admin@ruangbonsai.com" class="text-gray-400 text-xs hover:text-emerald-400 transition-colors">admin@ruangbonsai.com</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Copyright & Policy Links Bar (Replaces Midtrans) -->
                <div class="border-t border-slate-800/90 mt-12 pt-7">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
                        <p class="text-gray-400 text-xs">
                            &copy; {{ date('Y') }} <span class="font-bold"><span class="text-emerald-400">RUANG</span><span style="color: #d4a373;">BONSAI</span></span>. Seluruh Hak Cipta Dilindungi.
                        </p>

                        <!-- Legal & Policy Links -->
                        <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 text-xs text-gray-400">
                            <a href="javascript:void(0)" onclick="triggerPolicyModal('kebijakan-privasi')" class="hover:text-emerald-400 transition font-medium">
                                Kebijakan Privasi
                            </a>
                            <span class="text-slate-700 hidden sm:inline">•</span>
                            <a href="javascript:void(0)" onclick="triggerPolicyModal('syarat-ketentuan')" class="hover:text-emerald-400 transition font-medium">
                                Syarat & Ketentuan
                            </a>
                            <span class="text-slate-700 hidden sm:inline">•</span>
                            <a href="{{ route('shop.tentang') }}" class="hover:text-emerald-400 transition font-medium">
                                Tentang Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- FOOTER END -->

        <script>
            function triggerPolicyModal(type) {
                if (typeof Swal === 'undefined') return;
                if (type === 'kebijakan-privasi') {
                    Swal.fire({
                        title: 'Kebijakan Privasi',
                        html: '<div class="text-left text-xs text-slate-600 space-y-2 leading-relaxed"><p>Khadir Florist (RUANGBONSAI) berkomitmen melindungi kerahasiaan data pribadi seluruh pelanggan dan anggota komunitas kami.</p><p>1. Informasi akun & alamat hanya digunakan untuk pemrosesan pesanan dan pengiriman tanaman.</p><p>2. Data transaksi dilindungi dengan enkripsi keamanan standar tinggi.</p><p>3. Kami tidak pernah membagikan atau menjual data Anda kepada pihak ketiga.</p></div>',
                        icon: 'info',
                        confirmButtonColor: '#059669',
                        confirmButtonText: 'Tutup'
                    });
                } else {
                    Swal.fire({
                        title: 'Syarat & Ketentuan Layanan',
                        html: '<div class="text-left text-xs text-slate-600 space-y-2 leading-relaxed"><p>Ketentuan berbelanja dan berinteraksi di platform Khadir Florist:</p><p>1. Seluruh pesanan bonsai dikemas dengan proteksi kayu bergaransi hidup sampai tujuan.</p><p>2. Klaim garansi kerusakan tanaman wajib menyertakan video unboxing maksimal 1x24 jam setelah paket tiba.</p><p>3. Di area komunitas, postingan promosi jualan hanya diperbolehkan bagi akun resmi Khadir Florist.</p></div>',
                        icon: 'info',
                        confirmButtonColor: '#059669',
                        confirmButtonText: 'Tutup'
                    });
                }
            }
        </script>

        <script>
            // Mobile menu functionality
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileMenu = document.getElementById('mobile-menu');
                const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
                const closeMenuButton = document.getElementById('close-menu');
                const searchToggle = document.getElementById('search-toggle');
                const mobileSearch = document.getElementById('mobile-search');

                // Mobile menu toggle
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.add('active');
                    mobileMenuOverlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });

                // Close mobile menu
                function closeMobileMenu() {
                    mobileMenu.classList.remove('active');
                    mobileMenuOverlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }

                closeMenuButton.addEventListener('click', closeMobileMenu);
                mobileMenuOverlay.addEventListener('click', closeMobileMenu);

                // Mobile search toggle
                searchToggle.addEventListener('click', function() {
                    mobileSearch.classList.toggle('active');
                });

                // Close mobile menu when clicking on menu items
                document.querySelectorAll('#mobile-menu a').forEach(link => {
                    link.addEventListener('click', closeMobileMenu);
                });

                // Page Transition Loader
                const loader = document.getElementById('page-loader');

                window.addEventListener('load', () => {
                    setTimeout(() => {
                        loader.classList.add('hidden-loader');
                    }, 500);
                });

                document.querySelectorAll('a').forEach(link => {
                    if (
                        link.hostname === window.location.hostname &&
                        !link.hash &&
                        !link.getAttribute('target') &&
                        !link.hasAttribute('onclick') &&
                        !link.href.includes('javascript:void(0)') &&
                        !link.href.includes('tel:') &&
                        !link.href.includes('mailto:') &&
                        link.href !== window.location.href + '#'
                    ) {
                        link.addEventListener('click', (e) => {
                            const href = link.href;
                            if (href && !href.startsWith('#')) {
                                e.preventDefault();
                                loader.classList.remove('hidden-loader');
                                setTimeout(() => {
                                    window.location.href = href;
                                }, 400);
                            }
                        });
                    }
                });
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Add to cart AJAX
            window.addToCart = function(productId, isBuyNow) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Silakan login terlebih dahulu untuk berbelanja.'
                    });
                    setTimeout(() => window.location.href = '/login', 2000);
                    return;
                }

                if (isBuyNow) {
                    window.location.href = '/checkout?bonsai_id=' + productId;
                    return;
                }

                fetch('/keranjang', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            bonsai_id: productId,
                            quantity: 1
                        })
                    })
                    .then(response => {
                        if (response.status === 401) {
                            throw new Error('Unauthenticated');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            if (isBuyNow) {
                                window.location.href = '/keranjang';
                            } else {
                                // Show notification using SweetAlert Toast
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                });
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Ditambahkan ke keranjang!'
                                });

                                // Update cart badges if exists
                                document.querySelectorAll('.cart-count-badge, #cart-count').forEach(el => {
                                    if (data.cart_count !== undefined) {
                                        el.textContent = data.cart_count;
                                        if (data.cart_count > 0) {
                                            el.classList.remove('hidden');
                                        } else {
                                            el.classList.add('hidden');
                                        }
                                    }
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data.message || 'Gagal menambahkan produk.'
                            });
                        }
                    })
                    .catch(error => {
                        if (error.message === 'Unauthenticated') {
                            window.location.href = '/login';
                        } else {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan sistem.'
                            });
                        }
                    });
            };

            function confirmLogout(formId) {
                Swal.fire({
                    title: 'Keluar dari Akun?',
                    text: "Anda harus login kembali untuk melakukan pesanan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(formId).submit();
                    }
                });
            }
        </script>

    </div>

    @if(Auth::check() && Auth::user()->role === 'user')
    <div x-data="chatWidget()" x-init="init()"
        :style="getContainerStyle()"
        class="fixed z-[60] select-none"
        style="bottom: 1.5rem; right: 1.5rem;">

        <!-- Chat Bubble (Draggable) -->
        <button type="button"
            @mousedown="startDrag($event)"
            @touchstart="startDrag($event)"
            @click="handleClick()"
            :class="isDragging ? 'cursor-grabbing scale-105 shadow-emerald-500/50' : 'cursor-grab hover:scale-110 active:scale-95'"
            class="w-14 h-14 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full shadow-2xl flex items-center justify-center transition-transform duration-200 group relative touch-none select-none"
            title="Klik untuk membuka pesan / Tahan dan geser untuk memindahkan ikon">
            <i class="fas fa-comment-dots text-2xl group-hover:rotate-12 transition-transform pointer-events-none"></i>
            <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white pointer-events-none"></span>
        </button>

        <!-- Chat Window -->
        <div x-show="open"
            :class="getWindowClass()"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-10 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-10 scale-90"
            class="absolute w-80 sm:w-96 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden flex flex-col h-[500px]"
            style="display: none;">

            <!-- Header -->
            <div class="bg-emerald-600 p-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">RUANGBONSAI Support</h4>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                            <span class="text-[10px] opacity-80">Online</span>
                        </div>
                    </div>
                </div>
                <button @click="open = false" class="hover:bg-white/10 p-2 rounded-lg transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Messages Area -->
            <div id="shop-chat-box" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 dark:bg-slate-900">
                <template x-for="msg in messages" :key="msg.id">
                    <div class="flex" :class="msg.sender_id === '{{ Auth::id() }}' ? 'justify-end' : 'justify-start'">
                        <div :class="msg.sender_id === '{{ Auth::id() }}' ? 'bg-emerald-600 text-white rounded-l-2xl rounded-tr-2xl' : 'bg-white dark:bg-slate-800 text-gray-800 dark:text-slate-100 rounded-r-2xl rounded-tl-2xl shadow-sm border border-gray-100 dark:border-slate-700'"
                            class="max-w-[85%] px-4 py-2.5">


                            <!-- Attachment -->
                            <template x-if="msg.attachment_path">
                                <div class="mb-2">
                                    <template x-if="msg.attachment_type === 'image'">
                                        <img :src="'/storage/' + msg.attachment_path" class="rounded-lg max-w-full h-auto cursor-pointer" @click="window.open('/storage/' + msg.attachment_path)">
                                    </template>
                                    <template x-if="msg.attachment_type === 'video'">
                                        <video controls class="rounded-lg max-w-full h-auto">
                                            <source :src="'/storage/' + msg.attachment_path" type="video/mp4">
                                        </video>
                                    </template>
                                </div>
                            </template>

                            <p x-show="msg.message" class="text-xs leading-relaxed" x-text="msg.message"></p>
                            <p class="text-[8px] mt-1 opacity-60" :class="msg.sender_id === '{{ Auth::id() }}' ? 'text-right' : ''" x-text="formatTime(msg.created_at)"></p>
                        </div>
                    </div>
                </template>
                <div x-show="messages.length === 0" class="text-center py-10">
                    <i class="fas fa-leaf text-gray-200 text-4xl mb-2"></i>
                    <p class="text-xs text-gray-400">Ada yang bisa kami bantu?</p>
                </div>
            </div>

            <!-- Preview Area -->
            <div x-show="filePreview" class="px-4 py-2 bg-gray-100 border-t border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <template x-if="fileType === 'image'">
                        <img :src="filePreview" class="w-8 h-8 rounded object-cover">
                    </template>
                    <template x-if="fileType === 'video'">
                        <div class="w-8 h-8 rounded bg-black flex items-center justify-center text-white text-[8px]">
                            <i class="fas fa-video"></i>
                        </div>
                    </template>
                    <span class="text-[10px] text-gray-500 truncate max-w-[150px]" x-text="fileName"></span>
                </div>
                <button @click="clearFile()" class="text-red-500"><i class="fas fa-times-circle"></i></button>
            </div>

            <!-- Input Area -->
            <div class="p-4 bg-white border-t border-gray-100">
                <form @submit.prevent="sendMessage()" class="flex items-end gap-2">
                    <button type="button" @click="$refs.shopFileInput.click()" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-emerald-600 rounded-xl transition">
                        <i class="fas fa-paperclip text-lg"></i>
                    </button>
                    <input type="file" x-ref="shopFileInput" class="hidden" @change="handleFileSelect($event)" accept="image/*,video/*">

                    <textarea x-model="newMessage" rows="1" placeholder="Tulis pesan..." @keydown.enter.prevent="sendMessage()"
                        class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition resize-none"></textarea>

                    <button type="submit" :disabled="!newMessage.trim() && !fileSelected"
                        class="w-10 h-10 flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-lg transition-all active:scale-95 disabled:opacity-50">
                        <i class="fas fa-paper-plane text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function chatWidget() {
            return {
                open: false,
                messages: [],
                newMessage: '',
                unreadCount: 0,
                interval: null,
                fileSelected: null,
                filePreview: null,
                fileType: null,
                fileName: '',

                // Draggable states
                posX: null,
                posY: null,
                isDragging: false,
                hasMoved: false,
                startX: 0,
                startY: 0,
                initialPosX: 0,
                initialPosY: 0,

                async init() {
                    // Restore saved position or use default
                    try {
                        const saved = localStorage.getItem('bonsaiku_chat_pos');
                        if (saved) {
                            const parsed = JSON.parse(saved);
                            const maxX = Math.max(10, window.innerWidth - 75);
                            const maxY = Math.max(10, window.innerHeight - 75);
                            this.posX = Math.max(10, Math.min(maxX, parsed.x));
                            this.posY = Math.max(10, Math.min(maxY, parsed.y));
                        }
                    } catch (e) {}

                    window.addEventListener('resize', () => {
                        if (this.posX !== null && this.posY !== null) {
                            const maxX = Math.max(10, window.innerWidth - 75);
                            const maxY = Math.max(10, window.innerHeight - 75);
                            this.posX = Math.max(10, Math.min(maxX, this.posX));
                            this.posY = Math.max(10, Math.min(maxY, this.posY));
                        }
                    });

                    await this.fetchMessages();
                    @auth
                    if (window.Echo) {
                        window.Echo.private('chat.{{ Auth::id() }}')
                            .listen('.message.sent', (e) => {
                                if (e.message && !this.messages.some(m => m.id === e.message.id)) {
                                    this.messages.push(e.message);
                                    if (!this.open) {
                                        this.unreadCount++;
                                    } else {
                                        this.markAsRead();
                                        setTimeout(() => this.scrollToBottom(), 100);
                                    }
                                }
                            });
                    }

                    // Fallback polling saat widget chat sedang dibuka
                    setInterval(() => {
                        if (!document.hidden && this.open) {
                            this.fetchMessages();
                        }
                    }, 4000);
                    @endauth
                },

                startDrag(e) {
                    const isTouch = e.type === 'touchstart';
                    const clientX = isTouch ? e.touches[0].clientX : e.clientX;
                    const clientY = isTouch ? e.touches[0].clientY : e.clientY;

                    this.hasMoved = false;
                    this.startX = clientX;
                    this.startY = clientY;

                    const el = e.currentTarget.parentElement;
                    const rect = el.getBoundingClientRect();
                    this.initialPosX = rect.left;
                    this.initialPosY = rect.top;

                    const onMove = (moveEvt) => {
                        const mX = isTouch ? moveEvt.touches[0].clientX : moveEvt.clientX;
                        const mY = isTouch ? moveEvt.touches[0].clientY : moveEvt.clientY;
                        const dx = mX - this.startX;
                        const dy = mY - this.startY;

                        if (Math.hypot(dx, dy) > 5) {
                            this.hasMoved = true;
                            this.isDragging = true;
                            if (isTouch && moveEvt.cancelable) {
                                moveEvt.preventDefault();
                            }

                            const maxX = Math.max(10, window.innerWidth - 75);
                            const maxY = Math.max(10, window.innerHeight - 75);
                            this.posX = Math.max(10, Math.min(maxX, this.initialPosX + dx));
                            this.posY = Math.max(10, Math.min(maxY, this.initialPosY + dy));
                        }
                    };

                    const onEnd = () => {
                        window.removeEventListener(isTouch ? 'touchmove' : 'mousemove', onMove);
                        window.removeEventListener(isTouch ? 'touchend' : 'mouseup', onEnd);

                        if (this.hasMoved && this.posX !== null && this.posY !== null) {
                            try {
                                localStorage.setItem('bonsaiku_chat_pos', JSON.stringify({
                                    x: this.posX,
                                    y: this.posY
                                }));
                            } catch (e) {}
                        }

                        setTimeout(() => {
                            this.isDragging = false;
                        }, 50);
                    };

                    window.addEventListener(isTouch ? 'touchmove' : 'mousemove', onMove, {
                        passive: false
                    });
                    window.addEventListener(isTouch ? 'touchend' : 'mouseup', onEnd);
                },

                handleClick() {
                    if (this.hasMoved) {
                        return; // Sedang digeser, jangan buka/tutup chat
                    }
                    this.toggle();
                },

                getContainerStyle() {
                    if (this.posX === null || this.posY === null) {
                        return 'bottom: 1.5rem; right: 1.5rem;';
                    }
                    return `left: ${this.posX}px; top: ${this.posY}px; bottom: auto; right: auto;`;
                },

                getWindowClass() {
                    const isRight = this.posX === null || this.posX > (window.innerWidth / 2);
                    const isTop = this.posY !== null && this.posY < 520;

                    let classes = [];
                    if (isRight) {
                        classes.push('right-0');
                    } else {
                        classes.push('left-0');
                    }

                    if (isTop) {
                        classes.push('top-16');
                    } else {
                        classes.push('bottom-20');
                    }

                    return classes.join(' ');
                },

                handleFileSelect(e) {
                    const file = e.target.files[0];
                    if (!file) return;
                    this.fileSelected = file;
                    this.fileName = file.name;
                    this.fileType = file.type.includes('image') ? 'image' : 'video';
                    if (this.fileType === 'image') {
                        const reader = new FileReader();
                        reader.onload = (e) => this.filePreview = e.target.result;
                        reader.readAsDataURL(file);
                    } else {
                        this.filePreview = 'video';
                    }
                },

                clearFile() {
                    this.fileSelected = null;
                    this.filePreview = null;
                    this.fileType = null;
                    this.fileName = '';
                    this.$refs.shopFileInput.value = '';
                },

                toggle() {
                    this.open = !this.open;
                    if (this.open) {
                        this.unreadCount = 0;
                        this.markAsRead();
                        setTimeout(() => this.scrollToBottom(), 100);
                    }
                },

                async markAsRead() {
                    try {
                        await fetch('{{ route('shop.chat.markRead') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                    } catch (e) {}
                },

                async fetchMessages() {
                    try {
                        const res = await fetch('{{ route('shop.chat.messages') }}');
                        const data = await res.json();

                        this.messages = data.messages;
                        if (!this.open) {
                            this.unreadCount = data.unread_count;
                        } else {
                            this.unreadCount = 0;
                            if (data.unread_count > 0) this.markAsRead();
                            this.$nextTick(() => this.scrollToBottom());
                        }
                    } catch (e) {
                        console.error('Chat fetch error', e);
                    }
                },

                async sendMessage() {
                    if (!this.newMessage.trim() && !this.fileSelected) return;

                    const msgText = this.newMessage;
                    const receiverId = '{{ \App\Models\User::where('role', 'admin')->first()->id ?? '' }}';
                    const formData = new FormData();
                    formData.append('message', msgText);
                    formData.append('receiver_id', receiverId);
                    if (this.fileSelected) formData.append('attachment', this.fileSelected);

                    this.newMessage = '';
                    this.clearFile();

                    try {
                        const res = await fetch('{{ route('shop.chat.send') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const data = await res.json();
                        if (data.success) {
                            this.messages.push(data.message);
                            setTimeout(() => this.scrollToBottom(), 100);
                        }
                    } catch (e) {
                        console.error('Chat send error', e);
                    }
                },

                scrollToBottom() {
                    const box = document.getElementById('shop-chat-box');
                    if (box) box.scrollTop = box.scrollHeight;
                },

                formatTime(dateStr) {
                    const date = new Date(dateStr);
                    return date.getHours().toString().padStart(2, '0') + ':' + date.getMinutes().toString().padStart(2, '0');
                }
            }
        }
    </script>
    @endif

    <script>
        function downloadStrukPdf(event, url) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            // Unduh file secara instan di background tanpa reload halaman dan tanpa animasi
            let iframe = document.getElementById('hidden-download-frame');
            if (!iframe) {
                iframe = document.createElement('iframe');
                iframe.id = 'hidden-download-frame';
                iframe.style.display = 'none';
                document.body.appendChild(iframe);
            }
            iframe.src = url;
        }
    </script>
</body>

</html>