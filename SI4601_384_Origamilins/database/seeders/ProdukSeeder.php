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
                'deskripsi' => 'Origami burung angsa yang elegan ini dilipat dengan rapi menggunakan kertas berkualitas, cocok sebagai hiasan meja, hadiah unik, atau simbol kasih sayang dan ketulusan.',
                'gambar' => 'https://origami.me/wp-content/uploads/2024/07/easy-origami-swan-1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Bunga Kertas',
                'harga' => 250000,
                'kategori' => 'Dekorasi',
                'deskripsi' => ' Origami bunga kertas yang anggun ini dibuat dengan detail yang halus dan presisi, menciptakan tampilan alami yang tak pernah layu. Cocok untuk dekorasi ruangan, bingkisan istimewa, atau lambang cinta yang abadi.',
                'gambar' => 'https://1.bp.blogspot.com/-D_8Oyp_dOkM/X9KhDiWpOwI/AAAAAAABZEk/Pr-zS8m7XlQIiGsoRABV2Br-vVKQA2DFQCLcBGAsYHQ/s0/_5xh0nuwzd.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Tirai Burung Angsa',
                'harga' => 80000,
                'kategori' => 'Merchandise',
                'deskripsi' => 'Tirai origami bertema burung angsa ini dirangkai dari deretan lipatan angsa yang simetris dan elegan. Menambah sentuhan artistik pada ruangan, cocok sebagai dekorasi acara spesial, hiasan jendela, atau pemanis sudut rumah.',
                'gambar' => 'https://deavita.fr/wp-content/uploads/2014/06/grues-origami-chambre-bebe-originale.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Bunga Tulip',
                'harga' => 15000,
                'kategori' => 'Merchandise',
                'deskripsi' => 'Origami bunga yang dibuat dengan teknik lipatan presisi ini menghadirkan keindahan alami dalam bentuk seni kertas. Cocok sebagai hiasan meja, buket kreatif, atau simbol keindahan dan harapan yang mekar.',
                'gambar' => 'https://th.bing.com/th/id/OIP.ISf7vyG9JMjraG2VFh5EkQHaHa?w=480&h=480&rs=1&pid=ImgDetMain',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Tirai Jendela Bunga',
                'harga' => 100000,
                'kategori' => 'Dekorasi',
                'deskripsi' => 'Tirai jendela origami bertema bunga ini disusun dari rangkaian kelopak kertas yang lembut dan berwarna. Memberikan nuansa segar dan manis pada ruangan, ideal untuk dekorasi acara, kamar tidur, atau sudut rumah yang ingin tampak lebih hidup.',
                'gambar' => 'https://archzine.net/wp-content/uploads/2015/05/kronleuchter-in-pink-wundersch%C3%B6ne-rosen.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Burung Merak',
                'harga' => 325000,
                'kategori' => 'Merchandise',
                'deskripsi' => 'Origami burung merak ini menampilkan detail lipatan yang rumit dan anggun, menggambarkan keindahan serta kemegahan sang burung. Cocok sebagai pajangan elegan, simbol keanggunan, atau hadiah penuh makna..',
                'gambar' => 'https://media.s-bol.com/gyB0E7DzEmYD/zw96mZ/550x595.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
