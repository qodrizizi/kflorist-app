@extends('layouts.shop')

@section('content')

<section class="min-h-[70vh] flex items-center justify-center bg-gray-50 py-16">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-xl mx-auto bg-white rounded-xl shadow-lg p-8 md:p-12">
            <div class="text-4xl text-gray-400 mb-6">
                <i class="fas fa-user-circle"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Anda Belum Login</h2>
            <p class="text-gray-600 mb-8">
                Silakan masuk ke akun Anda untuk melihat profil dan riwayat pesanan.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white font-semibold px-8 py-3 rounded-full transition transform hover:scale-105">
                    Login
                </a>
                <a href="{{ route('register') }}" class="w-full sm:w-auto border-2 border-green-500 text-green-500 hover:bg-green-500 hover:text-white font-semibold px-8 py-3 rounded-full transition">
                    Daftar
                </a>
            </div>
        </div>
    </div>
</section>

@endsection