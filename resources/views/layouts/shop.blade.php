<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BonsaiKu - Toko Bonsai Online Terpercaya</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logonobg.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
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
            max-height: 80px;
        }
        
        /* Map container */
        .map-container {
            height: 250px;
            border-radius: 12px;
            overflow: hidden;
        }
        
        /* Main content spacing */
        .main-content {
            min-height: calc(100vh - 80px); /* Adjust based on header height */
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
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.2); }
            100% { transform: rotate(360deg) scale(1); }
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
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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
            border-radius: 1.5rem !important; /* 24px */
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
            border-radius: 0.875rem !important; /* 14px */
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
            border-radius: 1rem !important; /* 16px */
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
<body class="bg-gray-50">

    <!-- PAGE LOADER START -->
    <div id="page-loader" class="fixed inset-0 z-[100] flex flex-col items-center justify-center">
        <div class="relative">
            <div class="w-20 h-20 border-4 border-green-100 rounded-full"></div>
            <div class="w-20 h-20 border-t-4 border-green-500 rounded-full absolute top-0 left-0 animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <i class="fas fa-leaf text-3xl text-green-500 loader-leaf"></i>
            </div>
        </div>
        <div class="mt-6 flex flex-col items-center">
            <h3 class="text-xl font-bold text-gray-800 tracking-wider">BONSAIKU</h3>
            <div class="flex space-x-1 mt-2">
                <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
            </div>
        </div>
    </div>
    <!-- PAGE LOADER END -->

    <div class="page-fade-in">

    <!-- HEADER START -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="{{ route('shop.index') }}" class="flex items-center space-x-2 group">
                    <i class="fas fa-leaf text-green-600 text-2xl group-hover:rotate-12 transition-transform"></i>
                    <h1 class="text-2xl font-bold text-gray-800">BonsaiKu</h1>
                </a>
                
                <!-- Desktop Menu -->
                <div class="hidden lg:flex space-x-8 items-center">
                    <a href="{{ route('shop.index') }}" 
                    class="{{ request()->routeIs('shop.index') ? 'text-green-600 font-semibold' : 'text-gray-600 hover:text-green-600' }} transition">
                    Beranda
                    </a>
                    <a href="{{ route('shop.tentang') }}" 
                    class="{{ request()->routeIs('shop.tentang') ? 'text-green-600 font-semibold' : 'text-gray-600 hover:text-green-600' }} transition">
                    Tentang
                    </a>
                    <a href="{{ route('shop.kategori') }}" 
                    class="{{ request()->routeIs('shop.kategori') ? 'text-green-600 font-semibold' : 'text-gray-600 hover:text-green-600' }} transition">
                    Kategori
                    </a>
                    <a href="{{ route('shop.produk') }}" 
                    class="{{ request()->routeIs('shop.produk') ? 'text-green-600 font-semibold' : 'text-gray-600 hover:text-green-600' }} transition">
                    Produk
                    </a>
                    <a href="{{ route('shop.komunitas') }}" 
                    class="{{ request()->routeIs('shop.komunitas') ? 'text-green-600 font-semibold' : 'text-gray-600 hover:text-green-600' }} transition inline-flex items-center gap-1.5">
                    <span>Komunitas</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 tracking-wide uppercase">Baru</span>
                    </a>
                </div>

                
                <!-- Desktop Search & Icons -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- <div class="relative">
                        <input type="text" placeholder="Cari bonsai..." class="pl-10 pr-4 py-2 border rounded-full focus:outline-none focus:border-green-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div> -->
                    @auth
                        <a href="{{ route('shop.pesanan') }}" title="Pesanan Saya" class="fas fa-receipt text-gray-600 text-xl cursor-pointer hover:text-green-600"></a>
                    @endauth
                    <a href="{{ route('shop.keranjang') }}" title="Keranjang" class="fas fa-shopping-cart text-gray-600 text-xl cursor-pointer hover:text-green-600"></a>
                    {{-- Navbar User --}}
                    @auth
                        @php
                            // Ambil inisial user
                            $name = Auth::user()->name;
                            $initial = strtoupper(substr($name, 0, 1)); // huruf pertama
                        @endphp

                        <div class="relative group">
                            <button class="flex items-center justify-center w-10 h-10 rounded-full bg-emerald-500 text-white font-bold hover:bg-emerald-600 transition-colors focus:outline-none ring-2 ring-transparent group-hover:ring-emerald-200 overflow-hidden">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ $name }}" class="w-full h-full object-cover">
                                @else
                                    {{ $initial }}
                                @endif
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right group-hover:translate-y-0 translate-y-2 z-50">
                                <div class="p-2 space-y-1">
                                    <div class="px-3 py-2 border-b border-gray-100 mb-2">
                                        <p class="text-xs text-gray-500">Masuk sebagai</p>
                                        <p class="text-sm font-bold text-gray-800 truncate">{{ $name }}</p>
                                    </div>
                                    <a href="{{ route('shop.profile') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-lg transition-colors">
                                        <i class="fas fa-user-circle mr-3 w-4 text-center"></i> Profil Saya
                                    </a>
                                    <a href="{{ route('shop.pesanan') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-lg transition-colors">
                                        <i class="fas fa-receipt mr-3 w-4 text-center"></i> Pesanan Saya
                                    </a>
                                    <button onclick="confirmLogout('logout-form-desktop')" class="w-full text-left flex items-center px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors mt-1">
                                        <i class="fas fa-sign-out-alt mr-3 w-4 text-center"></i> Keluar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Form Logout Hidden -->
                        <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @else
                        {{-- Kalau belum login --}}
                        <a href="{{ route('login') }}" class="fas fa-user text-gray-600 text-xl cursor-pointer hover:text-green-600"></a>
                    @endauth

                </div>
                
                <!-- Mobile Icons -->
                <div class="md:hidden flex items-center space-x-4">
                    <i id="search-toggle" class="fas fa-search text-gray-600 text-xl cursor-pointer hover:text-green-600"></i>
                    @auth
                        <a href="{{ route('shop.pesanan') }}" class="fas fa-receipt text-gray-600 text-xl cursor-pointer hover:text-green-600"></a>
                    @endauth
                    <a href="{{ route('shop.keranjang') }}"  class="fas fa-shopping-cart text-gray-600 text-xl cursor-pointer hover:text-green-600"></a>
                    
                    @auth
                        @php
                            $name = Auth::user()->name;
                            $initial = strtoupper(substr($name, 0, 1));
                        @endphp
                        <a href="{{ route('shop.profile') }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500 text-white font-bold hover:bg-emerald-600 text-sm overflow-hidden">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ $name }}" class="w-full h-full object-cover">
                            @else
                                {{ $initial }}
                            @endif
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="fas fa-user text-gray-600 text-xl cursor-pointer hover:text-green-600"></a>
                    @endauth

                    <button id="mobile-menu-button" class="lg:hidden">
                        <i class="fas fa-bars text-gray-600 text-xl hover:text-green-600"></i>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Search Bar -->
            <div id="mobile-search" class="mobile-search md:hidden">
                <div class="pb-4">
                    <div class="relative">
                        <input type="text" placeholder="Cari bonsai..." class="w-full pl-10 pr-4 py-2 border rounded-full focus:outline-none focus:border-green-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="mobile-menu fixed left-0 top-0 w-80 h-full bg-white shadow-xl z-50 lg:hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-leaf text-green-600 text-2xl"></i>
                    <h2 class="text-xl font-bold text-gray-800">BonsaiKu</h2>
                </div>
                <button id="close-menu">
                    <i class="fas fa-times text-gray-600 text-xl hover:text-green-600"></i>
                </button>
            </div>
            <nav class="space-y-4">
                <a href="{{ route('shop.index') }}" class="block py-3 px-4 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition">
                    <i class="fas fa-home mr-3"></i>Beranda
                </a>
                <a href="{{ route('shop.tentang') }}" class="block py-3 px-4 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition">
                    <i class="fas fa-info-circle mr-3"></i>Tentang
                </a>
                <a href="{{ route('shop.kategori') }}" class="block py-3 px-4 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition">
                    <i class="fas fa-th-large mr-3"></i>Kategori
                </a>
                <a href="{{ route('shop.produk') }}" class="block py-3 px-4 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition {{ request()->routeIs('shop.produk') ? 'bg-green-50 text-green-600 font-semibold' : '' }}">
                    <i class="fas fa-leaf mr-3"></i>Produk
                </a>
                <a href="{{ route('shop.komunitas') }}" class="block py-3 px-4 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition {{ request()->routeIs('shop.komunitas') ? 'bg-green-50 text-green-600 font-semibold' : '' }}">
                    <i class="fas fa-users mr-3"></i>Komunitas
                </a>

                <div class="border-t pt-4 mt-4">
                    @auth
                        <a href="{{ route('shop.profile') }}" class="block py-3 px-4 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition">
                            <i class="fas fa-user mr-3"></i>Akun Saya
                        </a>
                        <a href="{{ route('shop.pesanan') }}" class="block py-3 px-4 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition">
                            <i class="fas fa-receipt mr-3"></i>Pesanan Saya
                        </a>
                        <a href="#" onclick="event.preventDefault(); confirmLogout('mobile-logout-form');" class="block py-3 px-4 text-red-600 hover:bg-red-50 hover:text-red-700 rounded-lg transition">
                            <i class="fas fa-sign-out-alt mr-3"></i>Keluar
                        </a>
                        <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block py-3 px-4 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition">
                            <i class="fas fa-sign-in-alt mr-3"></i>Masuk
                        </a>
                        <a href="{{ route('register') }}" class="block py-3 px-4 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition">
                            <i class="fas fa-user-plus mr-3"></i>Daftar
                        </a>
                    @endauth
                </div>
            </nav>
        </div>
    </div>
    <!-- HEADER END -->

    @yield('content')

    <!-- FOOTER START -->
    <footer class="relative text-white pt-16 pb-12 overflow-hidden bg-slate-950">
        <!-- Background Wallpaper: footer.webp -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-20 pointer-events-none scale-105"
             style="background-image: url('{{ asset('images/footer.webp') }}');"></div>
        <!-- Deep Gradient Overlay for text contrast -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/92 to-slate-950/85 pointer-events-none"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12">
                <!-- Company Info -->
                <div class="space-y-5">
                    <div class="flex items-center space-x-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center p-2 shadow-inner">
                            <img src="{{ asset('images/logonobg.png') }}" alt="Logo BonsaiKu" class="w-full h-full object-contain"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'%2334d399\'><path d=\'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.4z\'/></svg>'">
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-extrabold tracking-widest text-emerald-400 block">Khadir Florist</span>
                            <h4 class="text-2xl font-extrabold text-white leading-tight">BonsaiKu</h4>
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
                            <a href="mailto:admin@bonsaiku.com" class="text-gray-400 text-xs hover:text-emerald-400 transition-colors">admin@bonsaiku.com</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Copyright & Policy Links Bar (Replaces Midtrans) -->
            <div class="border-t border-slate-800/90 mt-12 pt-7">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
                    <p class="text-gray-400 text-xs">
                        &copy; {{ date('Y') }} <span class="text-emerald-400 font-bold">Khadir Florist • BonsaiKu</span>. Seluruh Hak Cipta Dilindungi.
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
                    html: '<div class="text-left text-xs text-slate-600 space-y-2 leading-relaxed"><p>Khadir Florist (BonsaiKu) berkomitmen melindungi kerahasiaan data pribadi seluruh pelanggan dan anggota komunitas kami.</p><p>1. Informasi akun & alamat hanya digunakan untuk pemrosesan pesanan dan pengiriman tanaman.</p><p>2. Data transaksi dilindungi dengan enkripsi keamanan standar tinggi.</p><p>3. Kami tidak pernah membagikan atau menjual data Anda kepada pihak ketiga.</p></div>',
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
            anchor.addEventListener('click', function (e) {
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
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan login terlebih dahulu untuk berbelanja.' });
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

                        // Update cart badge if exists
                        const cartCountElem = document.getElementById('cart-count');
                        if (cartCountElem && data.cart_count !== undefined) {
                            cartCountElem.textContent = data.cart_count;
                            cartCountElem.classList.remove('hidden');
                        }
                    }
                } else {
                    Swal.fire({ icon: 'error', title: 'Oops...', text: data.message || 'Gagal menambahkan produk.' });
                }
            })
            .catch(error => {
                if (error.message === 'Unauthenticated') {
                    window.location.href = '/login';
                } else {
                    console.error('Error:', error);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan sistem.' });
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
                        <h4 class="font-bold text-sm">BonsaiKu Support</h4>
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
            <div id="shop-chat-box" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
                <template x-for="msg in messages" :key="msg.id">
                    <div class="flex" :class="msg.sender_id === '{{ Auth::id() }}' ? 'justify-end' : 'justify-start'">
                        <div :class="msg.sender_id === '{{ Auth::id() }}' ? 'bg-emerald-600 text-white rounded-l-2xl rounded-tr-2xl' : 'bg-white text-gray-800 rounded-r-2xl rounded-tl-2xl shadow-sm border border-gray-100'" 
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
                                localStorage.setItem('bonsaiku_chat_pos', JSON.stringify({ x: this.posX, y: this.posY }));
                            } catch (e) {}
                        }

                        setTimeout(() => {
                            this.isDragging = false;
                        }, 50);
                    };

                    window.addEventListener(isTouch ? 'touchmove' : 'mousemove', onMove, { passive: false });
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
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
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
                    } catch (e) { console.error('Chat fetch error', e); }
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
                    } catch (e) { console.error('Chat send error', e); }
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
</body>
</html>