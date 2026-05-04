<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Khadir Florist Dashboard - Verifikasi OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #0f766e 0%, #059669 25%, #10b981 50%, #34d399 100%);
            background-attachment: fixed;
            position: relative;
            overflow: auto;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1),
                        inset 0 1px 0 rgba(255, 255, 255, 0.6);
        }
        .logo-section {
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(5, 150, 105, 0.3);
        }
        .input-field {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(16, 185, 129, 0.2);
            transition: all 0.3s ease;
            padding: 0.5rem;
        }
        .input-field:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            background: rgba(255, 255, 255, 1);
        }
        .login-btn {
            background: linear-gradient(135deg, #059669, #10b981, #34d399);
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
            transition: all 0.3s ease;
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(5, 150, 105, 0.4);
        }
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .error-message {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border: 1px solid #fca5a5;
            color: #dc2626;
        }
        .welcome-text {
            background: linear-gradient(135deg, #059669, #34d399);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md md:max-w-xl login-container p-6 rounded-3xl relative">
        
        <div class="logo-section">
            <div class="text-4xl mb-2">🔐</div>
            <h1 class="text-xl font-bold mb-1">Khaidir Florist</h1>
            <p class="text-green-100 text-xs">Verifikasi Akun</p>
        </div>

        <div class="text-center mb-4">
            <h2 class="text-xl font-bold welcome-text mb-1">Masukkan Kode OTP 📩</h2>
            <p class="text-gray-600 text-sm">Kode verifikasi sudah dikirim ke email kamu</p>
        </div>

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="mb-4 p-3 rounded-lg text-sm flex items-center space-x-2 bg-green-100 text-green-700">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Pesan error --}}
        @if($errors->any())
            <div class="error-message mb-4 p-3 rounded-lg text-sm flex items-center space-x-2">
                <span>⚠️</span>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('verify.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">🔑 Kode OTP</label>
                <input type="text" name="code" required
                       class="input-field w-full px-4 py-2 rounded-lg focus:outline-none"
                       placeholder="Masukkan kode OTP">
            </div>

            <button type="submit" class="login-btn w-full text-white py-2 px-6 rounded-lg font-semibold flex items-center justify-center space-x-2 focus:outline-none">
                <span>✅</span>
                <span>Verifikasi</span>
            </button>
        </form>
    </div>

</body>
</html>
