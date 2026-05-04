<div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
    <div class="flex justify-between items-center mb-4 border-b border-gray-50 pb-4">
        <div class="flex items-center gap-3">
            <span class="font-mono text-sm font-bold text-gray-700 bg-gray-100 px-3 py-1 rounded-lg">
                <i class="fas fa-receipt text-gray-400 mr-2"></i>{{ $order->order_code }}
            </span>
            <span class="text-xs text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</span>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $badgeClass }}">
            {{ $order->status }}
        </span>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 mb-4">
        <div class="w-full sm:w-20 sm:h-20 md:w-24 md:h-24 aspect-video sm:aspect-square shrink-0 bg-emerald-50 rounded-xl overflow-hidden">
            @if($order->bonsai->image_path)
                <img src="{{ asset('storage/' . $order->bonsai->image_path) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <i class="fas fa-seedling text-3xl text-emerald-300"></i>
                </div>
            @endif
        </div>

        <div class="flex-grow">
            <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $order->bonsai->name }}</h3>
            <p class="text-sm text-gray-500 mb-2">{{ $order->quantity }} Barang x Rp {{ number_format($order->bonsai->current_value, 0, ',', '.') }}</p>
            @if($order->catatan)
                <p class="text-xs text-gray-500 italic bg-gray-50 p-2 rounded-md border-l-2 border-gray-200">
                    Catatan: {{ $order->catatan }}
                </p>
            @endif
        </div>

        <div class="sm:text-right border-t sm:border-t-0 sm:border-l border-gray-100 pt-4 sm:pt-0 sm:pl-6 flex flex-col justify-center">
            <p class="text-sm text-gray-500 mb-1">Total Belanja</p>
            <p class="text-xl font-black text-emerald-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="border-t border-gray-100 pt-4 flex flex-col sm:flex-row sm:flex-wrap sm:justify-end gap-3 mt-4">
        
        @if($order->status === 'pending')
            <a href="{{ route('shop.pesanan.pay', $order->id) }}" class="w-full sm:w-auto justify-center bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white px-6 py-2.5 sm:py-2 rounded-lg font-bold shadow-sm hover:shadow-md transition-all text-sm flex items-center">
                <i class="fas fa-wallet mr-2"></i> Bayar Sekarang
            </a>
        @endif

        @if(in_array($order->status, ['diproses', 'dikirim']))
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20BonsaiKu,%20saya%20ingin%20bertanya%20tentang%20pesanan%20{{ $order->order_code }}" target="_blank" class="w-full sm:w-auto justify-center bg-white border-2 border-green-500 text-green-600 hover:bg-green-50 px-5 py-2.5 sm:py-2 rounded-lg font-bold shadow-sm hover:shadow-md transition-all text-sm flex items-center">
                <i class="fab fa-whatsapp text-lg mr-2"></i> Chat Penjual
            </a>
        @endif

        @if($order->status === 'dikirim')
            <button onclick="lacakPengiriman('{{ $order->order_code }}')" class="w-full sm:w-auto justify-center bg-blue-500 hover:bg-blue-600 text-white px-5 py-2.5 sm:py-2 rounded-lg font-bold shadow-sm hover:shadow-md transition-all text-sm flex items-center">
                <i class="fas fa-truck mr-2"></i> Lacak Pengiriman
            </button>
            <form action="{{ route('shop.pesanan.complete', $order->id) }}" method="POST" class="inline-block w-full sm:w-auto">
                @csrf
                @method('PUT')
                <button type="submit" class="w-full justify-center bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2.5 sm:py-2 rounded-lg font-bold shadow-sm hover:shadow-md transition-all text-sm flex items-center">
                    <i class="fas fa-box-open mr-2"></i> Pesanan Diterima
                </button>
            </form>
        @endif

        @if($order->status === 'selesai')
            @php
                $userReview = $order->bonsai->reviews->first();
            @endphp

            @if($userReview)
                @php
                    $reviewData = [
                        "rating" => $userReview->rating,
                        "comment" => $userReview->comment,
                        "image" => $userReview->image_path ? asset("storage/" . $userReview->image_path) : null,
                        "date" => $userReview->created_at->format("d M Y")
                    ];
                @endphp
                <button onclick='lihatReview(@json($reviewData), "{{ $order->bonsai->name }}")' class="w-full sm:w-auto justify-center bg-emerald-100 text-emerald-700 px-6 py-2.5 sm:py-2 rounded-lg font-bold shadow-sm hover:bg-emerald-200 transition-all text-sm flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> Sudah Dinilai
                </button>
            @else
                <button onclick="beriRating('{{ $order->bonsai_id }}', '{{ $order->bonsai->name }}')" class="w-full sm:w-auto justify-center bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-2.5 sm:py-2 rounded-lg font-bold shadow-sm hover:shadow-md transition-all text-sm flex items-center">
                    <i class="fas fa-star mr-2 text-yellow-100"></i> Beri Penilaian
                </button>
            @endif
        @endif

    </div>
</div>
