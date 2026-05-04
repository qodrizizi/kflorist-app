@extends('layouts.shop')

@section('content')
<section class="py-16 bg-gradient-to-br from-gray-50 to-white min-h-[70vh]">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-gray-800 mb-2 text-center">Pembayaran</h1>
        <p class="text-center text-gray-500 mb-10">Selesaikan pesanan Anda dengan mengisi detail di bawah ini</p>
        
        <form action="{{ route('shop.checkout.process') }}" method="POST">
            @csrf
            @if($isDirectBuy && count($items) > 0)
                <input type="hidden" name="bonsai_id" value="{{ $items[0]['bonsai']->id }}">
            @endif

            <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                
                <!-- Formulir Alamat & Pembayaran -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Detail Pengiriman -->
                    <div class="bg-white rounded-3xl shadow-lg p-6 md:p-8 border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center border-b pb-4">
                            <i class="fas fa-map-marker-alt text-emerald-500 mr-3"></i> Alamat Pengiriman
                        </h2>
                        
                        <div class="space-y-4">
                            @php
                                $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
                            @endphp

                            @if($addresses->count() > 0)
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Alamat Pengiriman <span class="text-red-500">*</span></label>
                                    <div class="space-y-3">
                                        @foreach($addresses as $idx => $address)
                                            <label class="block relative border-2 {{ $address->is_default ? 'border-emerald-500 bg-emerald-50/20' : 'border-gray-200 hover:border-emerald-300' }} rounded-xl p-4 cursor-pointer transition-colors">
                                                <input type="radio" name="alamat_pengiriman" value="{{ $address->address_line }}, {{ $address->district }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }} (Penerima: {{ $address->recipient_name }} - {{ $address->phone }})" class="absolute top-5 right-5 text-emerald-500 focus:ring-emerald-500 w-5 h-5" {{ $address->is_default ? 'checked' : '' }} required>
                                                
                                                <div class="pr-8">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="font-bold text-gray-800">{{ $address->recipient_name }}</span>
                                                        <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded">{{ $address->title }}</span>
                                                        @if($address->is_default)
                                                            <span class="text-xs px-2 py-0.5 bg-emerald-100 text-emerald-700 font-bold rounded">Utama</span>
                                                        @endif
                                                    </div>
                                                    <p class="text-sm text-gray-600 mb-1"><i class="fas fa-phone text-gray-400 mr-1 w-4"></i> {{ $address->phone }}</p>
                                                    <p class="text-sm text-gray-600 leading-relaxed"><i class="fas fa-map-marker-alt text-gray-400 mr-1 w-4"></i> {{ $address->address_line }}, {{ $address->district }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    <div class="mt-4 text-right">
                                        <a href="{{ route('shop.profile') }}" class="text-sm text-emerald-600 font-medium hover:underline"><i class="fas fa-plus mr-1"></i> Tambah / Kelola Alamat Baru</a>
                                    </div>
                                </div>
                            @else
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-xl mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                Anda belum memiliki alamat pengiriman yang tersimpan.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                    <textarea name="alamat_pengiriman" rows="3" required placeholder="Contoh: Jl. Sudirman No. 123, RT 01/RW 02, Kec. X, Kota Y" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"></textarea>
                                    <div class="mt-2 text-right">
                                        <a href="{{ route('shop.profile') }}" class="text-xs text-emerald-600 font-medium hover:underline">Atau simpan alamat di Profil untuk nanti</a>
                                    </div>
                                </div>
                            @endif

                            <div class="pt-4 border-t border-gray-100">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                                <textarea name="catatan" rows="2" placeholder="Contoh: Titip di pos satpam atau telpon sebelum sampai" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="bg-white rounded-3xl shadow-lg p-6 md:p-8 border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center border-b pb-4">
                            <i class="fas fa-wallet text-emerald-500 mr-3"></i> Metode Pembayaran
                        </h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- BCA VA -->
                            <label class="relative flex flex-col p-4 border-2 border-gray-200 rounded-2xl cursor-pointer hover:border-emerald-500 transition-all group has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/30">
                                <input type="radio" name="metode_pembayaran" value="bca" class="hidden" required>
                                <div class="flex justify-between items-start mb-4">
                                    <span class="font-bold text-gray-800">BCA Virtual Account</span>
                                    <div class="bg-blue-600 text-white px-2 py-0.5 rounded text-[10px] font-bold">BCA</div>
                                </div>
                                <div class="mt-auto flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Otomatis Terverifikasi</span>
                                    <i class="fas fa-check-circle text-emerald-500 opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></i>
                                </div>
                            </label>

                            <!-- Mandiri VA -->
                            <label class="relative flex flex-col p-4 border-2 border-gray-200 rounded-2xl cursor-pointer hover:border-emerald-500 transition-all group has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/30">
                                <input type="radio" name="metode_pembayaran" value="mandiri" class="hidden">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="font-bold text-gray-800">Mandiri Bill Payment</span>
                                    <div class="bg-yellow-500 text-white px-2 py-0.5 rounded text-[10px] font-bold">MANDIRI</div>
                                </div>
                                <div class="mt-auto flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Otomatis Terverifikasi</span>
                                    <i class="fas fa-check-circle text-emerald-500 opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></i>
                                </div>
                            </label>

                            <!-- BRI VA -->
                            <label class="relative flex flex-col p-4 border-2 border-gray-200 rounded-2xl cursor-pointer hover:border-emerald-500 transition-all group has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/30">
                                <input type="radio" name="metode_pembayaran" value="bri" class="hidden">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="font-bold text-gray-800">BRI Virtual Account</span>
                                    <div class="bg-blue-800 text-white px-2 py-0.5 rounded text-[10px] font-bold">BRI</div>
                                </div>
                                <div class="mt-auto flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Otomatis Terverifikasi</span>
                                    <i class="fas fa-check-circle text-emerald-500 opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></i>
                                </div>
                            </label>

                            <!-- QRIS -->
                            <label class="relative flex flex-col p-4 border-2 border-gray-200 rounded-2xl cursor-pointer hover:border-emerald-500 transition-all group has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/30">
                                <input type="radio" name="metode_pembayaran" value="qris" class="hidden">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="font-bold text-gray-800">QRIS (Gopay/OVO/Dana)</span>
                                    <div class="bg-rose-500 text-white px-2 py-0.5 rounded text-[10px] font-bold">QRIS</div>
                                </div>
                                <div class="mt-auto flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Scan & Bayar Instan</span>
                                    <i class="fas fa-check-circle text-emerald-500 opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></i>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Ringkasan Pesanan -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center border-b pb-4">
                            <i class="fas fa-shopping-basket text-emerald-500 mr-3"></i> Pesanan Anda
                        </h3>
                        
                        <div class="space-y-4 mb-6 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($items as $item)
                                <div class="flex items-center gap-4 border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                    <img src="{{ $item['bonsai']->image_path ? asset('storage/' . $item['bonsai']->image_path) : asset('images/logonobg.png') }}" 
                                         class="w-16 h-16 rounded-lg object-cover bg-emerald-50">
                                    <div class="flex-grow">
                                        <h4 class="text-sm font-bold text-gray-800 leading-tight">{{ $item['bonsai']->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $item['quantity'] }} x Rp {{ number_format($item['bonsai']->current_value, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-sm font-bold text-emerald-600">
                                        Rp {{ number_format($item['total'], 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="border-t-2 border-dashed border-gray-200 pt-6 mb-8 space-y-3">
                            <div class="flex justify-between items-center text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-600">
                                <span>Ongkos Kirim</span>
                                <span class="font-medium text-emerald-600">Gratis</span>
                            </div>
                            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                                <span class="text-lg font-bold text-gray-800">Total Pembayaran</span>
                                <span class="text-2xl font-black text-emerald-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 flex justify-center items-center">
                            <i class="fas fa-check-circle mr-2"></i> Buat Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #059669; }
</style>
@endsection
