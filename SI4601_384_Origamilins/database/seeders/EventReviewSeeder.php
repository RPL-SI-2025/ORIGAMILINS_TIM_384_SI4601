<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\EventReview;
use Illuminate\Database\Seeder;

class EventReviewSeeder extends Seeder
{
    public function run()
    {
        // Pastikan ada event dan user
        $events = Event::all();
        $users = User::where('role', '!=', 'admin')->get();

        if ($events->isEmpty() || $users->isEmpty()) {
            return;
        }

        // Array komentar yang relevan dengan seminar dan event
        $comments = [
            "Sesi tanya jawabnya interaktif dan pembicara sangat responsif. Materi yang disampaikan juga mudah dipahami.",
            "Fasilitas dan tempat seminar nyaman, mendukung proses pembelajaran. Akan ikut lagi di event berikutnya.",
            "Slide presentasi dan materi pendukung sangat terstruktur. Sangat membantu untuk memahami topik yang dibahas.",
            "Networking session-nya sangat bermanfaat, bisa bertemu dengan banyak profesional di bidang yang sama.",
            "Topik yang dibahas sangat relevan dengan kebutuhan industri saat ini. Pembicara sangat menguasai materi.",
            "Meskipun online, interaksi tetap terasa hidup dan materi tersampaikan dengan baik. Sistem webinarnya lancar.",
            "Pembicara sangat kompeten dan berpengalaman. Banyak insight baru yang didapat dari seminar ini.",
            "Workshop-nya sangat praktikal dan hands-on. Langsung bisa mempraktekkan ilmu yang didapat.",
            "Pamerannya sangat informatif dan edukatif. Stand-stand yang ada memberikan banyak pengetahuan baru.",
            "Acara sangat terorganisir dengan baik. Waktu tidak molor dan sesuai rundown yang dijadwalkan."
        ];

        foreach ($events as $event) {
            // Buat 3-5 review untuk setiap event
            $reviewCount = rand(3, 5);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                EventReview::create([
                    'event_id' => $event->id,
                    'user_id' => $users->random()->id,
                    'rating' => rand(3, 5), // Rating antara 3-5 bintang
                    'komentar' => $comments[array_rand($comments)],
                    'status' => 'Menunggu',
                    'created_at' => now()->subDays(rand(1, 30)), // Review dalam 30 hari terakhir
                ]);
            }
        }
    }
} 