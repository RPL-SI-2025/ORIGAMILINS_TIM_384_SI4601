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
                'gambar' => 'https://origami.me/wp-content/uploads/2024/07/easy-origami-swan-1.jpg',
                'nama' => 'Burung Angsa',
                'nama_produk' => 'Burung Angsa',
                'harga' => 15000,
                'kategori' => 'Merchandise',
                'ukuran' => '10 x 10 cm,15 x 15 cm',
                'deskripsi' => 'Origami burung angsa yang elegan ini dilipat dengan rapi menggunakan kertas berkualitas, cocok sebagai hiasan meja, hadiah unik, atau simbol kasih sayang dan ketulusan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gambar' => 'https://1.bp.blogspot.com/-D_8Oyp_dOkM/X9KhDiWpOwI/AAAAAAABZEk/Pr-zS8m7XlQIiGsoRABV2Br-vVKQA2DFQCLcBGAsYHQ/s0/_5xh0nuwzd.jpg',
                'nama' => 'Bunga Kertas',
                'nama_produk' => 'Bunga Kertas',
                'harga' => 250000,
                'kategori' => 'Dekorasi',
                'ukuran' => '1 meter, 2 meter',
                'deskripsi' => 'Origami bunga kertas yang anggun ini dibuat dengan detail yang halus dan presisi, menciptakan tampilan alami yang tak pernah layu. Cocok untuk dekorasi ruangan, bingkisan istimewa, atau lambang cinta yang abadi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gambar' => 'https://deavita.fr/wp-content/uploads/2014/06/grues-origami-chambre-bebe-originale.jpg',
                'nama' => 'Tirai Burung Angsa',
                'nama_produk' => 'Tirai Burung Angsa',
                'harga' => 80000,
                'kategori' => 'Merchandise',
                'ukuran' => '5 x 5 cm,10 x 10 cm,15 x 15 cm',
                'deskripsi' => 'Tirai origami bertema burung angsa ini dirangkai dari deretan lipatan angsa yang simetris dan elegan. Menambah sentuhan artistik pada ruangan, cocok sebagai dekorasi acara spesial, hiasan jendela, atau pemanis sudut rumah.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gambar' => 'https://th.bing.com/th/id/OIP.ISf7vyG9JMjraG2VFh5EkQHaHa?w=480&h=480&rs=1&pid=ImgDetMain',
                'nama' => 'Bunga Tulip',
                'nama_produk' => 'Bunga Tulip',
                'harga' => 15000,
                'kategori' => 'Merchandise',
                'ukuran' => '5 x 5 cm,10 x 10 cm',
                'deskripsi' => 'Origami bunga yang dibuat dengan teknik lipatan presisi ini menghadirkan keindahan alami dalam bentuk seni kertas. Cocok sebagai hiasan meja, buket kreatif, atau simbol keindahan dan harapan yang mekar.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
