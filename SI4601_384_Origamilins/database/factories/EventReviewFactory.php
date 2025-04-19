<?php

namespace Database\Factories;

use App\Models\EventReview;
use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventReviewFactory extends Factory
{
    protected $model = EventReview::class;

    public function definition()
    {
        return [
            'event_id' => Event::factory(),
            'user_id' => User::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'komentar' => $this->faker->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
} 