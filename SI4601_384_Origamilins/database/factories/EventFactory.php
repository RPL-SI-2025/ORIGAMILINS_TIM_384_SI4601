<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'nama_event' => $this->faker->sentence(3),
            'deskripsi' => $this->faker->paragraph,
            'tanggal_pelaksanaan' => $this->faker->dateTimeBetween('now', '+1 year'),
            'harga' => $this->faker->randomFloat(2, 100000, 1000000),
            'lokasi' => $this->faker->address,
            'poster' => $this->faker->imageUrl(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
} 