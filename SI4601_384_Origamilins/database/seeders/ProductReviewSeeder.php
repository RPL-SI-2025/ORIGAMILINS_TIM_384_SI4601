<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\User;
use App\Models\ProductReview;
use Illuminate\Database\Seeder;

class ProductReviewSeeder extends Seeder
{
    public function run()
    {
        // Pastikan ada produk dan user
        $produks = Produk::all();
        $users = User::where('role', '!=', 'admin')->get();

        if ($produks->isEmpty() || $users->isEmpty()) {
            return;
        }

        foreach ($produks as $produk) {
            $reviewCount = rand(3, 5);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                ProductReview::create([
                    'produk_id' => $produk->id,
                    'user_id' => $users->random()->id,
                    'rating' => rand(3, 5), // Rating antara 3-5 bintang
                    'komentar' => fake()->realText(100),
                    'created_at' => now()->subDays(rand(1, 30)), // Review dalam 30 hari terakhir
                ]);
            }
        }
    }
} 