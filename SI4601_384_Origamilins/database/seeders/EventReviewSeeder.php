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

        foreach ($events as $event) {
            // Buat 3-5 review untuk setiap event
            $reviewCount = rand(3, 5);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                EventReview::create([
                    'event_id' => $event->id,
                    'user_id' => $users->random()->id,
                    'rating' => rand(3, 5), // Rating antara 3-5 bintang
                    'komentar' => fake()->realText(100),
                    'created_at' => now()->subDays(rand(1, 30)), // Review dalam 30 hari terakhir
                ]);
            }
        }
    }
} 