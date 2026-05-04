@extends('layouts.app')

    @section('title', 'Admin Manajemen Bonsai')

    {{-- Add required CSS --}}
    @push('styles')
    @yield('styles')
    <!-- Font Awesome CDN -->
    @endpush
    
    @section('content')
        {{-- Header --}}
        <div class="mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.898 20.562L16.25 21.75l-.648-1.188a2.25 2.25 0 01-1.423-1.423L13.25 18.5l1.188-.648a2.25 2.25 0 011.423-1.423L16.25 15l.648 1.188a2.25 2.25 0 011.423 1.423L19.5 18.5l-1.188.648a2.25 2.25 0 01-1.423 1.423z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">
                                Manajemen Bonsai
                            </h1>
                            <p class="text-gray-600">Kelola koleksi bonsai dengan mudah dan efisien</p>
                        </div>
                    </div>
                    <button onclick="openAddModal()" class="group relative overflow-hidden bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative flex items-center space-x-2">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="hidden sm:inline">Tambah Bonsai</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        {{-- Notifications --}}
        @if (session('success'))
            <div id="success-message" class="p-4 mb-6 text-sm text-green-800 rounded-2xl bg-green-50 border border-green-200" role="alert">
                <span class="font-medium">Sukses!</span> {{ session('success') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div id="error-message" class="p-4 mb-6 text-sm text-red-800 rounded-2xl bg-red-50 border border-red-200" role="alert">
                <span class="font-medium">Terjadi Kesalahan!</span> Mohon periksa kembali data yang Anda masukkan.
                <ul class="mt-1.5 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-gray-100/50 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Bonsai</p>
                        <p class="text-2xl font-bold text-gray-800" id="totalBonsai">{{ $bonsais->total() ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-gray-100/50 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tersedia</p>
                        <p class="text-2xl font-bold text-gray-800" id="availableBonsai">{{ $stats['available'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-gray-100/50 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.472-2.472a3.75 3.75 0 00-5.303-5.303L6.25 9.75M11.42 15.17L6.25 9.75m5.17 5.42l2.472-2.472a3.75 3.75 0 00-5.303-5.303L6.25 9.75" /></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Perawatan</p>
                        <p class="text-2xl font-bold text-gray-800" id="maintenanceBonsai">{{ $stats['maintenance'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-gray-100/50 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75" /></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Nilai</p>
                        <p class="text-xl font-bold text-gray-800" id="totalValue">Rp {{ number_format($stats['total_value'] ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter & Search --}}
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-gray-100/50 mb-8">
            <form method="GET" action="{{ route('dashboard.manajemen') }}">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari bonsai..." 
                                class="pl-10 pr-4 py-3 w-full border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300">
                        </div>
                    </div>
                    <select name="category" class="px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300">
                        <option value="">Semua Kategori</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <select name="status" class="px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300">
                        <option value="">Semua Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Terjual</option>
                        <option value="display" {{ request('status') == 'display' ? 'selected' : '' }}>Pajangan</option>
                        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Perawatan</option>
                    </select>
                    <button type="submit" class="px-6 py-3 bg-green-500 text-white rounded-2xl hover:bg-green-600 transition-colors duration-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678a1.5 1.5 0 011.069 1.488V19.5a1.5 1.5 0 01-1.5 1.5h-15a1.5 1.5 0 01-1.5-1.5V5.166a1.5 1.5 0 011.069-1.488A49.009 49.009 0 0112 3zm-2.25 9.75a.75.75 0 000 1.5h4.5a.75.75 0 000-1.5h-4.5zm-2.25-4.5a.75.75 0 000 1.5h9a.75.75 0 000-1.5h-9z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- Table Container --}}
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-gray-100/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Gambar</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Detail Bonsai</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Kategori</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nilai</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bonsais as $key => $bonsai)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-200 border-b border-gray-100">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $bonsais->firstItem() + $key }}</td>
                                <td class="px-6 py-4">
                                    <img src="{{ $bonsai->image_path ? asset('storage/' . $bonsai->image_path) : 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=300&fit=crop' }}" 
                                        alt="{{ $bonsai->name }}" 
                                        class="w-20 h-20 object-cover rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="font-bold text-gray-900 text-lg">{{ $bonsai->name }}</div>
                                        <div class="text-sm text-gray-500 font-mono bg-gray-100 px-2 py-1 rounded-lg inline-block">{{ $bonsai->code }}</div>
                                        <div class="text-sm text-gray-600">{{ $bonsai->species ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $bonsai->age_years ?? 'N/A' }} tahun</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $bonsai->category->name ?? 'Tidak ada kategori' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ getStatusClass($bonsai->status) }}">
                                            {{ getStatusText($bonsai->status) }}
                                        </span>
                                        
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-lg text-green-600">Rp {{ number_format($bonsai->current_value ?? 0, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button onclick='openEditModal(@json($bonsai))'
                                            class="w-10 h-10 flex items-center justify-center bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors duration-300 shadow-md hover:shadow-lg"
                                            title="Edit Bonsai">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('dashboard.manajemen.destroy', $bonsai->id) }}" 
                                            method="POST" 
                                            class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="w-10 h-10 flex items-center justify-center bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors duration-300 shadow-md hover:shadow-lg"
                                                title="Hapus Bonsai"
                                                onclick="confirmDelete(this)">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>

                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-16">
                                    <div class="flex flex-col items-center space-y-4">
                                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 text-lg">Tidak ada data bonsai ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($bonsais->hasPages())
            <div class="flex justify-center mt-8">
                {{ $bonsais->appends(request()->query())->links() }}
            </div>
        @endif

        {{-- Modal --}}
        <div id="bonsaiModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
            <div class="min-h-screen flex items-center justify-center p-4">
                <div class="bg-white rounded-3xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-t-3xl">
                        <div class="flex justify-between items-center">
                            <h3 id="modalTitle" class="text-2xl font-bold text-white">Modal Title</h3>
                            <button onclick="closeModal()" class="text-white/80 hover:text-white text-2xl transition-colors duration-200">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <form id="bonsaiForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <input type="hidden" id="methodField" name="_method" value="POST">
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                {{-- Left Column --}}
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-tag mr-2 text-green-500"></i>Nama Bonsai
                                        </label>
                                        <input type="text" id="name" name="name" required 
                                            class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-barcode mr-2 text-green-500"></i>Kode Bonsai
                                        </label>
                                        <input type="text" id="code" name="code" required 
                                            placeholder="BNS-001"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-list mr-2 text-green-500"></i>Kategori
                                        </label>
                                        <select id="category_id" name="category_id" required 
                                                class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($categories ?? [] as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-dna mr-2 text-green-500"></i>Spesies
                                        </label>
                                        <input type="text" id="species" name="species" 
                                            placeholder="Contoh: Ficus Benjamina"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300">
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-calendar mr-2 text-green-500"></i>Umur (Tahun)
                                            </label>
                                            <input type="number" id="age_years" name="age_years" min="0" 
                                                class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-coins mr-2 text-green-500"></i>Nilai (Rp)
                                            </label>
                                            <input type="number" id="current_value" name="current_value" 
                                                class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300">
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-store mr-2 text-green-500"></i>Status Penjualan
                                            </label>
                                            <select id="status" name="status" required 
                                                    class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300">
                                                <option value="available">Tersedia</option>
                                                <option value="sold">Terjual</option>
                                                <option value="display">Pajangan</option>
                                                <option value="maintenance">Perawatan</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-heartbeat mr-2 text-green-500"></i>Kesehatan
                                            </label>
                                            <select id="health_status" name="health_status" required 
                                                    class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300">
                                                <option value="excellent">Sangat Baik</option>
                                                <option value="good">Baik</option>
                                                <option value="fair">Cukup Baik</option>
                                                <option value="poor">Kurang Baik</option>
                                                <option value="critical">Kritis</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Right Column --}}
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-image mr-2 text-green-500"></i>Gambar Bonsai
                                        </label>
                                        <div class="relative">
                                            <div id="imagePreviewContainer" class="mb-4 hidden">
                                                <img id="imagePreview" class="w-full h-48 object-cover rounded-2xl shadow-lg">
                                            </div>
                                            <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center hover:border-green-500 transition-colors duration-300" id="imageUploadArea">
                                                <div class="space-y-2">
                                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                                    <p class="text-gray-500">Klik untuk upload gambar atau drag & drop</p>
                                                    <p class="text-xs text-gray-400">PNG, JPG, GIF up to 2MB</p>
                                                </div>
                                                <input type="file" id="image_path" name="image_path" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-sticky-note mr-2 text-green-500"></i>Deskripsi
                                        </label>
                                        <textarea id="description" name="description" rows="4" 
                                                placeholder="Tambahkan deskripsi detail tentang bonsai..."
                                                class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-300 resize-none"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex space-x-4 pt-6">
                                <button type="button" onclick="closeModal()" 
                                        class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-2xl font-semibold hover:bg-gray-200 transition-colors duration-300">
                                    <i class="fas fa-times mr-2"></i>Batal
                                </button>
                                <button type="submit" 
                                        class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-2xl font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-save mr-2"></i>Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
    <script>
        // Wait for DOM to be ready
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('bonsaiModal');
            const modalTitle = document.getElementById('modalTitle');
            const bonsaiForm = document.getElementById('bonsaiForm');
            const methodField = document.getElementById('methodField');
            const modalContent = document.getElementById('modalContent');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');

            // Make functions globally available
            window.openModal = function() {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            window.closeModal = function() {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                
                setTimeout(() => {
                    modal.classList.add('hidden');
                    bonsaiForm.reset();
                    imagePreviewContainer.classList.add('hidden');
                }, 300);
            }

            window.openAddModal = function() {
                console.log('Opening add modal...');
                bonsaiForm.reset();
                modalTitle.innerText = 'Tambah Bonsai Baru';
                bonsaiForm.action = "{{ route('dashboard.manajemen.store') }}";
                methodField.value = "POST";
                imagePreviewContainer.classList.add('hidden');
                document.getElementById('image_path').required = true;
                openModal();
            }

            // Ganti fungsi openEditModal dengan yang ini:
            window.openEditModal = function(bonsai) {
                console.log('Opening edit modal...', bonsai);
                bonsaiForm.reset();
                modalTitle.innerText = 'Edit Data Bonsai';
                
                // Solusi 1: Gunakan base URL + path langsung
                bonsaiForm.action = `{{ url('dashboard/manajemen') }}/${bonsai.id}`;
                methodField.value = "PUT";

                // Populate form fields
                document.getElementById('name').value = bonsai.name || '';
                document.getElementById('code').value = bonsai.code || '';
                document.getElementById('category_id').value = bonsai.category_id || '';
                document.getElementById('species').value = bonsai.species || '';
                document.getElementById('age_years').value = bonsai.age_years || '';
                document.getElementById('current_value').value = bonsai.current_value || '';
                document.getElementById('status').value = bonsai.status || 'available';
                document.getElementById('health_status').value = bonsai.health_status || 'good';
                document.getElementById('description').value = bonsai.description || '';
                
                // Show existing image if available
                if(bonsai.image_path) {
                    imagePreview.src = `{{ asset('storage') }}/${bonsai.image_path}`;
                    imagePreviewContainer.classList.remove('hidden');
                } else {
                    imagePreviewContainer.classList.add('hidden');
                }
                
                // Image not required for edit
                document.getElementById('image_path').required = false;
                openModal();
            }

            // Debug function untuk testing
            window.debugEditModal = function(bonsai) {
                const baseUrl = '{{ url("dashboard/manajemen") }}';
                const fullUrl = `${baseUrl}/${bonsai.id}`;
                console.log('Base URL:', baseUrl);
                console.log('Bonsai ID:', bonsai.id);
                console.log('Full URL:', fullUrl);
            }

            // Image preview functionality
            document.getElementById('image_path').addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreviewContainer.classList.add('hidden');
                }
            });

            // Close modal when clicking outside
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
                if (e.ctrlKey && e.key === 'n') {
                    e.preventDefault();
                    openAddModal();
                }
            });

            

            // Form submission with loading state
            bonsaiForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
                
                // Re-enable after 3 seconds as fallback
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 3000);
            });

            console.log('Script loaded successfully');
        });

        // Helper functions for status classes (moved outside DOMContentLoaded for global access)
        function getStatusClass(status) {
            const classes = {
                'available': 'bg-green-100 text-green-800',
                'sold': 'bg-gray-100 text-gray-800',
                'display': 'bg-blue-100 text-blue-800',
                'maintenance': 'bg-yellow-100 text-yellow-800'
            };
            return classes[status] || 'bg-gray-100 text-gray-800';
        }

        function getStatusText(status) {
            const texts = {
                'available': 'Tersedia',
                'sold': 'Terjual',
                'display': 'Pajangan',
                'maintenance': 'Perawatan'
            };
            return texts[status] || status;
        }

        function getHealthClass(health) {
            const classes = {
                'excellent': 'bg-green-100 text-green-700',
                'good': 'bg-blue-100 text-blue-700',
                'fair': 'bg-yellow-100 text-yellow-700',
                'poor': 'bg-orange-100 text-orange-700',
                'critical': 'bg-red-100 text-red-700'
            };
            return classes[health] || 'bg-gray-100 text-gray-700';
        }

        function getHealthText(health) {
            const texts = {
                'excellent': '●●●●●',
                'good': '●●●●○',
                'fair': '●●●○○',
                'poor': '●●○○○',
                'critical': '●○○○○'
            };
            return texts[health] || health;
        }
    </script>

    @php
        // Helper functions that should be moved to a Helper class or added to the model
        function getStatusClass($status) {
            $classes = [
                'available' => 'bg-green-100 text-green-800',
                'sold' => 'bg-gray-100 text-gray-800',
                'display' => 'bg-blue-100 text-blue-800',
                'maintenance' => 'bg-yellow-100 text-yellow-800'
            ];
            return $classes[$status] ?? 'bg-gray-100 text-gray-800';
        }

        function getStatusText($status) {
            $texts = [
                'available' => 'Tersedia',
                'sold' => 'Terjual',
                'display' => 'Pajangan',
                'maintenance' => 'Perawatan'
            ];
            return $texts[$status] ?? $status;
        }

        function getHealthClass($health) {
            $classes = [
                'excellent' => 'bg-green-100 text-green-700',
                'good' => 'bg-blue-100 text-blue-700',
                'fair' => 'bg-yellow-100 text-yellow-700',
                'poor' => 'bg-orange-100 text-orange-700',
                'critical' => 'bg-red-100 text-red-700'
            ];
            return $classes[$health] ?? 'bg-gray-100 text-gray-700';
        }

        
        
    @endphp