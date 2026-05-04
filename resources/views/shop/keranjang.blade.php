@extends('layouts.shop')

@section('content')

<section class="py-16 bg-gradient-to-br from-gray-50 to-white min-h-[70vh]">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-gray-800 mb-2 text-center">Keranjang Belanja</h1>
        <p class="text-center text-gray-500 mb-10">Selesaikan pembelian bonsai impian Anda</p>
        
        @if(session('success'))
        <div class="max-w-4xl mx-auto mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl flex items-center">
            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
            <span class="text-green-800 font-medium">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="max-w-4xl mx-auto mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
            <span class="text-red-800 font-medium">{{ session('error') }}</span>
        </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center border-b pb-4">
                        <i class="fas fa-shopping-bag text-emerald-500 mr-3"></i> Daftar Produk
                    </h2>

                    @php
                        $subtotal = 0;
                        $totalItems = 0;
                    @endphp

                    @forelse($cartItems as $item)
                        @php
                            $subtotal += $item->bonsai->current_value * $item->quantity;
                            $totalItems += $item->quantity;
                        @endphp
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 border-b border-gray-100 pb-6 mb-6 last:border-0 last:pb-0 last:mb-0">
                            <!-- Image -->
                            <div class="w-24 h-24 md:w-32 md:h-32 shrink-0">
                                @if($item->bonsai->image_path)
                                    <img src="{{ asset('storage/' . $item->bonsai->image_path) }}" alt="{{ $item->bonsai->name }}" class="w-full h-full object-cover rounded-2xl shadow-sm">
                                @else
                                    <div class="w-full h-full bg-emerald-50 rounded-2xl flex items-center justify-center border border-emerald-100">
                                        <i class="fas fa-seedling text-3xl text-emerald-300"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Detail -->
                            <div class="flex-grow w-full">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg mb-2 inline-block">
                                            {{ $item->bonsai->category->name ?? 'Bonsai' }}
                                        </span>
                                        <h4 class="text-lg md:text-xl font-bold text-gray-800 leading-tight">
                                            {{ $item->bonsai->name }}
                                        </h4>
                                    </div>
                                    <form action="{{ route('shop.keranjang.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 p-2 transition-colors rounded-lg hover:bg-red-50" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <p class="text-xl font-bold text-emerald-600 mb-4">
                                    Rp {{ number_format($item->bonsai->current_value ?? 0, 0, ',', '.') }}
                                </p>
                                
                                <div class="flex items-center gap-4">
                                    <!-- Qty Control -->
                                    <div class="flex items-center bg-gray-50 rounded-xl p-1 border border-gray-200">
                                        <button class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-white hover:text-emerald-600 hover:shadow-sm transition-all"
                                                onclick="updateQuantity({{ $item->id }}, -1, {{ $item->quantity }})">
                                            <i class="fas fa-minus text-xs"></i>
                                        </button>
                                        <input type="number" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" min="1" readonly
                                               class="w-12 text-center bg-transparent border-none font-semibold text-gray-700 focus:ring-0 p-0 text-sm">
                                        <button class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-white hover:text-emerald-600 hover:shadow-sm transition-all"
                                                onclick="updateQuantity({{ $item->id }}, 1, {{ $item->quantity }})">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                    
                                    <span class="text-sm text-gray-500 font-medium">
                                        Total: <span class="text-gray-800">Rp {{ number_format(($item->bonsai->current_value ?? 0) * $item->quantity, 0, ',', '.') }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-shopping-basket text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Keranjang Belanja Kosong</h3>
                            <p class="text-gray-500 mb-8">Anda belum menambahkan produk apapun ke keranjang.</p>
                            <a href="{{ route('shop.produk') }}" class="inline-flex items-center bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-3 rounded-full font-semibold hover:shadow-lg transition-all transform hover:-translate-y-1">
                                <i class="fas fa-search mr-2"></i> Mulai Belanja
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Summary -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center border-b pb-4">
                        <i class="fas fa-file-invoice text-emerald-500 mr-3"></i> Ringkasan Belanja
                    </h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Total Harga ({{ $totalItems }} produk)</span>
                            <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Biaya Pengiriman</span>
                            <span class="text-sm italic text-emerald-600">Dihitung saat checkout</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Diskon</span>
                            <span class="font-medium text-red-500">- Rp 0</span>
                        </div>
                    </div>
                    
                    <div class="border-t-2 border-dashed border-gray-200 pt-6 mb-8">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-800">Total Tagihan</span>
                            <span class="text-2xl font-black text-emerald-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    @if($cartItems->count() > 0)
                        <a href="{{ route('shop.checkout') }}" class="w-full bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 flex justify-center items-center">
                            <i class="fas fa-lock mr-2"></i> Lanjut ke Pembayaran
                        </a>
                    @else
                        <button disabled class="w-full bg-gray-200 text-gray-400 font-bold py-4 rounded-xl cursor-not-allowed flex justify-center items-center">
                            <i class="fas fa-lock mr-2"></i> Lanjut ke Pembayaran
                        </button>
                    @endif
                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('shop.produk') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 flex items-center justify-center transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali Belanja
                        </a>
                    </div>
                    
                    <!-- Trust Badges -->
                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-center gap-4 text-gray-400">
                        <i class="fab fa-cc-visa text-2xl hover:text-blue-600 transition-colors"></i>
                        <i class="fab fa-cc-mastercard text-2xl hover:text-orange-500 transition-colors"></i>
                        <i class="fas fa-money-bill-wave text-2xl hover:text-green-500 transition-colors" title="Bank Transfer"></i>
                        <i class="fas fa-shield-alt text-2xl hover:text-blue-400 transition-colors" title="Secure Payment"></i>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

<!-- Form for quantity update -->
<form id="update-qty-form" method="POST" class="hidden">
    @csrf
    @method('PUT')
    <input type="hidden" name="quantity" id="form-qty">
</form>

<script>
    function updateQuantity(cartId, change, currentQty) {
        const newQty = currentQty + change;
        if (newQty < 1) return;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        // Show loading state (optional)
        Swal.showLoading();
        
        fetch(`/keranjang/${cartId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: newQty })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                window.location.reload();
            } else {
                Swal.fire({icon: 'error', title: 'Oops', text: data.message || 'Gagal mengubah jumlah'});
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({icon: 'error', title: 'Oops', text: 'Terjadi kesalahan sistem'});
        });
    }
</script>

@endsection