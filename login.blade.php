<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Toko Shopping</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(3deg); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .animate-float-delayed {
            animation: float 8s ease-in-out infinite 2s;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-800 via-emerald-600 to-teal-900 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Elemen Animasi Lingkaran Latar Belakang -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500 rounded-full mix-blend-multiply filter blur-2xl opacity-40 animate-float"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-teal-400 rounded-full mix-blend-multiply filter blur-2xl opacity-40 animate-float-delayed"></div>

    <!-- Kotak Form Login -->
    <div class="relative bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-8 w-full max-w-md border border-emerald-100 transform transition-all duration-500 hover:scale-[1.01]">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-emerald-800">Toko<span class="text-teal-600">Shopping</span></h1>
            <p class="text-sm text-gray-500 mt-2">Silakan masuk ke panel admin toko</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email Admin</label>
                <input type="email" name="email" value="admin@tokoshopping.com" required 
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition bg-gray-50/50">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" value="admin123" required 
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition bg-gray-50/50">
            </div>
            <button type="submit" 
                class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-600/30 transition-all transform active:scale-95">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('shop.index') }}" class="text-sm text-emerald-700 hover:underline font-medium">
                &larr; Kembali ke Beranda Toko
            </a>
        </div>
    </div>

</body>
</html>