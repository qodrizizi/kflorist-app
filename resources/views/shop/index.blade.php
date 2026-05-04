@extends('layouts.shop')

@section('content')

    <!-- Hero Section dengan Gradient Overlay yang Lebih Menarik -->
    <section id="home" class="min-h-screen flex items-center relative overflow-hidden" 
             style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.8), rgba(59, 130, 246, 0.6)), url('{{ asset('images/bghero.png') }}') center center / cover no-repeat;">
        <div class="container mx-auto px-4 z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-white space-y-6">
                    <div class="animate-fade-in-up">
                        <span class="inline-block bg-green-400/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium mb-4 border border-green-300/30">
                            🌿 Koleksi Eksklusif Terbaru
                        </span>
                        <h1 class="text-5xl lg:text-6xl font-bold leading-tight">
                            Koleksi Bonsai 
                            <span class="bg-gradient-to-r from-green-300 to-emerald-200 bg-clip-text text-transparent">Terbaik</span> 
                            untuk Rumah Anda
                        </h1>
                    </div>
                    <p class="text-xl text-blue-50/90 leading-relaxed">
                        Temukan keindahan dan kedamaian dengan koleksi bonsai premium kami. 
                        Dari pemula hingga kolektor berpengalaman.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <button class="group bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 px-8 py-4 rounded-full text-white font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                            <i class="fas fa-shopping-bag mr-2 group-hover:animate-bounce"></i>
                            Belanja Sekarang
                        </button>
                        <button class="border-2 border-white/80 text-white hover:bg-white hover:text-blue-600 px-8 py-4 rounded-full font-semibold transition-all duration-300 backdrop-blur-sm">
                            <i class="fas fa-play mr-2"></i>
                            Lihat Katalog
                        </button>
                    </div>
                </div>
                
                <!-- Stats Card yang Menarik -->
                <div class="relative">
                    <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center group hover:scale-105 transition-transform duration-300">
                                <div class="bg-gradient-to-br from-green-400 to-emerald-500 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-seedling text-white text-xl"></i>
                                </div>
                                <p class="text-white font-bold text-lg">500+</p>
                                <p class="text-white/80 text-sm">Varietas</p>
                            </div>
                            <div class="text-center group hover:scale-105 transition-transform duration-300">
                                <div class="bg-gradient-to-br from-blue-400 to-indigo-500 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-shipping-fast text-white text-xl"></i>
                                </div>
                                <p class="text-white font-bold text-lg">Gratis</p>
                                <p class="text-white/80 text-sm">Ongkir</p>
                            </div>
                            <div class="text-center group hover:scale-105 transition-transform duration-300">
                                <div class="bg-gradient-to-br from-yellow-400 to-orange-500 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-medal text-white text-xl"></i>
                                </div>
                                <p class="text-white font-bold text-lg">100%</p>
                                <p class="text-white/80 text-sm">Terjamin</p>
                            </div>
                            <div class="text-center group hover:scale-105 transition-transform duration-300">
                                <div class="bg-gradient-to-br from-purple-400 to-pink-500 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-headset text-white text-xl"></i>
                                </div>
                                <p class="text-white font-bold text-lg">24/7</p>
                                <p class="text-white/80 text-sm">Support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator dengan Animasi -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#categories" class="text-white text-2xl hover:text-green-300 transition-colors">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Categories Section dengan Hover Effects -->
    <section id="categories" class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-green-600 font-semibold text-sm tracking-wider uppercase">Pilihan Kategori</span>
                <h2 class="text-4xl font-bold text-gray-800 mt-2">Kategori Bonsai</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-emerald-500 mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="group category-card bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-8 text-white text-center cursor-pointer hover:scale-105 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-tree text-4xl mb-4 group-hover:scale-110 transition-transform duration-300 relative z-10"></i>
                    <h4 class="font-semibold text-lg relative z-10">Bonsai Indoor</h4>
                </div>
                <div class="group category-card bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl p-8 text-white text-center cursor-pointer hover:scale-105 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-sun text-4xl mb-4 group-hover:scale-110 transition-transform duration-300 relative z-10"></i>
                    <h4 class="font-semibold text-lg relative z-10">Bonsai Outdoor</h4>
                </div>
                <div class="group category-card bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl p-8 text-white text-center cursor-pointer hover:scale-105 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-star text-4xl mb-4 group-hover:scale-110 transition-transform duration-300 relative z-10"></i>
                    <h4 class="font-semibold text-lg relative z-10">Bonsai Premium</h4>
                </div>
                <div class="group category-card bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl p-8 text-white text-center cursor-pointer hover:scale-105 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-seedling text-4xl mb-4 group-hover:scale-110 transition-transform duration-300 relative z-10"></i>
                    <h4 class="font-semibold text-lg relative z-10">Bibit Bonsai</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-green-600 font-semibold text-sm tracking-wider uppercase">Koleksi Terpilih</span>
                <h2 class="text-4xl font-bold text-gray-800 mt-2">Produk Terlaris</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Koleksi bonsai pilihan yang paling diminati pelanggan dengan kualitas terbaik</p>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-emerald-500 mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" id="product-grid"></div>

            <div class="text-center mt-16">
                <a href="{{ route('shop.produk') }}" class="group inline-flex items-center bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-10 py-4 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    Lihat Semua Produk
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 bg-gradient-to-br from-gray-50 via-white to-green-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-green-600 font-semibold text-sm tracking-wider uppercase">Keunggulan Kami</span>
                <h2 class="text-4xl font-bold text-gray-800 mt-2">Mengapa Pilih BonsaiKu?</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-emerald-500 mx-auto mt-4"></div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group text-center p-8 bg-white rounded-2xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="bg-gradient-to-br from-green-400 to-emerald-500 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-leaf text-white text-2xl"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4 text-gray-800">Kualitas Premium</h4>
                    <p class="text-gray-600 leading-relaxed">Setiap bonsai dipilih dengan teliti dan dijamin kualitasnya oleh ahli bonsai berpengalaman</p>
                </div>
                
                <div class="group text-center p-8 bg-white rounded-2xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="bg-gradient-to-br from-blue-400 to-indigo-500 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shipping-fast text-white text-2xl"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4 text-gray-800">Pengiriman Aman</h4>
                    <p class="text-gray-600 leading-relaxed">Kemasan khusus untuk melindungi bonsai selama pengiriman hingga sampai dengan selamat</p>
                </div>
                
                <div class="group text-center p-8 bg-white rounded-2xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="bg-gradient-to-br from-purple-400 to-pink-500 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4 text-gray-800">Komunitas & Support</h4>
                    <p class="text-gray-600 leading-relaxed">Bergabung dengan komunitas pecinta bonsai dan dapatkan tips perawatan dari para ahli</p>
                </div>
            </div>
        </div>
    </section>
    
@endsection