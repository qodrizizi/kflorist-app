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
                <div class="hidden lg:flex space-x-8">
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
                </div>

                
                <!-- Desktop Search & Icons -->
                <div class="hidden md:flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Cari bonsai..." class="pl-10 pr-4 py-2 border rounded-full focus:outline-none focus:border-green-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
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
                <a href="{{ route('shop.produk') }}" class="block py-3 px-4 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition">
                    <i class="fas fa-leaf mr-3"></i>Produk
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
    <footer class="bg-gray-900 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Company Info -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-green-500 p-2 rounded-lg">
                            <i class="fas fa-leaf text-white text-xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">BonsaiKu</h4>
                    </div>
                    <p class="text-gray-400 leading-relaxed">
                        Destinasi terpercaya untuk koleksi bunga dan bonsai berkualitas premium. Kami menghadirkan keindahan alam langsung ke depan pintu Anda dengan pelayanan terbaik.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-green-500 hover:text-white transition-all duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-green-500 hover:text-white transition-all duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-green-500 hover:text-white transition-all duration-300">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-green-500 hover:text-white transition-all duration-300">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h5 class="text-lg font-bold mb-6 flex items-center">
                        <span class="w-8 h-1 bg-green-500 mr-3 rounded-full"></span>
                        Koleksi Produk
                    </h5>
                    <ul class="space-y-4">
                        <li>
                            <a href="{{ route('shop.produk', ['kategori' => 'Indoor']) }}" class="text-gray-400 hover:text-green-500 hover:translate-x-2 flex items-center transition-all duration-300">
                                <i class="fas fa-chevron-right text-[10px] mr-3 opacity-50"></i>
                                Bonsai Indoor
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.produk', ['kategori' => 'Outdoor']) }}" class="text-gray-400 hover:text-green-500 hover:translate-x-2 flex items-center transition-all duration-300">
                                <i class="fas fa-chevron-right text-[10px] mr-3 opacity-50"></i>
                                Bonsai Outdoor
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.produk', ['kategori' => 'Premium']) }}" class="text-gray-400 hover:text-green-500 hover:translate-x-2 flex items-center transition-all duration-300">
                                <i class="fas fa-chevron-right text-[10px] mr-3 opacity-50"></i>
                                Koleksi Premium
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.produk', ['kategori' => 'Bibit']) }}" class="text-gray-400 hover:text-green-500 hover:translate-x-2 flex items-center transition-all duration-300">
                                <i class="fas fa-chevron-right text-[10px] mr-3 opacity-50"></i>
                                Bibit & Bakalan
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h5 class="text-lg font-bold mb-6 flex items-center">
                        <span class="w-8 h-1 bg-green-500 mr-3 rounded-full"></span>
                        Layanan
                    </h5>
                    <ul class="space-y-4">
                        <li>
                            <a href="{{ route('shop.tentang') }}" class="text-gray-400 hover:text-green-500 hover:translate-x-2 flex items-center transition-all duration-300">
                                <i class="fas fa-chevron-right text-[10px] mr-3 opacity-50"></i>
                                Tentang Kami
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.pesanan') }}" class="text-gray-400 hover:text-green-500 hover:translate-x-2 flex items-center transition-all duration-300">
                                <i class="fas fa-chevron-right text-[10px] mr-3 opacity-50"></i>
                                Lacak Pesanan
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-green-500 hover:translate-x-2 flex items-center transition-all duration-300">
                                <i class="fas fa-chevron-right text-[10px] mr-3 opacity-50"></i>
                                Syarat & Ketentuan
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-green-500 hover:translate-x-2 flex items-center transition-all duration-300">
                                <i class="fas fa-chevron-right text-[10px] mr-3 opacity-50"></i>
                                Kebijakan Privasi
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h5 class="text-lg font-bold mb-6 flex items-center">
                        <span class="w-8 h-1 bg-green-500 mr-3 rounded-full"></span>
                        Hubungi Kami
                    </h5>
                    <ul class="space-y-4">
                        <li class="flex items-start group">
                            <div class="bg-gray-800 p-2 rounded-lg mr-4 group-hover:bg-green-500/20 transition-colors">
                                <i class="fas fa-map-marker-alt text-green-500"></i>
                            </div>
                            <span class="text-gray-400 text-sm leading-relaxed">
                                Jl. Bilal No. 123, Pulo Brayan Darat I, Kec. Medan Timur, Kota Medan, Sumatera Utara 20239
                            </span>
                        </li>
                        <li class="flex items-center group">
                            <div class="bg-gray-800 p-2 rounded-lg mr-4 group-hover:bg-green-500/20 transition-colors">
                                <i class="fas fa-phone text-green-500"></i>
                            </div>
                            <a href="tel:+6281234567890" class="text-gray-400 hover:text-white transition-colors">+62 812-3456-7890</a>
                        </li>
                        <li class="flex items-center group">
                            <div class="bg-gray-800 p-2 rounded-lg mr-4 group-hover:bg-green-500/20 transition-colors">
                                <i class="fas fa-envelope text-green-500"></i>
                            </div>
                            <a href="mailto:admin@bonsaiku.com" class="text-gray-400 hover:text-white transition-colors">admin@bonsaiku.com</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-16 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <p class="text-gray-500 text-sm">
                        &copy; 2025 <span class="text-green-500 font-semibold">BonsaiKu</span>. Semua Hak Cipta Dilindungi.
                    </p>
                    <div class="flex items-center space-x-6">
                        <i class="fab fa-cc-visa text-3xl text-gray-500 hover:text-[#1a1f71] transition-colors cursor-help" title="Visa"></i>
                        <i class="fab fa-cc-mastercard text-3xl text-gray-500 hover:text-[#eb001b] transition-colors cursor-help" title="Mastercard"></i>
                        <i class="fab fa-cc-jcb text-3xl text-gray-500 hover:text-[#0034a8] transition-colors cursor-help" title="JCB"></i>
                        <div class="flex items-center bg-gray-800 px-3 py-1 rounded-lg border border-gray-700 hover:border-green-500 transition-colors group">
                            <span class="text-[10px] font-bold text-gray-500 group-hover:text-white mr-2">Secured by</span>
                            <img src="https://assets.midtrans.com/img/logo-midtrans-color.png" 
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" 
                                 alt="Midtrans" class="h-4 brightness-0 invert opacity-60 group-hover:opacity-100 transition-opacity">
                            <span class="hidden text-[10px] font-bold text-green-500">MIDTRANS</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER END -->

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

    @auth
    <div x-data="chatWidget()" x-init="init()" class="fixed bottom-6 right-6 z-[60]">
        <!-- Chat Bubble -->
        <button @click="toggle()" 
                class="w-14 h-14 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 group relative">
            <i class="fas fa-comment-dots text-2xl group-hover:rotate-12 transition-transform"></i>
            <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white"></span>
        </button>

        <!-- Chat Window -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-10 scale-90"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-10 scale-90"
             class="absolute bottom-20 right-0 w-80 sm:w-96 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden flex flex-col h-[500px]"
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

                async init() {
                    await this.fetchMessages();
                    this.interval = setInterval(() => this.fetchMessages(), 3000);
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
    @endauth
</body>
</html>