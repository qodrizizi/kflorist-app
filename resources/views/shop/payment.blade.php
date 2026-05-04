@extends('layouts.shop')

@section('content')
<section class="py-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <div class="grid lg:grid-cols-5 gap-8">
                <!-- Instruction Card -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-emerald-500 to-green-600 p-8 text-white">
                            <h2 class="text-2xl font-bold mb-2">Instruksi Pembayaran</h2>
                            <p class="opacity-90">Selesaikan pembayaran Anda sebelum waktu habis</p>
                        </div>

                        <div class="p-8">
                            <!-- Bank Info / QRIS -->
                            <div class="mb-8 p-6 bg-emerald-50 rounded-2xl border border-emerald-100 text-center">
                                @if($order->payment_type === 'qris')
                                    <h3 class="font-bold text-gray-800 mb-4">Scan QRIS Berikut</h3>
                                    <div class="bg-white p-4 inline-block rounded-xl shadow-sm mb-4">
                                        <img src="{{ $order->payment_qr_url }}" alt="QRIS" class="w-64 h-64 mx-auto">
                                    </div>
                                    <p class="text-sm text-gray-600">Buka aplikasi m-banking atau e-wallet (Gopay/OVO/Dana) lalu scan kode di atas</p>
                                @elseif($order->payment_type === 'echannel')
                                    <h3 class="font-bold text-gray-800 mb-4">Mandiri Bill Payment</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Biller Code</p>
                                            <p class="text-2xl font-mono font-black text-emerald-600">{{ $order->payment_biller_code }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Bill Key</p>
                                            <div class="flex items-center justify-center gap-3">
                                                <p id="va-number" class="text-3xl font-mono font-black text-emerald-600">{{ $order->payment_bill_key }}</p>
                                                <button onclick="copyVA()" class="text-emerald-500 hover:text-emerald-700 transition-colors">
                                                    <i class="far fa-copy text-xl"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center justify-center gap-3 mb-2">
                                        <div class="bg-blue-600 text-white px-3 py-1 rounded-lg text-xs font-bold uppercase">{{ $order->payment_bank }}</div>
                                        <h3 class="font-bold text-gray-800">Virtual Account</h3>
                                    </div>
                                    <div class="flex items-center justify-center gap-4 mt-4">
                                        <p id="va-number" class="text-4xl font-mono font-black text-emerald-600 tracking-wider">
                                            {{ $order->payment_va_number }}
                                        </p>
                                        <button onclick="copyVA()" class="bg-white p-2 rounded-lg shadow-sm border border-emerald-200 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all">
                                            <i class="far fa-copy text-xl"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <!-- Payment Steps -->
                            <div class="space-y-4">
                                <h4 class="font-bold text-gray-800 border-b pb-2">Cara Pembayaran:</h4>
                                <div class="space-y-3">
                                    <div class="flex gap-4">
                                        <div class="flex-none w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs font-bold">1</div>
                                        <p class="text-sm text-gray-600">Buka aplikasi mobile banking atau pergi ke ATM terdekat.</p>
                                    </div>
                                    <div class="flex gap-4">
                                        <div class="flex-none w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs font-bold">2</div>
                                        <p class="text-sm text-gray-600">Pilih menu <strong>Transfer</strong> lalu pilih <strong>Virtual Account</strong>.</p>
                                    </div>
                                    <div class="flex gap-4">
                                        <div class="flex-none w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs font-bold">3</div>
                                        <p class="text-sm text-gray-600">Masukkan Nomor Virtual Account di atas.</p>
                                    </div>
                                    <div class="flex gap-4">
                                        <div class="flex-none w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs font-bold">4</div>
                                        <p class="text-sm text-gray-600">Periksa detail pembayaran, lalu konfirmasi.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row gap-4 items-center justify-between">
                            <a href="{{ route('shop.pesanan') }}" class="text-gray-500 hover:text-gray-800 font-medium transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Pesanan
                            </a>
                            <button onclick="window.location.reload()" class="bg-emerald-500 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-emerald-600 transition-all">
                                Cek Status Pembayaran
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-4">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Kode Pesanan</span>
                                <span class="font-bold text-gray-800">{{ $orderCode }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Metode</span>
                                <span class="font-bold text-emerald-600 uppercase">{{ $order->payment_type }}</span>
                            </div>
                            <div class="pt-4 border-t border-dashed">
                                <p class="text-xs text-gray-400 mb-1">Total yang harus dibayar:</p>
                                <p class="text-3xl font-black text-gray-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="bg-amber-50 rounded-2xl p-4 flex gap-3">
                            <i class="fas fa-info-circle text-amber-500 mt-1"></i>
                            <p class="text-xs text-amber-700 leading-relaxed">
                                Pesanan akan otomatis dibatalkan jika pembayaran tidak diterima dalam 24 jam.
                            </p>
                        </div>
                    </div>

                    <!-- Products Snapshot -->
                    <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
                        <h4 class="text-sm font-bold text-gray-800 mb-4">Item Pesanan:</h4>
                        <div class="space-y-3">
                            @foreach($allOrders ?? [$order] as $item)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden flex-none">
                                        <img src="{{ $item->bonsai->image_path ? asset('storage/'.$item->bonsai->image_path) : asset('images/logonobg.png') }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0 flex-grow">
                                        <p class="text-xs font-bold text-gray-800 truncate">{{ $item->bonsai->name }}</p>
                                        <p class="text-[10px] text-gray-500">{{ $item->quantity }}x @ Rp{{ number_format($item->bonsai->current_value, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    function copyVA() {
        const vaNumber = document.getElementById('va-number').innerText;
        navigator.clipboard.writeText(vaNumber).then(() => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Nomor disalin!',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }
</script>
@endsection
