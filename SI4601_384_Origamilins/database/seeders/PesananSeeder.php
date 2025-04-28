<?php

namespace Database\Seeders;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::table('pesanan')->truncate();

        // Get all products
        $produk = Produk::all();
        $users = User::all();
        
        // Get expedition options
        $ekspedisiOptions = ['JNE', 'J&T', 'SiCepat', 'Pos Indonesia'];

        // Create 20 dummy orders
        for ($i = 0; $i < 20; $i++) {
            $randomProduct = $produk->random();
            $randomUser = $users->random();
            $jumlah = rand(1, 5);
            $status = ['Rencana', 'Dalam Proses', 'Siap Dikirim', 'Dikirim', 'Selesai', 'Dibatalkan'][array_rand(['Rencana', 'Dalam Proses', 'Siap Dikirim', 'Dikirim', 'Selesai', 'Dibatalkan'])];
            $randomEkspedisi = $ekspedisiOptions[array_rand($ekspedisiOptions)];
            $createdAt = now()->subDays(rand(0, 30))->addHours(rand(0, 23))->addMinutes(rand(0, 59));

            Pesanan::create([
                'user_id' => $randomUser->id,
                'produk_id' => $randomProduct->id,
                'jumlah' => $jumlah,
                'total_harga' => $randomProduct->harga * $jumlah,
                'status' => $status,
                'ekspedisi' => $randomEkspedisi,
                'alamat_pengiriman' => 'Jl. Contoh No. ' . rand(1, 100),
                'nomor_telepon' => '08' . rand(1000000000, 9999999999),
                'tanggal_pesanan' => $createdAt,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
