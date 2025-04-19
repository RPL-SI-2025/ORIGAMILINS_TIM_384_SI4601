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
                'judul' => 'Tips Merawat Tanaman Hias Indoor',
                'isi' => '<p>Merawat tanaman hias indoor membutuhkan perhatian khusus. Berikut beberapa tips penting:</p>
                        <ul>
                            <li>Pastikan pencahayaan yang cukup</li>
                            <li>Atur penyiraman secara teratur</li>
                            <li>Pilih pot dengan drainase yang baik</li>
                            <li>Perhatikan kelembaban udara</li>
                            <li>Lakukan pemupukan secara berkala</li>
                        </ul>',
                'tanggal_publikasi' => Carbon::now(),
                'gambar' => 'uploads/artikel/tanaman_hias.jpg'
            ],
            [
                'judul' => 'Cara Membuat Taman Minimalis',
                'isi' => '<p>Taman minimalis menjadi solusi untuk rumah dengan lahan terbatas. Berikut langkah-langkahnya:</p>
                        <ol>
                            <li>Rencanakan layout dengan baik</li>
                            <li>Pilih tanaman yang sesuai</li>
                            <li>Tambahkan elemen dekoratif</li>
                            <li>Atur pencahayaan taman</li>
                            <li>Buat sistem drainase yang baik</li>
                        </ol>',
                'tanggal_publikasi' => Carbon::now()->subDays(2),
                'gambar' => 'uploads/artikel/taman_minimalis.jpg'
            ],
            [
                'judul' => 'Panduan Berkebun untuk Pemula',
                'isi' => '<p>Mulai berkebun tidak sesulit yang dibayangkan. Ikuti panduan dasar berikut:</p>
                        <ul>
                            <li>Pilih lokasi yang tepat</li>
                            <li>Siapkan media tanam berkualitas</li>
                            <li>Pilih tanaman yang mudah dirawat</li>
                            <li>Atur jadwal penyiraman</li>
                            <li>Pantau pertumbuhan secara rutin</li>
                        </ul>',
                'tanggal_publikasi' => Carbon::now()->subDays(5),
                'gambar' => 'uploads/artikel/panduan_berkebun.jpg'
            ]
        ];

        foreach ($artikels as $artikel) {
            Artikel::create($artikel);
        }
    }
} 