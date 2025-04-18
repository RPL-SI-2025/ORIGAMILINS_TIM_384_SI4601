<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'nama_event' => 'Workshop Daur Ulang',
                'deskripsi' => 'Workshop cara mendaur ulang sampah plastik menjadi produk bernilai jual tinggi',
                'tanggal_pelaksanaan' => '2025-05-15',
                'harga' => 50000,
                'lokasi' => 'Gedung Serbaguna Cimahi',
                'poster' => 'https://www.edinburghmuseums.org.uk/sites/default/files/Photo_4_-_origami%5B1%5D.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_event' => 'Pameran Produk Daur Ulang',
                'deskripsi' => 'Pameran berbagai produk hasil daur ulang dari komunitas peduli lingkungan',
                'tanggal_pelaksanaan' => '2025-06-20',
                'harga' => 25000,
                'lokasi' => 'Mall Cimahi',
                'poster' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS3agEehzs_5kjcDSrKIQhShwzToQHWt8MnLg&s',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_event' => 'Seminar Eco-Living',
                'deskripsi' => 'Seminar tentang gaya hidup ramah lingkungan dan zero waste',
                'tanggal_pelaksanaan' => '2025-07-10',
                'harga' => 75000,
                'lokasi' => 'Hotel Grand Cimahi',
                'poster' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRaC44-tvefAauTJ3fAXyTs5yXAeCLiaiznnQ&s',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
} 