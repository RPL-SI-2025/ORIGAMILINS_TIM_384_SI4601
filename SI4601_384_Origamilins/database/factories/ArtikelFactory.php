<?php

namespace Database\Factories;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

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

    public function configure()
    {
        return $this->afterCreating(function (Artikel $artikel) {
            Storage::disk('public')->exists(str_replace('storage/', '', $artikel->gambar));
        });
    }
}