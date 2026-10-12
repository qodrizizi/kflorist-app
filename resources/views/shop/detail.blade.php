@extends('layouts.shop')

@section('content')
<section class="py-8 md:py-12 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl">
        
        <!-- Breadcrumb & Top Utility Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 md:mb-8">
            <nav class="flex items-center flex-wrap text-xs md:text-sm text-gray-500 font-medium">
                <a href="{{ route('shop.index') }}" class="hover:text-emerald-600 transition-colors flex items-center gap-1.5">
                    <i class="fas fa-home text-xs"></i>
                    <span>Beranda</span>
                </a>
                <span class="mx-2 text-gray-300"><i class="fas fa-chevron-right text-[10px]"></i></span>
                <a href="{{ route('shop.produk') }}" class="hover:text-emerald-600 transition-colors">Katalog Bonsai</a>
                @if($product->category)
                    <span class="mx-2 text-gray-300"><i class="fas fa-chevron-right text-[10px]"></i></span>
                    <a href="{{ route('shop.produk', ['kategori' => $product->category->name]) }}" class="hover:text-emerald-600 transition-colors">
                        {{ $product->category->name }}
                    </a>
                @endif
                <span class="mx-2 text-gray-300"><i class="fas fa-chevron-right text-[10px]"></i></span>
                <span class="text-gray-900 font-semibold truncate max-w-[200px] sm:max-w-xs md:max-w-md">{{ $product->name }}</span>
            </nav>

            <!-- Quick Action Top Icons -->
            <div class="flex items-center gap-2 self-end sm:self-auto">
                <button type="button" onclick="openShareModal()" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white text-gray-700 hover:text-emerald-600 border border-gray-200 text-xs font-semibold shadow-sm hover:shadow transition-all">
                    <i class="fas fa-share-alt"></i>
                    <span>Bagikan</span>
                </button>
                <button type="button" id="wishlist-btn" onclick="toggleWishlist('{{ $product->id }}')" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white text-gray-700 hover:text-rose-500 border border-gray-200 text-xs font-semibold shadow-sm hover:shadow transition-all">
                    <i id="wishlist-icon" class="far fa-heart"></i>
                    <span id="wishlist-text">Favorit</span>
                </button>
            </div>
        </div>

        <!-- Main Product Card Showcase -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
                
                <!-- LEFT COLUMN: Product Visual Gallery & Quality Badges (5 cols) -->
                <div class="lg:col-span-5 p-6 md:p-10 flex flex-col justify-between bg-gradient-to-br from-slate-50 via-emerald-50/30 to-green-50/40 border-b lg:border-b-0 lg:border-r border-slate-100">
                    <div>
                        <!-- Primary Image Container -->
                        <div class="relative w-full aspect-square rounded-2xl overflow-hidden shadow-xl group bg-white border border-emerald-100/60 cursor-pointer" onclick="openImageLightbox()">
                            @if($product->image_path)
                                <img id="main-product-img" src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-emerald-100 to-green-200 flex flex-col items-center justify-center p-6 text-center">
                                    <i class="fas fa-seedling text-8xl text-emerald-400 mb-4 animate-pulse"></i>
                                    <span class="text-emerald-800 font-bold text-sm">Spesimen Nursery Khadir Florist</span>
                                </div>
                            @endif

                            <!-- Overlay Gradient for Badges -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-black/20 pointer-events-none"></div>
                            
                            <!-- Badges Overlay Top Left -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                                @if($product->category)
                                    <span class="bg-white/95 backdrop-blur-md text-emerald-800 border border-emerald-200 px-3.5 py-1.5 rounded-full text-xs font-bold shadow-md flex items-center gap-1.5 w-fit">
                                        <i class="fas fa-tag text-[10px] text-emerald-600"></i>
                                        {{ $product->category->name }}
                                    </span>
                                @endif
                                
                                @if($product->status === 'available' && $product->is_active)
                                    <span class="bg-emerald-600/95 backdrop-blur-md text-white px-3.5 py-1.5 rounded-full text-xs font-bold shadow-md flex items-center gap-1.5 w-fit">
                                        <span class="w-2 h-2 rounded-full bg-green-300 animate-ping inline-block"></span>
                                        Tersedia • Koleksi Asli
                                    </span>
                                @else
                                    <span class="bg-rose-600/95 backdrop-blur-md text-white px-3.5 py-1.5 rounded-full text-xs font-bold shadow-md flex items-center gap-1.5 w-fit">
                                        <i class="fas fa-check-circle text-xs"></i>
                                        Spesimen Terjual
                                    </span>
                                @endif
                            </div>

                            <!-- Specimen Tag Top Right -->
                            <div class="absolute top-4 right-4 z-10">
                                <span class="bg-slate-900/80 backdrop-blur-md text-amber-300 border border-amber-400/30 px-3 py-1.5 rounded-full text-[11px] font-bold shadow-md flex items-center gap-1">
                                    <i class="fas fa-gem text-amber-400"></i>
                                    1 of 1 Spesimen
                                </span>
                            </div>

                            <!-- Expand Prompt Bottom Overlay -->
                            <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-md text-gray-800 px-3 py-1.5 rounded-xl text-xs font-semibold shadow-lg opacity-90 group-hover:opacity-100 transition-all flex items-center gap-1.5">
                                <i class="fas fa-search-plus text-emerald-600"></i>
                                <span>Perbesar Foto</span>
                            </div>
                        </div>

                        <!-- 1-of-1 Notice Box -->
                        <div class="mt-4 p-3.5 bg-emerald-50/80 border border-emerald-200/70 rounded-2xl flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <i class="fas fa-camera text-sm"></i>
                            </div>
                            <p class="text-xs text-emerald-900 leading-relaxed font-medium">
                                <strong>Real Photo Guaranteed:</strong> Foto di atas merupakan pohon aktual yang Anda terima, bukan ilustrasi generic.
                            </p>
                        </div>
                    </div>

                    <!-- Assurance Highlights Grid Under Image -->
                    <div class="grid grid-cols-2 gap-3 mt-6 pt-6 border-t border-slate-200/60">
                        <div class="flex items-start gap-2.5 p-2.5 rounded-xl bg-white/80 border border-slate-100 shadow-sm">
                            <i class="fas fa-box text-emerald-600 mt-1 text-sm"></i>
                            <div>
                                <h5 class="text-xs font-bold text-gray-800">Peti Kayu Gratis</h5>
                                <p class="text-[11px] text-gray-500 leading-tight">Standar packing kargo aman</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 p-2.5 rounded-xl bg-white/80 border border-slate-100 shadow-sm">
                            <i class="fas fa-shield-alt text-emerald-600 mt-1 text-sm"></i>
                            <div>
                                <h5 class="text-xs font-bold text-gray-800">Garansi Tiba Segar</h5>
                                <p class="text-[11px] text-gray-500 leading-tight">Jaminan pohon hidup 100%</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 p-2.5 rounded-xl bg-white/80 border border-slate-100 shadow-sm">
                            <i class="fas fa-leaf text-emerald-600 mt-1 text-sm"></i>
                            <div>
                                <h5 class="text-xs font-bold text-gray-800">Bebas Kutu & Hama</h5>
                                <p class="text-[11px] text-gray-500 leading-tight">Karantina steril nursery</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 p-2.5 rounded-xl bg-white/80 border border-slate-100 shadow-sm">
                            <i class="fas fa-user-md text-emerald-600 mt-1 text-sm"></i>
                            <div>
                                <h5 class="text-xs font-bold text-gray-800">Bimbingan Seumur Hidup</h5>
                                <p class="text-[11px] text-gray-500 leading-tight">Konsultasi dokter bonsai</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Product Information, Specs & Actions (7 cols) -->
                <div class="lg:col-span-7 p-6 md:p-10 lg:p-12 flex flex-col justify-between">
                    <div>
                        <!-- Botanical Name & SKU Badges -->
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-xs font-semibold italic text-emerald-800 bg-emerald-100/70 border border-emerald-200 px-3 py-1 rounded-lg">
                                    <i class="fas fa-leaf text-[10px] mr-1 text-emerald-600"></i>
                                    {{ $product->species ?: 'Spesies Spesial' }}
                                </span>
                                <span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-2.5 py-1 rounded-lg flex items-center gap-1.5">
                                    <i class="fas fa-heartbeat text-rose-500 text-[10px]"></i>
                                    {{ $product->health_status ?: 'Prima / Sangat Sehat' }}
                                </span>
                            </div>

                            <!-- SKU with Copy Button -->
                            <button type="button" onclick="copySku('{{ $product->code }}')" title="Klik untuk salin SKU" class="text-xs font-mono font-medium text-gray-500 bg-gray-100 hover:bg-gray-200 border border-gray-200 px-2.5 py-1 rounded-lg transition-colors flex items-center gap-1.5 group">
                                <span>SKU: {{ $product->code }}</span>
                                <i class="far fa-copy text-gray-400 group-hover:text-emerald-600"></i>
                            </button>
                        </div>

                        <!-- Product Title -->
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight mb-3 leading-snug">
                            {{ $product->name }}
                        </h1>

                        <!-- Rating & Review Count Snippet -->
                        <div class="flex items-center gap-3 mb-6 pb-5 border-b border-gray-100 flex-wrap">
                            @php
                                $ratingAvg = round($product->reviews_avg_rating ?: ($product->reviews->avg('rating') ?: 0), 1);
                                $reviewCount = $product->reviews_count !== null ? $product->reviews_count : $product->reviews->count();
                            @endphp
                            <div class="flex items-center gap-1 text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($ratingAvg))
                                        <i class="fas fa-star text-sm"></i>
                                    @elseif($i - $ratingAvg < 1 && $i - $ratingAvg > 0)
                                        <i class="fas fa-star-half-alt text-sm"></i>
                                    @else
                                        <i class="far fa-star text-sm text-gray-300"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($ratingAvg, 1) }}</span>
                            <span class="text-gray-300">•</span>
                            <a href="#tabs-section" onclick="switchTab('reviews')" class="text-xs md:text-sm font-medium text-emerald-600 hover:text-emerald-700 hover:underline">
                                {{ $reviewCount }} Ulasan Kolektor
                            </a>
                            <span class="text-gray-300">•</span>
                            <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full">
                                Terverifikasi Khadir Florist
                            </span>
                        </div>

                        <!-- Pricing Display -->
                        <div class="bg-gradient-to-r from-emerald-50/70 via-green-50/40 to-transparent p-5 rounded-2xl border border-emerald-100 mb-6">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 block mb-1">Harga Koleksi Resmi</span>
                            <div class="flex items-baseline gap-3">
                                <span class="text-3xl md:text-4xl font-black text-emerald-700 tracking-tight">
                                    Rp {{ number_format($product->current_value ?? 0, 0, ',', '.') }}
                                </span>
                                <span class="text-xs text-gray-500 font-medium">/ 1 Pohon Spesimen</span>
                            </div>
                            <div class="flex items-center gap-2 mt-2 text-xs text-emerald-800">
                                <i class="fas fa-check-circle text-emerald-600"></i>
                                <span>Termasuk pot premium pilihan, media tanam matang & nutrisi awal</span>
                            </div>
                        </div>

                        <!-- Brief Story / Notes Snippet -->
                        <div class="text-gray-600 text-sm leading-relaxed mb-6">
                            <p>
                                {{ $product->notes ?: 'Spesimen bonsai eksklusif karya master nursery Khadir Florist. Menampilkan kematangan proporsi tajuk harmonis, perakaran kokoh (nebari), serta karakter batang berkelas yang siap menjadi pusat ketenangan di ruangan Anda.' }}
                            </p>
                        </div>

                        <!-- Quick Technical Specification Grid (6 At-A-Glance Cards) -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-8">
                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-100/80 text-emerald-700 flex items-center justify-center shrink-0">
                                    <i class="fas fa-ruler-vertical text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] text-gray-500 font-medium">Tinggi Pohon</p>
                                    <p class="text-xs font-bold text-gray-900">{{ $product->height_cm ? $product->height_cm . ' cm' : 'Proporsional' }}</p>
                                </div>
                            </div>

                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-100/80 text-emerald-700 flex items-center justify-center shrink-0">
                                    <i class="fas fa-circle-notch text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] text-gray-500 font-medium">Diameter Batang</p>
                                    <p class="text-xs font-bold text-gray-900">{{ $product->trunk_diameter_cm ? $product->trunk_diameter_cm . ' cm' : 'Harmonis' }}</p>
                                </div>
                            </div>

                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-100/80 text-emerald-700 flex items-center justify-center shrink-0">
                                    <i class="fas fa-hourglass-half text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] text-gray-500 font-medium">Usia Pohon</p>
                                    <p class="text-xs font-bold text-gray-900">
                                        {{ $product->age_years ? $product->age_years . ' Thn' : '-' }} {{ $product->age_months ? $product->age_months . ' Bln' : '' }}
                                    </p>
                                </div>
                            </div>

                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-100/80 text-emerald-700 flex items-center justify-center shrink-0">
                                    <i class="fas fa-sun text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] text-gray-500 font-medium">Kebutuhan Sinar</p>
                                    <p class="text-xs font-bold text-gray-900 truncate" title="{{ $product->light_requirement }}">{{ $product->light_requirement ?: 'Sinar Cukup' }}</p>
                                </div>
                            </div>

                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-100/80 text-emerald-700 flex items-center justify-center shrink-0">
                                    <i class="fas fa-water text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] text-gray-500 font-medium">Penyiraman</p>
                                    <p class="text-xs font-bold text-gray-900 truncate" title="{{ $product->watering_frequency }}">{{ $product->watering_frequency ?: '1-2x Sehari' }}</p>
                                </div>
                            </div>

                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-100/80 text-emerald-700 flex items-center justify-center shrink-0">
                                    <i class="fas fa-mountain text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] text-gray-500 font-medium">Tipe Pot</p>
                                    <p class="text-xs font-bold text-gray-900 truncate" title="{{ $product->pot_type }}">{{ $product->pot_type ?: 'Keramik' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Hub Buttons (Direct Buy, Cart, Chat Kurator) -->
                    <div id="product-actions" class="pt-4 border-t border-gray-100">
                        @if($product->status === 'available' && $product->is_active)
                            <div class="flex flex-col sm:flex-row gap-3">
                                <!-- Beli Langsung (Instant Checkout) -->
                                <button type="button" onclick="addToCart('{{ $product->id }}', true)" class="flex-1 bg-gradient-to-r from-emerald-600 via-emerald-500 to-green-600 text-white px-7 py-4 rounded-2xl font-bold shadow-lg shadow-emerald-600/25 hover:shadow-xl hover:shadow-emerald-600/35 hover:from-emerald-700 hover:to-green-700 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 group text-sm md:text-base">
                                    <i class="fas fa-bolt text-yellow-300 group-hover:scale-110 transition-transform"></i>
                                    <span>Beli Sekarang</span>
                                </button>
                                
                                <!-- Tambah ke Keranjang -->
                                <button type="button" onclick="addToCart('{{ $product->id }}', false)" class="sm:flex-none flex-1 bg-emerald-50/80 text-emerald-700 border-2 border-emerald-200/80 hover:bg-emerald-100/80 hover:border-emerald-300 px-6 py-4 rounded-2xl font-bold transition-all flex items-center justify-center gap-2 text-sm md:text-base">
                                    <i class="fas fa-cart-plus text-emerald-600"></i>
                                    <span>+ Keranjang</span>
                                </button>
                            </div>

                            <!-- Tanya Kurator via WhatsApp / Live Chat -->
                            <div class="mt-3 flex items-center justify-between gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-200/70">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-xs shadow-sm">
                                        <i class="fab fa-whatsapp"></i>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-xs font-bold text-gray-800">Ingin Lihat Video 360° Terkini?</p>
                                        <p class="text-[11px] text-gray-500">Hubungi kurator nursery untuk inspeksi daun & akar</p>
                                    </div>
                                </div>
                                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Khadir Florist, saya tertarik dengan bonsai ' . $product->name . ' (SKU: ' . $product->code . '). Apakah bisa kirim video update kondisi terbarunya?') }}" target="_blank" class="px-3.5 py-1.5 bg-white text-emerald-700 hover:text-emerald-800 border border-emerald-300 hover:border-emerald-400 rounded-xl text-xs font-bold transition-colors shrink-0 shadow-sm">
                                    Chat Kurator <i class="fas fa-arrow-right text-[10px] ml-1"></i>
                                </a>
                            </div>

                        @else
                            <div class="p-6 bg-slate-100 rounded-2xl text-center border border-slate-200">
                                <i class="fas fa-check-circle text-3xl text-gray-400 mb-2"></i>
                                <h4 class="font-bold text-gray-800 text-lg">Spesimen Telah Dikoleksi (Terjual)</h4>
                                <p class="text-sm text-gray-500 max-w-md mx-auto mb-4">
                                    Pohon ini telah menjadi milik kolektor lain. Jelajahi koleksi bonsai unggulan kami yang masih tersedia dengan karakter serupa.
                                </p>
                                <a href="{{ route('shop.produk', $product->category ? ['kategori' => $product->category->name] : []) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white rounded-xl font-bold text-sm shadow hover:bg-emerald-700 transition-colors">
                                    <i class="fas fa-search"></i>
                                    <span>Cari Koleksi Serupa Lainnya</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <!-- DETAILED CONTENT TABS SECTION -->
        <div id="tabs-section" class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden mb-16 scroll-mt-24">
            
            <!-- Tabs Navigation Header Bar -->
            <div class="border-b border-gray-100 bg-slate-50/70 p-2 md:p-4">
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar scroll-smooth">
                    <button type="button" onclick="switchTab('description')" id="tab-btn-description" class="tab-nav-btn active-tab px-4 md:px-6 py-3 rounded-2xl text-xs md:text-sm font-bold transition-all flex items-center gap-2 shrink-0">
                        <i class="fas fa-align-left text-xs"></i>
                        <span>Deskripsi & Filosofi</span>
                    </button>

                    <button type="button" onclick="switchTab('specs')" id="tab-btn-specs" class="tab-nav-btn inactive-tab px-4 md:px-6 py-3 rounded-2xl text-xs md:text-sm font-bold transition-all flex items-center gap-2 shrink-0">
                        <i class="fas fa-list-check text-xs"></i>
                        <span>Spesifikasi Lengkap</span>
                    </button>

                    <button type="button" onclick="switchTab('care')" id="tab-btn-care" class="tab-nav-btn inactive-tab px-4 md:px-6 py-3 rounded-2xl text-xs md:text-sm font-bold transition-all flex items-center gap-2 shrink-0">
                        <i class="fas fa-hand-holding-heart text-xs"></i>
                        <span>Panduan & Riwayat Rawat</span>
                        @if($product->perawatans->count() > 0)
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        @endif
                    </button>

                    <button type="button" onclick="switchTab('shipping')" id="tab-btn-shipping" class="tab-nav-btn inactive-tab px-4 md:px-6 py-3 rounded-2xl text-xs md:text-sm font-bold transition-all flex items-center gap-2 shrink-0">
                        <i class="fas fa-truck-fast text-xs"></i>
                        <span>Pengemasan & Garansi</span>
                    </button>

                    <button type="button" onclick="switchTab('reviews')" id="tab-btn-reviews" class="tab-nav-btn inactive-tab px-4 md:px-6 py-3 rounded-2xl text-xs md:text-sm font-bold transition-all flex items-center gap-2 shrink-0">
                        <i class="fas fa-star text-xs text-amber-400"></i>
                        <span>Ulasan Kolektor ({{ $product->reviews->count() }})</span>
                    </button>
                </div>
            </div>

            <!-- Tab Content Container -->
            <div class="p-6 md:p-10 lg:p-12">
                
                <!-- TAB 1: DESKRIPSI & FILOSOFI -->
                <div id="tab-content-description" class="tab-pane active-pane space-y-8">
                    <div>
                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="w-2 h-6 rounded-full bg-emerald-500 inline-block"></span>
                            Profil Artistik & Karakter Spesimen
                        </h3>
                        <div class="prose prose-emerald max-w-none text-gray-600 leading-relaxed space-y-4">
                            <p class="text-base md:text-lg text-gray-700 font-medium">
                                {{ $product->notes ?: 'Setiap lekukan dahan dan kerapatan daun pada bonsai ini dibentuk melalui proses penataan kawat (wiring) dan pemangkasan berkala selama bertahun-tahun untuk menghasilkan harmoni estetika visual yang matang.' }}
                            </p>
                            <p>
                                Bonsai jenis <strong>{{ $product->species ?: $product->name }}</strong> terkenal dengan ketahanan batang dan daya adaptasinya yang istimewa di iklim tropis. Struktur perakaran yang kokoh mencerminkan simbol ketangguhan dan kedamaian alam yang dihadirkan dalam wadah pot keramik berkualitas tinggi.
                            </p>
                        </div>
                    </div>

                    <!-- Placement Recommendations -->
                    <div class="bg-gradient-to-r from-emerald-50/80 via-white to-slate-50 p-6 rounded-3xl border border-emerald-100">
                        <h4 class="font-bold text-gray-800 text-sm md:text-base mb-4 flex items-center gap-2">
                            <i class="fas fa-compass text-emerald-600"></i>
                            Rekomendasi Penempatan Terbaik
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="bg-white p-4 rounded-2xl border border-emerald-100 shadow-sm">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center mb-2 font-bold text-xs">
                                    01
                                </div>
                                <h5 class="font-bold text-gray-800 text-sm mb-1">Teras atau Balkon Semi-Outdoor</h5>
                                <p class="text-xs text-gray-500">Mendapatkan sirkulasi angin alami dan sinar matahari pagi yang melimpah.</p>
                            </div>

                            <div class="bg-white p-4 rounded-2xl border border-emerald-100 shadow-sm">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center mb-2 font-bold text-xs">
                                    02
                                </div>
                                <h5 class="font-bold text-gray-800 text-sm mb-1">Ruang Tamu & Meja Display</h5>
                                <p class="text-xs text-gray-500">Memberikan sentuhan zen & kemewahan alami. Rotasi ke area terang 2-3 hari sekali.</p>
                            </div>

                            <div class="bg-white p-4 rounded-2xl border border-emerald-100 shadow-sm">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center mb-2 font-bold text-xs">
                                    03
                                </div>
                                <h5 class="font-bold text-gray-800 text-sm mb-1">Taman Kering / Courtyard</h5>
                                <p class="text-xs text-gray-500">Harmonis dipadukan dengan bebatuan alam, kerikil putih, dan elemen kayu.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: SPESIFIKASI LENGKAP -->
                <div id="tab-content-specs" class="tab-pane hidden space-y-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center gap-2">
                            <span class="w-2 h-6 rounded-full bg-emerald-500 inline-block"></span>
                            Spesifikasi Botani & Dimensi Fisik
                        </h3>
                        <span class="text-xs font-mono bg-slate-100 text-gray-600 px-3 py-1 rounded-full">
                            SKU: {{ $product->code }}
                        </span>
                    </div>

                    <!-- Comprehensive Specs Table -->
                    <div class="overflow-hidden border border-slate-200/80 rounded-2xl shadow-sm">
                        <table class="w-full text-left text-sm">
                            <tbody class="divide-y divide-slate-100">
                                <tr class="bg-slate-50/50 hover:bg-emerald-50/30 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-gray-600 w-1/3">Nama Pohon / Varietas</td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900">{{ $product->name }}</td>
                                </tr>
                                <tr class="hover:bg-emerald-50/30 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-gray-600">Nama Ilmiah / Botani</td>
                                    <td class="py-3.5 px-4 font-bold italic text-emerald-800">{{ $product->species ?: 'Spesies Spesifik Nursery' }}</td>
                                </tr>
                                <tr class="bg-slate-50/50 hover:bg-emerald-50/30 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-gray-600">Kategori / Klasifikasi</td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900">{{ $product->category->name ?? 'Koleksi Bonsai' }}</td>
                                </tr>
                                <tr class="hover:bg-emerald-50/30 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-gray-600">Estimasi Usia Tanaman</td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900">
                                        {{ $product->age_years ? $product->age_years . ' Tahun' : '-' }} {{ $product->age_months ? $product->age_months . ' Bulan' : '' }}
                                    </td>
                                </tr>
                                <tr class="bg-slate-50/50 hover:bg-emerald-50/30 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-gray-600">Tinggi Pohon (dari bibir pot)</td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900">{{ $product->height_cm ? $product->height_cm . ' cm' : 'Ukuran Standar' }}</td>
                                </tr>
                                <tr class="hover:bg-emerald-50/30 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-gray-600">Diameter Pangkal Batang</td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900">{{ $product->trunk_diameter_cm ? $product->trunk_diameter_cm . ' cm' : 'Karakter Kokoh' }}</td>
                                </tr>
                                <tr class="bg-slate-50/50 hover:bg-emerald-50/30 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-gray-600">Material & Tipe Pot</td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900">{{ $product->pot_type ?: 'Keramik Glazur Pilihan' }}</td>
                                </tr>
                                <tr class="hover:bg-emerald-50/30 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-gray-600">Ukuran Pot</td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900">{{ $product->pot_size ?: 'Proporsional dengan kanopi' }}</td>
                                </tr>
                                <tr class="bg-slate-50/50 hover:bg-emerald-50/30 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-gray-600">Kondisi Kesehatan Daun & Akar</td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-800 text-xs font-bold">
                                            <i class="fas fa-check-circle"></i>
                                            {{ $product->health_status ?: 'Prima & Sangat Sehat' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-emerald-50/30 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-gray-600">Lokasi Greenhouse / Asal</td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900">{{ $product->location ?: 'Greenhouse Utama Khadir Florist' }}</td>
                                </tr>
                                @if($product->acquisition_date)
                                <tr class="bg-slate-50/50 hover:bg-emerald-50/30 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-gray-600">Tanggal Registrasi Koleksi</td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900">{{ \Carbon\Carbon::parse($product->acquisition_date)->format('d F Y') }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 3: PANDUAN & RIWAYAT PERAWATAN -->
                <div id="tab-content-care" class="tab-pane hidden space-y-8">
                    <div>
                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2 flex items-center gap-2">
                            <span class="w-2 h-6 rounded-full bg-emerald-500 inline-block"></span>
                            Panduan Perawatan & SOP Pemeliharaan
                        </h3>
                        <p class="text-sm text-gray-500">
                            Ikuti pedoman praktis di bawah untuk menjaga kesehatan daun, percabangan, dan kesuburan media tanam.
                        </p>
                    </div>

                    <!-- 4 Pilar Kartu Perawatan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Cahaya -->
                        <div class="bg-amber-50/50 border border-amber-200/60 p-5 rounded-2xl flex flex-col justify-between">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mb-3">
                                    <i class="fas fa-sun text-lg"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 text-base mb-1">Sinar Matahari</h4>
                                <p class="text-xs text-gray-600 mb-3">
                                    {{ $product->light_requirement ?: 'Memerlukan sinar matahari pagi 4-6 jam sehari agar fotosintesis optimal.' }}
                                </p>
                            </div>
                            <span class="text-[11px] font-bold text-amber-800 bg-amber-100/70 px-2.5 py-1 rounded-lg w-fit">
                                Rekomendasi: Sinar Parsial - Penuh
                            </span>
                        </div>

                        <!-- Penyiraman -->
                        <div class="bg-blue-50/50 border border-blue-200/60 p-5 rounded-2xl flex flex-col justify-between">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-3">
                                    <i class="fas fa-droplet text-lg"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 text-base mb-1">Penyiraman</h4>
                                <p class="text-xs text-gray-600 mb-3">
                                    Frekuensi: <strong>{{ $product->watering_frequency ?: '1-2x Sehari' }}</strong>. Siram hingga air keluar dari lubang bawah pot.
                                </p>
                            </div>
                            <div class="text-[11px] text-blue-800 bg-blue-100/70 px-2.5 py-1 rounded-lg w-fit font-medium">
                                Terakhir: {{ $product->last_watered_at ? \Carbon\Carbon::parse($product->last_watered_at)->format('d M Y') : 'Terjadwal Rutin' }}
                            </div>
                        </div>

                        <!-- Pemangkasan -->
                        <div class="bg-emerald-50/50 border border-emerald-200/60 p-5 rounded-2xl flex flex-col justify-between">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">
                                    <i class="fas fa-scissors text-lg"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 text-base mb-1">Pemangkasan (Pruning)</h4>
                                <p class="text-xs text-gray-600 mb-3">
                                    Frekuensi: <strong>{{ $product->pruning_frequency ?: '1-2 Bulan Sekali' }}</strong>. Jaga proporsi tajuk dan buang tunas liar.
                                </p>
                            </div>
                            <div class="text-[11px] text-emerald-800 bg-emerald-100/70 px-2.5 py-1 rounded-lg w-fit font-medium">
                                Terakhir: {{ $product->last_pruned_at ? \Carbon\Carbon::parse($product->last_pruned_at)->format('d M Y') : 'Tajuk Proporsional' }}
                            </div>
                        </div>

                        <!-- Pemupukan -->
                        <div class="bg-purple-50/50 border border-purple-200/60 p-5 rounded-2xl flex flex-col justify-between">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mb-3">
                                    <i class="fas fa-flask text-lg"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 text-base mb-1">Pemupukan</h4>
                                <p class="text-xs text-gray-600 mb-3">
                                    Frekuensi: <strong>{{ $product->fertilizing_frequency ?: '3-4 Minggu Sekali' }}</strong>. Gunakan pupuk organik slow-release.
                                </p>
                            </div>
                            <div class="text-[11px] text-purple-800 bg-purple-100/70 px-2.5 py-1 rounded-lg w-fit font-medium">
                                Terakhir: {{ $product->last_fertilized_at ? \Carbon\Carbon::parse($product->last_fertilized_at)->format('d M Y') : 'Nutrisi Tercukupi' }}
                            </div>
                        </div>
                    </div>

                    <!-- RIWAYAT LOG PERAWATAN NURSERY -->
                    <div class="mt-8 pt-8 border-t border-slate-100">
                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-clipboard-list text-emerald-600"></i>
                            Jurnal & Riwayat Perawatan Nursery Khadir Florist
                        </h4>

                        @if($product->perawatans && $product->perawatans->count() > 0)
                            <div class="space-y-3">
                                @foreach($product->perawatans as $log)
                                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <h5 class="font-bold text-gray-900 text-sm">{{ $log->jenis_perawatan }}</h5>
                                                    <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full {{ $log->status === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                                        {{ ucfirst($log->status ?? 'selesai') }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-600 mt-1">{{ $log->catatan ?: 'Tindakan perawatan rutin berhasil diselesaikan sesuai SOP.' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-400 font-mono self-start sm:self-center shrink-0">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            {{ \Carbon\Carbon::parse($log->tanggal_perawatan)->format('d M Y') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-6 rounded-2xl bg-emerald-50/60 border border-emerald-100 flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                                    <i class="fas fa-award"></i>
                                </div>
                                <div>
                                    <h5 class="font-bold text-emerald-950 text-sm">Standar QC Nursery Khadir Florist</h5>
                                    <p class="text-xs text-emerald-800 leading-relaxed mt-0.5">
                                        Spesimen ini telah lolos 3 tahap inspeksi kesehatan tanaman: verifikasi kekuatan perakaran, pembasmian hama preventif, serta pemupukan nutrisi dasar sebelum dipasarkan.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- TAB 4: PENGEMASAN & GARANSI -->
                <div id="tab-content-shipping" class="tab-pane hidden space-y-8">
                    <div>
                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2 flex items-center gap-2">
                            <span class="w-2 h-6 rounded-full bg-emerald-500 inline-block"></span>
                            SOP Ekspedisi Khusus & Garansi Tiba Segar
                        </h3>
                        <p class="text-sm text-gray-500">
                            Kami memperlakukan setiap pohon sebagai karya seni hidup yang bernilai tinggi dengan protokol keamanan pengiriman terketat.
                        </p>
                    </div>

                    <!-- 4 Langkah Packing Kayu -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                            <span class="text-2xl font-black text-emerald-600 block mb-2">01</span>
                            <h4 class="font-bold text-gray-800 text-sm mb-1">Proteksi Media Tanam</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                Media tanam dibasahi optimal dan dibungkus rapat dengan plastik steril agar tanah tidak tumpah dan kelembapan akar terjaga.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                            <span class="text-2xl font-black text-emerald-600 block mb-2">02</span>
                            <h4 class="font-bold text-gray-800 text-sm mb-1">Penguncian Pot Kuat</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                Pot keramik diikat kuat menggunakan strap pengunci khusus pada dasar bantalan kayu agar tidak bergeser meski peti dibalik.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                            <span class="text-2xl font-black text-emerald-600 block mb-2">03</span>
                            <h4 class="font-bold text-gray-800 text-sm mb-1">Peti Kayu Berpori</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                Rangka peti kayu palet kokoh melindungi dahan dari benturan keras dengan tetap memberikan sirkulasi udara alami bagi dedaunan.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                            <span class="text-2xl font-black text-emerald-600 block mb-2">04</span>
                            <h4 class="font-bold text-gray-800 text-sm mb-1">Kargo Prioritas Kilat</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                Dikirim menggunakan kurir kargo spesialis tanaman hidup dengan label fragile khusus dan pemantauan resi real-time.
                            </p>
                        </div>
                    </div>

                    <!-- Garansi Box -->
                    <div class="bg-gradient-to-r from-emerald-600 to-green-700 text-white p-6 md:p-8 rounded-3xl shadow-lg">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                            <div class="space-y-2 max-w-2xl">
                                <span class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider inline-block">
                                    Garansi 100% Khadir Florist
                                </span>
                                <h4 class="text-xl md:text-2xl font-black leading-tight">Jaminan Tanaman Hidup Sampai di Tempat</h4>
                                <p class="text-emerald-100 text-xs md:text-sm leading-relaxed">
                                    Jika tanaman mengalami patah batang fatal atau mati saat paket pertama kali diterima, kami memberikan penggantian pohon setara atau garansi penanganan hingga sehat kembali. Cukup sertakan video unboxing 1x24 jam sejak paket diterima.
                                </p>
                            </div>
                            <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Khadir Florist, saya ingin tanya kebijakan garansi pengiriman.') }}" target="_blank" class="px-6 py-3.5 bg-white text-emerald-800 hover:bg-emerald-50 rounded-2xl font-bold text-xs md:text-sm shadow-md transition-colors shrink-0">
                                Tanya Garansi via WA
                            </a>
                        </div>
                    </div>
                </div>

                <!-- TAB 5: ULASAN & TESTIMONI -->
                <div id="tab-content-reviews" class="tab-pane hidden space-y-8">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center gap-2">
                                <span class="w-2 h-6 rounded-full bg-emerald-500 inline-block"></span>
                                Ulasan Kolektor & Pembeli
                            </h3>
                            <p class="text-sm text-gray-500">Penilaian murni dari pelanggan terverifikasi Khadir Florist</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 font-medium">Berdasarkan ulasan transaksi sukses</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        <!-- Rating Summary Score Card (4 cols) -->
                        <div class="lg:col-span-4 bg-slate-50 border border-slate-100 rounded-3xl p-6 md:p-8 text-center flex flex-col justify-center">
                            <h4 class="text-6xl font-black text-emerald-600 mb-2 tracking-tight">
                                {{ number_format($product->reviews->avg('rating') ?: 0, 1) }}
                            </h4>
                            <div class="flex justify-center text-amber-400 text-xl mb-2">
                                @php $avgScore = $product->reviews->avg('rating') ?: 0; @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($avgScore))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - $avgScore < 1 && $i - $avgScore > 0)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star text-gray-300"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-gray-500 text-xs font-semibold mb-6">
                                {{ $product->reviews->count() }} Ulasan Masuk
                            </p>

                            <!-- Rating Distribution Bars -->
                            <div class="space-y-2 text-left">
                                @php $totalRev = max(1, $product->reviews->count()); @endphp
                                @foreach([5, 4, 3, 2, 1] as $star)
                                    @php
                                        $countForStar = $product->reviews->where('rating', $star)->count();
                                        $percent = ($countForStar / $totalRev) * 100;
                                    @endphp
                                    <div class="flex items-center gap-2 text-xs">
                                        <span class="w-7 text-gray-600 font-semibold flex items-center gap-1">
                                            {{ $star }} <i class="fas fa-star text-[10px] text-amber-400"></i>
                                        </span>
                                        <div class="flex-grow h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <span class="w-6 text-right text-gray-400 font-mono text-[11px]">{{ $countForStar }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Review Cards List (8 cols) -->
                        <div class="lg:col-span-8 space-y-4">
                            @forelse($product->reviews->sortByDesc('created_at') as $review)
                                <div class="p-6 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow transition-shadow">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-green-600 text-white font-black text-sm flex items-center justify-center shrink-0 shadow-sm">
                                                {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <h5 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                                    {{ $review->user->name ?? 'Pembeli' }}
                                                    <span class="text-[10px] bg-emerald-50 text-emerald-700 font-semibold px-2 py-0.5 rounded-full border border-emerald-200">
                                                        <i class="fas fa-check text-[9px] mr-1"></i>Pembeli Terverifikasi
                                                    </span>
                                                </h5>
                                                <span class="text-xs text-gray-400">{{ $review->created_at ? $review->created_at->diffForHumans() : '-' }}</span>
                                            </div>
                                        </div>

                                        <div class="flex text-amber-400 text-xs">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= $review->rating ? 'fas' : 'far text-gray-300' }} fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>

                                    <p class="text-gray-700 text-sm leading-relaxed mb-3">
                                        "{{ $review->comment ?: 'Tanaman bonsai tiba dalam kondisi sangat sehat, packing peti kayu sangat rapi dan aman. Sangat puas!' }}"
                                    </p>

                                    @if($review->image_path)
                                        <div class="mt-2 w-28 h-28 rounded-xl overflow-hidden shadow-sm border border-gray-200 cursor-pointer group relative" onclick="window.open('{{ asset('storage/' . $review->image_path) }}', '_blank')">
                                            <img src="{{ asset('storage/' . $review->image_path) }}" alt="Foto Ulasan" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs">
                                                <i class="fas fa-search-plus"></i>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                    <i class="fas fa-comments text-4xl text-gray-300 mb-3"></i>
                                    <h5 class="font-bold text-gray-700 text-base mb-1">Belum Ada Ulasan Masuk</h5>
                                    <p class="text-xs text-gray-400 max-w-sm mx-auto">
                                        Jadilah kolektor pertama yang memiliki spesimen istimewa ini dan bagikan pengalaman Anda!
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- RELATED PRODUCTS SECTION -->
        @if($relatedProducts && $relatedProducts->count() > 0)
        <div class="mt-8 mb-16">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest block mb-1">Rekomendasi Koleksi</span>
                    <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Koleksi Serupa Pilihan</h3>
                </div>
                <a href="{{ route('shop.produk') }}" class="text-xs md:text-sm font-bold text-emerald-600 hover:text-emerald-700 hover:underline flex items-center gap-1.5">
                    <span>Lihat Semua Katalog</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <div class="group bg-white rounded-3xl shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 border border-slate-100 overflow-hidden flex flex-col justify-between">
                    <div>
                        <!-- Related Image -->
                        <a href="{{ route('shop.produk.show', $related->id) }}" class="block relative aspect-square overflow-hidden bg-slate-100">
                            @if($related->image_path)
                                <img src="{{ asset('storage/' . $related->image_path) }}" alt="{{ $related->name }}"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-emerald-100 to-green-200 flex items-center justify-center">
                                    <i class="fas fa-seedling text-5xl text-emerald-400"></i>
                                </div>
                            @endif

                            <!-- Related Badges -->
                            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                @if($related->category)
                                    <span class="bg-white/90 backdrop-blur-md text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm">
                                        {{ $related->category->name }}
                                    </span>
                                @endif
                            </div>

                            <div class="absolute bottom-3 right-3 bg-white/90 backdrop-blur-md text-emerald-700 w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-md">
                                <i class="fas fa-eye text-xs"></i>
                            </div>
                        </a>
                        
                        <!-- Related Details -->
                        <div class="p-5">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <span class="text-[11px] font-semibold italic text-emerald-700 truncate max-w-[150px]">
                                    {{ $related->species ?: 'Spesies Unggulan' }}
                                </span>
                                @if($related->reviews_avg_rating)
                                    <span class="text-[11px] font-bold text-gray-700 flex items-center gap-1">
                                        <i class="fas fa-star text-amber-400 text-[10px]"></i>
                                        {{ number_format($related->reviews_avg_rating, 1) }}
                                    </span>
                                @endif
                            </div>

                            <a href="{{ route('shop.produk.show', $related->id) }}">
                                <h4 class="font-bold text-gray-900 text-base leading-snug mb-2 group-hover:text-emerald-600 transition-colors line-clamp-1">
                                    {{ $related->name }}
                                </h4>
                            </a>

                            <div class="flex items-baseline justify-between mt-3">
                                <div>
                                    <span class="text-xs text-gray-400 block text-[10px]">Harga</span>
                                    <span class="text-lg font-black text-emerald-700">
                                        Rp {{ number_format($related->current_value ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                                <span class="text-[11px] text-gray-500 font-mono">
                                    {{ $related->height_cm ? $related->height_cm . ' cm' : '' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Related Action -->
                    <div class="p-5 pt-0">
                        <button type="button" onclick="addToCart('{{ $related->id }}', true)" class="w-full bg-slate-900 hover:bg-emerald-600 text-white py-2.5 rounded-xl text-xs font-bold transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <i class="fas fa-shopping-cart text-[11px]"></i>
                            <span>Beli Sekarang</span>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

<!-- STICKY BOTTOM MOBILE ACTION BAR -->
@if($product->status === 'available' && $product->is_active)
<div id="mobile-sticky-bar" class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 p-3 px-4 shadow-2xl flex items-center justify-between gap-3 transform translate-y-full transition-transform duration-300 md:hidden">
    <div class="flex items-center gap-2.5 truncate">
        @if($product->image_path)
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-11 h-11 rounded-xl object-cover border border-slate-200 shrink-0">
        @endif
        <div class="truncate">
            <h5 class="text-xs font-bold text-gray-900 truncate">{{ $product->name }}</h5>
            <span class="text-sm font-black text-emerald-600">Rp {{ number_format($product->current_value ?? 0, 0, ',', '.') }}</span>
        </div>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <button type="button" onclick="addToCart('{{ $product->id }}', false)" class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold">
            <i class="fas fa-cart-plus text-xs"></i>
        </button>
        <button type="button" onclick="addToCart('{{ $product->id }}', true)" class="px-4 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold shadow-md">
            Beli
        </button>
    </div>
</div>
@endif

<!-- IMAGE LIGHTBOX MODAL -->
<div id="image-lightbox" class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md hidden opacity-0 transition-opacity duration-300 flex items-center justify-center p-4">
    <button type="button" onclick="closeImageLightbox()" class="absolute top-5 right-5 text-white/80 hover:text-white text-2xl w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
        <i class="fas fa-times"></i>
    </button>
    <div class="max-w-4xl max-h-[85vh] flex flex-col items-center">
        @if($product->image_path)
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="max-w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl">
        @endif
        <div class="mt-4 text-center text-white">
            <h4 class="font-bold text-lg">{{ $product->name }}</h4>
            <p class="text-xs text-emerald-400 font-mono">{{ $product->code }} • {{ $product->species ?: 'Spesimen Khadir Florist' }}</p>
        </div>
    </div>
</div>

<!-- SHARE MODAL -->
<div id="share-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl transform transition-transform scale-95" id="share-modal-card">
        <div class="flex items-center justify-between mb-4">
            <h4 class="font-bold text-gray-900 text-base">Bagikan Produk Ini</h4>
            <button type="button" onclick="closeShareModal()" class="text-gray-400 hover:text-gray-600 text-lg">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <p class="text-xs text-gray-500 mb-6">Bagikan spesimen bonsai ini ke teman atau komunitas sesama pencinta tanaman hias.</p>
        
        <div class="grid grid-cols-4 gap-3 mb-6 text-center">
            <!-- WA -->
            <a href="https://wa.me/?text={{ urlencode('Lihat bonsai menawan ini: ' . $product->name . ' - ' . url()->current()) }}" target="_blank" class="flex flex-col items-center gap-1.5 group">
                <div class="w-12 h-12 rounded-2xl bg-green-500 text-white flex items-center justify-center text-xl shadow group-hover:scale-105 transition-transform">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <span class="text-[11px] text-gray-600 font-medium">WhatsApp</span>
            </a>
            <!-- Twitter/X -->
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($product->name . ' di Khadir Florist: ' . url()->current()) }}" target="_blank" class="flex flex-col items-center gap-1.5 group">
                <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-xl shadow group-hover:scale-105 transition-transform">
                    <i class="fab fa-x-twitter"></i>
                </div>
                <span class="text-[11px] text-gray-600 font-medium">Twitter</span>
            </a>
            <!-- FB -->
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="flex flex-col items-center gap-1.5 group">
                <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl shadow group-hover:scale-105 transition-transform">
                    <i class="fab fa-facebook-f"></i>
                </div>
                <span class="text-[11px] text-gray-600 font-medium">Facebook</span>
            </a>
            <!-- Telegram -->
            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($product->name) }}" target="_blank" class="flex flex-col items-center gap-1.5 group">
                <div class="w-12 h-12 rounded-2xl bg-sky-500 text-white flex items-center justify-center text-xl shadow group-hover:scale-105 transition-transform">
                    <i class="fab fa-telegram-plane"></i>
                </div>
                <span class="text-[11px] text-gray-600 font-medium">Telegram</span>
            </a>
        </div>

        <div class="flex items-center gap-2 p-2 bg-slate-100 rounded-xl border border-slate-200">
            <input type="text" readonly value="{{ url()->current() }}" id="share-link-input" class="bg-transparent text-xs text-gray-600 flex-grow px-2 font-mono truncate focus:outline-none">
            <button type="button" onclick="copyShareLink()" class="px-3 py-1.5 bg-emerald-600 text-white text-xs font-bold rounded-lg hover:bg-emerald-700 transition-colors shrink-0">
                Salin
            </button>
        </div>
    </div>
</div>

<style>
    /* Tabs Styles */
    .active-tab {
        background-color: #059669;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }
    .inactive-tab {
        background-color: transparent;
        color: #4b5563;
    }
    .inactive-tab:hover {
        background-color: #f1f5f9;
        color: #111827;
    }
    .active-pane {
        display: block;
        animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    // Tab Switching Functionality
    function switchTab(tabId) {
        // Update Buttons
        const buttons = document.querySelectorAll('.tab-nav-btn');
        buttons.forEach(btn => {
            btn.classList.remove('active-tab');
            btn.classList.add('inactive-tab');
        });
        const targetBtn = document.getElementById('tab-btn-' + tabId);
        if (targetBtn) {
            targetBtn.classList.add('active-tab');
            targetBtn.classList.remove('inactive-tab');
        }

        // Update Panes
        const panes = document.querySelectorAll('.tab-pane');
        panes.forEach(pane => {
            pane.classList.add('hidden');
            pane.classList.remove('active-pane');
        });
        const targetPane = document.getElementById('tab-content-' + tabId);
        if (targetPane) {
            targetPane.classList.remove('hidden');
            targetPane.classList.add('active-pane');
        }
    }

    // SKU Copy helper
    function copySku(sku) {
        navigator.clipboard.writeText(sku).then(() => {
            if (typeof Swal !== 'undefined') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
                Toast.fire({
                    icon: 'success',
                    title: 'SKU ' + sku + ' berhasil disalin!'
                });
            } else {
                alert('SKU ' + sku + ' berhasil disalin!');
            }
        });
    }

    // Wishlist Local Storage Toggle
    const productId = '{{ $product->id }}';
    function checkWishlistState() {
        try {
            const wishlist = JSON.parse(localStorage.getItem('ruangbonsai_wishlist') || localStorage.getItem('bonsaiku_wishlist') || '[]');
            const icon = document.getElementById('wishlist-icon');
            const text = document.getElementById('wishlist-text');
            if (wishlist.includes(productId)) {
                icon.className = 'fas fa-heart text-rose-500';
                text.textContent = 'Disukai';
            } else {
                icon.className = 'far fa-heart';
                text.textContent = 'Favorit';
            }
        } catch(e) {}
    }

    function toggleWishlist(id) {
        try {
            let wishlist = JSON.parse(localStorage.getItem('ruangbonsai_wishlist') || localStorage.getItem('bonsaiku_wishlist') || '[]');
            const index = wishlist.indexOf(id);
            let added = false;
            if (index > -1) {
                wishlist.splice(index, 1);
            } else {
                wishlist.push(id);
                added = true;
            }
            localStorage.setItem('ruangbonsai_wishlist', JSON.stringify(wishlist));
            checkWishlistState();

            if (typeof Swal !== 'undefined') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
                Toast.fire({
                    icon: added ? 'success' : 'info',
                    title: added ? 'Ditambahkan ke daftar favorit!' : 'Dihapus dari daftar favorit.'
                });
            }
        } catch(e) {}
    }

    // Lightbox Controls
    function openImageLightbox() {
        const lb = document.getElementById('image-lightbox');
        lb.classList.remove('hidden');
        setTimeout(() => lb.classList.remove('opacity-0'), 10);
    }

    function closeImageLightbox() {
        const lb = document.getElementById('image-lightbox');
        lb.classList.add('opacity-0');
        setTimeout(() => lb.classList.add('hidden'), 300);
    }

    // Share Modal Controls
    function openShareModal() {
        const modal = document.getElementById('share-modal');
        const card = document.getElementById('share-modal-card');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }, 10);
    }

    function closeShareModal() {
        const modal = document.getElementById('share-modal');
        const card = document.getElementById('share-modal-card');
        modal.classList.add('opacity-0');
        card.classList.add('scale-95');
        card.classList.remove('scale-100');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    function copyShareLink() {
        const input = document.getElementById('share-link-input');
        input.select();
        navigator.clipboard.writeText(input.value).then(() => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Tautan Tersalin!',
                    text: 'Tautan produk berhasil disalin ke clipboard.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                alert('Tautan berhasil disalin!');
            }
            closeShareModal();
        });
    }

    // Mobile Sticky Bottom Bar Scroll Listener
    window.addEventListener('scroll', () => {
        const actions = document.getElementById('product-actions');
        const stickyBar = document.getElementById('mobile-sticky-bar');
        if (!actions || !stickyBar) return;
        
        const rect = actions.getBoundingClientRect();
        if (rect.bottom < 0) {
            stickyBar.classList.remove('translate-y-full');
        } else {
            stickyBar.classList.add('translate-y-full');
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        checkWishlistState();
    });
</script>
@endsection
