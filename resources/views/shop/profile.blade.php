@extends('layouts.shop')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<section class="py-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 md:px-8 max-w-6xl">
        
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Profil Saya</h1>
            <p class="text-sm md:text-base text-gray-500">Kelola informasi pribadi, alamat, dan keamanan akun Anda</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm">
                <span class="text-emerald-800 font-medium"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                <ul class="list-disc list-inside text-red-800 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar / Profil Card -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 text-center sticky top-28">
                    @php
                        $initial = strtoupper(substr($user->name, 0, 1));
                    @endphp
                    
                    <div class="relative w-32 h-32 mx-auto mb-6 group cursor-pointer" onclick="document.getElementById('profile_photo_input').click()">
                        @if($user->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover shadow-lg ring-4 ring-emerald-50">
                        @else
                            <div class="w-32 h-32 bg-gradient-to-br from-emerald-400 to-green-600 rounded-full flex items-center justify-center text-white text-5xl font-black shadow-lg ring-4 ring-emerald-50">
                                {{ $initial }}
                            </div>
                        @endif
                        <!-- Hover overlay for photo edit -->
                        <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-camera text-xl mb-1"></i>
                            <span class="text-xs font-semibold">Ubah Foto</span>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-500 mb-6">{{ $user->email }}</p>
                    
                    <div class="border-t border-gray-100 pt-6 mt-2 text-left">
                        <div class="mb-4">
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Bergabung Sejak</p>
                            <p class="text-gray-700 font-medium"><i class="far fa-calendar-alt mr-2 text-emerald-500"></i>{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Status Akun</p>
                            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold"><i class="fas fa-check-circle mr-1"></i> Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulir & Data -->
            <div class="w-full lg:w-2/3 space-y-8">
                
                <!-- Edit Data Diri -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="border-b border-gray-100 px-8 py-6 bg-gray-50/50">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-user-edit text-emerald-500 mr-3"></i> Informasi Pribadi
                        </h3>
                    </div>
                    <div class="p-8">
                        <form action="{{ route('shop.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Hidden input for photo upload triggered by clicking avatar -->
                            <input type="file" name="profile_photo" id="profile_photo_input" class="hidden" accept="image/*" onchange="this.form.submit()">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon / WhatsApp</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-3 rounded-xl font-bold shadow-sm hover:shadow-md transition-all flex items-center">
                                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Manajemen Alamat -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="border-b border-gray-100 px-8 py-6 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-map-marked-alt text-emerald-500 mr-3"></i> Alamat Pengiriman
                        </h3>
                        <button type="button" onclick="openAddressModal()" class="text-sm bg-emerald-100 text-emerald-700 hover:bg-emerald-200 px-4 py-2 rounded-lg font-bold transition-colors">
                            <i class="fas fa-plus mr-1"></i> Tambah Alamat
                        </button>
                    </div>
                    <div class="p-8">
                        @if($addresses->count() > 0)
                            <div class="space-y-4">
                                @foreach($addresses as $address)
                                    <div class="border {{ $address->is_default ? 'border-emerald-500 bg-emerald-50/30' : 'border-gray-200' }} rounded-2xl p-5 relative transition-all hover:shadow-md">
                                        @if($address->is_default)
                                            <span class="absolute top-0 right-0 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-bl-xl rounded-tr-xl">
                                                Alamat Utama
                                            </span>
                                        @endif
                                        
                                        <div class="flex flex-col md:flex-row justify-between gap-4">
                                            <div>
                                                <div class="flex items-center gap-2 mb-2">
                                                    <h4 class="font-bold text-gray-800">{{ $address->recipient_name }}</h4>
                                                    <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-md">{{ $address->title }}</span>
                                                </div>
                                                <p class="text-sm text-gray-600 mb-1"><i class="fas fa-phone text-gray-400 mr-2"></i>{{ $address->phone }}</p>
                                                <p class="text-sm text-gray-600 mb-1"><i class="fas fa-map-marker-alt text-gray-400 mr-2 w-3"></i>{{ $address->address_line }}</p>
                                                <p class="text-sm text-gray-600 ml-5">{{ $address->district }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                                            </div>
                                            
                                            <div class="flex flex-row md:flex-col justify-end gap-2 text-right">
                                                @if(!$address->is_default)
                                                    <form action="{{ route('shop.profile.address.default', $address->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="text-xs font-semibold text-emerald-600 hover:text-emerald-800 border border-emerald-200 hover:bg-emerald-50 px-3 py-1.5 rounded-lg transition-colors w-full">
                                                            Jadikan Utama
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('shop.profile.address.destroy', $address->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus alamat ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-700 border border-red-100 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-colors w-full">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <h4 class="text-gray-500 font-medium mb-2">Belum ada alamat tersimpan</h4>
                                <p class="text-sm text-gray-400 mb-4">Tambahkan alamat untuk mempermudah proses checkout pesanan Anda.</p>
                                <button type="button" onclick="openAddressModal()" class="text-sm bg-emerald-500 text-white hover:bg-emerald-600 px-6 py-2 rounded-lg font-bold transition-colors">
                                    Tambah Alamat Sekarang
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Ubah Password -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="border-b border-gray-100 px-8 py-6 bg-gray-50/50">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-lock text-emerald-500 mr-3"></i> Ubah Password
                        </h3>
                    </div>
                    <div class="p-8">
                        <form action="{{ route('shop.profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="space-y-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini <span class="text-red-500">*</span></label>
                                    <input type="password" name="current_password" required placeholder="Masukkan password Anda saat ini" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                                    <input type="password" name="password_confirmation" required placeholder="Ketik ulang password baru" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-8 py-3 rounded-xl font-bold shadow-sm hover:shadow-md transition-all flex items-center">
                                    <i class="fas fa-key mr-2"></i> Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah Alamat -->
<div id="addressModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-3xl max-h-[90vh] flex flex-col shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0" id="addressModalContent">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">Tambah Alamat Baru</h3>
            <button type="button" onclick="closeAddressModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto flex-grow">
            <form id="addressForm" action="{{ route('shop.profile.address.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Label Alamat <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required placeholder="Contoh: Rumah, Kantor, Kosan" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima <span class="text-red-500">*</span></label>
                        <input type="text" name="recipient_name" required value="{{ $user->name }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" required value="{{ $user->phone }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi <span class="text-red-500">*</span></label>
                        <input type="text" name="province" required placeholder="Contoh: Jawa Barat" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten <span class="text-red-500">*</span></label>
                        <input type="text" name="city" required placeholder="Contoh: Bandung" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                        <input type="text" name="district" required placeholder="Contoh: Coblong" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos <span class="text-red-500">*</span></label>
                        <input type="text" name="postal_code" required placeholder="Contoh: 40132" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="address_line" required rows="3" placeholder="Nama jalan, gedung, RT/RW, nomor rumah..." class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-gray-700">Tandai Lokasi di Peta (Opsional)</label>
                            <button type="button" onclick="searchLocation()" class="text-xs bg-blue-100 text-blue-600 hover:bg-blue-200 px-3 py-1 rounded-lg font-bold transition-colors">
                                <i class="fas fa-search-location mr-1"></i> Sesuaikan Map dengan Alamat
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mb-2">Geser pin merah ke lokasi persis alamat Anda untuk memudahkan kurir.</p>
                        <div id="map" class="h-64 rounded-xl border border-gray-300 z-10"></div>
                        <input type="hidden" name="latitude" id="lat">
                        <input type="hidden" name="longitude" id="lng">
                    </div>

                    <div class="md:col-span-2 mt-2">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" name="is_default" value="1" class="form-checkbox h-5 w-5 text-emerald-500 rounded border-gray-300 focus:ring-emerald-500">
                            <span class="text-gray-700 font-medium text-sm">Jadikan sebagai alamat utama</span>
                        </label>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 rounded-b-3xl">
            <button type="button" onclick="closeAddressModal()" class="px-6 py-2.5 rounded-xl font-bold text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <button type="button" onclick="document.getElementById('addressForm').submit()" class="px-6 py-2.5 rounded-xl font-bold text-white bg-emerald-500 hover:bg-emerald-600 shadow-sm transition-colors">
                Simpan Alamat
            </button>
        </div>
    </div>
</div>

<script>
    let map;
    let marker;

    function initMap() {
        if (!map) {
            // Default center (Indonesia)
            const defaultLoc = [-0.789275, 113.921327];
            
            map = L.map('map').setView(defaultLoc, 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            marker = L.marker(defaultLoc, {draggable: true}).addTo(map);

            // Get user location if available
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const userLoc = [lat, lng];
                    
                    map.setView(userLoc, 15);
                    marker.setLatLng(userLoc);
                    updateInputCoords(lat, lng);
                }, function() {
                    console.log("Geolocation rejected");
                });
            }

            marker.on('dragend', function(e) {
                const pos = marker.getLatLng();
                updateInputCoords(pos.lat, pos.lng);
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateInputCoords(e.latlng.lat, e.latlng.lng);
            });
        }
    }

    async function searchLocation() {
        const address = document.querySelector('textarea[name="address_line"]').value;
        const district = document.querySelector('input[name="district"]').value;
        const city = document.querySelector('input[name="city"]').value;
        const province = document.querySelector('input[name="province"]').value;
        
        if (!city || !province) {
            Swal.fire({
                icon: 'warning',
                title: 'Info Belum Lengkap',
                text: 'Silakan isi Provinsi dan Kota terlebih dahulu.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            return;
        }

        const query = `${address} ${district} ${city} ${province} Indonesia`;
        
        // Show loading toast
        const loadingToast = Swal.fire({
            title: 'Mencari lokasi...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            Swal.close();

            if (data && data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lon = parseFloat(data[0].lon);
                
                map.setView([lat, lon], 16);
                marker.setLatLng([lat, lon]);
                updateInputCoords(lat, lon);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Lokasi ditemukan!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lokasi tidak ditemukan',
                    text: 'Coba masukkan alamat yang lebih spesifik atau geser pin secara manual.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        } catch (error) {
            Swal.close();
            console.error('Error fetching location:', error);
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Sistem',
                text: 'Gagal menghubungi layanan peta.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }
    }

    function updateInputCoords(lat, lng) {
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
    }

    function openAddressModal() {
        const modal = document.getElementById('addressModal');
        const content = document.getElementById('addressModalContent');
        
        modal.classList.remove('hidden');
        // Small delay to allow display:block to apply before animating opacity/transform
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
            
            // Map needs to invalidate size after modal becomes visible
            if(!map) initMap();
            setTimeout(() => { map.invalidateSize(); }, 300);
        }, 10);
    }

    function closeAddressModal() {
        const modal = document.getElementById('addressModal');
        const content = document.getElementById('addressModalContent');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection