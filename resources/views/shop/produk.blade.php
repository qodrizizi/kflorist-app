@extends('layouts.shop')

@section('content')
<!-- HERO SECTION DENGAN GAMBAR BACKGROUND (SEPERTI MENU LAIN) -->
<section class="relative bg-gradient-to-br from-gray-950 via-emerald-950 to-gray-900 text-white pt-20 pb-28 md:pt-28 md:pb-36 overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-cover bg-center opacity-30 scale-105 transition-transform duration-1000" style="background-image: url('{{ asset('images/bghero.png') }}');"></div>
    
    <!-- Animated Ambient Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-10 left-10 w-80 h-80 bg-emerald-500/15 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-teal-500/15 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-green-500/10 rounded-full blur-3xl animate-pulse delay-500"></div>
    </div>
    
    <!-- Subtle Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-gray-950/80 via-transparent to-black/40"></div>

    <div class="container mx-auto px-4 z-10 relative text-center">
        <div class="max-w-4xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 bg-emerald-500/20 backdrop-blur-md border border-emerald-400/30 rounded-full px-5 py-2 mb-6 shadow-inner">
                <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                <span class="text-emerald-300 text-xs sm:text-sm font-bold tracking-wide flex items-center gap-2">
                    <i class="fas fa-seedling"></i> Galeri & Nursery Bonsai Resmi
                </span>
            </div>
            
            <!-- Headline -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight tracking-tight">
                <span class="block text-white">Koleksi Mahakarya</span>
                <span class="bg-gradient-to-r from-emerald-300 via-green-300 to-teal-200 bg-clip-text text-transparent">
                    Pohon Bonsai
                </span>
            </h1>
            
            <!-- Description -->
            <p class="text-base sm:text-lg md:text-xl text-emerald-100/90 mb-10 leading-relaxed max-w-2xl mx-auto font-medium">
                Temukan karya seni hidup eksklusif hasil budidaya puluhan tahun. Dilindungi garansi tanaman hidup sampai tujuan dengan peti kayu pengaman berstandar khusus.
            </p>
            
            <!-- 3 Glassmorphism Counters -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-3xl mx-auto text-left">
                <div class="bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/20 rounded-2xl p-4 transition-all flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-400/25 text-emerald-300 flex items-center justify-center text-xl shrink-0">
                        <i class="fas fa-tree"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-white font-mono leading-none block mb-1">{{ $totalProducts }}</span>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-200">Tanaman Tersedia</span>
                    </div>
                </div>

                <div class="bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/20 rounded-2xl p-4 transition-all flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-teal-400/25 text-teal-300 flex items-center justify-center text-xl shrink-0">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-white font-mono leading-none block mb-1">{{ $categories->count() }}</span>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-200">Kategori Pilihan</span>
                    </div>
                </div>

                <div class="bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/20 rounded-2xl p-4 transition-all flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-400/25 text-amber-300 flex items-center justify-center text-xl shrink-0">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-white font-mono leading-none block mb-1">100%</span>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-200">Garansi Peti Kayu</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- CATALOG CONTENT SECTION -->
<section class="py-12 md:py-16 bg-slate-50 min-h-screen relative z-20">
    <div class="container mx-auto px-4 md:px-8 max-w-7xl">
        
        <!-- SEARCH & FILTER TOOLBAR (FLOATING OVER HERO) -->
        <div class="-mt-20 relative z-30 bg-white rounded-3xl shadow-xl border border-slate-200/90 p-6 md:p-8 mb-12">
            <form method="GET" action="{{ route('shop.produk') }}">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    
                    <!-- Search Input (5 Cols) -->
                    <div class="md:col-span-5">
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">
                            <i class="fas fa-search text-emerald-600 mr-1"></i> Cari Bonsai
                        </label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Cari nama bonsai, spesies, atau kode..."
                                   class="w-full pl-11 pr-4 py-3.5 bg-slate-50 hover:bg-slate-100/80 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            @if(request('search'))
                                <a href="{{ route('shop.produk', array_merge(request()->except('search'), [])) }}" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                                    <i class="fas fa-times-circle"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Category Dropdown (3 Cols) -->
                    <div class="md:col-span-3">
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">
                            <i class="fas fa-tags text-emerald-600 mr-1"></i> Kategori
                        </label>
                        <div class="relative">
                            <select name="kategori"
                                    class="w-full pl-4 pr-10 py-3.5 bg-slate-50 hover:bg-slate-100/80 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all appearance-none">
                                <option value="all">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->name }}" {{ request('kategori') === $cat->name ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                        </div>
                    </div>

                    <!-- Sort Dropdown (2 Cols) -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">
                            <i class="fas fa-arrow-down-short-wide text-emerald-600 mr-1"></i> Urutkan
                        </label>
                        <div class="relative">
                            <select name="sort"
                                    class="w-full pl-4 pr-10 py-3.5 bg-slate-50 hover:bg-slate-100/80 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all appearance-none">
                                <option value="terbaru" {{ request('sort') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="termurah" {{ request('sort') === 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                                <option value="termahal" {{ request('sort') === 'termahal' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="nama" {{ request('sort') === 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                        </div>
                    </div>

                    <!-- Submit Button (2 Cols) -->
                    <div class="md:col-span-2">
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white py-3.5 px-4 rounded-2xl font-bold transition-all shadow-md hover:shadow-lg text-sm flex items-center justify-center gap-2 transform active:scale-95">
                            <i class="fas fa-filter text-xs"></i>
                            <span>Terapkan</span>
                        </button>
                    </div>

                </div>
            </form>

            <!-- QUICK FILTER PILLS -->
            <div class="mt-6 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2 overflow-x-auto hide-scroll py-1 max-w-full">
                    <span class="text-xs font-black uppercase tracking-wider text-slate-400 mr-1 shrink-0">Filter Cepat:</span>
                    
                    <a href="{{ route('shop.produk', array_merge(request()->except('kategori'), [])) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5 {{ !request('kategori') || request('kategori') === 'all' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        <i class="fas fa-border-all text-[10px]"></i>
                        <span>Semua</span>
                    </a>

                    @foreach($categories as $cat)
                        <a href="{{ route('shop.produk', array_merge(request()->except('kategori'), ['kategori' => $cat->name])) }}"
                           class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5 {{ request('kategori') === $cat->name ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                            <i class="{{ $cat->icon ?? 'fas fa-leaf' }} text-[10px]"></i>
                            <span>{{ $cat->name }}</span>
                        </a>
                    @endforeach
                </div>

                @if(request('search') || (request('kategori') && request('kategori') !== 'all') || request('sort'))
                    <a href="{{ route('shop.produk') }}" class="text-xs font-bold text-rose-600 hover:text-rose-700 inline-flex items-center gap-1 shrink-0">
                        <i class="fas fa-rotate-left"></i>
                        <span>Reset Filter</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- AVAILABLE PRODUCTS GRID -->
        <div class="mb-14">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                        <i class="fas fa-circle-check text-emerald-600 text-lg"></i>
                        <span>Katalog Bonsai Tersedia</span>
                    </h2>
                    <p class="text-xs md:text-sm text-slate-500 font-medium">Tanaman sehat, terawat, dan siap dikirim ke seluruh nusantara</p>
                </div>

                <span class="text-xs font-bold text-slate-500 bg-white px-3 py-1.5 rounded-xl border border-slate-200 shadow-2xs font-mono">
                    Menampilkan {{ $availableProducts->count() }} Produk
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-7">
                @forelse($availableProducts as $product)
                <div class="group bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-200/90 hover:border-emerald-300 flex flex-col overflow-hidden relative">
                    
                    <!-- Thumbnail with Overlays -->
                    <a href="{{ route('shop.produk.show', $product->id) }}" class="relative overflow-hidden block aspect-4/3 bg-slate-50">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-emerald-50/70 flex items-center justify-center text-emerald-400">
                                <i class="fas fa-seedling text-4xl"></i>
                            </div>
                        @endif

                        <!-- Category Pill (Top Left) -->
                        <div class="absolute top-3.5 left-3.5 z-10">
                            <span class="bg-black/50 backdrop-blur-md text-white text-[11px] font-extrabold px-3 py-1 rounded-xl shadow-xs border border-white/20">
                                {{ $product->category->name ?? 'Bonsai' }}
                            </span>
                        </div>

                        <!-- Status Pill (Top Right) -->
                        <div class="absolute top-3.5 right-3.5 z-10">
                            <span class="bg-emerald-600/90 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-xl shadow-xs border border-emerald-400/30 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-200 animate-pulse"></span>
                                Tersedia
                            </span>
                        </div>
                        
                        <!-- Hover Quick Action -->
                        <div class="absolute inset-0 bg-emerald-950/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <div class="w-11 h-11 rounded-2xl bg-white/90 backdrop-blur-md text-emerald-700 flex items-center justify-center shadow-lg transform scale-90 group-hover:scale-100 transition-transform duration-200">
                                <i class="fas fa-eye text-sm"></i>
                            </div>
                        </div>
                    </a>

                    <!-- Card Body -->
                    <div class="p-5 md:p-6 flex-grow flex flex-col justify-between space-y-4">
                        
                        <div>
                            <!-- Species and Code Header -->
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <span class="text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100 truncate">
                                    {{ $product->species ?? 'Bonsai' }}
                                </span>
                                <span class="text-[10px] text-slate-400 font-mono shrink-0">{{ $product->code }}</span>
                            </div>

                            <!-- Product Title -->
                            <a href="{{ route('shop.produk.show', $product->id) }}">
                                <h3 class="text-base font-black text-slate-900 leading-snug group-hover:text-emerald-700 transition-colors line-clamp-1 mb-2">
                                    {{ $product->name }}
                                </h3>
                            </a>

                            <!-- Rating -->
                            <div class="flex items-center gap-1.5 mb-3">
                                <div class="flex text-amber-400 text-xs">
                                    @php $rating = $product->reviews_avg_rating ?: 0; @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= round($rating) ? 'fas' : 'far' }} fa-star"></i>
                                    @endfor
                                </div>
                                <span class="text-xs font-bold text-slate-600 font-mono">
                                    {{ number_format($rating, 1) }}
                                </span>
                                <span class="text-[11px] text-slate-400">({{ $product->reviews_count ?: 0 }} ulasan)</span>
                            </div>

                            <!-- Mini Specs Grid -->
                            <div class="grid grid-cols-2 gap-2 p-2.5 bg-slate-50 rounded-2xl border border-slate-100 text-[11px] text-slate-600 mb-4 font-medium">
                                <div class="flex items-center gap-1.5 truncate">
                                    <i class="fas fa-ruler-vertical text-slate-400 text-xs"></i>
                                    <span>{{ $product->height_cm ? $product->height_cm . ' cm' : 'Koleksi' }}</span>
                                </div>
                                <div class="flex items-center gap-1.5 truncate">
                                    <i class="fas fa-clock text-slate-400 text-xs"></i>
                                    <span>{{ $product->age_years ? $product->age_years . ' thn' : 'Dewasa' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Price & Action Buttons -->
                        <div class="pt-3 border-t border-slate-100 space-y-3">
                            <div class="flex items-baseline justify-between">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Harga Resmi</span>
                                <span class="text-lg md:text-xl font-black text-emerald-600 font-mono tracking-tight">
                                    Rp {{ number_format($product->current_value ?? 0, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                <!-- Beli Sekarang Button -->
                                <button type="button" onclick="addToCart('{{ $product->id }}', true)" 
                                        class="flex-1 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white py-2.5 px-3 rounded-xl font-bold text-xs transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-1.5 transform active:scale-95">
                                    <i class="fas fa-wallet text-xs"></i>
                                    <span>Beli Sekarang</span>
                                </button>
                                
                                <!-- Tambah ke Keranjang Button -->
                                <button type="button" onclick="addToCart('{{ $product->id }}', false)" 
                                        class="w-10 h-10 rounded-xl bg-slate-50 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 border border-slate-200 hover:border-emerald-300 flex items-center justify-center transition-all shrink-0 shadow-2xs active:scale-95" 
                                        title="Tambah ke Keranjang">
                                    <i class="fas fa-cart-plus text-xs"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-20 px-4 bg-white rounded-3xl border border-slate-200/90 shadow-sm">
                    <div class="w-20 h-20 bg-slate-100 text-slate-400 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-4">
                        <i class="fas fa-magnifying-glass"></i>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-slate-800 mb-2">Tidak Ada Bonsai Ditemukan</h3>
                    <p class="text-xs md:text-sm text-slate-500 max-w-md mx-auto mb-6">
                        Maaf, tidak ada produk yang cocok dengan kata kunci atau filter pencarian Anda saat ini.
                    </p>
                    <a href="{{ route('shop.produk') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-600 text-white font-bold rounded-2xl text-xs md:text-sm shadow-md hover:shadow-lg transition-all">
                        <i class="fas fa-rotate-left"></i>
                        <span>Lihat Seluruh Koleksi</span>
                    </a>
                </div>
                @endforelse
            </div>

            <!-- PAGINATION -->
            @if($availableProducts->hasPages())
                <div class="mt-12 flex justify-center">
                    <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-200">
                        {{ $availableProducts->links() }}
                    </div>
                </div>
            @endif
        </div>

        <!-- PORTFOLIO PRODUK TERJUAL (SOLD OUT SECTION) -->
        @if($soldProducts->count() > 0)
        <div class="mt-20 pt-10 border-t border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-8">
                <div>
                    <h3 class="text-xl md:text-2xl font-black text-slate-700 tracking-tight flex items-center gap-2.5">
                        <i class="fas fa-archive text-slate-400"></i>
                        <span>Koleksi Teradopsi (Portfolio Terjual)</span>
                    </h3>
                    <p class="text-xs md:text-sm text-slate-400 font-medium">Bonsai pilihan yang telah resmi menjadi milik para kolektor setia RUANGBONSAI</p>
                </div>
                <span class="text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200 self-start sm:self-auto font-mono">
                    {{ $soldProducts->count() }} Koleksi
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($soldProducts as $product)
                <div class="group bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden flex flex-col opacity-80 hover:opacity-100 transition-all duration-300">
                    <a href="{{ route('shop.produk.show', $product->id) }}" class="relative overflow-hidden block aspect-4/3 bg-slate-100">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                                 class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                <i class="fas fa-seedling text-3xl"></i>
                            </div>
                        @endif

                        <div class="absolute top-3 right-3 z-10">
                            <span class="bg-rose-600 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-xl shadow-xs">
                                Teradopsi
                            </span>
                        </div>
                    </a>

                    <div class="p-5 flex-grow flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md inline-block mb-1.5 font-mono">
                                {{ $product->species ?? 'Bonsai' }}
                            </span>
                            <h4 class="text-sm font-bold text-slate-700 truncate group-hover:text-emerald-700 transition-colors">
                                {{ $product->name }}
                            </h4>
                        </div>
                        
                        <div class="pt-3 border-t border-slate-100 flex justify-between items-center text-xs">
                            <span class="font-mono font-bold text-slate-500">Rp {{ number_format($product->current_value ?? 0, 0, ',', '.') }}</span>
                            <a href="{{ route('shop.produk.show', $product->id) }}" class="font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                                <span>Detail</span>
                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- BOTTOM CONSULTATION & EXPERT CTA -->
        <div class="mt-20 relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-800 to-green-800 text-white p-8 md:p-12 shadow-xl border border-emerald-600/30">
            <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
                <i class="fas fa-comments text-9xl"></i>
            </div>

            <div class="relative z-10 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-white/20 text-emerald-200 mb-3 border border-white/20">
                    <i class="fas fa-headset"></i> Layanan Konsultasi Gratis
                </div>
                <h3 class="text-2xl md:text-3xl font-black mb-3 leading-tight">
                    Butuh Rekomendasi atau Informasi Khusus?
                </h3>
                <p class="text-xs md:text-sm text-emerald-100/90 font-medium mb-6 leading-relaxed">
                    Tim kurator dan ahli nursery RUANGBONSAI siap membantu Anda memilih tanaman yang paling cocok dengan pencahayaan, iklim, dan gaya ruangan Anda.
                </p>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="https://wa.me/6281234567890?text=Halo%20RUANGBONSAI,%20saya%20ingin%20konsultasi%20mengenai%20koleksi%20bonsai" target="_blank"
                       class="inline-flex items-center gap-2.5 bg-emerald-500 hover:bg-emerald-400 text-white font-extrabold px-6 py-3.5 rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 text-xs md:text-sm">
                        <i class="fab fa-whatsapp text-lg"></i>
                        <span>Chat dengan Ahli Bonsai (WhatsApp)</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection