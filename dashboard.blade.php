<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Toko Shopping</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between p-6">
        <div>
            <h1 class="text-2xl font-bold text-indigo-400 mb-8">Admin<span class="text-white">Panel</span></h1>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="block bg-indigo-600 px-4 py-2.5 rounded-lg font-medium">📦 Manajemen Produk</a>
                <a href="{{ route('shop.index') }}" class="block text-slate-300 hover:bg-slate-800 px-4 py-2.5 rounded-lg font-medium">🛍️ Lihat Toko Depan</a>
            </nav>
        </div>
        <div class="text-xs text-slate-400">
            &copy; 2026 Toko Shopping
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Dashboard Toko</h2>
            <span class="text-sm text-gray-500">Halo, Admin!</span>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Kartu Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Total Produk</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalProducts }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Total Pesanan</p>
                <p class="text-3xl font-extrabold text-indigo-600 mt-1">{{ $totalOrders }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Total Pendapatan</p>
                <p class="text-3xl font-extrabold text-emerald-600 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Tambah Produk -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-fit">
                <h3 class="font-bold text-lg mb-4">Tambah Produk Baru</h3>
                <form action="{{ route('product.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Produk</label>
                        <input type="text" name="name" required class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="Contoh: Sepatu Sneakers">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Kategori</label>
                        <input type="text" name="category" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="Contoh: Fashion">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
                            <input type="number" name="price" required class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="150000">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Stok</label>
                            <input type="number" name="stock" required class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="10">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">URL Gambar (Opsional)</label>
                        <input type="url" name="image" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="https://...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Deskripsi</label>
                        <textarea name="description" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg transition">
                        + Simpan Produk
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Produk -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-lg mb-4">Daftar Produk</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="border-b text-gray-500">
                                <th class="py-3">Produk</th>
                                <th class="py-3">Kategori</th>
                                <th class="py-3">Harga</th>
                                <th class="py-3">Stok</th>
                                <th class="py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($products as $product)
                                <tr>
                                    <td class="py-3 font-medium flex items-center gap-3">
                                        <img src="{{ $product->image }}" class="w-10 h-10 rounded object-cover">
                                        {{ $product->name }}
                                    </td>
                                    <td class="py-3">{{ $product->category }}</td>
                                    <td class="py-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="py-3">{{ $product->stock }}</td>
                                    <td class="py-3 text-right">
                                        <form action="{{ route('product.delete', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-400">Belum ada data produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

</body>
</html>