<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    // Tampilan Awal E-Commerce
    public function index()
    {
        $products = Product::latest()->get();
        $cart = session()->get('cart', []);
        return view('welcome', compact('products', 'cart'));
    }

    // Tambah ke Keranjang (Session)
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk masuk keranjang!');
    }

    // Proses Checkout Sederhana (Simpan ke tabel orders & order_items)
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->back();

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        DB::transaction(function () use ($cart, $total) {
            // Ubah 'total_price' dan 'status' jika tabel orders kamu memakai nama kolom lain
            // Atau sesuaikan dengan file migrasi orders milikmu
            $orderId = DB::table('orders')->insertGetId([
                'total_price' => $total, 
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($cart as $id => $details) {
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                Product::where('id', $id)->decrement('stock', $details['quantity']);
            }
        });

        session()->forget('cart');
        return redirect()->back()->with('success', 'Pesanan berhasil dibuat!');
    }

    // Tampilan Dashboard Admin
    public function dashboard()
    {
        $products = Product::latest()->get();
        $totalProducts = $products->count();
        $totalOrders = DB::table('orders')->count();
        $totalRevenue = DB::table('orders')->sum('total_price'); // Sesuaikan jika nama kolom berbeda

        return view('dashboard', compact('products', 'totalProducts', 'totalOrders', 'totalRevenue'));
    }

    // Simpan Produk Baru dari Dashboard
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        Product::create([
            'name' => $request->name,
            'category' => $request->category ?? 'Umum',
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $request->image ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500'
        ]);

        return redirect()->route('dashboard')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Hapus Produk
    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('dashboard')->with('success', 'Produk dihapus!');
    }
}