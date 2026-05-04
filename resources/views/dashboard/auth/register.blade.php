<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Khadir Florist - Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
            font-family: 'Inter', sans-serif;
        }
        .register-card {
            background-color: white;
            border-radius: 1.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        .register-card:hover {
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
        }
        .input-field {
            border: 1px solid #e2e8f0;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .input-field:focus {
            outline: none;
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
        }
        .btn-primary {
            background-color: #059669;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #047857;
            transform: translateY(-2px);
        }
        .btn-google {
            border: 1px solid #d1d5db;
            color: #4b5563;
            transition: background-color 0.3s ease;
        }
        .btn-google:hover {
            background-color: #f3f4f6;
        }
        .text-link {
            color: #059669;
            transition: color 0.3s ease;
        }
        .text-link:hover {
            color: #047857;
            text-decoration: underline;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md p-8 sm:p-10 register-card">
        
        <div class="text-center mb-8">
            <div class="text-4xl mb-2">🌿</div>
            <h1 class="text-3xl font-extrabold text-gray-900">Buat Akun Baru</h1>
            <p class="text-gray-500 mt-2">Daftar untuk mulai mengelola bonsai digital Anda</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" id="name" required autocomplete="name"
                       class="input-field w-full px-4 py-2 rounded-lg"
                       placeholder="Masukkan nama lengkap Anda">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" required autocomplete="email"
                       class="input-field w-full px-4 py-2 rounded-lg"
                       placeholder="Masukkan alamat email Anda">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" required autocomplete="new-password"
                       class="input-field w-full px-4 py-2 rounded-lg"
                       placeholder="Buat password Anda">
            </div>
            <button type="submit" 
                    class="btn-primary w-full text-white py-2.5 rounded-lg font-semibold shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-green-300">
                Buat Akun
            </button>
        </form>

        <div class="relative flex items-center justify-center my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative bg-white px-4 text-sm text-gray-500">
                Atau
            </div>
        </div>

        <a href="{{ route('auth.google') }}"
           class="btn-google w-full flex items-center justify-center space-x-2 px-4 py-2.5 rounded-lg font-semibold shadow-sm focus:outline-none focus:ring-4 focus:ring-gray-200">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
            <span>Daftar dengan Google</span>
        </a>

        <div class="text-center mt-8">
            <p class="text-sm text-gray-600">Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-link font-semibold">Login Sekarang</a>
            </p>
        </div>

    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.querySelector('.btn-primary');
            btn.innerHTML = '<span class="animate-pulse">Memuat...</span>';
            btn.disabled = true;
            btn.style.opacity = '0.7';
        });
    </script>
</body>
</html>
