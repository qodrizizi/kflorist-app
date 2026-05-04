<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BonsaiKu - Toko Bonsai Online Terpercaya</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logonobg.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
    </style>
</head>
<body class="bg-gray-50">

    <!-- HEADER START -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <i class="fas fa-leaf text-green-600 text-2xl"></i>
                    <h1 class="text-2xl font-bold text-gray-800">BonsaiKu</h1>
                </div>
                
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
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:gri d-cols-2 lg:grid-cols-5 gap-8">
                <!-- Company Info -->
                <div class="lg:col-span-1">
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-leaf text-green-500 text-2xl"></i>
                        <h4 class="text-xl font-bold">BonsaiKu</h4>
                    </div>
                    <p class="text-gray-400 mb-4">Toko bonsai online terpercaya dengan koleksi terlengkap di Indonesia</p>
                    <div class="flex space-x-3">
                        <a href="#" class="text-gray-400 hover:text-green-500 transition">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-green-500 transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-green-500 transition">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-green-500 transition">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Products -->
                <div>
                    <h5 class="font-semibold mb-4">Produk</h5>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Bonsai Indoor</a></li>
                        <li><a href="#" class="hover:text-white transition">Bonsai Outdoor</a></li>
                        <li><a href="#" class="hover:text-white transition">Aksesori</a></li>
                        <li><a href="#" class="hover:text-white transition">Pupuk & Perawatan</a></li>
                        <li><a href="#" class="hover:text-white transition">Pot & Wadah</a></li>
                    </ul>
                </div>
                
                <!-- Help -->
                <div>
                    <h5 class="font-semibold mb-4">Bantuan</h5>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Cara Pemesanan</a></li>
                        <li><a href="#" class="hover:text-white transition">Panduan Perawatan</a></li>
                        <li><a href="#" class="hover:text-white transition">Kebijakan Return</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">Live Chat</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h5 class="font-semibold mb-4">Kontak</h5>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 text-green-500"></i> 
                            <a href="tel:+6281234567890" class="hover:text-white transition">+62 812-3456-7890</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-green-500"></i> 
                            <a href="mailto:info@bonsaiku.com" class="hover:text-white transition">info@bonsaiku.com</a>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mr-3 mt-1 text-green-500"></i> 
                            <span>Jl. Tanaman Hias No. 123<br>Kebayoran Baru, Jakarta Selatan<br>12240, Indonesia</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-3 text-green-500"></i> 
                            <span>Senin - Sabtu: 08:00 - 17:00</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Map -->
                <div>
                    <h5 class="font-semibold mb-4">Lokasi Kami</h5>
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.746311147726!2d106.79707831535!3d-6.2087634630447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sSetiabudi%20One!5e0!3m2!1sen!2sid!4v1642751234567!5m2!1sen!2sid" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            class="rounded-lg">
                        </iframe>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 mb-4 md:mb-0">&copy; 2025 BonsaiKu. Semua hak cipta dilindungi.</p>
                    <div class="flex space-x-6 text-gray-400 text-sm">
                        <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
                        <a href="#" class="hover:text-white transition">Kebijakan Privasi</a>
                        <a href="#" class="hover:text-white transition">Cookie Policy</a>
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
</body>
</html>