<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\PesananEvent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesananEventSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::table('pesanan_event')->truncate();

        // Get all events
        $events = Event::all();
        
        // Sample customer names
        $customerNames = [
            'Ayu Tri',
            'Alda Clarissa',
            'Hana Kamila',
            'Rafli',
            'Fauzan',
            'M. Nabil'
        ];

        // Create 20 dummy event orders
        for ($i = 0; $i < 20; $i++) {
            $randomEvent = $events->random();
            $randomCustomer = $customerNames[array_rand($customerNames)];
            $status = [
                'Menunggu',
                'Belum Berjalan',
                'Sedang Berjalan',
                'Selesai',
                'Dibatalkan'
            ][array_rand([0,1,2,3,4])];
            
            $createdAt = now()->subDays(rand(0, 30))->addHours(rand(0, 23))->addMinutes(rand(0, 59));

            PesananEvent::create([
                'nama_pemesan' => $randomCustomer,
                'nama_event' => $randomEvent->nama_event,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => $createdAt
            ]);
        }
    }
} 