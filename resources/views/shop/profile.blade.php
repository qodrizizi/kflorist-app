@extends('layouts.shop')

@section('content')

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-gray-800 mb-10 text-center">Profil Saya</h1>
        
        <div class="bg-white rounded-xl shadow-xl p-6 md:p-12">
            <div class="grid md:grid-cols-3 gap-10">
                <div class="md:col-span-1">
                    <div class="flex flex-col items-center text-center border-b pb-6 mb-6">
                        <img src="https://via.placeholder.com/150" alt="Foto Profil" class="w-24 h-24 rounded-full mb-4 border-4 border-green-500">
                        <h2 class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-600">{{ Auth::user()->email }}</p>
                    </div>

                    <nav class="flex flex-col space-y-2">
                        <a href="#profile-info" class="flex items-center gap-3 p-4 rounded-lg bg-green-500 text-white font-semibold transition hover:bg-green-600">
                            <i class="fas fa-user-edit"></i>
                            Informasi Profil
                        </a>
                        <a href="#orders" class="flex items-center gap-3 p-4 rounded-lg text-gray-600 font-semibold transition hover:bg-gray-100">
                            <i class="fas fa-shopping-bag"></i>
                            Pesanan Saya
                        </a>
                        <a href="#settings" class="flex items-center gap-3 p-4 rounded-lg text-gray-600 font-semibold transition hover:bg-gray-100">
                            <i class="fas fa-cog"></i>
                            Pengaturan Akun
                        </a>
                    </nav>
                </div>

                <div class="md:col-span-2">
                    <div id="profile-info" class="mb-10">
                        <h3 class="text-2xl font-bold text-gray-800 border-b pb-3 mb-6">Informasi Profil</h3>
                        <form action="#" method="POST">
                            <div class="grid sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                </div>
                                <div>
                                    <label for="email" class="block text-gray-700 font-semibold mb-2">Alamat Email</label>
                                    <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed" disabled>
                                </div>
                                </div>
                            <div class="mt-8">
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-full transition transform hover:scale-105">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="orders" class="mb-10">
                        <h3 class="text-2xl font-bold text-gray-800 border-b pb-3 mb-6">Pesanan Terbaru</h3>
                        <div class="bg-gray-100 p-6 rounded-lg">
                            <p class="text-gray-600">Anda belum memiliki pesanan. <a href="{{ route('shop.produk') }}" class="text-green-500 hover:underline font-semibold">Mulai belanja sekarang!</a></p>
                        </div>
                        </div>
                </div>
            </div>
            
            <div class="mt-12 text-center border-t pt-8">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-500 hover:text-red-700 font-semibold text-lg transition">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</section>

@endsection