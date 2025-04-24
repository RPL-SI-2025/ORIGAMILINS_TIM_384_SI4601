<?php

namespace Database\Factories;

use App\Models\ProductReview;
use App\Models\User;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductReviewFactory extends Factory
{
    protected $model = ProductReview::class;

    public function definition()
    {
        return [
            'produk_id' => Produk::factory(),
            'user_id' => User::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'komentar' => $this->faker->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
} 