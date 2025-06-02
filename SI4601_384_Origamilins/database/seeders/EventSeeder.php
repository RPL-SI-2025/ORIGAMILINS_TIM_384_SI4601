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
                'poster' => 'uploads/event3.png',
                'kuota' => 100,
                'kuota_terisi' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_event' => 'Origami Festival 2025',
                'deskripsi' => 'Festival tahunan untuk para pecinta origami, menampilkan workshop, lomba, dan pameran karya origami dari berbagai daerah.',
                'tanggal_pelaksanaan' => '2025-07-10',
                'harga' => 30000,
                'lokasi' => 'Gedung Kesenian Bandung',
                'poster' => 'uploads/event2.png',
                'kuota' => 150,
                'kuota_terisi' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_event' => 'Origami for Kids',
                'deskripsi' => 'Acara khusus anak-anak untuk belajar origami sambil bermain dan berkreasi dengan warna-warni kertas.',
                'tanggal_pelaksanaan' => '2025-06-20',
                'harga' => 10000,
                'lokasi' => 'Taman Kota Cimahi',
                'poster' => 'uploads/event1.png',
                'kuota' => 80,
                'kuota_terisi' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_event' => 'Origami & Mindfulness',
                'deskripsi' => 'Workshop origami untuk dewasa yang ingin belajar teknik melipat sekaligus meditasi dan mindfulness.',
                'tanggal_pelaksanaan' => '2025-08-05',
                'harga' => 25000,
                'lokasi' => 'Ruang Komunitas Origamilins',
                'poster' => 'uploads/event4.png',
                'kuota' => 50,
                'kuota_terisi' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
} 