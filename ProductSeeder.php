<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Sepatu Sneakers Casual',
                'category' => 'Fashion',
                'description' => 'Sepatu nyaman untuk aktivitas sehari-hari dengan bahan premium.',
                'price' => 299000,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jam Tangan Minimalis',
                'category' => 'Aksesoris',
                'description' => 'Jam tangan elegan tahan air dengan tali kulit asli.',
                'price' => 450000,
                'stock' => 8,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tas Ransel Laptop',
                'category' => 'Tas',
                'description' => 'Tas ransel muat laptop 15.6 inch dilengkapi port USB charger.',
                'price' => 210000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Headphone Bluetooth',
                'category' => 'Elektronik',
                'description' => 'Suara jernih bass mantap dengan fitur active noise cancellation.',
                'price' => 650000,
                'stock' => 10,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}