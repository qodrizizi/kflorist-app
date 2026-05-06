<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BonsaiController;
use App\Http\Middleware\Role;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Verify (OTP)
Route::get('/verify', [AuthController::class, 'showVerifyForm'])->name('verify.form');
Route::post('/verify', [AuthController::class, 'verify'])->name('verify.submit');

// Google OAuth
Route::get('/auth-google-redirect', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');


use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Dashboard Routes (Admin Only)
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard')
    ->middleware([Role::class.':admin','auth'])
    ->group(function () {
        // Home - Overview
        Route::get('/', [DashboardController::class, 'home'])->name('dashboard.home');

        // Manajemen Bonsai
        Route::get('/manajemen', [BonsaiController::class, 'manajemen'])->name('dashboard.manajemen');
        Route::post('/manajemen', [BonsaiController::class, 'storeManajemen'])->name('dashboard.manajemen.store');
        Route::put('/manajemen/{bonsai}', [BonsaiController::class, 'updateManajemen'])->name('dashboard.manajemen.update');
        Route::delete('/manajemen/{bonsai}', [BonsaiController::class, 'destroyManajemen'])->name('dashboard.manajemen.destroy');

        // Kategori
        Route::get('/categories', [DashboardController::class, 'categories'])->name('dashboard.categories');
        Route::post('/categories', [DashboardController::class, 'storeCategory'])->name('dashboard.categories.store');
        Route::put('/categories/{category}', [DashboardController::class, 'updateCategory'])->name('dashboard.categories.update');
        Route::delete('/categories/{category}', [DashboardController::class, 'destroyCategory'])->name('dashboard.categories.destroy');

        // Pesanan
        Route::get('/orders', [DashboardController::class, 'orders'])->name('dashboard.orders');
        Route::put('/orders/{order}/status', [DashboardController::class, 'updateOrderStatus'])->name('dashboard.orders.updateStatus');

        // Perawatan
        Route::get('/perawatan', [BonsaiController::class, 'perawatan'])->name('dashboard.perawatan');
        Route::post('/perawatan', [BonsaiController::class, 'storePerawatan'])->name('dashboard.perawatan.store');
        Route::patch('/perawatan/{perawatan}/status', [BonsaiController::class, 'updateStatusPerawatan'])->name('dashboard.perawatan.status');
        Route::delete('/perawatan/{perawatan}', [BonsaiController::class, 'destroyPerawatan'])->name('dashboard.perawatan.destroy');

        // Keuangan
        Route::get('/keuangan', [BonsaiController::class, 'keuangan'])->name('dashboard.keuangan');

        // Laporan
        Route::get('/laporan', [BonsaiController::class, 'laporan'])->name('dashboard.laporan');

        // Profile
        Route::get('/profile', [BonsaiController::class, 'profile'])->name('dashboard.profile');
        Route::post('/profile', [BonsaiController::class, 'updateProfile'])->name('dashboard.profile.update');
        Route::post('/profile/password', [BonsaiController::class, 'updatePassword'])->name('dashboard.profile.password');

        // Chat
        Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('dashboard.chat.index');
        Route::get('/chat/{user}', [App\Http\Controllers\ChatController::class, 'show'])->name('dashboard.chat.show');
        Route::get('/chat/{user}/messages', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('dashboard.chat.messages');
        Route::get('/chat/unread-count', [App\Http\Controllers\ChatController::class, 'getAdminUnreadCount'])->name('dashboard.chat.unreadCount');
        Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('dashboard.chat.send');
        Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'getNotifications'])->name('dashboard.notifications');
    });
use App\Http\Controllers\ShopController;

/*
|--------------------------------------------------------------------------
| Shop Routes (Public)
|--------------------------------------------------------------------------
*/
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/produk', [ShopController::class, 'produk'])->name('shop.produk');
Route::get('/produk/{id}', [ShopController::class, 'show'])->name('shop.produk.show');
Route::get('/tentang', fn() => view('shop.tentang'))->name('shop.tentang');
Route::get('/kategori', fn() => view('shop.kategori'))->name('shop.kategori');

use App\Http\Controllers\CartController;

Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::get('/profil', [App\Http\Controllers\ProfileController::class, 'index'])->name('shop.profil');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('shop.profile');
    Route::put('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('shop.profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('shop.profile.password');
    Route::post('/profile/address', [App\Http\Controllers\ProfileController::class, 'storeAddress'])->name('shop.profile.address.store');
    Route::delete('/profile/address/{id}', [App\Http\Controllers\ProfileController::class, 'destroyAddress'])->name('shop.profile.address.destroy');
    Route::put('/profile/address/{id}/default', [App\Http\Controllers\ProfileController::class, 'setDefaultAddress'])->name('shop.profile.address.default');
    
    // Cart Routes
    Route::get('/keranjang', [CartController::class, 'index'])->name('shop.keranjang');
    Route::post('/keranjang', [CartController::class, 'store'])->name('shop.keranjang.store');
    Route::put('/keranjang/{cart}', [CartController::class, 'update'])->name('shop.keranjang.update');
    Route::delete('/keranjang/{cart}', [CartController::class, 'destroy'])->name('shop.keranjang.destroy');
    
    // Checkout Routes
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('shop.checkout');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('shop.checkout.process');
    
    // Pesanan Saya Routes
    Route::get('/pesanan', [App\Http\Controllers\PesananController::class, 'index'])->name('shop.pesanan');
    Route::get('/pesanan/{id}/bayar', [App\Http\Controllers\PesananController::class, 'pay'])->name('shop.pesanan.pay');
    Route::put('/pesanan/{id}/selesai', [App\Http\Controllers\PesananController::class, 'complete'])->name('shop.pesanan.complete');
    
    // Review Route
    Route::post('/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('shop.review.store');

    // Chat Route
    Route::get('/chat/messages', [App\Http\Controllers\ChatController::class, 'getUserMessages'])->name('shop.chat.messages');
    Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('shop.chat.send');
    Route::post('/chat/read', [App\Http\Controllers\ChatController::class, 'markAsRead'])->name('shop.chat.markRead');
});

// Midtrans Callback (Public)
Route::post('/midtrans/callback', [App\Http\Controllers\MidtransController::class, 'callback']);


/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    // jika user login sebagai admin -> dashboard.profile
    if(Auth::check() && Auth::user()->role === 'admin'){
        return redirect()->route('dashboard.profile');
    }

    // jika user login sebagai user -> shop.profile
    if(Auth::check() && Auth::user()->role === 'user'){
        return redirect()->route('shop.profile');
    }

    // pengunjung biasa -> landing page
    return redirect()->route('login');
});
