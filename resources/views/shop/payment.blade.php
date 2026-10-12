@extends('layouts.shop')

@section('content')
<section class="py-10 md:py-16 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-5xl">
        
        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3 shadow-sm">
                <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center gap-3 shadow-sm">
                <i class="fas fa-exclamation-circle text-rose-600 text-lg"></i>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        {{-- ======================================================== --}}
        {{-- CASE A: SUDAH DIBAYAR (PAID SUCCESS STATE)              --}}
        {{-- ======================================================== --}}
        @if(!empty($isPaid) || in_array($order->status, ['diproses', 'dikirim', 'selesai']))
            
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 mb-8 transition-all">
                
                <!-- Hero Paid Header -->
                <div class="bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-600 p-8 md:p-12 text-white text-center relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
                        <i class="fas fa-check-circle text-9xl"></i>
                    </div>

                    <div class="w-20 h-20 md:w-24 md:h-24 bg-white/20 backdrop-blur-md text-white rounded-full flex items-center justify-center text-4xl md:text-5xl shadow-lg mx-auto mb-5 border border-white/30 animate-bounce">
                        <i class="fas fa-check"></i>
                    </div>

                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-1.5 rounded-full text-xs md:text-sm font-extrabold uppercase tracking-widest mb-3 border border-white/25">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-200 animate-pulse"></span>
                        Status: SUDAH DIBAYAR (LUNAS)
                    </div>

                    <h1 class="text-2xl md:text-4xl font-black mb-2 tracking-tight">Pembayaran Berhasil Diverifikasi!</h1>
                    <p class="text-xs md:text-base text-emerald-50 max-w-xl mx-auto leading-relaxed">
                        Terima kasih! Pembayaran untuk pesanan <span class="font-mono font-bold text-white bg-black/20 px-2 py-0.5 rounded">{{ $orderCode }}</span> telah kami terima dan pesanan Anda segera diproses oleh tim RUANGBONSAI.
                    </p>
                </div>

                <!-- Info Rincian Pembayaran -->
                <div class="p-6 md:p-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Kode Transaksi</span>
                            <span class="text-sm md:text-base font-mono font-bold text-gray-900">{{ $orderCode }}</span>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Total Pembayaran</span>
                            <span class="text-sm md:text-base font-black text-emerald-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Metode Bayar</span>
                            <span class="text-sm md:text-base font-bold text-gray-800 uppercase">{{ $order->metode_pembayaran ?: 'Midtrans Gateway' }}</span>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Waktu Verifikasi</span>
                            <span class="text-sm md:text-base font-semibold text-gray-700">{{ $order->updated_at->translatedFormat('d M Y - H:i') }} WIB</span>
                        </div>
                    </div>

                    <!-- Items Preview -->
                    <div class="mb-8 border-t border-slate-100 pt-6">
                        <h3 class="text-sm md:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-seedling text-emerald-600"></i> Rincian Produk yang Dibeli
                        </h3>
                        <div class="space-y-3">
                            @foreach($allOrders ?? [$order] as $item)
                                <div class="flex items-center justify-between p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-12 h-12 bg-white rounded-xl overflow-hidden flex-none border border-slate-200">
                                            <img src="{{ $item->bonsai && $item->bonsai->image_path ? asset('storage/'.$item->bonsai->image_path) : asset('images/logo.png') }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="text-xs md:text-sm font-bold text-gray-900">{{ $item->bonsai ? $item->bonsai->name : 'Pohon Bonsai' }}</h4>
                                            <p class="text-[11px] text-gray-500 font-mono">{{ $item->quantity }}x @ Rp {{ number_format($item->bonsai ? $item->bonsai->current_value : $item->total_price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs md:text-sm font-bold text-gray-900">
                                        Rp {{ number_format($item->total_price, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons: Kembali ke Pesanan Saya & Cetak Struk -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-slate-100">
                        <a href="{{ route('shop.pesanan') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 text-sm md:text-base">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali ke Pesanan Saya</span>
                        </a>

                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <a href="{{ route('shop.pesanan.struk', $order->id) }}" onclick="downloadStrukPdf(event, this.href)" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white hover:bg-slate-50 border-2 border-slate-200 hover:border-emerald-500 text-gray-800 hover:text-emerald-700 font-bold rounded-2xl shadow-sm transition-all text-sm md:text-base">
                                <i class="fas fa-file-pdf text-emerald-600"></i>
                                <span>Download Struk Resmi (PDF)</span>
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        {{-- ======================================================== --}}
        {{-- CASE B: MENUNGGU PEMBAYARAN (PENDING PAYMENT FLOW)       --}}
        {{-- ======================================================== --}}
        @else

            @php
                // Hitung waktu kadaluarsa (24 Jam)
                $expiryTimestamp = $order->payment_expiry_time 
                    ? \Carbon\Carbon::parse($order->payment_expiry_time)->timestamp 
                    : $order->created_at->addHours(24)->timestamp;
                
                $formattedExpiry = $order->payment_expiry_time 
                    ? \Carbon\Carbon::parse($order->payment_expiry_time)->translatedFormat('l, d F Y - H:i') . ' WIB'
                    : $order->created_at->addHours(24)->translatedFormat('l, d F Y - H:i') . ' WIB';
            @endphp

            <!-- 24-HOUR COUNTDOWN TIMER BANNER -->
            <div class="mb-8 p-5 md:p-6 bg-gradient-to-r from-amber-500 via-amber-600 to-orange-500 rounded-3xl text-white shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-white animate-ping"></span>
                        <span class="text-xs font-bold uppercase tracking-wider bg-white/20 px-2.5 py-0.5 rounded-full">
                            Batas Waktu Pembayaran
                        </span>
                    </div>
                    <h3 class="text-base md:text-lg font-bold">Selesaikan Pembayaran Sebelum:</h3>
                    <p class="text-xs md:text-sm text-amber-100 font-medium">{{ $formattedExpiry }}</p>
                </div>

                <!-- Real-time Countdown Tiles -->
                <div class="flex items-center gap-2 bg-black/25 backdrop-blur-md p-2.5 px-4 rounded-2xl self-start sm:self-auto border border-white/20">
                    <div class="text-center min-w-[42px]">
                        <span id="cd-hours" class="block text-xl md:text-2xl font-black font-mono leading-none">00</span>
                        <span class="text-[9px] uppercase tracking-wider text-amber-200">Jam</span>
                    </div>
                    <span class="text-lg font-bold opacity-60">:</span>
                    <div class="text-center min-w-[42px]">
                        <span id="cd-minutes" class="block text-xl md:text-2xl font-black font-mono leading-none">00</span>
                        <span class="text-[9px] uppercase tracking-wider text-amber-200">Menit</span>
                    </div>
                    <span class="text-lg font-bold opacity-60">:</span>
                    <div class="text-center min-w-[42px]">
                        <span id="cd-seconds" class="block text-xl md:text-2xl font-black font-mono leading-none">00</span>
                        <span class="text-[9px] uppercase tracking-wider text-amber-200">Detik</span>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-5 gap-8 items-start">
                
                <!-- LEFT COLUMN: Full Midtrans Snap & Channel Options (3 cols) -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
                        
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-emerald-600 via-emerald-500 to-green-600 p-6 md:p-8 text-white flex items-center justify-between gap-4">
                            <div>
                                <h2 class="text-xl md:text-2xl font-bold mb-1">Instruksi Pembayaran</h2>
                                <p class="text-xs md:text-sm text-emerald-100">Pilih metode pembayaran lengkap melalui Midtrans</p>
                            </div>
                            <button type="button" onclick="openChangePaymentModal()" class="px-3.5 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white border border-white/30 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shrink-0 shadow-sm">
                                <i class="fas fa-rotate"></i>
                                <span>Ganti Metode</span>
                            </button>
                        </div>

                        <div class="p-6 md:p-8">
                            
                            <!-- PRIMARY ACTION: FULL MIDTRANS SNAP BUTTON -->
                            @if(!empty($snapToken))
                                <div class="mb-8 p-6 md:p-8 bg-gradient-to-br from-emerald-50 via-teal-50 to-green-50 rounded-3xl border-2 border-emerald-500/60 text-center relative overflow-hidden shadow-sm">
                                    <div class="inline-flex items-center gap-2 bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider mb-4 shadow-sm">
                                        <i class="fas fa-bolt"></i> Pembayaran Instan
                                    </div>

                                    <h3 class="text-xl md:text-2xl font-black text-gray-900 mb-2">
                                        Pilihan Lengkap Pembayaran Midtrans
                                    </h3>
                                    <p class="text-xs md:text-sm text-gray-600 max-w-md mx-auto mb-6">
                                        Klik tombol di bawah ini untuk membayar dengan metode pilihan Anda: <strong>QRIS, GoPay, ShopeePay, Virtual Account (BCA, Mandiri, BRI, BNI, Permata), Kartu Kredit, Alfamart / Indomaret</strong>.
                                    </p>

                                    <!-- Tombol Utama Snap -->
                                    <button type="button" id="pay-button" onclick="payWithSnap()" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-emerald-600 via-emerald-500 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-extrabold text-base md:text-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1 inline-flex items-center justify-center gap-3">
                                        <i class="fas fa-wallet text-xl"></i>
                                        <span>Bayar Sekarang via Midtrans</span>
                                        <i class="fas fa-arrow-right text-sm"></i>
                                    </button>

                                    <!-- Channels Logos / Pills -->
                                    <div class="mt-6 pt-5 border-t border-emerald-200/60 flex flex-wrap items-center justify-center gap-2 text-[11px] font-bold text-gray-600">
                                        <span class="bg-white px-2.5 py-1 rounded-lg border border-emerald-200 shadow-2xs">QRIS / e-Wallet</span>
                                        <span class="bg-white px-2.5 py-1 rounded-lg border border-emerald-200 shadow-2xs">BCA VA</span>
                                        <span class="bg-white px-2.5 py-1 rounded-lg border border-emerald-200 shadow-2xs">Mandiri Bill</span>
                                        <span class="bg-white px-2.5 py-1 rounded-lg border border-emerald-200 shadow-2xs">BRI VA</span>
                                        <span class="bg-white px-2.5 py-1 rounded-lg border border-emerald-200 shadow-2xs">BNI VA</span>
                                        <span class="bg-white px-2.5 py-1 rounded-lg border border-emerald-200 shadow-2xs">Kartu Kredit</span>
                                        <span class="bg-white px-2.5 py-1 rounded-lg border border-emerald-200 shadow-2xs">Alfamart / Indomaret</span>
                                    </div>
                                </div>
                            @endif

                            <!-- DETAILS BOX (Jika Ada VA / QRIS Spesifik) -->
                            @if($order->payment_type === 'qris')
                                <div class="mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-200/80 text-center">
                                    <div class="flex items-center justify-center gap-2 mb-3">
                                        <span class="bg-slate-900 text-white px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider">
                                            QRIS Bersama
                                        </span>
                                        <span class="text-xs font-semibold text-gray-500">Gopay / ShopeePay / OVO / Dana / LinkAja</span>
                                    </div>

                                    <div class="bg-white p-4 inline-block rounded-2xl shadow-md border border-slate-200 mb-4">
                                        @if($order->payment_qr_url)
                                            <img src="{{ $order->payment_qr_url }}" alt="QRIS Code" class="w-64 h-64 mx-auto object-contain">
                                        @else
                                            <div class="w-64 h-64 flex flex-col items-center justify-center text-gray-400 bg-gray-50 rounded-xl">
                                                <i class="fas fa-qrcode text-5xl mb-2"></i>
                                                <span class="text-xs">QR Code dapat dibuka melalui tombol Midtrans</span>
                                            </div>
                                        @endif
                                    </div>

                                    <p class="text-xs md:text-sm text-gray-600 mb-4 max-w-sm mx-auto">
                                        Buka aplikasi m-Banking atau E-Wallet pilihan Anda, lalu scan QRIS di atas.
                                    </p>

                                    @if($order->payment_va_number)
                                        <div class="mt-4 pt-4 border-t border-slate-200/60 text-left">
                                            <div class="flex items-center justify-between mb-1.5">
                                                <span class="text-[11px] font-bold text-gray-600">Kode String QRIS (Simulator Sandbox):</span>
                                                <button type="button" onclick="copyQRString()" class="text-xs text-emerald-600 hover:text-emerald-700 font-bold flex items-center gap-1">
                                                    <i class="far fa-copy"></i> Salin String
                                                </button>
                                            </div>
                                            <p id="qr-string-val" class="text-[10px] font-mono bg-white p-2.5 rounded-xl border border-slate-200 text-gray-500 break-all select-all">
                                                {{ $order->payment_va_number }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @elseif($order->payment_type === 'echannel')
                                <div class="mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-200/80 text-center">
                                    <div class="flex items-center justify-center gap-2 mb-4">
                                        <span class="bg-blue-600 text-white px-3 py-1 rounded-lg text-xs font-bold uppercase">Mandiri</span>
                                        <h3 class="font-bold text-gray-800 text-base">Bill Payment</h3>
                                    </div>

                                    <div class="space-y-4 max-w-sm mx-auto">
                                        <div class="bg-white p-3.5 rounded-xl border border-slate-200">
                                            <p class="text-[11px] text-gray-500 uppercase font-bold tracking-wider mb-0.5">Biller Code</p>
                                            <div class="flex items-center justify-center gap-2">
                                                <p id="biller-code" class="text-2xl font-mono font-black text-gray-900">{{ $order->payment_biller_code }}</p>
                                                <button onclick="copyText('{{ $order->payment_biller_code }}', 'Biller Code')" class="text-emerald-600 hover:text-emerald-700 p-1">
                                                    <i class="far fa-copy text-base"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="bg-white p-3.5 rounded-xl border border-slate-200">
                                            <p class="text-[11px] text-gray-500 uppercase font-bold tracking-wider mb-0.5">Bill Key / No. Pembayaran</p>
                                            <div class="flex items-center justify-center gap-2">
                                                <p id="va-number" class="text-2xl md:text-3xl font-mono font-black text-emerald-600">{{ $order->payment_bill_key }}</p>
                                                <button onclick="copyText('{{ $order->payment_bill_key }}', 'Bill Key')" class="text-emerald-600 hover:text-emerald-700 p-1">
                                                    <i class="far fa-copy text-base"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($order->payment_va_number)
                                <div class="mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-200/80 text-center">
                                    <div class="flex items-center justify-center gap-2 mb-3">
                                        <span class="bg-blue-600 text-white px-3 py-1 rounded-lg text-xs font-bold uppercase">
                                            {{ strtoupper($order->payment_bank ?? 'BANK') }}
                                        </span>
                                        <h3 class="font-bold text-gray-800 text-base">Virtual Account</h3>
                                    </div>

                                    <div class="bg-white p-4 md:p-5 rounded-2xl border border-slate-200 shadow-sm max-w-sm mx-auto">
                                        <p class="text-[11px] text-gray-500 font-semibold mb-1">Nomor Virtual Account:</p>
                                        <div class="flex items-center justify-center gap-3">
                                            <p id="va-number" class="text-2xl md:text-3xl font-mono font-black text-emerald-600 tracking-wider">
                                                {{ $order->payment_va_number }}
                                            </p>
                                            <button onclick="copyVA()" title="Salin Nomor VA" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 p-2.5 rounded-xl border border-emerald-200 transition-colors">
                                                <i class="far fa-copy text-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- PANDUAN LANGKAH PEMBAYARAN -->
                            <div class="space-y-4">
                                <h4 class="font-bold text-gray-800 border-b border-gray-100 pb-2 text-sm md:text-base flex items-center gap-2">
                                    <i class="fas fa-list-ol text-emerald-600"></i>
                                    Panduan Pembayaran Midtrans
                                </h4>
                                <div class="space-y-3 text-xs md:text-sm text-gray-600">
                                    <div class="flex gap-3">
                                        <span class="flex-none w-6 h-6 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                        <p>Klik tombol <strong>Bayar Sekarang via Midtrans</strong> di atas.</p>
                                    </div>
                                    <div class="flex gap-3">
                                        <span class="flex-none w-6 h-6 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                        <p>Pilih metode yang diinginkan (GoPay, QRIS, Bank BCA, Mandiri, BRI, BNI, Permata, Alfamart, dll).</p>
                                    </div>
                                    <div class="flex gap-3">
                                        <span class="flex-none w-6 h-6 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                        <p>Selesaikan transaksi sesuai instruksi di layar popup. Status pembayaran akan otomatis terverifikasi tanpa perlu konfirmasi manual!</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Footer Action Bar -->
                        <div class="p-6 md:p-8 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row gap-4 items-center justify-between">
                            <a href="{{ route('shop.pesanan') }}" class="text-xs md:text-sm text-gray-500 hover:text-gray-800 font-bold transition-colors flex items-center gap-1.5">
                                <i class="fas fa-arrow-left"></i>
                                <span>Kembali ke Pesanan Saya</span>
                            </a>

                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                <button type="button" onclick="openChangePaymentModal()" class="flex-1 sm:flex-none px-4 py-3 rounded-xl border border-gray-300 hover:border-emerald-500 text-gray-700 hover:text-emerald-700 text-xs md:text-sm font-bold transition-colors">
                                    Ganti Metode
                                </button>
                                <a href="{{ route('shop.pesanan.syncStatus', $order->order_code) }}" class="flex-1 sm:flex-none bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold text-xs md:text-sm shadow-md transition-all flex items-center justify-center gap-2">
                                    <i class="fas fa-sync-alt" id="sync-icon"></i>
                                    <span>Cek Status Pembayaran</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT COLUMN: Order Summary & Item Snapshot (2 cols) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Order Summary Card -->
                    <div class="bg-white rounded-3xl shadow-xl p-6 md:p-7 border border-slate-100">
                        <h3 class="text-base font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3 flex items-center justify-between">
                            <span>Ringkasan Transaksi</span>
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800">
                                Menunggu Bayar
                            </span>
                        </h3>
                        
                        <div class="space-y-3.5 mb-6 text-xs md:text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Kode Transaksi</span>
                                <span class="font-mono font-bold text-gray-800">{{ $orderCode }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Metode Bayar</span>
                                <span class="font-bold text-emerald-700 uppercase flex items-center gap-1">
                                    {{ $order->metode_pembayaran ?: 'Midtrans Gateway' }}
                                </span>
                            </div>
                            <div class="pt-4 border-t border-dashed border-slate-200">
                                <span class="text-[11px] text-gray-400 block mb-0.5">Total Tagihan:</span>
                                <span class="text-2xl md:text-3xl font-black text-gray-900 block">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Sandbox Testing Helper Box -->
                        <div class="bg-emerald-50/80 rounded-2xl p-4 border border-emerald-200/80">
                            <div class="flex items-start gap-2.5">
                                <i class="fas fa-flask text-emerald-600 text-sm mt-0.5"></i>
                                <div>
                                    <h5 class="text-xs font-bold text-emerald-950 mb-0.5">Simulator Midtrans Sandbox</h5>
                                    <p class="text-[11px] text-emerald-800 leading-relaxed mb-2">
                                        Gunakan simulator resmi Midtrans untuk memverifikasi pembayaran uji coba:
                                    </p>
                                    <a href="https://simulator.sandbox.midtrans.com/" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-white bg-emerald-600 hover:bg-emerald-700 px-3 py-1.5 rounded-lg transition-colors">
                                        <span>Buka Simulator Sandbox</span>
                                        <i class="fas fa-external-link-alt text-[9px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Snapshot Card -->
                    <div class="bg-white rounded-3xl shadow-xl p-6 md:p-7 border border-slate-100">
                        <h4 class="text-sm font-bold text-gray-900 mb-4">Item yang Dipesan:</h4>
                        <div class="space-y-3">
                            @foreach($allOrders ?? [$order] as $item)
                                <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition-colors">
                                    <div class="w-12 h-12 bg-slate-100 rounded-xl overflow-hidden flex-none border border-slate-200">
                                        <img src="{{ $item->bonsai && $item->bonsai->image_path ? asset('storage/'.$item->bonsai->image_path) : asset('images/logo.png') }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0 flex-grow">
                                        <p class="text-xs font-bold text-gray-900 truncate">{{ $item->bonsai ? $item->bonsai->name : 'Pohon Bonsai' }}</p>
                                        <p class="text-[11px] text-gray-500 font-mono">{{ $item->quantity }}x @ Rp {{ number_format($item->bonsai ? $item->bonsai->current_value : $item->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>

        @endif

    </div>
</section>

<!-- MODAL GANTI METODE PEMBAYARAN -->
<div id="change-payment-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 md:p-8 shadow-2xl transform transition-transform scale-95" id="change-payment-card">
        
        <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
            <div>
                <h4 class="font-extrabold text-gray-900 text-lg">Ganti Metode Pembayaran</h4>
                <p class="text-xs text-gray-500">Pilih metode pembayaran baru untuk pesanan ini</p>
            </div>
            <button type="button" onclick="closeChangePaymentModal()" class="text-gray-400 hover:text-gray-600 text-xl w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('shop.pesanan.changePayment', $order->order_code) }}" method="POST">
            @csrf
            
            <div class="space-y-3 mb-6 max-h-[60vh] overflow-y-auto pr-1">
                
                <!-- MIDTRANS FULL -->
                <label class="flex items-center justify-between p-3.5 rounded-2xl border-2 border-slate-200 hover:border-emerald-500 cursor-pointer transition-all has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/30">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-emerald-600 to-green-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                            FULL
                        </div>
                        <div>
                            <span class="block font-bold text-gray-900 text-sm">Semua Metode Midtrans (Lengkap)</span>
                            <span class="text-[11px] text-gray-500">QRIS, E-Wallet, Semua Bank, Kartu Kredit, Indomaret/Alfamart</span>
                        </div>
                    </div>
                    <input type="radio" name="metode_pembayaran" value="midtrans" {{ $order->metode_pembayaran === 'midtrans' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 focus:ring-emerald-500" required>
                </label>

                <!-- BCA VA -->
                <label class="flex items-center justify-between p-3.5 rounded-2xl border-2 border-slate-200 hover:border-emerald-500 cursor-pointer transition-all has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/30">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">
                            BCA
                        </div>
                        <div>
                            <span class="block font-bold text-gray-900 text-sm">BCA Virtual Account</span>
                            <span class="text-[11px] text-gray-500">Verifikasi otomatis via KlikBCA / myBCA / ATM</span>
                        </div>
                    </div>
                    <input type="radio" name="metode_pembayaran" value="bca" {{ $order->metode_pembayaran === 'bca' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                </label>

                <!-- BRI VA -->
                <label class="flex items-center justify-between p-3.5 rounded-2xl border-2 border-slate-200 hover:border-emerald-500 cursor-pointer transition-all has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/30">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-800 flex items-center justify-center font-bold text-xs shrink-0">
                            BRI
                        </div>
                        <div>
                            <span class="block font-bold text-gray-900 text-sm">BRI Virtual Account (BRIVA)</span>
                            <span class="text-[11px] text-gray-500">Verifikasi otomatis via BRImo / ATM</span>
                        </div>
                    </div>
                    <input type="radio" name="metode_pembayaran" value="bri" {{ $order->metode_pembayaran === 'bri' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                </label>

                <!-- BNI VA -->
                <label class="flex items-center justify-between p-3.5 rounded-2xl border-2 border-slate-200 hover:border-emerald-500 cursor-pointer transition-all has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/30">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center font-bold text-xs shrink-0">
                            BNI
                        </div>
                        <div>
                            <span class="block font-bold text-gray-900 text-sm">BNI Virtual Account</span>
                            <span class="text-[11px] text-gray-500">Verifikasi otomatis via BNI Mobile</span>
                        </div>
                    </div>
                    <input type="radio" name="metode_pembayaran" value="bni" {{ $order->metode_pembayaran === 'bni' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                </label>

                <!-- MANDIRI -->
                <label class="flex items-center justify-between p-3.5 rounded-2xl border-2 border-slate-200 hover:border-emerald-500 cursor-pointer transition-all has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/30">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold text-xs shrink-0">
                            MDR
                        </div>
                        <div>
                            <span class="block font-bold text-gray-900 text-sm">Mandiri Bill Payment</span>
                            <span class="text-[11px] text-gray-500">Biller code & Bill key</span>
                        </div>
                    </div>
                    <input type="radio" name="metode_pembayaran" value="mandiri" {{ $order->metode_pembayaran === 'mandiri' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                </label>

                <!-- QRIS -->
                <label class="flex items-center justify-between p-3.5 rounded-2xl border-2 border-slate-200 hover:border-emerald-500 cursor-pointer transition-all has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/30">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-900 text-white flex items-center justify-center font-bold text-xs shrink-0">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-gray-900 text-sm">QRIS (Gopay / ShopeePay / E-Wallet)</span>
                            <span class="text-[11px] text-gray-500">Scan QR Code dengan aplikasi pembayaran apa saja</span>
                        </div>
                    </div>
                    <input type="radio" name="metode_pembayaran" value="qris" {{ $order->metode_pembayaran === 'qris' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                </label>

            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeChangePaymentModal()" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs md:text-sm font-bold hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs md:text-sm font-bold shadow-md transition-colors flex items-center gap-2">
                    <i class="fas fa-check"></i>
                    <span>Terapkan Metode Baru</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Load Midtrans Snap Script -->
<script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script>
    const isPaid = {{ (!empty($isPaid) || in_array($order->status, ['diproses', 'dikirim', 'selesai'])) ? 'true' : 'false' }};
    const snapToken = "{{ $snapToken ?? '' }}";
    const orderCode = "{{ $order->order_code }}";

    // 1. SNAP PAYMENT TRIGGER
    function payWithSnap() {
        if (!snapToken) {
            Swal.fire({
                icon: 'warning',
                title: 'Snap Token Belum Siap',
                text: 'Silakan refresh halaman atau hubungi admin.',
                confirmButtonColor: '#10b981'
            });
            return;
        }

        if (typeof window.snap === 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Memuat Midtrans',
                text: 'Pastikan koneksi internet aktif untuk memuat sistem pembayaran Midtrans.',
                confirmButtonColor: '#10b981'
            });
            return;
        }

        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                // Saat pembayaran sukses di Midtrans Snap
                Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Berhasil! (Sudah Dibayar)',
                    text: 'Memverifikasi status transaksi...',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('shop.pesanan.syncStatus', $order->order_code) }}";
                });
            },
            onPending: function(result) {
                // Menunggu pembayaran (misal VA dibuat di dalam snap)
                Swal.fire({
                    icon: 'info',
                    title: 'Menunggu Pembayaran',
                    text: 'Silakan selesaikan instruksi pembayaran yang dipilih.',
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    window.location.reload();
                });
            },
            onError: function(result) {
                Swal.fire({
                    icon: 'error',
                    title: 'Pembayaran Gagal',
                    text: 'Silakan coba lagi atau gunakan metode pembayaran lainnya.',
                    confirmButtonColor: '#10b981'
                });
            },
            onClose: function() {
                // Cek status jika user sudah membayar lalu menutup popup
                checkStatusInBackground();
            }
        });
    }

    // 2. AUTO-POLLING CEK STATUS PEMBAYARAN (REAL-TIME REFRESH)
    let pollingInterval = null;

    function checkStatusInBackground() {
        if (isPaid) return;

        fetch("{{ route('shop.pesanan.statusJson', $order->order_code) }}")
            .then(res => res.json())
            .then(data => {
                if (data && data.is_paid) {
                    if (pollingInterval) clearInterval(pollingInterval);
                    // Refresh halaman otomatis ke tampilan (Sudah Dibayar)
                    window.location.reload();
                }
            })
            .catch(err => {
                // Abaikan error polling
            });
    }

    if (!isPaid) {
        // Polling setiap 5 detik agar otomatis refresh begitu user selesai bayar di HP / simulator
        pollingInterval = setInterval(checkStatusInBackground, 5000);
    }

    // 3. 24-HOUR COUNTDOWN TIMER SCRIPT
    @if(isset($expiryTimestamp))
    const targetTimestamp = {{ $expiryTimestamp }} * 1000;

    function updateCountdown() {
        const cdHours = document.getElementById('cd-hours');
        if (!cdHours) return;

        const now = new Date().getTime();
        const difference = targetTimestamp - now;

        if (difference <= 0) {
            document.getElementById('cd-hours').textContent = '00';
            document.getElementById('cd-minutes').textContent = '00';
            document.getElementById('cd-seconds').textContent = '00';
            return;
        }

        const hours = Math.floor(difference / (1000 * 60 * 60));
        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

        document.getElementById('cd-hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('cd-minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('cd-seconds').textContent = String(seconds).padStart(2, '0');
    }

    setInterval(updateCountdown, 1000);
    updateCountdown();
    @endif

    // 4. COPY HELPERS
    function copyVA() {
        const vaElement = document.getElementById('va-number');
        if (vaElement) {
            copyText(vaElement.innerText.trim(), 'Nomor Virtual Account');
        }
    }

    function copyQRString() {
        const qrElement = document.getElementById('qr-string-val');
        if (qrElement) {
            copyText(qrElement.innerText.trim(), 'String QRIS');
        }
    }

    function copyText(text, label) {
        navigator.clipboard.writeText(text).then(() => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: label + ' berhasil disalin!',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                alert(label + ' berhasil disalin!');
            }
        });
    }

    // 5. MODAL CONTROLS
    function openChangePaymentModal() {
        const modal = document.getElementById('change-payment-modal');
        const card = document.getElementById('change-payment-card');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }, 10);
    }

    function closeChangePaymentModal() {
        const modal = document.getElementById('change-payment-modal');
        const card = document.getElementById('change-payment-card');
        modal.classList.add('opacity-0');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }
</script>
@endsection
