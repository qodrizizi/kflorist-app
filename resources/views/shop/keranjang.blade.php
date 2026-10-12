@extends('layouts.shop')

@section('content')

<section class="py-10 md:py-14 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-4 md:px-8 max-w-6xl">
        
        <!-- HERO BANNER DASHBOARD -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-900 via-teal-800 to-emerald-700 text-white p-6 sm:p-8 md:p-10 mb-8 shadow-xl border border-emerald-600/30">
            <!-- Decorative Glow Elements -->
            <div class="absolute -top-24 -right-24 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-teal-300/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute right-6 bottom-4 opacity-10 pointer-events-none hidden md:block">
                <i class="fas fa-shopping-basket text-9xl"></i>
            </div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="max-w-xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-white/15 text-emerald-100 backdrop-blur-md border border-white/20 mb-3 shadow-inner">
                        <i class="fas fa-seedling text-emerald-300 animate-pulse"></i>
                        <span>Troli Koleksi RUANGBONSAI</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-white tracking-tight leading-tight mb-2">
                        Keranjang Belanja
                    </h1>
                    <p class="text-xs sm:text-sm md:text-base text-emerald-100/90 font-medium leading-relaxed">
                        Selesaikan pembelian bonsai impian Anda dengan jaminan proteksi garansi hidup, pengemasan peti kayu kokoh, dan transaksi resmi terenkripsi.
                    </p>
                </div>

                <!-- Action Button -->
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('shop.produk') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/15 hover:bg-white/25 text-white backdrop-blur-md border border-white/25 rounded-2xl text-xs sm:text-sm font-bold transition-all shadow-sm">
                        <i class="fas fa-plus text-emerald-300"></i>
                        <span>Tambah Tanaman Lain</span>
                    </a>
                </div>
            </div>

            <!-- QUICK ASSURANCE CHIPS -->
            @php
                $calcSubtotal = 0;
                $calcItems = 0;
                foreach($cartItems as $ci) {
                    $calcSubtotal += ($ci->bonsai->current_value ?? 0) * $ci->quantity;
                    $calcItems += $ci->quantity;
                }
            @endphp
            <div class="relative z-10 grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4 mt-8 pt-6 border-t border-white/15">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-3.5 flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-400/20 text-emerald-300 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-200 block">Jumlah Muatan</span>
                        <span class="text-base font-extrabold text-white font-mono">{{ $calcItems }} Pohon Bonsai</span>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-3.5 flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-400/20 text-amber-300 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-200 block">Garansi Hidup</span>
                        <span class="text-base font-extrabold text-white">100% Proteksi Peti Kayu</span>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-3.5 flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-teal-400/20 text-teal-300 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-200 block">Estimasi Subtotal</span>
                        <span class="text-base font-extrabold text-white font-mono">Rp {{ number_format($calcSubtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- SESSION ALERTS -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 p-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                    <i class="fas fa-check"></i>
                </div>
                <span class="text-emerald-900 font-semibold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-rose-50 border border-rose-200 p-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-9 h-9 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
                <span class="text-rose-900 font-semibold text-sm">{{ session('error') }}</span>
            </div>
        @endif

        <!-- MAIN SHOPPING CART GRID -->
        <div class="grid lg:grid-cols-3 gap-8 items-start">
            
            <!-- LEFT COLUMN: CART PRODUCTS LIST (2 COLS) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/90 p-6 md:p-8">
                    
                    <div class="flex items-center justify-between border-b border-slate-100 pb-5 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg border border-emerald-100">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div>
                                <h2 class="text-lg md:text-xl font-black text-slate-800">
                                    Daftar Tanaman Pilihan
                                </h2>
                                <p class="text-xs text-slate-400 font-medium">Periksa kembali jenis tanaman dan jumlah pesanan Anda</p>
                            </div>
                        </div>

                        <span class="text-xs font-black px-3 py-1 bg-slate-100 text-slate-600 rounded-full font-mono">
                            {{ $cartItems->count() }} Varietas
                        </span>
                    </div>

                    @php
                        $subtotal = 0;
                        $totalItems = 0;
                    @endphp

                    @forelse($cartItems as $item)
                        @php
                            $subtotal += ($item->bonsai->current_value ?? 0) * $item->quantity;
                            $totalItems += $item->quantity;
                        @endphp
                        <div class="p-4 md:p-5 rounded-2xl border border-slate-100 hover:border-emerald-200/80 bg-white hover:bg-slate-50/50 transition-all mb-4 last:mb-0 group">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 md:gap-5">
                                
                                <!-- Product Image -->
                                <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 aspect-square shrink-0 rounded-2xl overflow-hidden bg-slate-50 border border-slate-150 relative">
                                    @if($item->bonsai && $item->bonsai->image_path)
                                        <img src="{{ asset('storage/' . $item->bonsai->image_path) }}" alt="{{ $item->bonsai->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-emerald-50/60 text-emerald-400">
                                            <i class="fas fa-seedling text-3xl"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Product Information -->
                                <div class="flex-grow w-full space-y-1.5">
                                    <div class="flex justify-between items-start gap-3">
                                        <div>
                                            <span class="text-[10px] font-black uppercase tracking-wider text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md inline-block">
                                                {{ $item->bonsai->category->name ?? 'Bonsai Koleksi' }}
                                            </span>
                                            <h4 class="text-base md:text-lg font-black text-slate-900 group-hover:text-emerald-700 transition-colors mt-0.5">
                                                {{ $item->bonsai->name }}
                                            </h4>
                                        </div>

                                        <!-- Delete Button -->
                                        <form action="{{ route('shop.keranjang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus bonsai ini dari keranjang?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-9 h-9 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 flex items-center justify-center transition-all" title="Hapus dari keranjang">
                                                <i class="fas fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <!-- Unit Price -->
                                    <p class="text-xs text-slate-400 font-medium">
                                        Harga Satuan: <span class="font-mono font-bold text-slate-700">Rp {{ number_format($item->bonsai->current_value ?? 0, 0, ',', '.') }}</span>
                                    </p>
                                    
                                    <!-- Controls Row: Quantity Stepper & Subtotal -->
                                    <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
                                        <!-- Qty Control -->
                                        <div class="flex items-center bg-slate-50 rounded-xl p-1 border border-slate-200">
                                            <button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-white hover:text-emerald-600 hover:shadow-xs transition-all active:scale-95"
                                                    onclick="updateQuantity({{ $item->id }}, -1, {{ $item->quantity }})"
                                                    title="Kurangi jumlah">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <input type="number" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" min="1" readonly
                                                   class="w-12 text-center bg-transparent border-none font-bold font-mono text-slate-800 focus:ring-0 p-0 text-sm">
                                            <button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-white hover:text-emerald-600 hover:shadow-xs transition-all active:scale-95"
                                                    onclick="updateQuantity({{ $item->id }}, 1, {{ $item->quantity }})"
                                                    title="Tambah jumlah">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Subtotal per item -->
                                        <div class="text-right">
                                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Subtotal</span>
                                            <span class="text-base md:text-lg font-black text-emerald-600 font-mono">
                                                Rp {{ number_format(($item->bonsai->current_value ?? 0) * $item->quantity, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- EMPTY STATE -->
                        <div class="text-center py-16 px-4 bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                            <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm border border-emerald-100">
                                <i class="fas fa-seedling"></i>
                            </div>
                            <h3 class="text-base md:text-lg font-bold text-slate-800 mb-1">Keranjang Belanja Masih Kosong</h3>
                            <p class="text-xs md:text-sm text-slate-500 max-w-sm mx-auto mb-6">
                                Anda belum memasukkan pohon bonsai impian ke dalam keranjang. Mulai jelajahi galeri bonsai pilihan kami sekarang!
                            </p>
                            <a href="{{ route('shop.produk') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold rounded-2xl text-xs md:text-sm shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-compass"></i>
                                <span>Mulai Jelajahi Produk</span>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- RIGHT COLUMN: ORDER SUMMARY SIDEBAR (1 COL) -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 bg-white rounded-3xl shadow-lg border border-slate-200/90 p-6 md:p-8 space-y-6">
                    
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg border border-teal-100">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-800">
                                Ringkasan Belanja
                            </h3>
                            <p class="text-xs text-slate-400 font-medium">Estimasi total pembayaran</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3.5 text-xs md:text-sm">
                        <div class="flex justify-between items-center text-slate-600">
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-boxes-packing text-slate-400"></i>
                                Subtotal ({{ $totalItems }} Pohon)
                            </span>
                            <span class="font-mono font-bold text-slate-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between items-center text-slate-600">
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-box-archive text-emerald-500"></i>
                                Packing Peti Kayu Khusus
                            </span>
                            <span class="font-bold text-emerald-600 text-[11px] bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">Gratis (Aman)</span>
                        </div>

                        <div class="flex justify-between items-center text-slate-600">
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-truck text-slate-400"></i>
                                Biaya Pengiriman
                            </span>
                            <span class="text-xs italic text-slate-400">Dihitung saat checkout</span>
                        </div>
                    </div>
                    
                    <!-- TOTAL TAGIHAN -->
                    <div class="border-t-2 border-dashed border-slate-200 pt-5">
                        <div class="flex justify-between items-baseline mb-1">
                            <span class="text-sm font-bold text-slate-800">Total Tagihan</span>
                            <span class="text-2xl font-black text-emerald-600 font-mono tracking-tight">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                        <span class="text-[10px] text-slate-400 block text-right">*Belum termasuk ongkir spesialis</span>
                    </div>
                    
                    <!-- CTA CHECKOUT BUTTON -->
                    @if($cartItems->count() > 0)
                        <a href="{{ route('shop.checkout') }}" class="w-full bg-gradient-to-r from-emerald-600 via-emerald-500 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-extrabold py-4 px-6 rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-3 text-sm md:text-base">
                            <i class="fas fa-lock text-sm"></i>
                            <span>Lanjut ke Pembayaran</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    @else
                        <button disabled class="w-full bg-slate-100 text-slate-400 font-bold py-4 px-6 rounded-2xl cursor-not-allowed flex items-center justify-center gap-2 text-sm">
                            <i class="fas fa-lock"></i>
                            <span>Keranjang Kosong</span>
                        </button>
                    @endif

                    <div class="text-center pt-2">
                        <a href="{{ route('shop.produk') }}" class="text-xs font-bold text-slate-500 hover:text-emerald-700 inline-flex items-center gap-2 transition-colors">
                            <i class="fas fa-arrow-left"></i>
                            <span>Lanjut Eksplorasi Koleksi</span>
                        </a>
                    </div>
                    
                    <!-- VALUE PROPOSITIONS & GUARANTEES -->
                    <div class="pt-5 border-t border-slate-100 space-y-3">
                        <div class="flex items-start gap-2.5 text-xs text-slate-600">
                            <div class="w-5 h-5 rounded-md bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 text-[11px]">
                                <i class="fas fa-shield-halved"></i>
                            </div>
                            <span><strong>Garansi Hidup 100%</strong> sampai alamat tujuan.</span>
                        </div>
                        <div class="flex items-start gap-2.5 text-xs text-slate-600">
                            <div class="w-5 h-5 rounded-md bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 text-[11px]">
                                <i class="fas fa-box"></i>
                            </div>
                            <span>Dikemas dalam <strong>peti kayu pengaman</strong> tahan guncangan.</span>
                        </div>
                        <div class="flex items-start gap-2.5 text-xs text-slate-600">
                            <div class="w-5 h-5 rounded-md bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 text-[11px]">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <span>Pembayaran resmi & aman via <strong>Midtrans</strong>.</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        
    </div>
</section>

<!-- Script AJAX untuk Ubah Jumlah Barang -->
<script>
    function updateQuantity(cartId, change, currentQty) {
        const newQty = currentQty + change;
        if (newQty < 1) return;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '{{ csrf_token() }}';
        
        if (typeof Swal !== 'undefined') {
            Swal.showLoading();
        }
        
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
                if (typeof Swal !== 'undefined') {
                    Swal.fire({icon: 'error', title: 'Oops', text: data.message || 'Gagal mengubah jumlah'});
                }
            }
        })
        .catch(err => {
            console.error(err);
            if (typeof Swal !== 'undefined') {
                Swal.fire({icon: 'error', title: 'Oops', text: 'Terjadi kesalahan sistem'});
            }
        });
    }
</script>

@endsection