<?php

namespace Database\Factories;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtikelFactory extends Factory
{
    protected $model = Artikel::class;

    public function definition()
    {
        return [
            'judul' => $this->faker->sentence,
            'isi' => $this->faker->paragraphs(3, true),
            'tanggal_publikasi' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'gambar' => 'uploads/artikel/default.jpg'
        ];
    }
} 