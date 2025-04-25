<?php

namespace Database\Seeders;

use App\Models\Pesanan;
use App\Models\Produk;
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
        
        // Sample customer names
        $customerNames = [
            'Ayu Tri',
            'Alda Clarissa',
            'Hana Kamila',
            'Rafli',
            'Fauzan',
            'M. Nabil'
        ];

        // Get expedition options
        $ekspedisiOptions = array_keys(Pesanan::getEkspedisiOptions());

        // Create 20 dummy orders
        for ($i = 0; $i < 20; $i++) {
            $randomProduct = $produk->random();
            $randomCustomer = $customerNames[array_rand($customerNames)];
            $status = ['Menunggu', 'Dikonfirmasi', 'Selesai', 'Dibatalkan'][array_rand([0,1,2,3])];
            $randomEkspedisi = $ekspedisiOptions[array_rand($ekspedisiOptions)];
            $createdAt = now()->subDays(rand(0, 30))->addHours(rand(0, 23))->addMinutes(rand(0, 59));

            Pesanan::create([
                'nama_pemesan' => $randomCustomer,
                'nama_produk' => $randomProduct->nama,
                'ekspedisi' => $randomEkspedisi,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => $createdAt
            ]);
        }
    }
} 