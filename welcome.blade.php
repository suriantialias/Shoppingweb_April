<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Shopping - Belanja Mudah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-indigo-600">Toko<span class="text-gray-900">Shopping</span></a>
            <div class="flex items-center gap-4">
    <a href="{{ route('login') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-full font-semibold text-sm transition shadow-sm">
        🔒 Login Admin
    </a>
    <div class="relative bg-indigo-50 text-indigo-700 px-4 py-2 rounded-full font-semibold text-sm">
        🛒 Keranjang ({{ count($cart) }})
    </div>
</div>
        </div>
    </nav>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Hero Banner -->
    <header class="bg-indigo-600 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-extrabold mb-3">Koleksi Produk Terbaik Minggu Ini</h1>
            <p class="text-indigo-100 max-w-xl mx-auto">Temukan berbagai kebutuhan harian dan gaya hidup dengan harga terbaik langsung dari toko kami.</p>
        </div>
    </header>

    <!-- Main Content: Katalog & Ringkasan Keranjang -->
    <main class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Daftar Produk (3 Kolom) -->
        <div class="lg:col-span-3">
            <h2 class="text-xl font-bold mb-6">Katalog Produk</h2>
            
            @if($products->isEmpty())
                <div class="bg-white p-8 rounded-xl shadow-sm text-center text-gray-500">
                    Belum ada produk. Silakan tambahkan melalui <a href="{{ route('dashboard') }}" class="text-indigo-600 underline">Dashboard Admin</a>.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 flex flex-col justify-between">
                            <div>
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2 py-1 rounded">
                                        {{ $product->category }}
                                    </span>
                                    <h3 class="font-bold text-lg mt-2">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $product->description }}</p>
                                </div>
                            </div>
                            <div class="p-4 pt-0">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-lg font-extrabold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <span class="text-xs text-gray-500">Stok: {{ $product->stock }}</span>
                                </div>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" {{ $product->stock < 1 ? 'disabled' : '' }}
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-300 text-white font-semibold py-2 rounded-lg transition">
                                        {{ $product->stock < 1 ? 'Stok Habis' : '+ Tambah Keranjang' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Sidebar Keranjang Belanja (1 Kolom) -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 sticky top-24">
                <h3 class="font-bold text-lg border-b pb-3 mb-4">Ringkasan Belanja</h3>
                
                @if(empty($cart))
                    <p class="text-sm text-gray-400 text-center py-6">Keranjang masih kosong.</p>
                @else
                    <ul class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                            @php $total += $item['price'] * $item['quantity']; @endphp
                            <li class="flex justify-between text-sm">
                                <div>
                                    <p class="font-semibold">{{ $item['name'] }}</p>
                                    <p class="text-gray-500">{{ $item['quantity'] }}x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                                <span class="font-bold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="border-t pt-3 flex justify-between font-bold text-base mb-4">
                        <span>Total</span>
                        <span class="text-indigo-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <form action="{{ route('shop.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-lg transition">
                            Checkout Sekarang
                        </button>
                    </form>
                @endif
            </div>
        </div>

    </main>
</body>
</html>