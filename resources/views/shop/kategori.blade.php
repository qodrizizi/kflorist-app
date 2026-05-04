@extends('layouts.shop')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-gray-900 via-green-900 to-gray-800 text-white py-20 md:py-32 overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('{{ asset('images/bgkategori.png') }}');"></div>
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-72 h-72 bg-green-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-500"></div>
    </div>
    
    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>
    
    <div class="container mx-auto px-4 text-center z-10 relative">
        <div class="max-w-4xl mx-auto">
            <div class="inline-block bg-green-500/20 backdrop-blur-sm border border-green-500/30 rounded-full px-6 py-3 mb-6">
                <span class="text-green-300 text-sm font-medium flex items-center gap-2">
                    <i class="fas fa-seedling"></i>
                    Eksplorasi Kategori Bonsai
                </span>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                <span class="block">Jelajahi</span>
                <span class="bg-gradient-to-r from-green-400 via-blue-400 to-purple-400 bg-clip-text text-transparent">
                    Dunia Bonsai
                </span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-300 mb-8 leading-relaxed max-w-3xl mx-auto">
                Temukan jenis bonsai yang paling sesuai dengan gaya hidup dan kebutuhanmu. 
                Dari indoor hingga premium, setiap kategori memiliki keunikan tersendiri.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#categories" 
                   class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 px-8 py-4 rounded-full text-white font-semibold transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl flex items-center gap-3">
                    <span>Mulai Eksplorasi</span>
                    <i class="fas fa-arrow-down group-hover:translate-y-1 transition-transform"></i>
                </a>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#" class="group bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-4 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 shadow-xl flex items-center justify-center gap-2">
                        <span>Lihat Bibit Tersedia</span>
                        <i class="fas fa-seedling group-hover:scale-110 transition-transform"></i>
                    </a>
                    
                    <a href="#" class="group border-2 border-orange-200 hover:bg-orange-50 text-orange-700 px-8 py-4 rounded-full font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Panduan Pemula</span>
                        <i class="fas fa-play group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Overview -->
<section id="categories" class="py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-block bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-medium mb-4">
                Kategori Pilihan
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                Temukan <span class="text-green-600">Kategori</span> Favoritmu
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Setiap kategori dirancang khusus untuk memenuhi kebutuhan dan preferensi yang berbeda
            </p>
        </div>

        <!-- Category Cards Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <div class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border-2 border-transparent hover:border-green-200">
                <div class="bg-gradient-to-br from-green-100 to-green-200 w-16 h-16 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-home text-2xl text-green-600"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Bonsai Indoor</h4>
                <p class="text-gray-600 text-sm mb-4">Perfect untuk dekorasi dalam ruangan</p>
                <div class="flex items-center justify-between">
                    <span class="text-green-600 font-medium text-sm">25+ Varietas</span>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-green-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </div>

            <div class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border-2 border-transparent hover:border-blue-200">
                <div class="bg-gradient-to-br from-blue-100 to-blue-200 w-16 h-16 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-sun text-2xl text-blue-600"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Bonsai Outdoor</h4>
                <p class="text-gray-600 text-sm mb-4">Ideal untuk taman dan halaman</p>
                <div class="flex items-center justify-between">
                    <span class="text-blue-600 font-medium text-sm">30+ Varietas</span>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </div>

            <div class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border-2 border-transparent hover:border-purple-200">
                <div class="bg-gradient-to-br from-purple-100 to-purple-200 w-16 h-16 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-crown text-2xl text-purple-600"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Bonsai Premium</h4>
                <p class="text-gray-600 text-sm mb-4">Koleksi eksklusif untuk kolektor</p>
                <div class="flex items-center justify-between">
                    <span class="text-purple-600 font-medium text-sm">15+ Masterpiece</span>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </div>

            <div class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border-2 border-transparent hover:border-orange-200">
                <div class="bg-gradient-to-br from-orange-100 to-orange-200 w-16 h-16 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-seedling text-2xl text-orange-600"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Bibit Bonsai</h4>
                <p class="text-gray-600 text-sm mb-4">Mulai perjalanan dari awal</p>
                <div class="flex items-center justify-between">
                    <span class="text-orange-600 font-medium text-sm">40+ Bibit</span>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-orange-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bonsai Indoor Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-gradient-to-r from-green-500 to-green-600 opacity-20 blur-2xl group-hover:opacity-30 transition-opacity rounded-3xl"></div>
                    <img src="{{ asset('images/c.jpg') }}"
                         alt="Bonsai Indoor" 
                         class="relative w-full rounded-3xl shadow-2xl group-hover:scale-105 transition-transform duration-500">
                    
                    <!-- Floating Info Cards -->
                    <div class="absolute -top-4 -right-4 bg-white rounded-2xl p-4 shadow-xl border border-green-100">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-gray-700">Low Light</span>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl p-4 shadow-xl border border-blue-100">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse delay-300"></div>
                            <span class="text-sm font-medium text-gray-700">Easy Care</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="order-1 lg:order-2">
                <div class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-medium mb-6">
                    <i class="fas fa-home mr-2"></i>Kategori Indoor
                </div>
                
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    Bonsai <span class="text-green-600">Indoor</span>
                </h2>
                
                <p class="text-lg text-gray-600 leading-relaxed mb-6">
                    Bonsai Indoor sangat cocok untuk kamu yang ingin menambah sentuhan alam di dalam rumah, apartemen, atau kantor. Jenis bonsai ini berasal dari tanaman tropis atau subtropis yang bisa bertahan dengan minim sinar matahari dan kelembapan ruangan.
                </p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div class="bg-gray-50 rounded-2xl p-4 flex items-center gap-3">
                        <div class="bg-green-100 p-2 rounded-xl">
                            <i class="fas fa-droplet text-green-600"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-800">Kelembaban Rendah</h5>
                            <p class="text-sm text-gray-600">Adaptif dengan AC</p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-2xl p-4 flex items-center gap-3">
                        <div class="bg-blue-100 p-2 rounded-xl">
                            <i class="fas fa-moon text-blue-600"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-800">Minim Cahaya</h5>
                            <p class="text-sm text-gray-600">Cocok di dalam ruangan</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-2xl p-6 mb-8">
                    <h4 class="font-bold text-gray-800 mb-3">Jenis Populer:</h4>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-white px-4 py-2 rounded-full text-sm font-medium text-gray-700 shadow-sm">Ficus</span>
                        <span class="bg-white px-4 py-2 rounded-full text-sm font-medium text-gray-700 shadow-sm">Sianci</span>
                        <span class="bg-white px-4 py-2 rounded-full text-sm font-medium text-gray-700 shadow-sm">Sancang</span>
                        <span class="bg-white px-4 py-2 rounded-full text-sm font-medium text-gray-700 shadow-sm">Serissa</span>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#" class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-4 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 shadow-xl flex items-center justify-center gap-2">
                        <span>Lihat Koleksi Indoor</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    
                    <a href="#" class="group border-2 border-green-200 hover:bg-green-50 text-green-700 px-8 py-4 rounded-full font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Panduan Perawatan</span>
                        <i class="fas fa-book group-hover:scale-110 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bonsai Outdoor Section -->
<section class="py-20 bg-gradient-to-br from-blue-50 to-white">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-block bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-medium mb-6">
                    <i class="fas fa-sun mr-2"></i>Kategori Outdoor
                </div>
                
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    Bonsai <span class="text-blue-600">Outdoor</span>
                </h2>
                
                <p class="text-lg text-gray-600 leading-relaxed mb-6">
                    Bonsai Outdoor adalah pilihan sempurna untuk kamu yang memiliki halaman, teras, atau balkon. Jenis bonsai ini membutuhkan paparan sinar matahari langsung dan sirkulasi udara yang baik untuk tumbuh optimal.
                </p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div class="bg-white rounded-2xl p-4 flex items-center gap-3 shadow-sm">
                        <div class="bg-yellow-100 p-2 rounded-xl">
                            <i class="fas fa-sun text-yellow-600"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-800">Sinar Matahari</h5>
                            <p class="text-sm text-gray-600">6-8 jam per hari</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-4 flex items-center gap-3 shadow-sm">
                        <div class="bg-green-100 p-2 rounded-xl">
                            <i class="fas fa-wind text-green-600"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-800">Sirkulasi Udara</h5>
                            <p class="text-sm text-gray-600">Ventilasi alami</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6 mb-8">
                    <h4 class="font-bold text-gray-800 mb-3">Jenis Populer:</h4>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-white px-4 py-2 rounded-full text-sm font-medium text-gray-700 shadow-sm">Serut</span>
                        <span class="bg-white px-4 py-2 rounded-full text-sm font-medium text-gray-700 shadow-sm">Cemara Udang</span>
                        <span class="bg-white px-4 py-2 rounded-full text-sm font-medium text-gray-700 shadow-sm">Kimeng</span>
                        <span class="bg-white px-4 py-2 rounded-full text-sm font-medium text-gray-700 shadow-sm">Juniper</span>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#" class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-4 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 shadow-xl flex items-center justify-center gap-2">
                        <span>Lihat Koleksi Outdoor</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    
                    <a href="#" class="group border-2 border-blue-200 hover:bg-blue-50 text-blue-700 px-8 py-4 rounded-full font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Tips Perawatan</span>
                        <i class="fas fa-lightbulb group-hover:scale-110 transition-transform"></i>
                    </a>
                </div>
            </div>
            
            <div class="relative group">
                <div class="absolute -inset-4 bg-gradient-to-r from-blue-500 to-purple-500 opacity-20 blur-2xl group-hover:opacity-30 transition-opacity rounded-3xl"></div>
                <img src="{{ asset('images/c.jpg') }}"
                     alt="Bonsai Outdoor" 
                     class="relative w-full rounded-3xl shadow-2xl group-hover:scale-105 transition-transform duration-500">
                
                <!-- Floating Info Cards -->
                <div class="absolute -top-4 -left-4 bg-white rounded-2xl p-4 shadow-xl border border-blue-100">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-gray-700">Full Sun</span>
                    </div>
                </div>
                
                <div class="absolute -bottom-4 -right-4 bg-white rounded-2xl p-4 shadow-xl border border-green-100">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse delay-500"></div>
                        <span class="text-sm font-medium text-gray-700">Strong Growth</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bonsai Premium Section -->
<section class="py-20 bg-gradient-to-br from-gray-900 via-purple-900 to-gray-800 text-white">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1">
                <div class="relative group">
                    <div class="absolute -inset-6 bg-gradient-to-r from-purple-500 via-pink-500 to-yellow-500 opacity-30 blur-3xl group-hover:opacity-40 transition-opacity rounded-3xl"></div>
                    <img src="{{ asset('images/c.jpg') }}"
                         alt="Bonsai Premium" 
                         class="relative w-full rounded-3xl shadow-2xl group-hover:scale-105 transition-transform duration-500">
                    
                    <!-- Premium Badge -->
                    <div class="absolute top-6 left-6 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 px-4 py-2 rounded-full text-sm font-bold flex items-center gap-2">
                        <i class="fas fa-crown"></i>
                        <span>Premium Collection</span>
                    </div>
                    
                    <!-- Age Badge -->
                    <div class="absolute bottom-6 right-6 bg-black/80 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium">
                        <span>15-50 Years Old</span>
                    </div>
                </div>
            </div>
            
            <div class="order-1 lg:order-2">
                <div class="inline-block bg-purple-500/20 backdrop-blur-sm border border-purple-400/30 text-purple-300 px-4 py-2 rounded-full text-sm font-medium mb-6">
                    <i class="fas fa-crown mr-2"></i>Kategori Premium
                </div>
                
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Bonsai <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Premium</span>
                </h2>
                
                <p class="text-xl text-gray-300 leading-relaxed mb-8">
                    Kategori Bonsai Premium kami diperuntukkan bagi kolektor sejati. Setiap spesimen adalah masterpiece yang telah dibentuk selama bertahun-tahun dengan ketelitian luar biasa.
                </p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 flex items-center gap-3 border border-white/20">
                        <div class="bg-purple-500/20 p-2 rounded-xl">
                            <i class="fas fa-gem text-purple-400"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold text-white">Spesimen Langka</h5>
                            <p class="text-sm text-gray-300">Koleksi terbatas</p>
                        </div>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 flex items-center gap-3 border border-white/20">
                        <div class="bg-yellow-500/20 p-2 rounded-xl">
                            <i class="fas fa-certificate text-yellow-400"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold text-white">Berusia Tua</h5>
                            <p class="text-sm text-gray-300">15-50 tahun</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-purple-500/20 to-pink-500/20 backdrop-blur-sm rounded-2xl p-6 mb-8 border border-purple-400/30">
                    <h4 class="font-bold text-white mb-4">Keunggulan Premium:</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check text-green-400"></i>
                            <span>Dibentuk oleh master bonsai berpengalaman</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check text-green-400"></i>
                            <span>Sertifikat keaslian dan usia</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check text-green-400"></i>
                            <span>Pot premium dan aksesoris eksklusif</span>
                        </li>
                    </ul>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#" class="group bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white px-8 py-4 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 shadow-xl flex items-center justify-center gap-2">
                        <span>Lihat Koleksi Premium</span>
                        <i class="fas fa-crown group-hover:rotate-12 transition-transform"></i>
                    </a>
                    
                    <a href="#" class="group border-2 border-purple-400/50 hover:bg-purple-500/20 backdrop-blur-sm text-purple-300 hover:text-white px-8 py-4 rounded-full font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Konsultasi Ahli</span>
                        <i class="fas fa-phone group-hover:scale-110 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bibit Bonsai Section -->
<section class="py-20 bg-gradient-to-br from-orange-50 to-yellow-50">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-block bg-orange-100 text-orange-700 px-4 py-2 rounded-full text-sm font-medium mb-6">
                    <i class="fas fa-seedling mr-2"></i>Kategori Bibit
                </div>
                
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    Bibit <span class="text-orange-600">Bonsai</span>
                </h2>
                
                <p class="text-lg text-gray-600 leading-relaxed mb-6">
                    Ingin memulai perjalanan bonsai dari awal? Kategori Bibit Bonsai kami adalah jawabannya. Kami menyediakan bibit berkualitas tinggi dari berbagai spesies yang ideal untuk dibentuk dan dikembangkan sendiri.
                </p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div class="bg-white rounded-2xl p-4 flex items-center gap-3 shadow-sm border border-orange-100">
                        <div class="bg-orange-100 p-2 rounded-xl">
                            <i class="fas fa-graduation-cap text-orange-600"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-800">Cocok Pemula</h5>
                            <p class="text-sm text-gray-600">Mudah dirawat</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-4 flex items-center gap-3 shadow-sm border border-green-100">
                        <div class="bg-green-100 p-2 rounded-xl">
                            <i class="fas fa-chart-line text-green-600"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-800">Pertumbuhan</h5>
                            <p class="text-sm text-gray-600">Cepat berkembang</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-orange-100 to-yellow-100 rounded-2xl p-6 mb-8">
                    <h4 class="font-bold text-gray-800 mb-4">Paket Lengkap Pemula:</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check text-orange-600"></i>
                            <span class="text-sm text-gray-700">Bibit berkualitas</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check text-orange-600"></i>
                            <span class="text-sm text-gray-700">Pot starter</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check text-orange-600"></i>
                            <span class="text-sm text-gray-700">Media tanam</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check text-orange-600"></i>
                            <span class="text-sm text-gray-700">Panduan lengkap</span>
                        </div>
                    </div>
                    </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#" class="group bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-4 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 shadow-xl flex items-center justify-center gap-2">
                        <span>Lihat Bibit Tersedia</span>
                        <i class="fas fa-seedling group-hover:scale-110 transition-transform"></i>
                    </a>
                    
                    <a href="#" class="group border-2 border-orange-200 hover:bg-orange-50 text-orange-700 px-8 py-4 rounded-full font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Panduan Pemula</span>
                        <i class="fas fa-play group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
            
            <div class="relative group">
                <div class="absolute -inset-4 bg-gradient-to-r from-orange-500 to-yellow-500 opacity-20 blur-2xl group-hover:opacity-30 transition-opacity rounded-3xl"></div>
                <img src="{{ asset('images/c.jpg') }}"
                     alt="Bibit Bonsai" 
                     class="relative w-full rounded-3xl shadow-2xl group-hover:scale-105 transition-transform duration-500">
                
                <!-- Growth Stages -->
                <div class="absolute top-6 right-6 bg-white/90 backdrop-blur-sm rounded-2xl p-4 shadow-xl">
                    <h5 class="font-bold text-gray-800 text-sm mb-2">Tahap Pertumbuhan</h5>
                    <div class="flex items-center gap-2">
                        <div class="flex gap-1">
                            <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                            <div class="w-2 h-2 bg-orange-300 rounded-full"></div>
                            <div class="w-2 h-2 bg-gray-200 rounded-full"></div>
                            <div class="w-2 h-2 bg-gray-200 rounded-full"></div>
                        </div>
                        <span class="text-xs text-gray-600">2/4</span>
                    </div>
                </div>
                
                <div class="absolute bottom-6 left-6 bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span>Ready to Shape</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Comparison Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm font-medium mb-4">
                Perbandingan Kategori
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                Pilih yang <span class="text-gray-600">Tepat</span> Untukmu
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Bandingkan setiap kategori untuk menemukan yang paling sesuai dengan kebutuhan dan pengalamanmu
            </p>
        </div>

        <!-- Comparison Table -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-900 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">Aspek</th>
                            <th class="px-6 py-4 text-center font-semibold text-green-300">Indoor</th>
                            <th class="px-6 py-4 text-center font-semibold text-blue-300">Outdoor</th>
                            <th class="px-6 py-4 text-center font-semibold text-purple-300">Premium</th>
                            <th class="px-6 py-4 text-center font-semibold text-orange-300">Bibit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-800">Level Perawatan</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">Mudah</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">Sedang</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">Expert</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">Pemula</span>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-800">Harga Range</td>
                            <td class="px-6 py-4 text-center text-gray-600">Rp 150K - 500K</td>
                            <td class="px-6 py-4 text-center text-gray-600">Rp 200K - 800K</td>
                            <td class="px-6 py-4 text-center text-gray-600">Rp 2M - 15M</td>
                            <td class="px-6 py-4 text-center text-gray-600">Rp 50K - 200K</td>
                        </tr>
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-800">Waktu Membentuk</td>
                            <td class="px-6 py-4 text-center text-gray-600">Sudah Jadi</td>
                            <td class="px-6 py-4 text-center text-gray-600">Sudah Jadi</td>
                            <td class="px-6 py-4 text-center text-gray-600">Masterpiece</td>
                            <td class="px-6 py-4 text-center text-gray-600">3-5 Tahun</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-800">Cocok Untuk</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600">Dekorasi ruangan, apartemen</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600">Taman, halaman, teras</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600">Kolektor, investasi</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600">Belajar, hobby baru</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-gray-900 via-green-900 to-blue-900 text-white relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-72 h-72 bg-green-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-700"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Sudah Menemukan <span class="bg-gradient-to-r from-green-400 to-blue-400 bg-clip-text text-transparent">Kategori</span> Favoritmu?
            </h2>
            
            <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                Jelajahi koleksi lengkap kami dan temukan bonsai yang sempurna untuk perjalananmu. 
                Tim ahli kami siap membantu memilih yang terbaik untukmu.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                <a href="{{ route('shop.produk') }}" 
                   class="group bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 px-10 py-4 rounded-full text-white font-semibold text-lg transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl flex items-center gap-3">
                    <i class="fas fa-leaf"></i>
                    <span>Jelajahi Semua Koleksi</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
                
                <a href="#" 
                   class="group border-2 border-white/30 hover:bg-white/10 backdrop-blur-sm px-10 py-4 rounded-full text-white font-semibold text-lg transition-all duration-300 flex items-center gap-3">
                    <i class="fab fa-whatsapp"></i>
                    <span>Konsultasi Gratis</span>
                    <i class="fas fa-phone group-hover:rotate-12 transition-transform"></i>
                </a>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                    <div class="text-2xl font-bold text-green-400 mb-1">25+</div>
                    <div class="text-gray-300">Indoor Varieties</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                    <div class="text-2xl font-bold text-blue-400 mb-1">30+</div>
                    <div class="text-gray-300">Outdoor Options</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                    <div class="text-2xl font-bold text-purple-400 mb-1">15+</div>
                    <div class="text-gray-300">Premium Pieces</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                    <div class="text-2xl font-bold text-orange-400 mb-1">40+</div>
                    <div class="text-gray-300">Starter Seeds</div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Enhanced animations and effects */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    .shimmer::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        animation: shimmer 2s infinite;
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
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

    /* Table hover effects */
    table tbody tr:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Loading animation for images */
    img {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    img:hover {
        transform: scale(1.02);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all sections for animation
        document.querySelectorAll('section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(section);
        });

        // Add parallax effect to hero background
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('section:first-child');
            if (hero) {
                hero.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });

        // Add loading states for buttons
        document.querySelectorAll('a[href="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 2000);
            });
        });
    });
</script>

@endsection