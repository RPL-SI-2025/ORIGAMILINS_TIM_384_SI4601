<?php

namespace Database\Factories;

use App\Models\Pesanan;
use App\Models\User;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesananFactory extends Factory
{
    protected $model = Pesanan::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'produk_id' => Produk::factory(),
            'jumlah' => $this->faker->numberBetween(1, 5),
            'total_harga' => $this->faker->randomFloat(2, 10000, 1000000),
            'status' => 'Rencana',
            'ekspedisi' => $this->faker->randomElement(['JNE', 'J&T', 'SiCepat', 'Pos Indonesia']),
            'alamat_pengiriman' => $this->faker->address,
            'nomor_telepon' => $this->faker->phoneNumber,
            'tanggal_pesanan' => now(),
            'created_at' => now(),
            'updated_at' => now()
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