@extends('layouts.shop')

@section('content')

<section class="py-16 bg-gray-50 min-h-[70vh]">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-gray-800 mb-10 text-center">Keranjang Belanja</h1>
        
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center gap-4 border-b pb-4 mb-4">
                        <input type="checkbox" class="form-checkbox text-green-500 rounded focus:ring-green-500">
                        <img src="https://via.placeholder.com/100x100?text=Bonsai" alt="Bonsai Ficus" class="w-24 h-24 object-cover rounded-lg">
                        <div class="flex-grow">
                            <h4 class="text-lg font-semibold text-gray-800">Bonsai Ficus Microcarpa</h4>
                            <p class="text-green-600 font-bold mt-1">Rp 350.000</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-minus-circle"></i>
                            </button>
                            <span class="text-lg font-semibold">1</span>
                            <button class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>
                        <button class="text-red-500 hover:text-red-700 ml-4 transition">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>

                    <div class="flex items-center gap-4 border-b pb-4 mb-4">
                        <input type="checkbox" class="form-checkbox text-green-500 rounded focus:ring-green-500">
                        <img src="https://via.placeholder.com/100x100?text=Bibit" alt="Bibit Bonsai" class="w-24 h-24 object-cover rounded-lg">
                        <div class="flex-grow">
                            <h4 class="text-lg font-semibold text-gray-800">Bibit Bonsai Kawista</h4>
                            <p class="text-green-600 font-bold mt-1">Rp 85.000</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-minus-circle"></i>
                            </button>
                            <span class="text-lg font-semibold">2</span>
                            <button class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>
                        <button class="text-red-500 hover:text-red-700 ml-4 transition">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>

                    <div class="mt-8">
                        <label for="shipping" class="block text-gray-700 font-semibold mb-2">Pilih Pengiriman</label>
                        <select id="shipping" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="standard">Reguler - Rp 15.000</option>
                            <option value="express">Express - Rp 30.000</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="lg:col-span-1 mt-8 lg:mt-0">
                <div class="sticky top-8 bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Ringkasan Belanja</h3>
                    
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Total Harga (2 barang)</span>
                        <span class="font-semibold">Rp 520.000</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Biaya Pengiriman</span>
                        <span class="font-semibold">Rp 15.000</span>
                    </div>
                    
                    <div class="flex justify-between items-center font-bold text-xl mt-4 pt-4 border-t-2 border-dashed">
                        <span>Total Pembayaran</span>
                        <span class="text-green-600">Rp 535.000</span>
                    </div>
                    
                    <button class="w-full mt-6 bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-full transition transform hover:scale-105">
                        <i class="fas fa-money-check-alt mr-2"></i> Checkout
                    </button>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('shop.produk') }}" class="text-green-500 hover:underline">Lanjutkan Belanja</a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

@endsection