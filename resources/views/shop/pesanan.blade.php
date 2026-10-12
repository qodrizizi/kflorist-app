@extends('layouts.shop')

@section('content')
<section class="py-10 md:py-14 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-4 md:px-8 max-w-5xl">
        
        <!-- HERO BANNER & STATS DASHBOARD -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-900 via-teal-800 to-emerald-700 text-white p-6 sm:p-8 md:p-10 mb-8 shadow-xl border border-emerald-600/30">
            <!-- Decorative Glow Elements -->
            <div class="absolute -top-24 -right-24 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-teal-300/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute right-6 bottom-4 opacity-10 pointer-events-none hidden md:block">
                <i class="fas fa-tree text-9xl"></i>
            </div>

            <!-- Header Content -->
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="max-w-xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-white/15 text-emerald-100 backdrop-blur-md border border-white/20 mb-3 shadow-inner">
                        <i class="fas fa-seedling text-emerald-300 animate-pulse"></i>
                        <span>Pusat Manajemen Transaksi</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-white tracking-tight leading-tight mb-2">
                        Pesanan Saya
                    </h1>
                    <p class="text-xs sm:text-sm md:text-base text-emerald-100/90 font-medium leading-relaxed">
                        Lacak dan kelola pesanan bonsai Anda, pantau pengiriman ekspedisi bergaransi, dan unduh struk transaksi resmi kapan saja.
                    </p>
                </div>

                <!-- Quick Actions -->
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/15 hover:bg-white/25 text-white backdrop-blur-md border border-white/25 rounded-2xl text-xs sm:text-sm font-bold transition-all shadow-sm">
                        <i class="fas fa-compass text-emerald-300"></i>
                        <span>Eksplorasi Katalog</span>
                    </a>
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20RUANGBONSAI,%20saya%20ingin%20bertanya%20mengenai%20status%20pesanan%20saya" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-white rounded-2xl text-xs sm:text-sm font-bold transition-all shadow-md">
                        <i class="fab fa-whatsapp text-base"></i>
                        <span>Bantuan CS</span>
                    </a>
                </div>
            </div>

            <!-- INTERACTIVE STATS SUMMARY GRID -->
            <div class="relative z-10 grid grid-cols-2 sm:grid-cols-4 gap-3 md:gap-4 mt-8 pt-6 border-t border-white/15">
                <!-- Belum Bayar -->
                <div onclick="switchTab('pending')" class="group cursor-pointer bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 rounded-2xl p-3.5 transition-all transform hover:-translate-y-0.5">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-200">Belum Bayar</span>
                        <div class="w-6 h-6 rounded-lg bg-amber-400/25 text-amber-300 flex items-center justify-center text-xs">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-white font-mono">{{ $pending->count() }}</span>
                        <span class="text-[11px] text-emerald-200/80">Pesanan</span>
                    </div>
                </div>

                <!-- Diproses -->
                <div onclick="switchTab('processing')" class="group cursor-pointer bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 rounded-2xl p-3.5 transition-all transform hover:-translate-y-0.5">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-200">Diproses</span>
                        <div class="w-6 h-6 rounded-lg bg-sky-400/25 text-sky-300 flex items-center justify-center text-xs">
                            <i class="fas fa-box-open"></i>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-white font-mono">{{ $processing->count() }}</span>
                        <span class="text-[11px] text-emerald-200/80">Pesanan</span>
                    </div>
                </div>

                <!-- Dikirim -->
                <div onclick="switchTab('shipping')" class="group cursor-pointer bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 rounded-2xl p-3.5 transition-all transform hover:-translate-y-0.5">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-200">Dikirim</span>
                        <div class="w-6 h-6 rounded-lg bg-purple-400/25 text-purple-300 flex items-center justify-center text-xs">
                            <i class="fas fa-truck-fast"></i>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-white font-mono">{{ $shipping->count() }}</span>
                        <span class="text-[11px] text-emerald-200/80">Pesanan</span>
                    </div>
                </div>

                <!-- Selesai -->
                <div onclick="switchTab('completed')" class="group cursor-pointer bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 rounded-2xl p-3.5 transition-all transform hover:-translate-y-0.5">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-200">Selesai</span>
                        <div class="w-6 h-6 rounded-lg bg-emerald-400/25 text-emerald-300 flex items-center justify-center text-xs">
                            <i class="fas fa-circle-check"></i>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-white font-mono">{{ $completed->count() }}</span>
                        <span class="text-[11px] text-emerald-200/80">Pesanan</span>
                    </div>
                </div>
            </div>
        </div>

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

        <!-- SEGMENTED TABS NAVIGATION -->
        <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-200/80 mb-6 overflow-x-auto hide-scroll flex items-center gap-1.5 snap-x">
            <button onclick="switchTab('pending')" id="tab-pending" class="tab-btn snap-start flex-1 min-w-[125px] py-3 px-3 text-xs md:text-sm font-bold text-center rounded-xl transition-all whitespace-nowrap flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-green-600 text-white shadow-md shadow-emerald-600/20">
                <i class="fas fa-wallet text-xs"></i>
                <span>Belum Bayar</span>
                <span class="tab-badge px-2 py-0.5 rounded-full text-[10px] md:text-xs font-black bg-white/20 text-white">{{ $pending->count() }}</span>
            </button>
            <button onclick="switchTab('processing')" id="tab-processing" class="tab-btn snap-start flex-1 min-w-[125px] py-3 px-3 text-xs md:text-sm font-semibold text-center rounded-xl transition-all whitespace-nowrap flex items-center justify-center gap-2 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50/50">
                <i class="fas fa-box-open text-xs"></i>
                <span>Diproses</span>
                <span class="tab-badge px-2 py-0.5 rounded-full text-[10px] md:text-xs font-bold bg-slate-100 text-slate-600">{{ $processing->count() }}</span>
            </button>
            <button onclick="switchTab('shipping')" id="tab-shipping" class="tab-btn snap-start flex-1 min-w-[125px] py-3 px-3 text-xs md:text-sm font-semibold text-center rounded-xl transition-all whitespace-nowrap flex items-center justify-center gap-2 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50/50">
                <i class="fas fa-truck-fast text-xs"></i>
                <span>Dikirim</span>
                <span class="tab-badge px-2 py-0.5 rounded-full text-[10px] md:text-xs font-bold bg-slate-100 text-slate-600">{{ $shipping->count() }}</span>
            </button>
            <button onclick="switchTab('completed')" id="tab-completed" class="tab-btn snap-start flex-1 min-w-[125px] py-3 px-3 text-xs md:text-sm font-semibold text-center rounded-xl transition-all whitespace-nowrap flex items-center justify-center gap-2 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50/50">
                <i class="fas fa-circle-check text-xs"></i>
                <span>Selesai</span>
                <span class="tab-badge px-2 py-0.5 rounded-full text-[10px] md:text-xs font-bold bg-slate-100 text-slate-600">{{ $completed->count() }}</span>
            </button>
            <button onclick="switchTab('cancelled')" id="tab-cancelled" class="tab-btn snap-start flex-1 min-w-[125px] py-3 px-3 text-xs md:text-sm font-semibold text-center rounded-xl transition-all whitespace-nowrap flex items-center justify-center gap-2 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50/50">
                <i class="fas fa-ban text-xs"></i>
                <span>Dibatalkan</span>
                <span class="tab-badge px-2 py-0.5 rounded-full text-[10px] md:text-xs font-bold bg-slate-100 text-slate-600">{{ $cancelled->count() }}</span>
            </button>
        </div>

        <!-- TAB CONTENTS -->
        <div class="space-y-6">
            
            <!-- Tab: Pending -->
            <div id="content-pending" class="tab-content space-y-5">
                @forelse($pending as $order)
                    @include('shop.components.order-card', ['order' => $order, 'badgeClass' => 'bg-amber-100 text-amber-800 border-amber-200'])
                @empty
                    <div class="text-center py-16 px-4 bg-white rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-20 h-20 bg-amber-50 text-amber-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm border border-amber-100">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-1">Tidak Ada Pesanan Menunggu Pembayaran</h3>
                        <p class="text-xs md:text-sm text-gray-500 max-w-sm mx-auto mb-6">
                            Semua tagihan Anda telah diselesaikan atau Anda belum memesan koleksi bonsai baru.
                        </p>
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold rounded-2xl text-xs md:text-sm shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            <i class="fas fa-tree"></i>
                            <span>Jelajahi Koleksi Bonsai</span>
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Tab: Processing -->
            <div id="content-processing" class="tab-content hidden space-y-5">
                @forelse($processing as $order)
                    @include('shop.components.order-card', ['order' => $order, 'badgeClass' => 'bg-sky-100 text-sky-800 border-sky-200'])
                @empty
                    <div class="text-center py-16 px-4 bg-white rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-20 h-20 bg-sky-50 text-sky-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm border border-sky-100">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-1">Tidak Ada Pesanan yang Sedang Diproses</h3>
                        <p class="text-xs md:text-sm text-gray-500 max-w-sm mx-auto mb-6">
                            Pesanan yang telah dibayar akan masuk ke sini untuk penyiapan peti kayu pengaman dan perawatan sebelum dikirim.
                        </p>
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold rounded-2xl text-xs md:text-sm shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            <i class="fas fa-tree"></i>
                            <span>Beli Bonsai Sekarang</span>
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Tab: Shipping -->
            <div id="content-shipping" class="tab-content hidden space-y-5">
                @forelse($shipping as $order)
                    @include('shop.components.order-card', ['order' => $order, 'badgeClass' => 'bg-purple-100 text-purple-800 border-purple-200', 'showAction' => true])
                @empty
                    <div class="text-center py-16 px-4 bg-white rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-20 h-20 bg-purple-50 text-purple-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm border border-purple-100">
                            <i class="fas fa-truck-fast"></i>
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-1">Tidak Ada Pesanan Dalam Pengiriman</h3>
                        <p class="text-xs md:text-sm text-gray-500 max-w-sm mx-auto mb-6">
                            Saat ini belum ada paket bonsai yang sedang dalam perjalanan menuju alamat Anda.
                        </p>
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold rounded-2xl text-xs md:text-sm shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            <i class="fas fa-shopping-bag"></i>
                            <span>Koleksi Terbaru</span>
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Tab: Completed -->
            <div id="content-completed" class="tab-content hidden space-y-5">
                @forelse($completed as $order)
                    @include('shop.components.order-card', ['order' => $order, 'badgeClass' => 'bg-emerald-100 text-emerald-800 border-emerald-200'])
                @empty
                    <div class="text-center py-16 px-4 bg-white rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm border border-emerald-100">
                            <i class="fas fa-circle-check"></i>
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-1">Belum Ada Pesanan yang Selesai</h3>
                        <p class="text-xs md:text-sm text-gray-500 max-w-sm mx-auto mb-6">
                            Pesanan yang telah sampai dan Anda konfirmasi akan tercatat di sini beserta ulasan bintang Anda.
                        </p>
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold rounded-2xl text-xs md:text-sm shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            <i class="fas fa-seedling"></i>
                            <span>Mulai Belanja</span>
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Tab: Cancelled -->
            <div id="content-cancelled" class="tab-content hidden space-y-5">
                @forelse($cancelled as $order)
                    @include('shop.components.order-card', ['order' => $order, 'badgeClass' => 'bg-rose-100 text-rose-800 border-rose-200'])
                @empty
                    <div class="text-center py-16 px-4 bg-white rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-20 h-20 bg-rose-50 text-rose-400 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm border border-rose-100">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-1">Tidak Ada Pesanan Dibatalkan</h3>
                        <p class="text-xs md:text-sm text-gray-500 max-w-sm mx-auto mb-6">
                            Bagus! Anda tidak memiliki catatan pesanan yang kedaluwarsa atau dibatalkan.
                        </p>
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold rounded-2xl text-xs md:text-sm shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            <i class="fas fa-compass"></i>
                            <span>Lihat Koleksi Bonsai</span>
                        </a>
                    </div>
                @endforelse
            </div>

        </div>

    </div>
</section>

<style>
    .hide-scroll::-webkit-scrollbar { display: none; }
    .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
    function switchTab(tabId) {
        // Simpan tab aktif ke localStorage
        localStorage.setItem('activeOrderTab', tabId);

        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        
        // Reset all buttons to inactive state
        document.querySelectorAll('.tab-btn').forEach(el => {
            el.className = 'tab-btn snap-start flex-1 min-w-[125px] py-3 px-3 text-xs md:text-sm font-semibold text-center rounded-xl transition-all whitespace-nowrap flex items-center justify-center gap-2 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50/50';
            
            // reset badge
            let badge = el.querySelector('.tab-badge');
            if(badge) {
                badge.className = 'tab-badge px-2 py-0.5 rounded-full text-[10px] md:text-xs font-bold bg-slate-100 text-slate-600';
            }
        });

        // Show selected content
        const targetContent = document.getElementById('content-' + tabId);
        if (targetContent) {
            targetContent.classList.remove('hidden');
        }

        // Highlight selected button with gradient & shadow
        const activeBtn = document.getElementById('tab-' + tabId);
        if(activeBtn) {
            activeBtn.className = 'tab-btn snap-start flex-1 min-w-[125px] py-3 px-3 text-xs md:text-sm font-bold text-center rounded-xl transition-all whitespace-nowrap flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-green-600 text-white shadow-md shadow-emerald-600/20';
            
            // highlight badge
            let activeBadge = activeBtn.querySelector('.tab-badge');
            if(activeBadge) {
                activeBadge.className = 'tab-badge px-2 py-0.5 rounded-full text-[10px] md:text-xs font-black bg-white/20 text-white';
            }
        }
    }

    // Restore active tab on page load
    document.addEventListener('DOMContentLoaded', () => {
        const savedTab = localStorage.getItem('activeOrderTab');
        if (savedTab && document.getElementById('tab-' + savedTab)) {
            switchTab(savedTab);
        }
    });

    function lacakPengiriman(orderCode) {
        Swal.fire({
            title: 'Lacak Pengiriman',
            html: `
                <div class="text-left mt-4">
                    <p class="font-bold text-gray-800 mb-2">No. Resi: <span class="text-blue-600">JNE-${orderCode}</span></p>
                    <ul class="relative border-l border-gray-200 ml-3 space-y-4">
                        <li class="mb-4 ml-4">
                            <div class="absolute w-3 h-3 bg-blue-500 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400">Hari ini, 08:00</time>
                            <h3 class="text-sm font-semibold text-gray-900">Pesanan sedang dalam perjalanan ke alamat tujuan</h3>
                        </li>
                        <li class="mb-4 ml-4">
                            <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400">Kemarin, 14:30</time>
                            <h3 class="text-sm font-semibold text-gray-900">Pesanan telah diserahkan ke kurir</h3>
                        </li>
                    </ul>
                </div>
            `,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#3b82f6'
        });
    }

    function beriRating(bonsaiId, bonsaiName) {
        let currentRating = 0;

        Swal.fire({
            title: 'Beri Penilaian',
            text: `Bagaimana kualitas ${bonsaiName}?`,
            html: `
                <div class="flex justify-center space-x-2 my-4 text-3xl text-gray-300 cursor-pointer" id="rating-stars">
                    <i class="fas fa-star hover:text-yellow-400 transition-colors" data-val="1"></i>
                    <i class="fas fa-star hover:text-yellow-400 transition-colors" data-val="2"></i>
                    <i class="fas fa-star hover:text-yellow-400 transition-colors" data-val="3"></i>
                    <i class="fas fa-star hover:text-yellow-400 transition-colors" data-val="4"></i>
                    <i class="fas fa-star hover:text-yellow-400 transition-colors" data-val="5"></i>
                </div>
                <textarea id="rating-comment" rows="3" class="w-full border-2 border-gray-200 rounded-xl p-3 focus:outline-none focus:border-yellow-400 transition-colors mb-4" placeholder="Tulis ulasan Anda di sini..."></textarea>
                <div class="text-left">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unggah Foto Produk (Opsional)</label>
                    <input type="file" id="rating-image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Kirim Penilaian',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#eab308',
            didOpen: () => {
                const stars = document.querySelectorAll('#rating-stars i');
                stars.forEach(star => {
                    star.addEventListener('click', (e) => {
                        currentRating = e.target.getAttribute('data-val');
                        stars.forEach(s => {
                            if (s.getAttribute('data-val') <= currentRating) {
                                s.classList.add('text-yellow-400');
                                s.classList.remove('text-gray-300');
                            } else {
                                s.classList.remove('text-yellow-400');
                                s.classList.add('text-gray-300');
                            }
                        });
                    });
                });
            },
            preConfirm: () => {
                const comment = document.getElementById('rating-comment').value;
                const imageFile = document.getElementById('rating-image').files[0];

                if (currentRating === 0) {
                    Swal.showValidationMessage('Silakan pilih rating bintang terlebih dahulu');
                    return false;
                }

                let formData = new FormData();
                formData.append('bonsai_id', bonsaiId);
                formData.append('rating', currentRating);
                formData.append('comment', comment);
                if (imageFile) {
                    formData.append('image', imageFile);
                }
                formData.append('_token', '{{ csrf_token() }}');

                return fetch('{{ route("shop.review.store") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(`Request failed: ${error}`);
                });
            }
        }).then((result) => {
            if (result.isConfirmed && result.value.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Terima Kasih!',
                    text: result.value.message,
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    location.reload(); // Reload to update button to "Sudah Dinilai"
                });
            }
        });
    }

    function lihatReview(review, bonsaiName) {
        let starsHtml = '';
        for (let i = 1; i <= 5; i++) {
            starsHtml += `<i class="${i <= review.rating ? 'fas' : 'far'} fa-star text-yellow-400 text-2xl mx-1"></i>`;
        }

        Swal.fire({
            title: 'Ulasan Anda',
            html: `
                <div class="text-center mb-6">
                    <p class="text-gray-500 text-sm mb-2">Produk: <span class="font-bold text-gray-800">${bonsaiName}</span></p>
                    <div class="mb-4">${starsHtml}</div>
                    <p class="text-xs text-gray-400">Dinilai pada ${review.date}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 text-left mb-6">
                    <p class="text-gray-600 italic">"${review.comment || 'Tidak ada komentar.'}"</p>
                </div>
                ${review.image ? `
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 font-bold mb-2 text-left">Foto yang Anda unggah:</p>
                        <div class="w-full aspect-video rounded-2xl overflow-hidden shadow-md border border-gray-100">
                            <img src="${review.image}" class="w-full h-full object-cover">
                        </div>
                    </div>
                ` : ''}
            `,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#10b981',
            customClass: {
                popup: 'rounded-3xl'
            }
        });
    }
</script>
@endsection
