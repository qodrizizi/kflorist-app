@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-2 bg-gradient-to-r from-bonsai-600 to-bonsai-500 bg-clip-text text-transparent">
                Profil Pengguna 👤
            </h2>
            <p class="text-sm md:text-base text-gray-600 font-medium">Kelola informasi dan pengaturan akun Anda.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 bg-white/80 backdrop-blur-sm rounded-xl shadow-xl p-6 border border-white/20 h-fit">
            <div class="flex flex-col items-center">
                <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-gradient-to-br from-bonsai-500 to-bonsai-600 flex items-center justify-center text-white text-4xl sm:text-5xl font-semibold mb-4">
                    {{ strtoupper(substr(Auth::user()->name ?? 'JD', 0, 2)) }}
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">{{ Auth::user()->name ?? 'John Doe' }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ Auth::user()->email ?? 'johndoe@example.com' }}</p>

                <span class="px-4 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                    Bergabung {{ Auth::user()->created_at->diffForHumans() ?? 'sejak 1 tahun lalu' }}
                </span>

                <div>
                    <p class="text-sm font-semibold text-gray-700">Peran Akun</p>
                    <p class="text-sm text-gray-500">{{ Auth::user()->role ?? 'Admin' }}</p>
                </div>

            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-xl p-6 border border-white/20">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">Perbarui Informasi Profil</h3>
                <form action="#" method="POST" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                        <input type="text" id="name" name="name" value="{{ Auth::user()->name ?? 'John Doe' }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ Auth::user()->email ?? 'johndoe@example.com' }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300">
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-gradient-to-r from-bonsai-500 to-bonsai-600 hover:from-bonsai-600 hover:to-bonsai-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-xl p-6 border border-white/20">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">Perbarui Kata Sandi</h3>
                <form action="#" method="POST" class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300">
                    </div>
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi Baru</label>
                        <input type="password" id="new_password" name="new_password" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300">
                    </div>
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300">
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            Ubah Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-xl p-6 border border-white/20">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">Kelola Sesi Login</h3>
                <p class="text-sm text-gray-600 mb-4">Anda dapat melihat dan mengakhiri sesi login Anda di perangkat lain.</p>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl">💻</span>
                            <div>
                                <p class="font-medium text-gray-800">Sesi Saat Ini (Desktop)</p>
                                <p class="text-xs text-gray-500">Medan, Indonesia • Chrome</p>
                            </div>
                        </div>
                        <span class="text-xs text-bonsai-600 font-semibold">Aktif</span>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl">📱</span>
                            <div>
                                <p class="font-medium text-gray-800">iPhone 14 Pro</p>
                                <p class="text-xs text-gray-500">Jakarta, Indonesia • Safari</p>
                            </div>
                        </div>
                        <button class="text-sm text-red-500 hover:underline">Keluar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection