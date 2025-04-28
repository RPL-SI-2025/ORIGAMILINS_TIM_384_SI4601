<?php

namespace Database\Seeders;

use App\Models\Artikel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $artikels = [
            [
                'judul' => 'Panduan Dasar Membuat Origami',
                'isi' => '<p>Origami adalah seni melipat kertas yang berasal dari Jepang. Untuk pemula, berikut beberapa langkah dasar:</p>
                        <ul>
                            <li>Gunakan kertas khusus origami berbentuk persegi</li>
                            <li>Pelajari lipatan dasar seperti valley fold dan mountain fold</li>
                            <li>Mulai dengan model sederhana seperti burung bangau atau perahu</li>
                            <li>Perhatikan ketelitian pada setiap lipatan</li>
                            <li>Latihan secara rutin untuk meningkatkan keterampilan</li>
                        </ul>',
                'tanggal_publikasi' => Carbon::now(),
                'gambar' => 'artikel1.jpg'
            ],
            [
                'judul' => '5 Model Origami Sederhana untuk Pemula',
                'isi' => '<p>Jika Anda baru mulai belajar origami, berikut beberapa model sederhana yang bisa dicoba:</p>
                        <ol>
                            <li>Burung Bangau (Tsuru)</li>
                            <li>Katak Melompat</li>
                            <li>Perahu Kertas</li>
                            <li>Hati Origami</li>
                            <li>Bunga Lili</li>
                        </ol>
                        <p>Model-model ini tidak hanya mudah dibuat, tetapi juga sangat populer di kalangan pemula.</p>',
                'tanggal_publikasi' => Carbon::now()->subDays(1),
                'gambar' => 'artikel2.jpg'
            ],
            [
                'judul' => 'Manfaat Belajar Origami untuk Anak-anak',
                'isi' => '<p>Origami bukan hanya seni, tetapi juga memiliki banyak manfaat untuk perkembangan anak-anak, antara lain:</p>
                        <ul>
                            <li>Meningkatkan koordinasi tangan dan mata</li>
                            <li>Melatih konsentrasi dan ketelitian</li>
                            <li>Memperkenalkan konsep dasar matematika dan geometri</li>
                            <li>Meningkatkan kreativitas dan imajinasi</li>
                            <li>Memberikan rasa pencapaian dan kepercayaan diri</li>
                        </ul>',
                'tanggal_publikasi' => Carbon::now()->subDays(3),
                'gambar' => 'artikel3.jpg'
            ]
        ];

        foreach ($artikels as $artikel) {
            Artikel::create($artikel);
        }
    }
}
