<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // 🔹 Tampilkan form register
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin' 
                ? redirect()->route('dashboard.home') 
                : redirect()->route('shop.index');
        }

        return view('dashboard.auth.register');
    }

    // 🔹 Proses register
    public function register(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6' . ($request->filled('password_confirmation') ? '|confirmed' : ''),
        ];

        $request->validate($rules);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'verification_code' => Str::random(6), // OTP
        ]);

        // kirim OTP
        Mail::to($user->email)->send(new \App\Mail\VerifyEmail($user));

        return redirect()->route('verify.form')->with('success', 'Kode OTP sudah dikirim ke email kamu. Silakan verifikasi.');
    }
   

    // 🔹 Tampilkan form login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin' 
                ? redirect()->route('dashboard.home') 
                : redirect()->route('shop.index');
        }

        return view('dashboard.auth.login');
    }

    // 🔹 Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // cek apakah user sudah verifikasi email
            if (is_null($user->email_verified_at)) {
                Auth::logout();
                return redirect()->route('verify.form')->withErrors([
                    'otp' => 'Akun belum diverifikasi, silakan cek email Anda.',
                ]);
            }

            // redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('dashboard.home'); // admin ke dashboard
            } else {
                return redirect()->route('shop.index'); // user biasa ke shop
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }


    // 🔹 Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout, silakan login kembali.');
    }

    // 🔹 Form verifikasi OTP
    public function showVerifyForm()
    {
        return view('dashboard.auth.verify');
    }

    // 🔹 Proses verifikasi OTP
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = User::where('verification_code', $request->code)->first();

        if (!$user) {
            return back()->withErrors(['code' => 'Kode OTP tidak valid.']);
        }

        // update data user
        $user->email_verified_at = now();
        $user->verification_code = null; // hapus OTP biar gak bisa dipakai lagi
        $user->save();

        // login user setelah verifikasi
        Auth::login($user);

        // redirect ke dashboard
        // redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.home');
        } else {
            return redirect()->route('shop.index');
        }
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // buat user baru
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'user',
                    'verification_code' => Str::random(6), // OTP wajib
                ]);

                // kirim OTP ke email
                Mail::to($user->email)->send(new \App\Mail\VerifyEmail($user));

                return redirect()->route('verify.form')->with('success', 'Kode OTP sudah dikirim ke email. Silakan verifikasi.');
            }

            // jika user sudah ada
            if (is_null($user->email_verified_at)) {
                // kirim ulang OTP
                $user->verification_code = Str::random(6);
                $user->save();
                Mail::to($user->email)->send(new \App\Mail\VerifyEmail($user));

                return redirect()->route('verify.form')->with('success', 'Akun belum diverifikasi, kode OTP dikirim ulang ke email.');
            }

            // user sudah verified, login langsung
            Auth::login($user);

            if ($user->role === 'admin') {
                return redirect()->route('dashboard.home');
            } else {
                return redirect()->route('shop.index');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['oauth' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }


}
