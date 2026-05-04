@extends('layouts.shop')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-gray-900 via-green-900 to-gray-800 text-white py-20 md:py-32 overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ asset('images/bgtentang.png') }}');"></div>
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-transparent"></div>
        <div class="absolute top-10 left-10 w-72 h-72 bg-green-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
    </div>
    
    <div class="container mx-auto px-4 z-10 relative">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-2/3">
                <div class="inline-block bg-green-500/20 backdrop-blur-sm border border-green-500/30 rounded-full px-4 py-2 mb-6">
                    <span class="text-green-300 text-sm font-medium">🌿 Sejak 1990</span>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    <span class="block">Menghadirkan</span>
                    <span class="bg-gradient-to-r from-green-400 to-blue-400 bg-clip-text text-transparent">
                        Kedamaian Alam
                    </span>
                    <span class="block">ke Rumah Anda</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-300 mb-8 leading-relaxed max-w-2xl">
                    BonsaiKu adalah tempat di mana seni dan alam bertemu. Kami berdedikasi untuk menyediakan bonsai berkualitas tinggi yang tidak hanya memperindah ruang Anda, tetapi juga membawa ketenangan dan filosofi hidup yang mendalam.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('shop.produk') }}" 
                       class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 px-8 py-4 rounded-full text-white font-semibold transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl flex items-center justify-center gap-2">
                        <span>Lihat Koleksi Bonsai</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="#story" 
                       class="group border border-white/30 hover:bg-white/10 backdrop-blur-sm px-8 py-4 rounded-full text-white font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Pelajari Cerita Kami</span>
                        <i class="fas fa-play group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center group">
                <div class="bg-green-50 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-green-100 transition-colors">
                    <i class="fas fa-seedling text-3xl text-green-600"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-2 counter" data-count="1000">0</h3>
                <p class="text-gray-600 font-medium">Bonsai Terjual</p>
            </div>
            <div class="text-center group">
                <div class="bg-blue-50 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-100 transition-colors">
                    <i class="fas fa-users text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-2 counter" data-count="500">0</h3>
                <p class="text-gray-600 font-medium">Pelanggan Puas</p>
            </div>
            <div class="text-center group">
                <div class="bg-purple-50 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-100 transition-colors">
                    <i class="fas fa-award text-3xl text-purple-600"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-2 counter" data-count="35">0</h3>
                <p class="text-gray-600 font-medium">Tahun Pengalaman</p>
            </div>
            <div class="text-center group">
                <div class="bg-orange-50 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-100 transition-colors">
                    <i class="fas fa-globe-asia text-3xl text-orange-600"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-2 counter" data-count="34">0</h3>
                <p class="text-gray-600 font-medium">Kota Terlayani</p>
            </div>
        </div>
    </div>
</section>

<!-- Story Section -->
<section id="story" class="py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center mb-16">
            <div class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-medium mb-4">
                Cerita Kami
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                Dari Hobi Menjadi <span class="text-green-600">Passion</span>
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed">
                Perjalanan kami dimulai dari kecintaan sederhana terhadap seni bonsai yang akhirnya tumbuh menjadi misi untuk membagikan keindahan dan filosofi bonsai kepada seluruh Indonesia.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="bg-green-100 p-3 rounded-xl">
                            <i class="fas fa-heart text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Passion yang Mendalam</h4>
                            <p class="text-gray-600 leading-relaxed">
                                BonsaiKu lahir dari hobi sederhana di kebun belakang rumah. Kami melihat bagaimana bonsai dapat menjadi jembatan antara manusia dan alam, membawa kedamaian dan refleksi dalam kehidupan sehari-hari.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-100 p-3 rounded-xl">
                            <i class="fas fa-rocket text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Pertumbuhan Berkelanjutan</h4>
                            <p class="text-gray-600 leading-relaxed">
                                Dari kebun kecil, kini kami telah berkembang menjadi sumber terpercaya untuk koleksi bonsai premium di seluruh Indonesia, dengan jaringan pengiriman ke 34 kota besar.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="bg-purple-100 p-3 rounded-xl">
                            <i class="fas fa-gem text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Kualitas Premium</h4>
                            <p class="text-gray-600 leading-relaxed">
                                Setiap bonsai adalah hasil dedikasi, kesabaran, dan pengetahuan mendalam. Kami percaya setiap pohon memiliki cerita unik dan kami berkomitmen membantu Anda menemukan yang tepat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -inset-4 bg-gradient-to-r from-green-500 to-blue-500 rounded-3xl opacity-10 blur-2xl"></div>
                <div class="relative bg-white rounded-3xl p-8 shadow-2xl">
                    <img src="{{ asset('images/logo.png') }}" alt="BonsaiKu Story" 
                         class="w-full rounded-2xl mb-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-gray-700 font-medium">Dimulai tahun 1990</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <span class="text-gray-700 font-medium">1000+ bonsai berkualitas tinggi</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                            <span class="text-gray-700 font-medium">Komunitas 500+ pecinta bonsai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-block bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-medium mb-4">
                Nilai-Nilai Kami
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                Yang Membuat Kami <span class="text-blue-600">Berbeda</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Komitmen kami tidak hanya pada kualitas produk, tetapi juga pada pengalaman dan hubungan jangka panjang dengan setiap pelanggan.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="group bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-8 text-center transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                <div class="bg-gradient-to-br from-green-400 to-green-600 text-white w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-seedling text-3xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-800 mb-4">Kualitas & Integritas</h4>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Kami hanya menyediakan bonsai dengan kualitas terbaik, dirawat oleh ahli dengan standar yang tinggi. Kejujuran adalah prioritas kami dalam setiap transaksi.
                </p>
                <div class="flex justify-center gap-2">
                    <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-sm font-medium">Premium Quality</span>
                    <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-sm font-medium">Trusted</span>
                </div>
            </div>

            <div class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 text-center transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 text-white w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-hands-helping text-3xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-800 mb-4">Edukasi & Dukungan</h4>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Kami tidak hanya menjual, tetapi juga mendidik. Kami menyediakan panduan perawatan lengkap dan dukungan 24/7 untuk memastikan bonsai Anda tumbuh subur.
                </p>
                <div class="flex justify-center gap-2">
                    <span class="bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">24/7 Support</span>
                    <span class="bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">Expert Guide</span>
                </div>
            </div>

            <div class="group bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-8 text-center transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                <div class="bg-gradient-to-br from-purple-400 to-purple-600 text-white w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-users text-3xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-800 mb-4">Komunitas Pecinta Bonsai</h4>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Kami membangun komunitas yang solid. Bergabunglah dengan kami untuk berbagi pengalaman, tips, dan inspirasi dengan sesama pecinta bonsai di seluruh Indonesia.
                </p>
                <div class="flex justify-center gap-2">
                    <span class="bg-purple-200 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">Community</span>
                    <span class="bg-purple-200 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">Sharing</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm font-medium mb-4">
                Perjalanan Kami
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                <span class="text-gray-600">Timeline</span> BonsaiKu
            </h2>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="relative">
                <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gradient-to-b from-green-500 to-blue-500 rounded-full"></div>
                
                <div class="space-y-16">
                    <div class="flex items-center gap-8">
                        <div class="w-1/2 text-right pr-8">
                            <div class="bg-white rounded-xl p-6 shadow-lg">
                                <h4 class="text-xl font-bold text-gray-800 mb-2">1990 - Awal Mula</h4>
                                <p class="text-gray-600">Memulai dari hobi pribadi dengan 5 bonsai di kebun belakang rumah</p>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="w-6 h-6 bg-green-500 rounded-full border-4 border-white shadow-lg"></div>
                        </div>
                        <div class="w-1/2"></div>
                    </div>

                    <div class="flex items-center gap-8">
                        <div class="w-1/2"></div>
                        <div class="relative">
                            <div class="w-6 h-6 bg-blue-500 rounded-full border-4 border-white shadow-lg"></div>
                        </div>
                        <div class="w-1/2 pl-8">
                            <div class="bg-white rounded-xl p-6 shadow-lg">
                                <h4 class="text-xl font-bold text-gray-800 mb-2">2015 - Ekspansi Online</h4>
                                <p class="text-gray-600">Meluncurkan platform online dan mencapai 100 pelanggan pertama</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-8">
                        <div class="w-1/2 text-right pr-8">
                            <div class="bg-white rounded-xl p-6 shadow-lg">
                                <h4 class="text-xl font-bold text-gray-800 mb-2">2020 - Milestone 500+</h4>
                                <p class="text-gray-600">Mencapai 500+ pelanggan puas dan 20 kota jangkauan pengiriman</p>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="w-6 h-6 bg-purple-500 rounded-full border-4 border-white shadow-lg"></div>
                        </div>
                        <div class="w-1/2"></div>
                    </div>

                    <div class="flex items-center gap-8">
                        <div class="w-1/2"></div>
                        <div class="relative">
                            <div class="w-6 h-6 bg-orange-500 rounded-full border-4 border-white shadow-lg"></div>
                        </div>
                        <div class="w-1/2 pl-8">
                            <div class="bg-white rounded-xl p-6 shadow-lg">
                                <h4 class="text-xl font-bold text-gray-800 mb-2">2025 - Era Baru</h4>
                                <p class="text-gray-600">1000+ bonsai terjual, 34 kota terlayani, dan komunitas solid pecinta bonsai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-block bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-medium mb-4">
                Testimoni Pelanggan
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                Apa Kata <span class="text-yellow-600">Pelanggan</span>
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <div class="bg-gradient-to-br from-gray-50 to-white border-2 border-gray-100 rounded-2xl p-8 hover:shadow-xl transition-shadow">
                <div class="flex items-center gap-1 mb-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
                <p class="text-gray-700 mb-6 italic leading-relaxed">
                    "Bonsai dari BonsaiKu benar-benar berkualitas premium. Sudah 2 tahun merawatnya dan masih tumbuh subur. Dukungan dari tim juga sangat membantu!"
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-blue-400 rounded-full flex items-center justify-center text-white font-bold">
                        AS
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-800">Andi Setiawan</h5>
                        <p class="text-sm text-gray-600">Jakarta</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-50 to-white border-2 border-gray-100 rounded-2xl p-8 hover:shadow-xl transition-shadow">
                <div class="flex items-center gap-1 mb-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
                <p class="text-gray-700 mb-6 italic leading-relaxed">
                    "Pelayanan sangat memuaskan! Pengiriman cepat dan aman. Bonsainya sampai dalam kondisi sempurna. Highly recommended!"
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-pink-400 to-purple-400 rounded-full flex items-center justify-center text-white font-bold">
                        SM
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-800">Sari Melati</h5>
                        <p class="text-sm text-gray-600">Surabaya</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-50 to-white border-2 border-gray-100 rounded-2xl p-8 hover:shadow-xl transition-shadow">
                <div class="flex items-center gap-1 mb-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
                <p class="text-gray-700 mb-6 italic leading-relaxed">
                    "Komunitasnya sangat supportif! Banyak tips dan sharing dari sesama pecinta bonsai. BonsaiKu lebih dari sekedar toko online."
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-orange-400 to-red-400 rounded-full flex items-center justify-center text-white font-bold">
                        BP
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-800">Budi Prasetyo</h5>
                        <p class="text-sm text-gray-600">Bandung</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-gray-900 via-green-900 to-gray-800 text-white relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-72 h-72 bg-green-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Siap untuk Memulai <span class="text-green-400">Perjalanan Bonsai</span> Anda?
            </h2>
            <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                Jelajahi koleksi premium kami dan temukan bonsai yang akan menjadi bagian dari cerita hidup Anda. 
                Bergabunglah dengan komunitas 500+ pecinta bonsai di seluruh Indonesia.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                <a href="{{ route('shop.produk') }}" 
                   class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 px-10 py-4 rounded-full text-white font-semibold text-lg transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl flex items-center gap-3">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Mulai Belanja Sekarang</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
                
                <a href="#" 
                   class="group border-2 border-white/30 hover:bg-white/10 backdrop-blur-sm px-10 py-4 rounded-full text-white font-semibold text-lg transition-all duration-300 flex items-center gap-3">
                    <i class="fab fa-whatsapp"></i>
                    <span>Konsultasi Gratis</span>
                    <i class="fas fa-external-link-alt group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="flex flex-wrap justify-center items-center gap-8 text-sm text-gray-400">
                <div class="flex items-center gap-2">
                    <i class="fas fa-shipping-fast text-green-400"></i>
                    <span>Pengiriman ke 34 Kota</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-shield-alt text-blue-400"></i>
                    <span>Garansi Kualitas</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-headset text-purple-400"></i>
                    <span>Support 24/7</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-users text-yellow-400"></i>
                    <span>1000+ Pelanggan Puas</span>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Counter Animation */
@keyframes countUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.counter {
    animation: countUp 0.6s ease-out;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Custom animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

/* Glassmorphism effect */
.glass {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation
    const counters = document.querySelectorAll('.counter');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.dataset.count);
                let count = 0;
                
                const updateCounter = () => {
                    const increment = target / 50;
                    if (count < target) {
                        count += increment;
                        counter.textContent = Math.ceil(count) + '+';
                        setTimeout(updateCounter, 30);
                    } else {
                        counter.textContent = target + '+';
                    }
                };
                
                updateCounter();
                observer.unobserve(counter);
            }
        });
    }, { threshold: 0.5 });
    
    counters.forEach(counter => {
        observer.observe(counter);
    });
    
    // Smooth scroll for internal links
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
});
</script>

@endsection