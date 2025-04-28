<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'nama_event' => 'Melipat Kertas, Merangkai Cerita',
                'deskripsi' => 'Origami Day adalah acara seru dan edukatif yang mengajak peserta dari berbagai usia untuk menjelajahi keindahan seni melipat kertas. Dalam event ini, 
                                peserta akan belajar membuat berbagai bentuk origami mulai dari yang sederhana hingga kompleks, serta mengeksplorasi filosofi dan makna di balik lipatan-lipatan kertas tersebut.',
                'tanggal_pelaksanaan' => '2025-05-15',
                'harga' => 20000,
                'lokasi' => 'SMK 1 Cimahi',
                'poster' => 'event1.jpg',
                'kuota' => 100,
                'kuota_terisi' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_event' => 'Kisah dalam Lipatan: Workshop Origami Kreatif',
                'deskripsi' => '"Kisah dalam Lipatan: Workshop Origami Kreatif" adalah sebuah perjalanan seni melipat kertas yang mengajak peserta untuk menciptakan karya origami unik sambil memahami cerita dan filosofi di balik setiap bentuk.
                                Dalam workshop ini, peserta tidak hanya belajar teknik dasar dan lanjutan origami, tetapi juga diajak untuk menghubungkan setiap lipatan dengan makna yang mendalam. Dari burung bangau pembawa harapan hingga bunga lotus lambang ketenangan, setiap karya memiliki kisah tersendiri.',
                'tanggal_pelaksanaan' => '2025-05-20',
                'harga' => 18000,
                'lokasi' => 'SMAN 1 Maranatha',
                'poster' => 'event2.png',
                'kuota' => 100,
                'kuota_terisi' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_event' => 'Seni Lipat Dunia: Eksplorasi Origami Internasional',
                'deskripsi' => 'Eksplorasi Origami Internasional mempersembahkan karya-karya origami dari berbagai budaya dunia. 
                                Melalui lipatan-lipatan kreatif, pameran ini mengungkap keindahan, filosofi, dan inovasi seni kertas dalam perspektif global.',
                'tanggal_pelaksanaan' => '2025-05-30',
                'harga' => 22000,
                'lokasi' => 'Hotel Horison Bandung',
                'poster' => 'event3.png',
                'kuota' => 100,
                'kuota_terisi' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_event' => 'Cahaya dan Bayang: Instalasi Seni Kertas Dunia',
                'deskripsi' => 'Sebuah pameran instalasi kertas yang memadukan teknik lipat, potong, dan susun dari berbagai budaya. 
                                Setiap karya bermain dengan cahaya dan bayangan, menciptakan pengalaman visual yang imersif dan mengajak pengunjung melihat keindahan dalam detail sederhana.',
                'tanggal_pelaksanaan' => '2025-06-05',
                'harga' => 20000,
                'lokasi' => 'SMK 1 Cimahi', 
                'poster' => 'event4.jpg',
                'kuota' => 100,
                'kuota_terisi' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
} 