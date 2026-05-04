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

        // Keuangan
        Route::get('/keuangan', [BonsaiController::class, 'keuangan'])->name('dashboard.keuangan');

        // Laporan
        Route::get('/laporan', [BonsaiController::class, 'laporan'])->name('dashboard.laporan');

        // Profile
        Route::get('/profile', [BonsaiController::class, 'profile'])->name('dashboard.profile');
    });


/*
|--------------------------------------------------------------------------
| Shop Routes (User Only)
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('shop.index'))->name('shop.index');
Route::get('/produk', fn() => view('shop.produk'))->name('shop.produk');
Route::get('/tentang', fn() => view('shop.tentang'))->name('shop.tentang');
Route::get('/kategori', fn() => view('shop.kategori'))->name('shop.kategori');

Route::middleware(['auth'])->group(function () {
    Route::get('/profil', fn() => view('shop.profil'))->name('shop.profil');
    Route::get('/keranjang', fn() => view('shop.keranjang'))->name('shop.keranjang');
    Route::get('/profile', fn() => view('shop.profile'))->name('shop.profile');
});


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
