<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Produk::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->word,
            'deskripsi' => $this->faker->paragraph,
            'harga' => $this->faker->randomFloat(2, 10000, 1000000),
            'kategori' => $this->faker->randomElement(['Dekorasi', 'Aksesoris', 'Lainnya']),
            'gambar' => $this->faker->imageUrl(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
} 