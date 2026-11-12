<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

// Halaman Awal (Toko)
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::post('/cart/add/{id}', [ShopController::class, 'addToCart'])->name('cart.add');
Route::post('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');

// Halaman Dashboard Admin
Route::get('/dashboard', [ShopController::class, 'dashboard'])->name('dashboard');
Route::post('/dashboard/product', [ShopController::class, 'storeProduct'])->name('product.store');
Route::delete('/dashboard/product/{id}', [ShopController::class, 'deleteProduct'])->name('product.delete');

// Halaman Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    // Simulasi login sederhana (bisa dikembangkan pakai Auth bawaan Laravel)
    if($request->email == 'admin@tokoshopping.com' && $request->password == 'admin123') {
        return redirect()->route('dashboard')->with('success', 'Berhasil login!');
    }
    return back()->with('error', 'Email atau password salah!');
})->name('login.submit');