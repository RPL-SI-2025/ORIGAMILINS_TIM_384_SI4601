<?php

namespace Database\Factories;

use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesananFactory extends Factory
{
    protected $model = Pesanan::class;

    public function definition()
    {
        return [
            'nama_pemesan' => $this->faker->name,
            'nama_produk' => $this->faker->word,
            'status' => $this->faker->randomElement(['Diproses', 'Dikirim', 'Selesai', 'Dibatalkan']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function diproses()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'Diproses',
            ];
        });
    }

    public function dikirim()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'Dikirim',
            ];
        });
    }

    public function selesai()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'Selesai',
            ];
        });
    }

    public function dibatalkan()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'Dibatalkan',
            ];
        });
    }
} 