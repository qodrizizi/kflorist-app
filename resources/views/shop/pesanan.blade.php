@extends('layouts.shop')

@section('content')
<section class="py-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 md:px-8 max-w-5xl">
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Pesanan Saya</h1>
            <p class="text-sm md:text-base text-gray-500">Lacak dan kelola pesanan bonsai Anda</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-emerald-500 p-4 rounded-r-xl">
                <span class="text-emerald-800 font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                <span class="text-red-800 font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <!-- Tabs Navigation -->
            <div class="flex overflow-x-auto border-b border-gray-200 hide-scroll snap-x">
                <button onclick="switchTab('pending')" id="tab-pending" class="tab-btn snap-start flex-1 min-w-[110px] md:min-w-[140px] py-4 text-xs md:text-sm font-bold text-center border-b-2 border-emerald-500 text-emerald-600 transition-colors whitespace-nowrap">
                    Belum Bayar <span class="bg-emerald-100 text-emerald-600 px-1.5 md:px-2 py-0.5 rounded-full text-[10px] md:text-xs ml-1">{{ $pending->count() }}</span>
                </button>
                <button onclick="switchTab('processing')" id="tab-processing" class="tab-btn snap-start flex-1 min-w-[110px] md:min-w-[140px] py-4 text-xs md:text-sm font-bold text-center border-b-2 border-transparent text-gray-500 hover:text-emerald-600 transition-colors whitespace-nowrap">
                    Diproses <span class="bg-gray-100 text-gray-600 px-1.5 md:px-2 py-0.5 rounded-full text-[10px] md:text-xs ml-1">{{ $processing->count() }}</span>
                </button>
                <button onclick="switchTab('shipping')" id="tab-shipping" class="tab-btn snap-start flex-1 min-w-[110px] md:min-w-[140px] py-4 text-xs md:text-sm font-bold text-center border-b-2 border-transparent text-gray-500 hover:text-emerald-600 transition-colors whitespace-nowrap">
                    Dikirim <span class="bg-gray-100 text-gray-600 px-1.5 md:px-2 py-0.5 rounded-full text-[10px] md:text-xs ml-1">{{ $shipping->count() }}</span>
                </button>
                <button onclick="switchTab('completed')" id="tab-completed" class="tab-btn snap-start flex-1 min-w-[110px] md:min-w-[140px] py-4 text-xs md:text-sm font-bold text-center border-b-2 border-transparent text-gray-500 hover:text-emerald-600 transition-colors whitespace-nowrap">
                    Selesai <span class="bg-gray-100 text-gray-600 px-1.5 md:px-2 py-0.5 rounded-full text-[10px] md:text-xs ml-1">{{ $completed->count() }}</span>
                </button>
            </div>

            <!-- Tab Contents -->
            <div class="p-4 md:p-6 bg-gray-50/50">
                
                <!-- Tab: Pending -->
                <div id="content-pending" class="tab-content space-y-6">
                    @forelse($pending as $order)
                        @include('shop.components.order-card', ['order' => $order, 'badgeClass' => 'bg-orange-100 text-orange-700'])
                    @empty
                        <div class="text-center py-12">
                            <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Tidak ada pesanan menunggu pembayaran.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Tab: Processing -->
                <div id="content-processing" class="tab-content hidden space-y-6">
                    @forelse($processing as $order)
                        @include('shop.components.order-card', ['order' => $order, 'badgeClass' => 'bg-blue-100 text-blue-700'])
                    @empty
                        <div class="text-center py-12">
                            <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Tidak ada pesanan yang sedang diproses.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Tab: Shipping -->
                <div id="content-shipping" class="tab-content hidden space-y-6">
                    @forelse($shipping as $order)
                        @include('shop.components.order-card', ['order' => $order, 'badgeClass' => 'bg-purple-100 text-purple-700', 'showAction' => true])
                    @empty
                        <div class="text-center py-12">
                            <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Tidak ada pesanan yang sedang dikirim.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Tab: Completed -->
                <div id="content-completed" class="tab-content hidden space-y-6">
                    @forelse($completed as $order)
                        @include('shop.components.order-card', ['order' => $order, 'badgeClass' => 'bg-emerald-100 text-emerald-700'])
                    @empty
                        <div class="text-center py-12">
                            <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Belum ada pesanan yang selesai.</p>
                        </div>
                    @endforelse
                </div>

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
        // Reset all buttons
        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('border-emerald-500', 'text-emerald-600');
            el.classList.add('border-transparent', 'text-gray-500');
            // reset badge
            let badge = el.querySelector('span');
            if(badge) {
                badge.classList.remove('bg-emerald-100', 'text-emerald-600');
                badge.classList.add('bg-gray-100', 'text-gray-600');
            }
        });

        // Show selected content
        document.getElementById('content-' + tabId).classList.remove('hidden');
        // Highlight selected button
        const activeBtn = document.getElementById('tab-' + tabId);
        if(activeBtn) {
            activeBtn.classList.remove('border-transparent', 'text-gray-500');
            activeBtn.classList.add('border-emerald-500', 'text-emerald-600');
            // highlight badge
            let activeBadge = activeBtn.querySelector('span');
            if(activeBadge) {
                activeBadge.classList.remove('bg-gray-100', 'text-gray-600');
                activeBadge.classList.add('bg-emerald-100', 'text-emerald-600');
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
