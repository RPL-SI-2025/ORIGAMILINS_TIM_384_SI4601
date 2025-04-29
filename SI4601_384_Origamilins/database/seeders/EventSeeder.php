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
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
} 