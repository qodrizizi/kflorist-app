@extends('layouts.shop')

@section('content')

    <!-- Hero Section -->
    <section id="home" class="pt-32 pb-20 md:pt-40 md:pb-32 relative overflow-hidden"
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
                        <a href="{{ route('shop.produk') }}" class="group bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 px-8 py-4 rounded-full text-white font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl text-center">
                            <i class="fas fa-shopping-bag mr-2 group-hover:animate-bounce"></i>
                            Belanja Sekarang
                        </a>
                        <a href="#products" class="border-2 border-white/80 text-white hover:bg-white hover:text-blue-600 px-8 py-4 rounded-full font-semibold transition-all duration-300 backdrop-blur-sm text-center">
                            <i class="fas fa-play mr-2"></i>
                            Lihat Katalog
                        </a>
                    </div>
                </div>

                <!-- Stats Card - Dynamic from DB -->
                <div class="relative">
                    <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center group hover:scale-105 transition-transform duration-300">
                                <div class="bg-gradient-to-br from-green-400 to-emerald-500 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-seedling text-white text-xl"></i>
                                </div>
                                <p class="text-white font-bold text-lg">{{ $totalBonsai }}+</p>
                                <p class="text-white/80 text-sm">Koleksi</p>
                            </div>
                            <div class="text-center group hover:scale-105 transition-transform duration-300">
                                <div class="bg-gradient-to-br from-blue-400 to-indigo-500 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-tags text-white text-xl"></i>
                                </div>
                                <p class="text-white font-bold text-lg">{{ $categories->count() }}</p>
                                <p class="text-white/80 text-sm">Kategori</p>
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

        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#categories" class="text-white text-2xl hover:text-green-300 transition-colors">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Categories Section - Dynamic from DB -->
    <section id="categories" class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-green-600 font-semibold text-sm tracking-wider uppercase">Pilihan Kategori</span>
                <h2 class="text-4xl font-bold text-gray-800 mt-2">Kategori Bonsai</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-emerald-500 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($categories as $category)
                @php
                    $gradients = [
                        'green'  => 'from-green-500 to-emerald-600',
                        'orange' => 'from-orange-500 to-red-500',
                        'purple' => 'from-purple-500 to-indigo-600',
                        'teal'   => 'from-teal-500 to-cyan-600',
                    ];
                    $gradient = $gradients[$category->color] ?? 'from-green-500 to-emerald-600';
                @endphp
                <a href="{{ route('shop.produk', ['kategori' => $category->name]) }}"
                   class="group bg-gradient-to-br {{ $gradient }} rounded-2xl p-8 text-white text-center cursor-pointer hover:scale-105 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="{{ $category->icon ?? 'fas fa-leaf' }} text-4xl mb-4 group-hover:scale-110 transition-transform duration-300 relative z-10"></i>
                    <h4 class="font-semibold text-lg relative z-10">{{ $category->name }}</h4>
                    <p class="text-sm text-white/80 mt-1 relative z-10">{{ $category->bonsais_count }} produk</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Products Section - Dynamic from DB -->
    <section id="products" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-green-600 font-semibold text-sm tracking-wider uppercase">Koleksi Terpilih</span>
                <h2 class="text-4xl font-bold text-gray-800 mt-2">Produk Terbaru</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Koleksi bonsai terbaru yang tersedia di toko kami</p>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-emerald-500 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($featuredProducts as $product)
                <div class="group bg-white rounded-3xl shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 border border-gray-100 flex flex-col">
                    <!-- Image -->
                    <a href="{{ route('shop.produk.show', $product->id) }}" class="relative overflow-hidden block">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-56 bg-gradient-to-br from-emerald-100 to-green-200 flex items-center justify-center">
                                <i class="fas fa-seedling text-5xl text-emerald-400"></i>
                            </div>
                        @endif

                        <!-- Category Badge -->
                        <div class="absolute top-4 left-4 z-10">
                            @php
                                $catColors = [
                                    'Indoor'  => 'bg-green-500',
                                    'Outdoor' => 'bg-blue-500',
                                    'Premium' => 'bg-purple-500',
                                    'Bibit'   => 'bg-teal-500',
                                ];
                                $catColor = $catColors[$product->category->name ?? ''] ?? 'bg-gray-500';
                            @endphp
                            <span class="{{ $catColor }} text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>

                        <!-- Status -->
                        <div class="absolute top-4 right-4 z-10">
                            @if($product->status === 'available')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold shadow-sm">Tersedia</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold shadow-sm">Terjual</span>
                            @endif
                        </div>
                        
                        <!-- Hover Icon overlay -->
                        <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <div class="bg-white/90 backdrop-blur-sm p-3 rounded-full shadow-lg transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                <i class="fas fa-search-plus text-emerald-600 text-xl"></i>
                            </div>
                        </div>
                    </a>

                    <!-- Content -->
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="mb-3">
                            <span class="text-sm font-bold text-green-600 bg-green-100 px-2 py-1 rounded-lg">{{ $product->species ?? '-' }}</span>
                        </div>
                        <a href="{{ route('shop.produk.show', $product->id) }}">
                            <h4 class="text-lg font-bold text-gray-800 leading-tight mb-1 hover:text-emerald-600 transition-colors">{{ $product->name }}</h4>
                        </a>

                        <!-- Rating -->
                        <div class="flex items-center mb-3">
                            <div class="flex text-yellow-400 text-[10px] mr-1.5">
                                @php $rating = $product->reviews_avg_rating ?: 0; @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= round($rating) ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                            <span class="text-[10px] text-gray-400 font-medium">({{ $product->reviews_count ?: 0 }})</span>
                        </div>

                        <!-- Specs -->
                        <div class="mb-4 p-3 bg-gray-50 rounded-xl">
                            <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                @if($product->height_cm)
                                <div class="flex items-center"><i class="fas fa-ruler mr-1 text-gray-400"></i> {{ $product->height_cm }}cm</div>
                                @endif
                                @if($product->age_years)
                                <div class="flex items-center"><i class="fas fa-seedling mr-1 text-gray-400"></i> {{ $product->age_years }} tahun</div>
                                @endif
                                @if($product->light_requirement)
                                <div class="flex items-center"><i class="fas fa-sun mr-1 text-gray-400"></i> {{ $product->light_requirement }}</div>
                                @endif
                                @if($product->health_status)
                                <div class="flex items-center"><i class="fas fa-heart mr-1 text-gray-400"></i> {{ $product->health_status }}</div>
                                @endif
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <span class="text-xl font-bold text-gray-800">
                                Rp {{ number_format($product->current_value ?? 0, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-2">
                            @if($product->status === 'available')
                                <button onclick="addToCart('{{ $product->id }}', true)" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl hover:from-green-600 hover:to-green-700 transition-all font-semibold text-sm shadow-sm hover:shadow-md">
                                    <i class="fas fa-shopping-cart mr-2"></i>Beli
                                </button>
                                <button onclick="addToCart('{{ $product->id }}', false)" class="bg-gray-100 text-gray-600 p-3 rounded-xl hover:bg-gray-200 transition-colors shadow-sm">
                                    <i class="fas fa-plus"></i>
                                </button>
                            @else
                                <button disabled class="flex-1 bg-gray-200 text-gray-500 py-3 rounded-xl font-semibold text-sm cursor-not-allowed">
                                    <i class="fas fa-ban mr-2"></i>Terjual
                                </button>
                                <a href="{{ route('shop.produk.show', $product->id) }}" class="bg-gray-100 text-gray-600 p-3 rounded-xl hover:bg-gray-200 transition-all shadow-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-4 text-center py-12">
                    <i class="fas fa-seedling text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada produk tersedia</p>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-16">
                <a href="{{ route('shop.produk') }}" class="group inline-flex items-center bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-10 py-4 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    Lihat Semua Produk
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
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