@extends('layouts.shop')

@section('content')
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm text-gray-500 font-medium">
            <a href="{{ route('shop.index') }}" class="hover:text-emerald-600 transition-colors">Beranda</a>
            <span class="mx-2"><i class="fas fa-chevron-right text-xs"></i></span>
            <a href="{{ route('shop.produk') }}" class="hover:text-emerald-600 transition-colors">Produk</a>
            <span class="mx-2"><i class="fas fa-chevron-right text-xs"></i></span>
            <span class="text-gray-800 truncate max-w-[200px] md:max-w-none">{{ $product->name }}</span>
        </nav>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                
                <!-- Product Image -->
                <div class="p-8 md:p-12 flex items-center justify-center bg-gradient-to-br from-emerald-50 to-green-100/50">
                    <div class="relative w-full max-w-md aspect-square rounded-2xl overflow-hidden shadow-2xl group">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-emerald-100 flex items-center justify-center">
                                <i class="fas fa-seedling text-8xl text-emerald-300"></i>
                            </div>
                        @endif
                        
                        <!-- Badges Overlay -->
                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            <span class="bg-green-500 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-md">
                                {{ $product->category->name ?? 'Kategori' }}
                            </span>
                            @if($product->status === 'available')
                                <span class="bg-blue-500 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-md">Tersedia</span>
                            @else
                                <span class="bg-red-500 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-md">Terjual</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <div class="mb-2">
                        <span class="text-sm font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-lg">
                            {{ $product->species ?? '-' }}
                        </span>
                        <span class="text-sm text-gray-400 ml-2 border-l border-gray-300 pl-2">SKU: {{ $product->code }}</span>
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-black text-gray-800 mb-4 leading-tight">
                        {{ $product->name }}
                    </h1>
                    
                    <div class="mb-6 flex items-end gap-4 border-b border-gray-100 pb-6">
                        <span class="text-4xl font-black text-emerald-600">
                            Rp {{ number_format($product->current_value ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="prose prose-emerald text-gray-600 mb-8 max-w-none">
                        <p class="leading-relaxed">{{ $product->description ?: 'Bonsai eksklusif dengan kualitas terbaik. Cocok untuk mempercantik ruangan atau taman Anda.' }}</p>
                    </div>

                    <!-- Specifications -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-gray-50 rounded-2xl p-4 flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-emerald-500">
                                <i class="fas fa-ruler"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Tinggi</p>
                                <p class="font-bold text-gray-800">{{ $product->height_cm ? $product->height_cm . ' cm' : '-' }}</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4 flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-emerald-500">
                                <i class="fas fa-seedling"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Umur</p>
                                <p class="font-bold text-gray-800">{{ $product->age_years ? $product->age_years . ' Tahun' : '-' }}</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4 flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-emerald-500">
                                <i class="fas fa-sun"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Sinar Matahari</p>
                                <p class="font-bold text-gray-800 truncate max-w-[120px] md:max-w-none" title="{{ $product->light_requirement }}">{{ Str::limit($product->light_requirement, 15, '...') }}</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4 flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-emerald-500">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Status Kesehatan</p>
                                <p class="font-bold text-gray-800">{{ $product->health_status ?: 'Sehat' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-auto">
                        @if($product->status === 'available' && $product->is_active)
                            <button onclick="addToCart('{{ $product->id }}', true)" class="flex-1 bg-gradient-to-r from-emerald-500 to-green-600 text-white px-8 py-4 rounded-2xl font-bold shadow-lg hover:shadow-xl hover:from-emerald-600 hover:to-green-700 transition-all transform hover:-translate-y-1 flex items-center justify-center">
                                <i class="fas fa-bolt mr-2 text-yellow-300"></i> Beli Langsung
                            </button>
                            <button onclick="addToCart('{{ $product->id }}', false)" class="sm:flex-none flex-1 bg-emerald-50 text-emerald-600 px-8 py-4 rounded-2xl font-bold border-2 border-emerald-100 hover:bg-emerald-100 hover:border-emerald-200 transition-all flex items-center justify-center">
                                <i class="fas fa-shopping-cart mr-2"></i> + Keranjang
                            </button>
                        @else
                            <button disabled class="w-full bg-gray-200 text-gray-500 px-8 py-4 rounded-2xl font-bold cursor-not-allowed flex items-center justify-center">
                                <i class="fas fa-times-circle mr-2"></i> Tidak Tersedia
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-12 bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8 md:p-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-8 border-l-4 border-emerald-500 pl-4">Ulasan Pelanggan</h3>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Rating Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-emerald-50 rounded-3xl p-8 text-center h-full flex flex-col justify-center">
                            <h4 class="text-6xl font-black text-emerald-600 mb-2">{{ number_format($product->reviews->avg('rating') ?: 0, 1) }}</h4>
                            <div class="flex justify-center text-yellow-400 text-2xl mb-4">
                                @php $avg = $product->reviews->avg('rating') ?: 0; @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= round($avg) ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                            <p class="text-gray-500 font-medium">Berdasarkan {{ $product->reviews->count() }} ulasan</p>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="lg:col-span-2 space-y-8">
                        @forelse($product->reviews->sortByDesc('created_at') as $review)
                            <div class="border-b border-gray-100 pb-8 last:border-0 last:pb-0">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center font-bold text-emerald-600 shrink-0">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-start">
                                            <h5 class="font-bold text-gray-800">{{ $review->user->name }}</h5>
                                            <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex text-yellow-400 text-xs">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-600 leading-relaxed mb-4 italic">"{{ $review->comment ?: 'Tidak ada ulasan tertulis.' }}"</p>
                                @if($review->image_path)
                                    <div class="w-32 h-32 rounded-2xl overflow-hidden shadow-md border border-gray-200 cursor-zoom-in" onclick="window.open('{{ asset('storage/' . $review->image_path) }}', '_blank')">
                                        <img src="{{ asset('storage/' . $review->image_path) }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <i class="fas fa-comment-slash text-5xl text-gray-200 mb-4"></i>
                                <p class="text-gray-400 font-medium">Belum ada ulasan untuk produk ini. Jadilah yang pertama memberikan penilaian!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-20">
            <h3 class="text-2xl font-bold text-gray-800 mb-8 border-l-4 border-emerald-500 pl-4">Produk Serupa</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($relatedProducts as $related)
                <div class="group bg-white rounded-3xl shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 border border-gray-100">
                    <a href="{{ route('shop.produk.show', $related->id) }}" class="block relative overflow-hidden">
                        @if($related->image_path)
                            <img src="{{ asset('storage/' . $related->image_path) }}" alt="{{ $related->name }}"
                                 class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-56 bg-gradient-to-br from-emerald-100 to-green-200 flex items-center justify-center">
                                <i class="fas fa-seedling text-5xl text-emerald-400"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-eye text-emerald-600"></i>
                        </div>
                    </a>
                    
                    <div class="p-6">
                        <div class="mb-2">
                            <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-lg">{{ $related->species ?? '-' }}</span>
                        </div>
                        <a href="{{ route('shop.produk.show', $related->id) }}">
                            <h4 class="text-lg font-bold text-gray-800 leading-tight mb-2 hover:text-emerald-600 transition-colors">{{ $related->name }}</h4>
                        </a>
                        <div class="mb-4">
                            <span class="text-xl font-bold text-gray-800">
                                Rp {{ number_format($related->current_value ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="addToCart('{{ $related->id }}', true)" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl hover:from-green-600 hover:to-green-700 transition-all font-semibold text-sm shadow-md">
                                <i class="fas fa-shopping-cart mr-2"></i>Beli
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>
@endsection
