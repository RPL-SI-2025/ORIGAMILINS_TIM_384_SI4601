<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->word,
            'deskripsi' => $this->faker->paragraph,
            'harga' => $this->faker->randomFloat(2, 10000, 1000000),
            'kategori' => $this->faker->randomElement(['Dekorasi', 'Merchandise']),
            'ukuran' => '5 x 5 cm,10 x 10 cm,15 x 15 cm,20 x 20 cm',
            'gambar' => $this->faker->imageUrl(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
