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
            'nama_produk' => $this->faker->word,
            'harga_dasar' => $this->faker->numberBetween(50000, 500000),
            'kategori' => $this->faker->randomElement(['Merchandise', 'Dekorasi']),
            'ukuran' => '5 x 5,10 x 10,15 x 15',
            'deskripsi' => $this->faker->paragraph,
            'harga' => $this->faker->numberBetween(100000, 1000000),
            'gambar' => $this->faker->imageUrl(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
