@extends('layouts.shop')

@section('content')
<section class="py-16 bg-gradient-to-br from-green-50 via-white to-emerald-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-bold text-gray-800 mb-4">🌿 Koleksi Bonsai Premium</h2>
            <p class="text-xl text-gray-600 mb-8">Temukan bonsai berkualitas tinggi untuk mempercantik rumah Anda</p>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-green-100">
                    <div class="text-3xl font-bold text-green-600">500+</div>
                    <div class="text-gray-600">Produk Tersedia</div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-green-100">
                    <div class="text-3xl font-bold text-green-600">1000+</div>
                    <div class="text-gray-600">Customer Puas</div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-green-100">
                    <div class="text-3xl font-bold text-green-600">98%</div>
                    <div class="text-gray-600">Rating Positif</div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-green-100">
                    <div class="text-3xl font-bold text-green-600">24/7</div>
                    <div class="text-gray-600">Support</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-xl p-8 mb-12 border border-gray-100">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Bonsai</label>
                    <div class="relative">
                        <input type="text" id="search-input" placeholder="Cari nama, jenis, atau gaya..."
                               class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                        <button class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-green-500 text-white p-2 rounded-xl hover:bg-green-600 transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                        <select id="category-filter" class="w-full border-2 border-gray-200 rounded-2xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="all">Semua Kategori</option>
                            <option value="indoor">🏠 Indoor</option>
                            <option value="outdoor">🌳 Outdoor</option>
                            <option value="premium">⭐ Premium</option>
                            <option value="bibit">🌱 Bibit</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Harga</label>
                        <select id="price-filter" class="w-full border-2 border-gray-200 rounded-2xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="all">Semua Harga</option>
                            <option value="low">Rp 0 - Rp 500rb</option>
                            <option value="medium">Rp 500rb - Rp 1jt</option>
                            <option value="high"> > Rp 1jt</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan</label>
                        <select id="sort-by" class="w-full border-2 border-gray-200 rounded-2xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="default">🆕 Terbaru</option>
                            <option value="popular">🔥 Terpopuler</option>
                            <option value="price-asc">💰 Termurah</option>
                            <option value="price-desc">💎 Termahal</option>
                            <option value="rating-desc">⭐ Rating Tertinggi</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex flex-wrap gap-3">
                    <span class="text-sm font-semibold text-gray-700 mr-4">Filter Cepat:</span>
                    <button data-filter="bestseller" class="quick-filter-btn px-4 py-2 bg-gray-100 text-gray-800 rounded-full text-sm hover:bg-gray-200 transition-colors">🏆 Best Seller</button>
                    <button data-filter="beginner" class="quick-filter-btn px-4 py-2 bg-gray-100 text-gray-800 rounded-full text-sm hover:bg-gray-200 transition-colors">🎯 Cocok Pemula</button>
                    <button data-filter="premium" class="quick-filter-btn px-4 py-2 bg-gray-100 text-gray-800 rounded-full text-sm hover:bg-gray-200 transition-colors">💎 Premium Quality</button>
                    <button data-filter="ready" class="quick-filter-btn px-4 py-2 bg-gray-100 text-gray-800 rounded-full text-sm hover:bg-gray-200 transition-colors">⚡ Ready Stock</button>
                    <button data-filter="discount" class="quick-filter-btn px-4 py-2 bg-gray-100 text-gray-800 rounded-full text-sm hover:bg-gray-200 transition-colors">🔥 Diskon</button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="product-grid">
            </div>

        <div class="text-center mt-16">
            <button id="load-more-btn" class="bg-white border-2 border-green-500 text-green-600 px-8 py-4 rounded-2xl hover:bg-green-500 hover:text-white transition-all font-semibold shadow-lg">
                <i class="fas fa-plus mr-2"></i>Lihat Produk Lainnya
            </button>
        </div>

        <div class="mt-12 flex justify-center">
            <nav class="flex items-center space-x-2">
                <button class="px-4 py-3 rounded-xl text-gray-500 bg-white shadow-md hover:bg-gray-50 border border-gray-200 transition-colors">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="px-5 py-3 rounded-xl text-white bg-gradient-to-r from-green-500 to-green-600 shadow-lg font-semibold">1</button>
                <button class="px-5 py-3 rounded-xl text-gray-700 bg-white shadow-md hover:bg-gray-50 border border-gray-200 transition-colors">2</button>
                <button class="px-5 py-3 rounded-xl text-gray-700 bg-white shadow-md hover:bg-gray-50 border border-gray-200 transition-colors">3</button>
                <button class="px-4 py-3 rounded-xl text-gray-500 bg-white shadow-md hover:bg-gray-50 border border-gray-200 transition-colors">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </nav>
        </div>

        <div class="mt-20 bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
            <h3 class="text-2xl font-bold text-center text-gray-800 mb-8">Mengapa Memilih Kami?</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shipping-fast text-2xl text-green-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Pengiriman Aman</h4>
                    <p class="text-sm text-gray-600">Kemasan khusus untuk menjaga keamanan bonsai selama pengiriman</p>
                </div>

                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-2xl text-blue-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Garansi Hidup</h4>
                    <p class="text-sm text-gray-600">Garansi hidup 30 hari dengan panduan perawatan lengkap</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-2xl text-purple-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Support 24/7</h4>
                    <p class="text-sm text-gray-600">Tim ahli siap membantu masalah perawatan bonsai kapan saja</p>
                </div>

                <div class="text-center">
                    <div class="bg-orange-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-certificate text-2xl text-orange-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Kualitas Terjamin</h4>
                    <p class="text-sm text-gray-600">Bonsai berkualitas tinggi dengan sertifikat keaslian</p>
                </div>
            </div>
        </div>

        <div class="mt-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-3xl p-8 text-white text-center">
            <h3 class="text-2xl font-bold mb-4">Dapatkan Tips Perawatan Bonsai!</h3>
            <p class="mb-6 opacity-90">Berlangganan newsletter kami dan dapatkan tips eksklusif dari ahli bonsai</p>
            <div class="max-w-md mx-auto flex gap-3">
                <input type="email" id="newsletter-email" placeholder="Masukkan email Anda..."
                       class="flex-1 px-4 py-3 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-white">
                <button id="subscribe-btn" class="bg-white text-green-600 px-6 py-3 rounded-xl font-semibold hover:bg-gray-100 transition-colors">
                    Berlangganan
                </button>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // --- DUMMY DATA BONSAI ---
        const bonsaiProducts = [
            {
                id: 1,
                name: "Bonsai Ficus Microcarpa Premium",
                type: "Ficus Microcarpa",
                description: "Bonsai indoor yang mudah perawatan, cocok untuk pemula. Tinggi 25cm dengan pot keramik eksklusif.",
                image: "/images/bgtentang.png",
                category: "indoor",
                badges: ["indoor", "bestseller", "discount"],
                price: 297500,
                originalPrice: 350000,
                rating: 4.8,
                reviews: 127,
                specs: [
                    { icon: "fas fa-ruler", text: "25cm" },
                    { icon: "fas fa-seedling", text: "3 tahun" },
                    { icon: "fas fa-home", text: "Indoor" },
                    { icon: "fas fa-tint", text: "2-3x/minggu" }
                ]
            },
            {
                id: 2,
                name: "Bonsai Serut Gaya Tegak Lurus",
                type: "Serut Premium",
                description: "Bonsai outdoor premium dengan bentuk yang sangat indah. Cocok untuk taman atau halaman rumah.",
                image: "/images/bghero.png",
                category: "outdoor",
                badges: ["outdoor", "premium", "ready"],
                price: 780000,
                originalPrice: 780000,
                rating: 4.7,
                reviews: 89,
                specs: [
                    { icon: "fas fa-ruler", text: "40cm" },
                    { icon: "fas fa-seedling", text: "5 tahun" },
                    { icon: "fas fa-sun", text: "Outdoor" },
                    { icon: "fas fa-tint", text: "1x/hari" }
                ]
            },
            {
                id: 3,
                name: "Bonsai Azalea Satsuki Premium",
                type: "Azalea Satsuki",
                description: "Bonsai berbunga yang sangat langka dengan keindahan bunga yang memukau. Koleksi eksklusif.",
                image: "/images/c.jpg",
                category: "premium",
                badges: ["premium", "limited"],
                price: 1250000,
                originalPrice: 1250000,
                rating: 5.0,
                reviews: 23,
                specs: [
                    { icon: "fas fa-ruler", text: "35cm" },
                    { icon: "fas fa-seedling", text: "8 tahun" },
                    { icon: "fas fa-flower", text: "Berbunga" },
                    { icon: "fas fa-certificate", text: "Sertifikat" }
                ]
            },
            {
                id: 4,
                name: "Bibit Bonsai Kawista Batu",
                type: "Kawista Batu",
                description: "Bibit berkualitas tinggi untuk memulai hobi bonsai. Termasuk panduan lengkap perawatan.",
                image: "https://via.placeholder.com/400x300.png?text=Bibit+Bonsai+Kawista",
                category: "bibit",
                badges: ["bibit", "beginner", "ready"],
                price: 85000,
                originalPrice: 85000,
                rating: 3.2,
                reviews: 45,
                specs: [
                    { icon: "fas fa-ruler", text: "15cm" },
                    { icon: "fas fa-seedling", text: "1 tahun" },
                    { icon: "fas fa-book", text: "+ Panduan" },
                    { icon: "fas fa-tools", text: "+ Kit tools" }
                ]
            },
            {
                id: 5,
                name: "Bonsai Sianci Variegata",
                type: "Sianci Variegata",
                description: "Bonsai indoor dengan daun variegata yang unik dan indah. Perfect untuk dekorasi ruangan.",
                image: "https://via.placeholder.com/400x300.png?text=Bonsai+Sianci",
                category: "indoor",
                badges: ["indoor", "toprated", "ready"],
                price: 480000,
                originalPrice: 480000,
                rating: 5.0,
                reviews: 67,
                specs: [
                    { icon: "fas fa-ruler", text: "30cm" },
                    { icon: "fas fa-seedling", text: "4 tahun" },
                    { icon: "fas fa-home", text: "Indoor" },
                    { icon: "fas fa-palette", text: "Variegata" }
                ]
            },
            {
                id: 6,
                name: "Bonsai Cemara Udang",
                type: "Cemara Udang",
                description: "Bonsai outdoor dengan bentuk unik seperti udang. Sangat cocok untuk taman minimalis.",
                image: "https://via.placeholder.com/400x300.png?text=Bonsai+Cemara",
                category: "outdoor",
                badges: ["outdoor", "popular", "ready"],
                price: 650000,
                originalPrice: 650000,
                rating: 3.8,
                reviews: 134,
                specs: [
                    { icon: "fas fa-ruler", text: "35cm" },
                    { icon: "fas fa-seedling", text: "6 tahun" },
                    { icon: "fas fa-sun", text: "Outdoor" },
                    { icon: "fas fa-leaf", text: "Evergreen" }
                ]
            },
        ];

        // --- HELPER FUNCTIONS ---
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        };

        const getStarRating = (rating) => {
            const fullStars = Math.floor(rating);
            const halfStar = rating % 1 >= 0.5;
            let starsHtml = '';
            for (let i = 0; i < fullStars; i++) {
                starsHtml += '<i class="fas fa-star"></i>';
            }
            if (halfStar) {
                starsHtml += '<i class="fas fa-star-half-alt"></i>';
            }
            const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
            for (let i = 0; i < emptyStars; i++) {
                starsHtml += '<i class="far fa-star"></i>';
            }
            return starsHtml;
        };

        const getBadgeHtml = (badges) => {
            const badgeMap = {
                "indoor": { text: "🏠 Indoor", class: "bg-green-500 text-white" },
                "outdoor": { text: "🌳 Outdoor", class: "bg-blue-500 text-white" },
                "bestseller": { text: "🏆 Best Seller", class: "bg-red-500 text-white animate-pulse" },
                "premium": { text: "💎 Premium", class: "bg-purple-500 text-white" },
                "limited": { text: "LIMITED EDITION", class: "bg-gradient-to-r from-yellow-400 to-orange-500 text-white" },
                "beginner": { text: "🎯 Pemula", class: "bg-blue-500 text-white" },
                "ready": { text: "⚡ Ready Stock", class: "text-green-600 font-semibold text-xs" },
                "toprated": { text: "⭐ Top Rated", class: "bg-yellow-500 text-white" },
                "popular": { text: "🔥 Populer", class: "bg-blue-500 text-white" },
                "discount": { text: `DISKON ${Math.round((1 - (297500 / 350000)) * 100)}%`, class: "bg-gradient-to-r from-orange-400 to-red-500 text-white" },
            };
            return badges.map(badge => {
                const badgeInfo = badgeMap[badge];
                if (badgeInfo.text.includes('Ready')) {
                    return `<span class="${badgeInfo.class}">${badgeInfo.text}</span>`;
                }
                return `<span class="${badgeInfo.class} px-3 py-1 rounded-full text-xs font-bold">${badgeInfo.text}</span>`;
            }).join('');
        };

        const getSpecHtml = (specs) => {
            return specs.map(spec => `
                <div class="flex items-center"><i class="${spec.icon} text-gray-400 mr-1"></i> ${spec.text}</div>
            `).join('');
        };
        
        // --- RENDER PRODUCTS DYNAMICALLY ---
        const productGrid = document.getElementById('product-grid');

        const renderProducts = (products) => {
            productGrid.innerHTML = '';
            products.forEach(product => {
                const productHtml = `
                    <div class="product-card group bg-white rounded-3xl shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 border border-gray-100" data-id="${product.id}" data-category="${product.category}" data-price="${product.price}" data-rating="${product.rating}" data-badges="${product.badges.join(' ')}">
                        <div class="relative overflow-hidden">
                            <img src="${product.image}" alt="${product.name}" class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-110">

                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                ${getBadgeHtml(product.badges.filter(b => !b.includes('ready') && !b.includes('discount')))}
                            </div>

                            <div class="absolute top-4 right-4 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <button class="wishlist-btn bg-white text-gray-500 p-2 rounded-full shadow-lg hover:bg-red-50 hover:text-red-500 transition-colors">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="quick-view-btn bg-white text-blue-500 p-2 rounded-full shadow-lg hover:bg-blue-50 transition-colors">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            
                            ${product.originalPrice > product.price ? `
                                <div class="absolute bottom-4 left-4">
                                    <span class="bg-gradient-to-r from-orange-400 to-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">DISKON ${Math.round((1 - (product.price / product.originalPrice)) * 100)}%</span>
                                </div>` : ''}
                        </div>

                        <div class="p-6">
                            <div class="mb-3">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-bold text-green-600 bg-green-100 px-2 py-1 rounded-lg">${product.type}</span>
                                    ${getBadgeHtml(product.badges.filter(b => b.includes('ready')))}
                                </div>
                                <h4 class="text-lg font-bold text-gray-800 leading-tight mb-2">${product.name}</h4>
                                <p class="text-sm text-gray-600 mb-3">${product.description}</p>
                            </div>

                            <div class="mb-4 p-3 bg-gray-50 rounded-xl">
                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    ${getSpecHtml(product.specs)}
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <span class="text-lg font-bold text-gray-800">${formatRupiah(product.price)}</span>
                                        ${product.originalPrice > product.price ? `
                                            <span class="text-sm text-gray-400 line-through ml-2">${formatRupiah(product.originalPrice)}</span>` : ''}
                                    </div>
                                    ${product.originalPrice > product.price ? `
                                        <span class="text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full font-bold">Hemat ${Math.round((1 - (product.price / product.originalPrice)) * 100)}%</span>` : ''}
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="text-yellow-400 text-sm mr-2">
                                            ${getStarRating(product.rating)}
                                        </div>
                                        <span class="text-xs text-gray-600">(${product.rating}) • ${product.reviews} ulasan</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button class="add-to-cart-btn flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl hover:from-green-600 hover:to-green-700 transition-all font-semibold" data-id="${product.id}">
                                    <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                                </button>
                                <button class="add-to-cart-plus bg-gray-100 text-gray-600 p-3 rounded-xl hover:bg-gray-200 transition-colors" data-id="${product.id}">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                productGrid.innerHTML += productHtml;
            });
            // Re-apply event listeners after rendering
            addEventListenersToProducts();
        };

        const addEventListenersToProducts = () => {
            const products = document.querySelectorAll('.product-card');

            // Quick view functionality
            const quickViewButtons = document.querySelectorAll('.quick-view-btn');
            quickViewButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productCard = this.closest('.product-card');
                    const productId = parseInt(productCard.dataset.id);
                    const product = bonsaiProducts.find(p => p.id === productId);
                    showQuickView(product);
                });
            });

            // Wishlist toggle
            const wishlistButtons = document.querySelectorAll('.wishlist-btn');
            wishlistButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const heart = this.querySelector('.fa-heart');
                    const isLiked = heart.classList.contains('fas');
                    heart.classList.toggle('fas');
                    heart.classList.toggle('far');
                    if (!isLiked) {
                        this.style.color = '#ef4444';
                        heart.style.animation = 'heartBeat 0.8s ease-in-out';
                        showNotification('Ditambahkan ke wishlist!', 'success');
                    } else {
                        this.style.color = '#6b7280';
                        heart.style.animation = 'shake 0.5s ease-in-out';
                        showNotification('Dihapus dari wishlist!', 'info');
                    }
                    setTimeout(() => { heart.style.animation = ''; }, 800);
                });
            });
            
            // Add to cart animation
            const addToCartButtons = document.querySelectorAll('.add-to-cart-btn, .add-to-cart-plus');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const buttonRect = this.getBoundingClientRect();
                    const icon = document.createElement('i');
                    icon.className = 'fas fa-shopping-cart';
                    icon.style.cssText = `
                        position: fixed;
                        top: ${buttonRect.top + buttonRect.height/2}px;
                        left: ${buttonRect.left + buttonRect.width/2}px;
                        color: #22c55e;
                        font-size: 24px;
                        z-index: 1000;
                        pointer-events: none;
                        animation: floatToCart 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
                        transform: translate(-50%, -50%);
                    `;
                    document.body.appendChild(icon);
                    setTimeout(() => {
                        if (icon.parentNode) {
                            icon.remove();
                        }
                    }, 1200);
                    showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');
                });
            });

            // Page load animations
            const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'slideInUp 0.6s ease-out forwards';
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            products.forEach(product => {
                product.style.opacity = '0';
                product.style.transform = 'translateY(30px)';
                observer.observe(product);
            });
        };

        // --- FILTER & SORTING LOGIC ---
        const searchInput = document.getElementById('search-input');
        const categoryFilter = document.getElementById('category-filter');
        const priceFilter = document.getElementById('price-filter');
        const sortBy = document.getElementById('sort-by');
        const quickFilters = document.querySelectorAll('.quick-filter-btn');

        const applyFiltersAndSort = () => {
            let filteredProducts = [...bonsaiProducts];

            // Search Filter
            const searchTerm = searchInput.value.toLowerCase();
            if (searchTerm) {
                filteredProducts = filteredProducts.filter(p => 
                    p.name.toLowerCase().includes(searchTerm) || 
                    p.description.toLowerCase().includes(searchTerm) ||
                    p.type.toLowerCase().includes(searchTerm)
                );
            }

            // Category Filter
            const selectedCategory = categoryFilter.value;
            if (selectedCategory !== 'all') {
                filteredProducts = filteredProducts.filter(p => p.category === selectedCategory);
            }
            
            // Price Filter
            const selectedPrice = priceFilter.value;
            if (selectedPrice !== 'all') {
                filteredProducts = filteredProducts.filter(p => {
                    if (selectedPrice === 'low') return p.price <= 500000;
                    if (selectedPrice === 'medium') return p.price > 500000 && p.price <= 1000000;
                    if (selectedPrice === 'high') return p.price > 1000000;
                });
            }

            // Quick Filters
            const activeQuickFilter = document.querySelector('.quick-filter-btn.bg-green-500');
            if (activeQuickFilter) {
                const filterType = activeQuickFilter.dataset.filter;
                if (filterType === 'bestseller') {
                    filteredProducts = filteredProducts.filter(p => p.badges.includes('bestseller'));
                } else if (filterType === 'beginner') {
                    filteredProducts = filteredProducts.filter(p => p.badges.includes('beginner'));
                } else if (filterType === 'premium') {
                    filteredProducts = filteredProducts.filter(p => p.badges.includes('premium') || p.badges.includes('limited') || p.badges.includes('toprated'));
                } else if (filterType === 'ready') {
                    filteredProducts = filteredProducts.filter(p => p.badges.includes('ready'));
                } else if (filterType === 'discount') {
                    filteredProducts = filteredProducts.filter(p => p.originalPrice > p.price);
                }
            }
            
            // Sorting
            const sortMethod = sortBy.value;
            if (sortMethod === 'price-asc') {
                filteredProducts.sort((a, b) => a.price - b.price);
            } else if (sortMethod === 'price-desc') {
                filteredProducts.sort((a, b) => b.price - a.price);
            } else if (sortMethod === 'rating-desc') {
                filteredProducts.sort((a, b) => b.rating - a.rating);
            } else if (sortMethod === 'popular') {
                filteredProducts.sort((a, b) => b.reviews - a.reviews);
            }
            
            renderProducts(filteredProducts);
        };

        searchInput.addEventListener('input', applyFiltersAndSort);
        categoryFilter.addEventListener('change', applyFiltersAndSort);
        priceFilter.addEventListener('change', applyFiltersAndSort);
        sortBy.addEventListener('change', applyFiltersAndSort);

        quickFilters.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const isActive = this.classList.contains('bg-green-500');
                quickFilters.forEach(btn => {
                    btn.classList.remove('bg-green-500', 'text-white');
                    btn.classList.add('bg-gray-100', 'text-gray-800');
                });
                if (!isActive) {
                    this.classList.add('bg-green-500', 'text-white');
                    this.classList.remove('bg-gray-100', 'text-gray-800');
                }
                applyFiltersAndSort();
            });
        });

        // --- UTILITY FUNCTIONS ---
        function showNotification(message, type = 'info') {
            const existingNotifications = document.querySelectorAll('.notification-toast');
            existingNotifications.forEach(notif => notif.remove());

            const notification = document.createElement('div');
            notification.className = `notification-toast fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg border-l-4 max-w-sm transform translate-x-full transition-transform duration-300 ease-in-out`;

            const colors = { success: 'bg-white border-green-500 text-green-800', error: 'bg-white border-red-500 text-red-800', info: 'bg-white border-blue-500 text-blue-800' };
            const icons = { success: 'fas fa-check-circle text-green-500', error: 'fas fa-exclamation-circle text-red-500', info: 'fas fa-info-circle text-blue-500' };

            notification.className += ` ${colors[type]}`;
            notification.innerHTML = `<div class="flex items-center"><i class="${icons[type]} mr-3"></i><span class="font-medium">${message}</span><button class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button></div>`;
            document.body.appendChild(notification);
            setTimeout(() => { notification.style.transform = 'translateX(0)'; }, 100);
            setTimeout(() => { notification.style.transform = 'translateX(full)'; setTimeout(() => { if (notification.parentNode) notification.remove(); }, 300); }, 4000);
        }

        function showQuickView(product) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-2xl max-w-md w-full p-6 transform scale-95 transition-transform duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Preview Produk</h3>
                        <button class="text-gray-400 hover:text-gray-600 text-xl" onclick="this.closest('.fixed').remove()"><i class="fas fa-times"></i></button>
                    </div>
                    <img src="${product.image}" alt="${product.name}" class="w-full h-48 object-cover rounded-xl mb-4">
                    <h4 class="text-lg font-bold text-gray-800 mb-2">${product.name}</h4>
                    <p class="text-xl font-bold text-green-600 mb-4">${formatRupiah(product.price)}</p>
                    <p class="text-sm text-gray-600 mb-4">${product.description}</p>
                    <div class="flex gap-3">
                        <button class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all add-to-cart-btn" data-id="${product.id}">
                            <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                        </button>
                        <button class="bg-gray-100 text-gray-600 px-4 py-3 rounded-xl hover:bg-gray-200 transition-colors wishlist-btn" data-id="${product.id}">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            setTimeout(() => { modal.querySelector('div').style.transform = 'scale(1)'; }, 10);
            modal.addEventListener('click', function(e) { if (e.target === modal) modal.remove(); });
            // Re-apply event listeners for buttons in the modal
            modal.querySelector('.add-to-cart-btn').addEventListener('click', function() {
                // Add to cart logic for modal
                showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');
                modal.remove();
            });
            modal.querySelector('.wishlist-btn').addEventListener('click', function() {
                // Wishlist logic for modal
                showNotification('Ditambahkan ke wishlist!', 'success');
            });
        }

        function validateEmail(email) { const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; return emailRegex.test(email); }

        // Initial render
        renderProducts(bonsaiProducts);

        // Newsletter signup
        const newsletterEmail = document.getElementById('newsletter-email');
        const subscribeBtn = document.getElementById('subscribe-btn');
        if (subscribeBtn) {
            subscribeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const email = newsletterEmail.value.trim();
                if (email && validateEmail(email)) {
                    showNotification('Terima kasih! Anda berhasil berlangganan newsletter.', 'success');
                    newsletterEmail.value = '';
                } else {
                    showNotification('Mohon masukkan alamat email yang valid.', 'error');
                }
            });
        }

        // CSS Keyframes
        if (!document.getElementById('bonsai-shop-styles')) {
            const style = document.createElement('style');
            style.id = 'bonsai-shop-styles';
            style.textContent = `
                @keyframes floatToCart {
                    0% { transform: translate(-50%, -50%) scale(1) rotate(0deg); opacity: 1; }
                    50% { transform: translate(-50%, -100px) scale(1.2) rotate(180deg); opacity: 0.8; }
                    100% { transform: translate(-50%, -250px) scale(0.3) rotate(360deg); opacity: 0; }
                }
                @keyframes slideInUp {
                    from { opacity: 0; transform: translateY(30px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                @keyframes heartBeat {
                    0%, 100% { transform: scale(1); }
                    25% { transform: scale(1.1); }
                    50% { transform: scale(1.3); }
                    75% { transform: scale(1.1); }
                }
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    25% { transform: translateX(-5px); }
                    75% { transform: translateX(5px); }
                }
            `;
            document.head.appendChild(style);
        }

        console.log('🌿 Bonsai Shop Enhanced - Script loaded successfully!');
    });
</script>
@endsection