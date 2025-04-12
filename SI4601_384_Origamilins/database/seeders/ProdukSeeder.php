<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('produk')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('produk')->insert([
            [
                'nama' => 'Burung Angsa',
                'harga' => 15000,
                'kategori' => 'Merchandise',
                'deskripsi' => 'Origami burung angsa yang elegan ini dilipat dengan rapi 
                menggunakan kertas berkualitas, cocok sebagai hiasan meja, hadiah unik, atau simbol kasih sayang dan ketulusan.',
                'gambar' => 'https://origami.me/wp-content/uploads/2024/07/easy-origami-swan-1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Bunga Kertas',
                'harga' => 250000,
                'kategori' => 'Dekorasi',
                'deskripsi' => 'Kit lengkap origami untuk pemula dengan petunjuk dan kertas.',
                'gambar' => 'https://1.bp.blogspot.com/-D_8Oyp_dOkM/X9KhDiWpOwI/AAAAAAABZEk/Pr-zS8m7XlQIiGsoRABV2Br-vVKQA2DFQCLcBGAsYHQ/s0/_5xh0nuwzd.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Tirai Burung Angsa',
                'harga' => 80000,
                'kategori' => 'Merchandise',
                'deskripsi' => 'Set untuk membuat origami 3D dengan bahan dan panduan lengkap.',
                'gambar' => 'https://deavita.fr/wp-content/uploads/2014/06/grues-origami-chambre-bebe-originale.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
