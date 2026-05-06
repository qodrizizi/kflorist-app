@extends('layouts.shop')

@section('content')
<section class="py-16 bg-gradient-to-br from-green-50 via-white to-emerald-50">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-16">
            <h2 class="text-5xl font-bold text-gray-800 mb-4">🌿 Koleksi Bonsai</h2>
            <p class="text-xl text-gray-600 mb-8">Temukan bonsai berkualitas tinggi untuk mempercantik rumah Anda</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-green-100">
                    <div class="text-3xl font-bold text-green-600">{{ $totalProducts }}</div>
                    <div class="text-gray-600">Produk Tersedia</div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-green-100">
                    <div class="text-3xl font-bold text-green-600">{{ $categories->count() }}</div>
                    <div class="text-gray-600">Kategori</div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-green-100">
                    <div class="text-3xl font-bold text-green-600">100%</div>
                    <div class="text-gray-600">Kualitas Terjamin</div>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-12 border border-gray-100">
            <form method="GET" action="{{ route('shop.produk') }}">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Bonsai</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Cari nama atau species..."
                                   class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                        <select name="kategori"
                                class="w-full border-2 border-gray-200 rounded-2xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="all">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}" {{ request('kategori') === $cat->name ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan</label>
                        <select name="sort"
                                class="w-full border-2 border-gray-200 rounded-2xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="terbaru" {{ request('sort') === 'terbaru' ? 'selected' : '' }}>🆕 Terbaru</option>
                            <option value="termurah" {{ request('sort') === 'termurah' ? 'selected' : '' }}>💰 Termurah</option>
                            <option value="termahal" {{ request('sort') === 'termahal' ? 'selected' : '' }}>💎 Termahal</option>
                            <option value="nama" {{ request('sort') === 'nama' ? 'selected' : '' }}>🔤 Nama A-Z</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white py-4 rounded-2xl font-semibold transition-all text-center">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                    </div>
                </div>
            </form>

            <!-- Quick Category Links -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex flex-wrap gap-3">
                    <span class="text-sm font-semibold text-gray-700 mr-4 self-center">Kategori Cepat:</span>
                    <a href="{{ route('shop.produk') }}"
                       class="px-4 py-2 rounded-full text-sm transition-colors {{ !request('kategori') || request('kategori') === 'all' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                        Semua
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('shop.produk', ['kategori' => $cat->name]) }}"
                           class="px-4 py-2 rounded-full text-sm transition-colors {{ request('kategori') === $cat->name ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                            <i class="{{ $cat->icon ?? 'fas fa-leaf' }} mr-1"></i>{{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Available Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($availableProducts as $product)
            <div class="group bg-white rounded-3xl shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 border border-gray-100 flex flex-col">
                <!-- Image -->
                <a href="{{ route('shop.produk.show', $product->id) }}" class="relative overflow-hidden block">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                             class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-110">
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
                            {{ $product->category->name ?? '-' }}
                        </span>
                    </div>

                    <!-- Status -->
                    <div class="absolute top-4 right-4 z-10">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold shadow-sm">Tersedia</span>
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
                    <div class="mb-2">
                        <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-lg">{{ $product->species ?? '-' }}</span>
                        <span class="text-xs text-gray-400 ml-2">{{ $product->code }}</span>
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
                            <div class="flex items-center"><i class="fas fa-sun mr-1 text-gray-400"></i> {{ Str::limit($product->light_requirement, 12) }}</div>
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
                        <button onclick="addToCart('{{ $product->id }}', true)" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl hover:from-green-600 hover:to-green-700 transition-all font-semibold text-sm shadow-md hover:shadow-lg">
                            <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                        </button>
                        <button onclick="addToCart('{{ $product->id }}', false)" class="bg-gray-100 text-gray-600 p-3 rounded-xl hover:bg-gray-200 hover:text-green-600 transition-all shadow-sm hover:shadow">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-16">
                <i class="fas fa-search text-6xl text-gray-300 mb-4 block"></i>
                <p class="text-gray-500 text-xl font-semibold mb-2">Tidak ada produk ditemukan</p>
                <p class="text-gray-400">Coba ubah filter atau kata kunci pencarian Anda</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($availableProducts->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $availableProducts->links() }}
        </div>
        @endif

        <!-- Sold Products Section -->
        @if($soldProducts->count() > 0)
        <div class="mt-24">
            <div class="flex items-center gap-4 mb-8">
                <h3 class="text-2xl font-bold text-gray-400">Produk Terjual</h3>
                <div class="flex-grow h-px bg-gray-200"></div>
                <span class="text-sm font-medium text-gray-400 italic">Portfolio Bonsai Terkurasi</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($soldProducts as $product)
                <div class="group bg-white rounded-3xl shadow-md overflow-hidden opacity-75 hover:opacity-100 transition-all duration-500 border border-gray-100 flex flex-col grayscale hover:grayscale-0">
                    <!-- Image -->
                    <a href="{{ route('shop.produk.show', $product->id) }}" class="relative overflow-hidden block">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                                 class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-seedling text-3xl text-gray-300"></i>
                            </div>
                        @endif

                        <div class="absolute top-3 right-3 z-10">
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm">Sold Out</span>
                        </div>
                    </a>

                    <div class="p-5 flex-grow flex flex-col">
                        <div class="mb-1">
                            <span class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded">{{ $product->species ?? '-' }}</span>
                        </div>
                        <h4 class="text-base font-bold text-gray-600 mb-2 truncate">{{ $product->name }}</h4>
                        
                        <div class="mt-auto pt-4 flex justify-between items-center border-t border-gray-50">
                            <span class="text-sm font-bold text-gray-400">Rp {{ number_format($product->current_value ?? 0, 0, ',', '.') }}</span>
                            <a href="{{ route('shop.produk.show', $product->id) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Bottom CTA -->
        <div class="mt-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-3xl p-8 text-white text-center">
            <h3 class="text-2xl font-bold mb-4">Ada Pertanyaan Tentang Bonsai?</h3>
            <p class="mb-6 opacity-90">Hubungi kami dan dapatkan konsultasi gratis dari ahli bonsai kami</p>
            <a href="https://wa.me/6281234567890" target="_blank"
               class="inline-block bg-white text-green-600 px-8 py-3 rounded-xl font-semibold hover:bg-gray-100 transition-colors">
                <i class="fab fa-whatsapp mr-2"></i>Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection